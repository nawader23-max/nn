<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Sovereign Digital Contract — Execution Copy</title>
  <style>
    @page { margin: 26mm 18mm; }
    * { box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; color: #1c2430; font-size: 10.5px; line-height: 1.55; }
    .brand { border-bottom: 3px solid #b8912f; padding-bottom: 10px; margin-bottom: 18px; }
    .brand h1 { margin: 0; font-size: 17px; color: #0e1726; letter-spacing: 1px; }
    .brand small { color: #8a6d1f; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; }
    .doc-meta { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    .doc-meta td { padding: 6px 9px; border: 1px solid #d8dce4; font-size: 10px; }
    .doc-meta .k { background: #f4f6fa; width: 24%; color: #4a5568; font-weight: bold; }
    h2 { font-size: 12px; color: #0e1726; border-left: 4px solid #b8912f; padding-left: 8px; margin: 20px 0 8px; }
    .legal { background: #f8f9fc; border: 1px solid #e3e7ef; padding: 10px 12px; font-size: 9.5px; color: #3d4757; }
    table.grid { width: 100%; border-collapse: collapse; }
    table.grid td, table.grid th { border: 1px solid #d8dce4; padding: 6px 9px; font-size: 10px; text-align: left; }
    table.grid th { background: #0e1726; color: #e7c56a; }
    .mono { font-family: DejaVu Sans Mono, monospace; font-size: 9px; word-break: break-all; }
    .seal-box { border: 2px solid #0e8f84; border-radius: 6px; padding: 12px; margin-top: 14px; background: #f0fbfa; }
    .seal-flex { width: 100%; }
    .seal-flex td { border: none; vertical-align: top; }
    .qr { width: 128px; height: 128px; }
    .badge { display: inline-block; background: #0e8f84; color: #fff; padding: 3px 10px; border-radius: 10px; font-size: 9px; font-weight: bold; }
    .badge.gold { background: #b8912f; }
    .sig-img { height: 60px; border-bottom: 1px solid #47506b; }
    .footer { margin-top: 22px; border-top: 1px solid #d8dce4; padding-top: 8px; font-size: 8px; color: #7a8494; text-align: center; }
    .amount { font-size: 14px; font-weight: bold; color: #0e1726; }
  </style>
</head>
<body>
  <div class="brand">
    <h1>NAWADER SOVEREIGN SERVICES</h1>
    <small>Digital Contract &middot; Execution Copy &middot; {{ $c->contract_number }}</small>
  </div>

  <table class="doc-meta">
    <tr>
      <td class="k">Contract No.</td><td class="mono">{{ $c->contract_number }}</td>
      <td class="k">Status</td><td><span class="badge">{{ $sealed ? 'SEALED &amp; EXECUTED' : 'DRAFT — UNSIGNED' }}</span></td>
    </tr>
    <tr>
      <td class="k">Issued</td><td>{{ $c->created_at?->format('Y-m-d H:i') }} (+03:00)</td>
      <td class="k">Linked Request</td><td class="mono">{{ $request?->request_number ?? '—' }}</td>
    </tr>
    <tr>
      <td class="k">Governing Law</td><td colspan="3">Saudi Electronic Transactions Law &amp; US E-SIGN Act (15 U.S.C. §§7001–7031)</td>
    </tr>
  </table>

  <h2>Parties</h2>
  <table class="grid">
    <tr><th>Party</th><th>Role</th><th>Identifier</th></tr>
    @foreach(($c->parties ?? []) as $party)
      <tr>
        <td>{{ $party['name'] ?? '—' }}</td>
        <td>{{ $party['role'] ?? '—' }}</td>
        <td class="mono">{{ $party['email'] ?? $c->contract_number }}</td>
      </tr>
    @endforeach
  </table>
  <h2>Commercial Terms (as computed by the sovereign pricing engine)</h2>
  @php $tm = $c->terms_meta ?? []; @endphp
  <table class="grid">
    <tr><td>Service engagement</td><td>Registered under client dashboard request <span class="mono">{{ $tm['request_number'] ?? ($request?->request_number ?? '—') }}</span> (full Arabic scope of work shown to and acknowledged by the signer at the secure signing session).</td></tr>
    <tr><td>Execution track</td><td>{{ $tm['speed'] ?? 'Standard' }} — SLA {{ $tm['sla'] ?? '—' }}</td></tr>
    <tr><td>Professional fees</td><td>{{ number_format((float) ($tm['base_fee'] ?? 0), 2) }} SAR</td></tr>
    <tr><td>Expedite fee</td><td>{{ number_format((float) ($tm['speed_fee'] ?? 0), 2) }} SAR</td></tr>
    <tr><td>VAT (15%)</td><td>{{ number_format((float) ($tm['vat'] ?? 0), 2) }} SAR</td></tr>
    <tr><td>Total</td><td><span class="amount">{{ number_format((float) $c->amount, 2) }} {{ $c->currency }}</span> (VAT inclusive)</td></tr>
    <tr><td>Payment security</td><td>Sovereign Escrow — funds held and released only upon service completion per client protection policy.</td></tr>
  </table>

  @if($sealed)
    <h2>Electronic Signature &amp; Cryptographic Seal</h2>
    <div class="seal-box">
      <table class="seal-flex">
        <tr>
          <td width="62%">
            @if($signatureDataUri)<img class="sig-img" src="{{ $signatureDataUri }}" alt="signature">@endif
            <div style="margin-top:4px;font-size:9.5px;">
              Signed by: <strong>{{ $user?->name ?? '—' }}</strong><br>
              Channel: WhatsApp reverse-OTP identity verification<br>
              Signature record: <span class="mono">{{ $c->signature_hash }}</span><br>
              Executed at: {{ $c->otp_verified_at?->format('Y-m-d H:i') ?? $c->signed_at?->format('Y-m-d H:i') }} (+03:00)
            </div>
          </td>
          <td width="38%" style="text-align:center;">
            <div>{!! $verificationQr !!}</div>
            <div style="font-size:8px;" class="mono">{{ $verificationUrl }}</div>
          </td>
        </tr>
      </table>
      <p style="margin:8px 0 0;font-size:9px;">
        Document hash (SHA-256): <span class="mono">{{ $documentSha256 }}</span><br>
        Any alteration of this sealed PDF invalidates the hash above.
        <span class="badge gold">TAMPER-EVIDENT RECORD</span>
      </p>
    </div>
  @else
    <h2>Signature Status</h2>
    <div class="legal">
      This is an unexecuted draft generated at order intake. It becomes an executed instrument only after the
      client completes WhatsApp reverse-OTP identity verification and applies the digital signature, at which
      point this document is regenerated and sealed with a SHA-256 tamper-evident hash.
    </div>
  @endif

  <h2>Standard Terms</h2>
  <div class="legal">
    1. Nawader shall perform the agreed sovereign services with professional diligence; the client guarantees the
    authenticity of submitted documents and data.<br>
    2. Escrowed amounts are held under the client-protection policy and released upon completion; disputes follow
    the internal grievance mechanism first, then competent Saudi courts.<br>
    3. Personal data is processed under the Saudi Personal Data Protection Law (PDPL); the client's consent record
    (with IP and cryptographic fingerprint) forms part of this digital file.<br>
    4. Final tax invoices are issued in ZATCA Phase-2 compliance with cryptographic QR stamps.
  </div>

  <div class="footer">
    NAWADER SOVEREIGN SERVICES — VAT 302910492800003 &middot; Verify this record publicly at nawadersrv.com &middot; {{ now()->format('Y') }}
  </div>

</body>
</html>
