<?php

namespace App\Services\Invoicing;

use App\Services\Contracts\ContractArchiveService;
use App\Services\Government\GovernmentEngine;
use App\Services\Loyalty\LoyaltyEngine;
use App\Services\Requests\RequestLifecycle;
use App\Models\ServiceRequest;
use App\Models\WalletTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Final ZATCA-compliant tax invoice issuance (Phase 2 seal + QR),
 * fired when an escrowed request reaches completion. Awards loyalty points.
 */
final class FinalInvoiceService
{
    public function __construct(
        private readonly GovernmentEngine $government,
        private readonly LoyaltyEngine $loyalty,
        private readonly ContractArchiveService $archive,
        private readonly RequestLifecycle $lifecycle,
    ) {}

    /** @return array{invoice_number: string, pdf_path: string, invoice_hash: string, points: int, total: float} */
    public function issue(ServiceRequest $request): array
    {
        if ($request->invoice_issued_at !== null) {
            throw ValidationException::withMessages(['invoice' => 'صدرت الفاتورة الضريبية لهذا الطلب مسبقاً.']);
        }
        if (!$request->escrow_reference) {
            throw ValidationException::withMessages(['invoice' => 'يلزم تفعيل الضمان السيادي (Escrow) قبل إصدار الفاتورة النهائية.']);
        }
        abort_unless($request->status === 'completed', 422, 'تُصدر الفاتورة النهائية عند إنجاز الطلب فقط.');

        $total = (float) $request->price_total;
        $net = round($total / 1.15, 2);
        $vat = round($total - $net, 2);
        $invoiceNumber = 'NW-INV-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));

        $payload = $this->government->generateZatcaInvoicePayload([
            'invoice_number' => $invoiceNumber,
            'request_number' => $request->request_number,
            'amount' => $net,
            'vat' => $vat,
            'total' => $total,
            'issued_at' => now()->toIso8601String(),
        ]);

        $qrDataUri = $this->archive->qrDataUri((string) $payload['qr_code']);

        $pdf = Pdf::loadView('invoices.final', [
            'request' => $request,
            'invoice_number' => $invoiceNumber,
            'net' => $net,
            'vat' => $vat,
            'total' => $total,
            'payload' => $payload,
            'qrDataUri' => $qrDataUri,
        ])->setPaper('a4');
        $bytes = $pdf->output();
        $path = "invoices/{$invoiceNumber}.pdf";
        Storage::put($path, $bytes);

        $spendable = (float) $request->price_base + (float) $request->price_speed_fee;
        $points = (int) ($spendable / 10);
        $account = $this->loyalty->getAccount($request->user);

        DB::transaction(function () use ($request, $invoiceNumber, $total, $payload, $account, $spendable) {
            WalletTransaction::create([
                'user_id' => $request->user_id,
                'transaction_number' => $invoiceNumber,
                'type' => 'tax_invoice',
                'amount' => $total,
                'currency' => 'SAR',
                'status' => 'completed',
                'payment_method' => 'escrow_final_settlement',
                'reference_id' => $request->escrow_reference,
                'description' => "الفاتورة الضريبية النهائية {$request->request_number} — ختم ZATCA المرحلة الثانية",
            ]);
            $request->update([
                'invoice_number' => $invoiceNumber,
                'invoice_hash' => $payload['invoice_hash'],
                'invoice_issued_at' => now(),
            ]);
            $this->loyalty->awardPoints($account, $spendable);
        });

        $this->lifecycle->transition(
            $request->fresh(),
            'completed',
            "الفاتورة الضريبية النهائية {$invoiceNumber} صدرت بختم ZATCA (المرحلة الثانية), بصمة: ".substr((string) $payload['invoice_hash'], 0, 16)."… ورُصدت لك {$points} نقطة ولاء.",
            'system',
            '🧾 فاتورتك الضريبية النهائية جاهزة',
        );

        return [
            'invoice_number' => $invoiceNumber,
            'pdf_path' => $path,
            'invoice_hash' => (string) $payload['invoice_hash'],
            'points' => $points,
            'total' => $total,
        ];
    }
}
