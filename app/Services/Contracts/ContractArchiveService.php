<?php

namespace App\Services\Contracts;

use App\Models\DigitalContract;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

/**
 * Contract document pipeline: draft PDF, OTP-gated signing canvas,
 * sealed final PDF with SHA-256 document hash + public QR verification.
 */
final class ContractArchiveService
{
    public function __construct(private readonly ContractsEngine $engine) {}

    public function qrDataUri(string $content): string
    {
        $renderer = new ImageRenderer(new RendererStyle(128), new SvgImageBackEnd());
        $writer = new Writer($renderer);
        $svg = $writer->writeString($content);
        $start = strpos($svg, '<svg');

        return $start === false ? '' : substr($svg, $start);
    }

    public function buildDraft(DigitalContract $contract): string
    {
        $pdf = Pdf::loadHTML($this->renderDocument($contract, false, null))->setPaper('a4');
        $path = "contracts/{$contract->contract_number}-draft.pdf";
        Storage::put($path, $pdf->output());
        $contract->update(['pdf_path' => $path]);

        return $path;
    }

    /**
     * @param string $signaturePngBase64 Raw canvas PNG (data-URL prefix allowed)
     * @return array{pdf_path: string, document_sha256: string, signature_hash: string}
     */
    public function finalizeSigned(DigitalContract $contract, string $signaturePngBase64, string $signerName, string $signerIp): array
    {
        $raw = base64_decode(preg_replace('#^data:image/png;base64,#', '', $signaturePngBase64) ?? '', true);
        if (!is_string($raw) || !str_starts_with($raw, "\x89PNG") || strlen($raw) < 100) {
            throw new InvalidArgumentException('صورة التوقيع غير صالحة.');
        }

        $signaturePath = "contracts/{$contract->contract_number}-signature.png";
        Storage::put($signaturePath, $raw);

        // Cryptographic signature record via the sovereign engine (keeps legal terms_meta).
        $this->engine->signContract($contract, $signerName, $signerIp);
        $contract->update(['otp_verified_at' => $contract->otp_verified_at ?? now()]);

        $pdf = Pdf::loadHTML($this->renderDocument($contract->fresh(), true, $raw))->setPaper('a4');
        $bytes = $pdf->output();
        $path = "contracts/{$contract->contract_number}.pdf";
        Storage::put($path, $bytes);

        $documentHash = hash('sha256', $bytes);
        $contract->update([
            'pdf_path' => $path,
            'signature_path' => $signaturePath,
            'document_sha256' => $documentHash,
        ]);

        return [
            'pdf_path' => $path,
            'document_sha256' => $documentHash,
            'signature_hash' => (string) $contract->fresh()->signature_hash,
        ];
    }

    private function renderDocument(DigitalContract $contract, bool $sealed, ?string $signaturePng): string
    {
        return view('contracts.document', [
            'c' => $contract,
            'user' => $contract->user,
            'request' => $contract->serviceRequest,
            'sealed' => $sealed,
            'signatureDataUri' => $signaturePng !== null ? 'data:image/png;base64,'.base64_encode($signaturePng) : null,
            'verificationUrl' => url('/verify/'.$contract->verification_token),
            'verificationQr' => $this->qrDataUri(url('/verify/'.$contract->verification_token)),
            'documentSha256' => $contract->document_sha256,
        ])->render();
    }
}
