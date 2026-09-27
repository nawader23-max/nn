@extends('layouts.app')
@section('title', 'إنشاء حساب — نوادر')
@push('head')
<style>
.nw-auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 100px 1rem 2rem; position: relative; overflow: hidden; }
.nw-auth-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
.nw-auth-card { width: 100%; max-width: 500px; background: rgba(15,23,40,0.85); backdrop-filter: blur(30px); border: 1px solid rgba(212,168,67,0.15); border-radius: 28px; padding: 2.5rem; position: relative; z-index: 2; box-shadow: 0 40px 100px rgba(0,0,0,0.6); }
.nw-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
</style>
@endpush
@section('content')
<div class="nw-auth-page">
  <div class="nw-auth-orb" style="width:500px;height:500px;top:-100px;left:-100px;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>
  <div class="nw-auth-card" data-nw-animate>
    <div style="text-align:center;margin-bottom:2rem;">
      <div style="width:60px;height:60px;border-radius:18px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:900;color:var(--nawader-navy);margin:0 auto 1.25rem;box-shadow:var(--shadow-gold);">ن</div>
      <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:0.4rem;">أنشئ حسابك</h1>
      <p style="font-size:0.85rem;color:var(--text-muted);">انضم إلى +15,000 عميل يثقون بنوادر</p>
    </div>
    @if($errors->any())
    <div style="background:rgba(232,93,138,0.1);border:1px solid rgba(232,93,138,0.3);border-radius:12px;padding:0.9rem;margin-bottom:1.5rem;font-size:0.82rem;color:#FF9BC0;">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('register.post') }}" id="register-form">
      @csrf
      <div style="display:flex;flex-direction:column;gap:1.25rem;margin-bottom:2rem;">
        <div class="nw-input-group">
          <label class="nw-label">الاسم الكامل</label>
          <input type="text" name="name" id="reg-name" class="nw-input" placeholder="محمد العمري" value="{{ old('name') }}" required>
        </div>
        <div class="nw-input-group">
          <label class="nw-label">البريد الإلكتروني</label>
          <input type="email" name="email" id="reg-email" class="nw-input" placeholder="name@company.com" value="{{ old('email') }}" required>
        </div>
        <div class="nw-form-grid">
          <div class="nw-input-group">
            <label class="nw-label">كلمة المرور</label>
            <input type="password" name="password" id="reg-password" class="nw-input" placeholder="8+ أحرف" required>
          </div>
          <div class="nw-input-group">
            <label class="nw-label">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" id="reg-password-confirm" class="nw-input" placeholder="أعد الإدخال" required>
          </div>
        </div>
        <label style="display:flex;align-items:flex-start;gap:0.6rem;cursor:pointer;font-size:0.78rem;color:var(--text-muted);">
          <input type="checkbox" required style="width:16px;height:16px;accent-color:var(--nawader-gold);margin-top:2px;">
          <span>أوافق على <a href="{{ route('terms') }}" style="color:var(--nawader-gold);">شروط الاستخدام</a> و<a href="{{ route('privacy') }}" style="color:var(--nawader-gold);">سياسة الخصوصية</a></span>
        </label>
      </div>
      <button type="submit" id="register-submit-btn" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;">
        إنشاء الحساب مجاناً
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
    </form>
    <div style="text-align:center;margin-top:1.5rem;font-size:0.82rem;color:var(--text-muted);">
      لديك حساب؟ <a href="{{ route('login') }}" style="color:var(--nawader-gold);font-weight:700;">سجل دخولك</a>
    </div>
    <div style="display:flex;align-items:center;justify-content:center;gap:2rem;margin-top:1.5rem;flex-wrap:wrap;">
      @foreach(['لا رسوم للتسجيل','بيانات مؤمّنة','دعم فوري'] as $g)
      <div style="display:flex;align-items:center;gap:0.4rem;font-size:0.72rem;color:var(--text-muted);">
        <span style="color:var(--nawader-teal);">✓</span> {{ $g }}
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
