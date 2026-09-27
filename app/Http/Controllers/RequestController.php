<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Services\Consent\PdplConsentService;
use App\Services\Contracts\ContractArchiveService;
use App\Services\Contracts\ContractsEngine;
use App\Services\Invoicing\FinalInvoiceService;
use App\Services\Payment\SovereignPaymentEngine;
use App\Services\Requests\RequestLifecycle;
use App\Support\SovereignPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class RequestController extends Controller
{
    public function __construct(
        private readonly RequestLifecycle $lifecycle,
        private readonly PdplConsentService $consent,
        private readonly ContractsEngine $contracts,
    ) {}

    public function index(Request $request)
    {
        $operations = ServiceRequest::where('user_id', $request->user()->id);

        return view('pages.dashboard.requests', [
            'requests' => $operations->latest('submitted_at')->latest()->get(),
            'summary' => [
                'total' => (clone $operations)->count(),
                'active' => (clone $operations)->whereNotIn('status', ['completed', 'cancelled'])->count(),
                'completed' => (clone $operations)->where('status', 'completed')->count(),
                'waiting' => (clone $operations)->where('status', 'waiting_documents')->count(),
            ],
        ]);
    }

    public function create()
    {
        $services = ServicesController::getCatalog();

        return view('pages.dashboard.request-create', [
            'services' => $services,
            'pricingMap' => SovereignPricing::jsMap(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'service_name' => ['required', 'string', 'max:255'],
            'entity_name' => ['required', 'string', 'max:255'],
            'target_market' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'speed' => ['required', 'in:standard,express,sovereign'],
            'pdpl_consent' => ['required', 'accepted'],
            'documents' => ['nullable', 'array', 'max:8'],
            'documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240'],
        ]);

        $user = $request->user();

        // Server-authoritative quote: the client-side estimate is never trusted.
        $quote = SovereignPricing::quote($data['category'], $data['speed']);

        $operation = DB::transaction(function () use ($data, $request, $user, $quote): ServiceRequest {
            $operation = ServiceRequest::create([
                ...collect($data)->except(['documents', 'pdpl_consent'])->all(),
                'user_id' => $user->id,
                'request_number' => $this->nextRequestNumber(),
                'status' => 'submitted',
                'progress' => 10,
                'submitted_at' => now(),
                'documents' => [],
                'price_base' => $quote['base'],
                'price_speed_fee' => $quote['speed_fee'],
                'price_vat' => $quote['vat'],
                'price_total' => $quote['total'],
            ]);

            $documents = collect($request->file('documents', []))->map(function ($file) use ($operation) {
                return [
                    'name' => $file->getClientOriginalName(),
                    'path' => $file->store("request-documents/{$operation->id}"),
                    'uploaded_at' => now()->toIso8601String(),
                ];
            })->all();
            $operation->update(['documents' => $documents]);

            // PDPL explicit-consent ledger with cryptographic fingerprint.
            $this->consent->record($user, $request, 'order_submit');

            // Provision the digital contract draft (sealed PDF generated on signing).
            $contract = $this->contracts->createContract([
                'user_id' => $user->id,
                'title' => "عقد تقديم خدمات سيادية — {$operation->service_name}",
                'entity_name' => $operation->entity_name,
                'contract_type' => 'service_provision',
                'amount' => $quote['total'],
                'currency' => 'SAR',
                'parties' => [
                    ['name' => $user->name, 'role' => 'الطرف الأول — العميل', 'email' => $user->email],
                    ['name' => 'شركة نوادر للخدمات السيادية', 'role' => 'الطرف الثاني — مزود الخدمة'],
                ],
                'terms_meta' => [
                    'request_number' => $operation->request_number,
                    'speed' => $quote['speed_label'],
                    'sla' => $quote['sla'],
                    'base_fee' => $quote['base'],
                    'speed_fee' => $quote['speed_fee'],
                    'vat' => $quote['vat'],
                    'total_sar' => $quote['total'],
                    'escrow' => 'الضمان السيادي Escrow وفق سياسة حماية المستفيد',
                ],
            ]);
            $contract->update([
                'service_request_id' => $operation->id,
                'verification_token' => Str::random(40),
            ]);
            $operation->update(['contract_id' => $contract->id]);

            return $operation;
        });

        // Draft PDF is best-effort: the final sealed copy is regenerated at signing.
        try {
            app(ContractArchiveService::class)->buildDraft($operation->contract()->firstOrFail());
        } catch (Throwable $e) {
            Log::warning('Contract draft PDF failed: '.$e->getMessage());
        }

        $this->lifecycle->transition(
            $operation,
            'submitted',
            "استلمنا طلبك رسمياً — القيمة المعتمدة {$quote['total']} ر.س (شاملة الضريبة). فعّل الضمان السيادي ثم وقّع العقد الرقمي للبدء.",
            'client',
            'تم استلام طلبك',
        );

        return redirect()
            ->route('dashboard.requests.show', $operation->request_number)
            ->with('success', "تم إنشاء طلبك {$operation->request_number} بقيمة معتمدة {$quote['total']} ر.س مع عقد رقمي جاهز للتوقيع.");
    }

    public function show(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);

        return view('pages.dashboard.request-show', [
            'id' => $operation->request_number,
            'operation' => $operation,
        ]);
    }

    public function track(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);

        return view('pages.dashboard.request-track', ['id' => $operation->request_number, 'operation' => $operation]);
    }

    /** Live tracker JSON feed (polled by the track page). */
    public function eventsFeed(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);
        $contract = $operation->contract;

        return response()->json([
            'request_number' => $operation->request_number,
            'status' => $operation->status,
            'label' => $operation->statusLabel(),
            'progress' => $operation->progress,
            'updated_at' => $operation->updated_at?->toIso8601String(),
            'pricing' => [
                'base' => (float) $operation->price_base,
                'speed_fee' => (float) $operation->price_speed_fee,
                'vat' => (float) $operation->price_vat,
                'total' => (float) $operation->price_total,
            ],
            'escrow_reference' => $operation->escrow_reference,
            'invoice' => $operation->invoice_number ? [
                'number' => $operation->invoice_number,
                'issued_at' => $operation->invoice_issued_at?->toIso8601String(),
                'hash' => $operation->invoice_hash,
            ] : null,
            'contract' => $contract ? [
                'id' => $contract->id,
                'number' => $contract->contract_number,
                'status' => $contract->status,
                'signable' => $contract->status === 'pending_signature',
                'pdf' => $contract->pdf_path ? Storage::url($contract->pdf_path) : null,
            ] : null,
            'events' => $operation->events->map(fn ($event) => [
                'status' => $event->status,
                'label' => $this->statusLabel($event->status),
                'note' => $event->note,
                'actor' => $event->actor,
                'at' => $event->created_at?->toIso8601String(),
            ])->values(),
        ]);
    }

    /** Sovereign escrow payment-hold for this request. */
    public function payEscrow(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);
        abort_if(in_array($operation->status, ['cancelled'], true), 422, 'لا يمكن سداد طلب ملغى.');
        abort_if(!$operation->price_total || (float) $operation->price_total <= 0, 422, 'لا توجد قيمة معتمدة لهذا الطلب.');

        if ($operation->escrow_reference) {
            return back()->with('info', 'الضمان السيادي مفعّل مسبقااً لهذا الطلب.');
        }

        $result = (new SovereignPaymentEngine())->initiatePayment([
            'method' => 'escrow',
            'amount' => (float) $operation->price_total,
            'currency' => 'SAR',
            'order_id' => $operation->request_number,
            'user_id' => $request->user()->id,
            'description' => "ضمان سيادي — {$operation->service_name} ({$operation->request_number})",
        ]);

        abort_unless(($result['success'] ?? false) && ($result['status'] ?? '') === 'locked', 502, 'تعذر حجز الضمان السيادي، حاول مجددااً.');

        $operation->update(['escrow_reference' => $result['escrow_id']]);

        $this->lifecycle->transition(
            $operation,
            'escrow_locked',
            'تم حجز الضمان السيادي (Escrow) بقيمة '.number_format((float) $operation->price_total, 2).' ر.س برقم مرجعي '.$result['escrow_id'].' — لا يُصرف إلا عند إنجاز الخدمة.',
            'client',
            'تم حجز الضمان السيادي',
        );

        return back()->with('success', 'تم تفعيل الضمان السيادي بنجاح: '.$result['escrow_id']);
    }

    /** Final ZATCA tax invoice + loyalty award once the request is completed. */
    public function issueFinalInvoice(Request $request, string $id, FinalInvoiceService $invoices)
    {
        $operation = $this->operationFor($request, $id);
        $result = $invoices->issue($operation);

        return back()->with('success', "صدرت فاتورتك الضريبية {$result['invoice_number']} (ZATCA Phase-2) ورُصدت {$result['points']} نقطة ولاء.");
    }

    public function uploadDoc(Request $request, string $id)
    {
        $operation = $this->operationFor($request, $id);
        $request->validate(['document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:10240']]);
        $file = $request->file('document');
        $documents = $operation->documents ?? [];
        $documents[] = [
            'name' => $file->getClientOriginalName(),
            'path' => $file->store("request-documents/{$operation->id}"),
            'uploaded_at' => now()->toIso8601String(),
        ];
        $operation->update(['documents' => $documents]);

        $this->lifecycle->transition(
            $operation,
            $operation->status,
            'تم إرفاق مستند جديد: '.$file->getClientOriginalName(),
            'client',
            'تم استلام مستندك',
        );

        return response()->json(['success' => true, 'file' => $file->getClientOriginalName()]);
    }

    private function operationFor(Request $request, string $requestNumber): ServiceRequest
    {
        return ServiceRequest::where('user_id', $request->user()->id)->where('request_number', $requestNumber)->firstOrFail();
    }

    private function nextRequestNumber(): string
    {
        do {
            $number = 'NW-RQ-'.now()->format('Ymd').'-'.strtoupper(Str::random(5));
        } while (ServiceRequest::where('request_number', $number)->exists());

        return $number;
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            'submitted' => 'تم استلام الطلب',
            'escrow_locked' => 'الضمان السيادي محجوز',
            'contract_signed' => 'العقد موقّع رقميا',
            'in_review' => 'قيد المراجعة',
            'waiting_documents' => 'بانتظار مستندات',
            'in_progress', 'processing' => 'قيد التنفيذ',
            'completed' => 'مكتمل ومفوتر',
            'cancelled' => 'ملغى',
            default => 'تحديث',
        };
    }
}
