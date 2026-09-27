@extends('layouts.app')
@section('title', 'استعادة كلمة المرور — بوابة نوادر السيادية')

@push('head')
<style>
.nw-auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 120px 1rem 3rem; position: relative; overflow: hidden; }
.nw-auth-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
.nw-auth-card {
  width: 100%; max-width: 480px; background: rgba(15,23,40,0.88); backdrop-filter: blur(35px);
  border: 1px solid rgba(212,168,67,0.22); border-radius: 28px; padding: 2.75rem;
  position: relative; z-index: 2; box-shadow: 0 40px 100px rgba(0,0,0,0.65), 0 0 40px rgba(212,168,67,0.08);
}
.nw-auth-channel-tab {
  display: flex; gap: 0.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px; padding: 0.25rem; margin-bottom: 1.5rem;
}
.channel-btn {
  flex: 1; padding: 0.6rem; border-radius: 9px; border: none; font-size: 0.8rem; font-weight: 700;
  cursor: pointer; transition: all 0.2s; background: transparent; color: var(--text-muted); font-family: var(--font-arabic);
}
.channel-btn.active { background: var(--grad-gold); color: var(--nawader-navy); box-shadow: 0 2px 10px rgba(212,168,67,0.3); }
</style>
@endpush

@section('content')
<div class="nw-auth-page">
  <div class="nw-auth-orb" style="width:500px;height:500px;top:-100px;right:-100px;background:radial-gradient(circle,rgba(212,168,67,0.14) 0%,transparent 70%);"></div>
  <div class="nw-auth-orb" style="width:400px;height:400px;bottom:-80px;left:-80px;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>

  <div class="nw-auth-card" data-nw-animate>
    <div style="text-align:center;margin-bottom:2rem;">
      <div style="width:68px;height:68px;border-radius:20px;background:rgba(212,168,67,0.1);border:1px solid rgba(212,168,67,0.35);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 1.25rem;box-shadow:0 0 25px rgba(212,168,67,0.2);">
        🔑
      </div>
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.4rem;">استعادة بيانات الدخول السيادية</div>
      <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">استعادة كلمة المرور</h1>
      <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;">
        أدخل عنوان بريدك الإلكتروني المسجل في المنصة أو رقم الهوية الرقمية لاستلام رابط فوري مشفر لإعادة تعيين الدخول.
      </p>
    </div>

    @if(session('status'))
    <div style="background:rgba(0,212,200,0.1);border:1px solid rgba(0,212,200,0.4);border-radius:14px;padding:1rem;margin-bottom:1.75rem;font-size:0.85rem;color:#7bf5ee;display:flex;align-items:center;gap:0.75rem;">
      <span style="font-size:1.3rem;">✓</span>
      <div>
        <div style="font-weight:700;">تم إرسال رابط التعيين بنجاح</div>
        <div style="font-size:0.78rem;opacity:0.85;">تحقق من صندوق الوارد أو البريد غير الهام (Spam) خلال دقيقة واحدة.</div>
      </div>
    </div>
    @endif

    <div class="nw-auth-channel-tab">
      <button type="button" class="channel-btn active" onclick="switchMethod('email', this)">📧 البريد المعتمد</button>
      <button type="button" class="channel-btn" onclick="switchMethod('national', this)">🇸🇦 نفاذ الوطني</button>
      <button type="button" class="channel-btn" onclick="switchMethod('ein', this)">🇺🇸 US EIN / Phone</button>
    </div>

    <form method="POST" action="{{ route('password.email') }}" id="forgot-password-form">
      @csrf
      
      <div id="method-email-box" style="margin-bottom:1.75rem;">
        <div class="nw-input-group">
          <label class="nw-label" for="forgot-email">البريد الإلكتروني المؤسسي أو الشخصي</label>
          <input type="email" name="email" id="forgot-email" class="nw-input" placeholder="corp-lead@company.sa" required autofocus>
          <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.4rem;">
            🔒 معالج عبر بوابة التشفير السيادي TLS 1.3 مع مفاتيح HSM
          </div>
        </div>
      </div>

      <div id="method-national-box" style="display:none;margin-bottom:1.75rem;">
        <div class="nw-input-group">
          <label class="nw-label">رقم الهوية الوطنية أو الإقامة (نفاذ)</label>
          <input type="text" class="nw-input" placeholder="10xxxxxxxx / 20xxxxxxxx" maxlength="10">
          <div style="font-size:0.75rem;color:var(--nawader-teal);margin-top:0.4rem;">
            🇸🇦 سيتم توجيه طلب المصادقة لتطبيق نفاذ المعتمد
          </div>
        </div>
      </div>

      <div id="method-ein-box" style="display:none;margin-bottom:1.75rem;">
        <div class="nw-input-group">
          <label class="nw-label">US Federal EIN or US Phone Number</label>
          <input type="text" class="nw-input" placeholder="XX-XXXXXXX / +1 (555) 000-0000">
          <div style="font-size:0.75rem;color:#78a9ff;margin-top:0.4rem;">
            🇺🇸 Bilateral SMS verification dispatched via Twilio GovCloud
          </div>
        </div>
      </div>

      <button type="submit" id="forgot-submit-btn" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;padding:0.9rem;font-size:0.92rem;">
        <span>إرسال تعليمات إعادة التعيين</span>
        <span style="font-size:1.1rem;">⚡</span>
      </button>
    </form>

    <div style="text-align:center;margin-top:1.75rem;font-size:0.85rem;color:var(--text-muted);">
      تذكرت كلمة المرور؟ <a href="{{ route('login') }}" style="color:var(--nawader-gold);font-weight:700;">تسجيل الدخول</a>
    </div>

    <div class="nw-divider" style="margin:1.5rem 0;"></div>

    <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.78rem;color:var(--text-muted);">
      <span>مركز الاستجابة السيادي:</span>
      <a href="tel:8001234567" style="color:var(--nawader-teal);font-weight:700;direction:ltr;">800-123-4567</a>
    </div>
  </div>
</div>

<script>
function switchMethod(method, btn) {
  document.querySelectorAll('.channel-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('method-email-box').style.display = method === 'email' ? 'block' : 'none';
  document.getElementById('method-national-box').style.display = method === 'national' ? 'block' : 'none';
  document.getElementById('method-ein-box').style.display = method === 'ein' ? 'block' : 'none';
}
</script>
@endsection
