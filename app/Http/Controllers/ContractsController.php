<?php

namespace App\Http\Controllers;

use App\Models\DigitalContract;
use App\Services\Contracts\ContractArchiveService;
use App\Services\Contracts\ContractsEngine;
use App\Services\Requests\RequestLifecycle;
use App\Services\ReverseOtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContractsController extends Controller
{
    public function __construct(protected ContractsEngine $engine) {}

    public function index(Request $request)
    {
        $contracts = DigitalContract::where('user_id', $request->user()->id)->latest()->get();

        return view('pages.dashboard.contracts', compact('contracts'));
    }

    /** Secure signing room: WhatsApp OTP gate then the signature canvas. */
    public function show(Request $request, int $id)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        $user = $request->user();
        $phone = $user->phone_e164 ?: $user->phone;

        return view('pages.dashboard.contract-sign', [
            'contract' => $contract,
            'phone' => $phone,
            'verificationUrl' => $contract->verification_token ? url('/verify/'.$contract->verification_token) : null,
        ]);
    }

    public function requestOtp(Request $request, int $id, ReverseOtpService $otp)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        abort_unless($contract->status === 'pending_signature', 422, 'هذا العقد لا يحتاج إلى توقيع جديد.');

        $user = $request->user();
        $phone = $user->phone_e164 ?: $user->phone;
        if (!$phone) {
            throw ValidationException::withMessages(['phone' => 'أضف رقم جوال في ملفك أولاً لتفعيل التحقق السيادي.']);
        }

        $payload = $otp->issue($request, $user, $otp->normalizePhone($phone), 'contract_sign');

        return response()->json($payload);
    }

    public function otpStatus(Request $request, int $id, ReverseOtpService $otp)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        $token = (string) $request->query('token', '');
        $result = $otp->status($request, $token);

        if (($result['status'] ?? '') === 'verified' && !$contract->otp_verified_at) {
            $contract->update(['otp_verified_at' => now()]);
        }

        return response()->json($result);
    }

    /** Seal the contract: canvas PNG + OTP-verified identity → hashed PDF. */
    public function sign(Request $request, int $id, ContractArchiveService $archive, RequestLifecycle $lifecycle)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        abort_unless($contract->status === 'pending_signature', 422, 'هذا العقد لا يحتاج إلى توقيع جديد.');
        abort_unless($contract->otp_verified_at !== null && $contract->otp_verified_at->gt(now()->subMinutes(15)), 419, 'انتهت صلاحية التحقق، أعد طلب رمز واتساب.');

        $data = $request->validate([
            'signature_png' => ['required', 'string'],
            'consent_signed' => ['required', 'accepted'],
        ]);

        $result = $archive->finalizeSigned($contract, $data['signature_png'], $request->user()->name, (string) $request->ip());

        if ($contract->serviceRequest) {
            $lifecycle->transition(
                $contract->serviceRequest,
                'contract_signed',
                'تم التوقيع الرقمي على العقد '.$contract->contract_number.' بعد تحقق واتساب — بصمة الوثيقة SHA-256: '.substr($result['document_sha256'], 0, 16).'…',
                'client',
                '✍️ تم ختم عقدك رقمياً',
            );
        }

        return redirect()->route('dashboard.contracts')
            ->with('success', 'تم ختم وتوقيع العقد رقمياً وحفظ بصمته: '.substr($result['document_sha256'], 0, 16).'…');
    }

    /** Public tamper-evidence certificate (no auth): proves hash + parties + status. */
    public function verify(Request $request, string $verificationToken)
    {
        $contract = DigitalContract::where('verification_token', $verificationToken)
            ->whereIn('status', ['active', 'pending_signature'])
            ->firstOrFail();

        if ($request->expectsJson()) {
            return response()->json([
                'contract_number' => $contract->contract_number,
                'status' => $contract->status,
                'parties' => $contract->parties,
                'amount' => (float) $contract->amount,
                'currency' => $contract->currency,
                'signed_at' => $contract->signed_at?->toIso8601String(),
                'signature_hash' => $contract->signature_hash,
                'document_sha256' => $contract->document_sha256,
            ]);
        }

        return view('pages.verify-contract', ['contract' => $contract]);
    }

    /** Download the sealed PDF for the owning client only. */
    public function download(Request $request, int $id)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        abort_unless($contract->pdf_path && \Storage::exists($contract->pdf_path), 404, 'النسخة المؤرشفة غير متوفرة بعد.');

        return \Storage::download($contract->pdf_path, $contract->contract_number.'.pdf');
    }

}

