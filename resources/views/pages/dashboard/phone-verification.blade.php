@extends('layouts.app')

@section('title', 'ربط رقم التحقق — نوادر')
@section('page_title', 'تأكيد رقم الهاتف')

@push('head')
<style>
.phone-verify { padding:120px 0 80px; }.phone-verify-card { max-width:640px;margin:auto;padding:2.25rem;border-radius:24px;background:rgba(15,23,40,.88);border:1px solid rgba(255,255,255,.1);text-align:center;box-shadow:0 24px 64px rgba(0,0,0,.3) }.reverse-otp-panel {display:none;margin-top:1.25rem;padding:1rem;border:1px solid rgba(0,212,200,.24);background:rgba(0,212,200,.05);border-radius:16px}.reverse-otp-panel.is-active{display:block}.reverse-otp-qr{display:none;width:190px;height:190px;margin:1rem auto;padding:10px;border-radius:12px;background:#fff}.reverse-otp-qr.is-active{display:block}
</style>
@vite('resources/js/reverse-otp.js')
@endpush

@section('content')
<main class="phone-verify"><div class="nw-container"><section class="phone-verify-card" id="reverse-otp" data-purpose="verify" data-csrf="{{ csrf_token() }}" data-generate-url="{{ route('reverse-otp.generate') }}" data-status-url="{{ route('reverse-otp.status') }}">
  <div class="nw-section-eyebrow">حماية الحساب</div>
  <h1 style="color:#fff;font-size:1.7rem;margin:.6rem 0">ربط رقم التحقق</h1>
  <p style="color:var(--text-muted);line-height:1.8">سيُربط الرقم بحسابك بعد أن تصلنا رسالة التحقق من هاتفك. لا تستخدم رقم شخص آخر.</p>
  <label class="nw-label" style="text-align:right;display:block" for="reverse-otp-phone">رقم WhatsApp</label>
  <input type="tel" id="reverse-otp-phone" class="nw-input" placeholder="05XXXXXXXX أو +966…" inputmode="tel" autocomplete="tel">
  <button type="button" id="reverse-otp-start" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;margin-top:1rem">تأكيد عبر WhatsApp</button>
  <div class="reverse-otp-panel" id="reverse-otp-panel" aria-live="polite">
    <canvas id="reverse-otp-qr" class="reverse-otp-qr" aria-label="رمز QR للتحقق"></canvas>
    <p id="reverse-otp-instructions" style="color:#fff"></p>
    <p style="font-family:monospace;font-size:1.1rem;color:var(--nawader-gold)" id="reverse-otp-code"></p>
    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap"><a id="reverse-otp-whatsapp" class="nw-btn nw-btn-primary" rel="noopener">فتح WhatsApp</a><a id="reverse-otp-sms" class="nw-btn nw-btn-ghost">فتح SMS</a><button type="button" id="reverse-otp-copy" class="nw-btn nw-btn-ghost">نسخ الرمز</button></div>
  </div>
  <p id="reverse-otp-state" style="margin-top:1rem;color:var(--text-muted)"></p>
</section></div></main>
@endsection
