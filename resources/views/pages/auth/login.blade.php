@extends('layouts.app')
@section('title', 'تسجيل الدخول — نوادر')
@push('head')
<style>
.nw-auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 100px 1rem 2rem; position: relative; overflow: hidden; }
.nw-auth-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
.nw-auth-card { width: 100%; max-width: 440px; background: rgba(15,23,40,0.85); backdrop-filter: blur(30px); border: 1px solid rgba(212,168,67,0.15); border-radius: 28px; padding: 2.5rem; position: relative; z-index: 2; box-shadow: 0 40px 100px rgba(0,0,0,0.6); }
.reverse-otp-panel { display:none; margin-top:1.25rem; padding:1rem; border:1px solid rgba(0,212,200,.24); background:rgba(0,212,200,.05); border-radius:16px; text-align:center; }
.reverse-otp-panel.is-active { display:block; }
.reverse-otp-qr { display:none; width:190px; height:190px; margin:1rem auto; padding:10px; border-radius:12px; background:#fff; }
.reverse-otp-qr.is-active { display:block; }
</style>
@vite('resources/js/reverse-otp.js')
@endpush
@section('content')
<div class="nw-auth-page">
  <div class="nw-auth-orb" style="width:500px;height:500px;top:-100px;right:-100px;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="nw-auth-orb" style="width:400px;height:400px;bottom:-100px;left:-100px;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>
  <div class="nw-auth-card" data-nw-animate>
    <div style="text-align:center;margin-bottom:2rem;">
      <div style="width:60px;height:60px;border-radius:18px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:900;color:var(--nawader-navy);margin:0 auto 1.25rem;box-shadow:var(--shadow-gold);">ن</div>
      <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:0.4rem;">مرحباً بعودتك</h1>
      <p style="font-size:0.85rem;color:var(--text-muted);">أدخل بياناتك للوصول إلى حسابك</p>
    </div>
    @if($errors->any())
    <div style="background:rgba(232,93,138,0.1);border:1px solid rgba(232,93,138,0.3);border-radius:12px;padding:0.9rem;margin-bottom:1.5rem;font-size:0.82rem;color:#FF9BC0;">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('login.post') }}" id="login-form">
      @csrf
      <div style="display:flex;flex-direction:column;gap:1.25rem;margin-bottom:2rem;">
        <div class="nw-input-group">
          <label class="nw-label">البريد الإلكتروني</label>
          <input type="email" name="email" id="login-email" class="nw-input" placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="nw-input-group">
          <label class="nw-label" style="display:flex;justify-content:space-between;">
            <span>كلمة المرور</span>
            <a href="{{ route('password.request') }}" style="color:var(--nawader-teal);font-size:0.78rem;">نسيت كلمة المرور؟</a>
          </label>
          <input type="password" name="password" id="login-password" class="nw-input" placeholder="••••••••" required autocomplete="current-password">
        </div>
        <label style="display:flex;align-items:center;gap:0.6rem;cursor:pointer;font-size:0.82rem;color:var(--text-muted);">
          <input type="checkbox" name="remember" style="width:16px;height:16px;accent-color:var(--nawader-gold);"> تذكرني
        </label>
      </div>
      <button type="submit" id="login-submit-btn" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;">
        تسجيل الدخول
      </button>
    </form>
    <div class="nw-divider" style="margin:1.5rem 0;"></div>
    <section id="reverse-otp" data-generate-url="{{ route('reverse-otp.generate') }}" data-status-url="{{ route('reverse-otp.status') }}">
      <p style="text-align:center;font-size:.82rem;color:var(--text-muted);margin:0 0 .75rem;">أو ادخل برقم هاتفك الموثق</p>
      <div class="nw-input-group">
        <label class="nw-label" for="reverse-otp-phone">رقم WhatsApp</label>
        <input type="tel" id="reverse-otp-phone" class="nw-input" placeholder="05XXXXXXXX أو +966…" inputmode="tel" autocomplete="tel">
      </div>
      <button type="button" id="reverse-otp-start" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;margin-top:.8rem;">تحقق عبر WhatsApp</button>
      <div class="reverse-otp-panel" id="reverse-otp-panel" aria-live="polite">
        <p id="reverse-otp-instructions" style="font-size:.8rem;margin:0;color:var(--text-secondary);">أرسل الرمز إلى رقم الخدمة، وسنكمل الدخول تلقائياً.</p>
        <canvas id="reverse-otp-qr" class="reverse-otp-qr" aria-label="رمز QR لتسجيل الدخول عبر WhatsApp"></canvas>
        <code id="reverse-otp-code" style="display:block;direction:ltr;font-size:1rem;color:var(--nawader-teal);margin:.8rem 0;"></code>
        <div style="display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;">
          <a id="reverse-otp-whatsapp" class="nw-btn nw-btn-primary" style="font-size:.8rem;display:none;" rel="noopener">فتح WhatsApp</a>
          <a id="reverse-otp-sms" class="nw-btn" style="font-size:.8rem;border:1px solid rgba(255,255,255,.18);display:none;" rel="noopener">فتح SMS</a>
          <button type="button" id="reverse-otp-copy" class="nw-btn" style="font-size:.8rem;border:1px solid rgba(255,255,255,.18);">نسخ الرمز</button>
        </div>
        <p id="reverse-otp-state" style="font-size:.76rem;color:var(--text-muted);margin:.8rem 0 0;"></p>
      </div>
    </section>
    <div style="text-align:center;margin-top:1.5rem;font-size:0.82rem;color:var(--text-muted);">
      ليس لديك حساب؟ <a href="{{ route('register') }}" style="color:var(--nawader-gold);font-weight:700;">أنشئ حساباً مجاناً</a>
    </div>
    <div class="nw-divider" style="margin:1.5rem 0;"></div>
    <div style="display:flex;gap:0.75rem;">
      <button style="flex:1;padding:0.75rem;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:var(--text-secondary);font-size:0.82rem;cursor:pointer;font-family:var(--font-arabic);transition:all 0.2s;" onmouseenter="this.style.background='rgba(255,255,255,0.07)'" onmouseleave="this.style.background='rgba(255,255,255,0.04)'">🇸🇦 نفاذ</button>
      <button style="flex:1;padding:0.75rem;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:var(--text-secondary);font-size:0.82rem;cursor:pointer;font-family:var(--font-arabic);transition:all 0.2s;" onmouseenter="this.style.background='rgba(255,255,255,0.07)'" onmouseleave="this.style.background='rgba(255,255,255,0.04)'">Google</button>
    </div>
  </div>
</div>
@endsection
