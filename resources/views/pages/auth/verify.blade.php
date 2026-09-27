@extends('layouts.app')
@section('title', 'التحقق والمصادقة الثنائية 2FA — منصة نوادر السيادية')

@push('head')
<style>
.nw-auth-page { min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 120px 1rem 3rem; position: relative; overflow: hidden; }
.nw-auth-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
.nw-auth-card {
  width: 100%; max-width: 480px; background: rgba(15,23,40,0.88); backdrop-filter: blur(35px);
  border: 1px solid rgba(0,212,200,0.25); border-radius: 28px; padding: 2.75rem;
  position: relative; z-index: 2; box-shadow: 0 40px 100px rgba(0,0,0,0.65), 0 0 35px rgba(0,212,200,0.08);
}
.otp-inputs {
  display: flex; gap: 0.75rem; justify-content: center; direction: ltr; margin: 2rem 0;
}
.otp-digit {
  width: 52px; height: 60px; text-align: center; font-size: 1.6rem; font-weight: 800;
  border-radius: 14px; background: rgba(255,255,255,0.04); border: 1.5px solid rgba(255,255,255,0.12);
  color: var(--nawader-teal); font-family: var(--font-latin); outline: none; transition: all 0.25s;
}
.otp-digit:focus {
  border-color: var(--nawader-teal); background: rgba(0,212,200,0.08);
  box-shadow: 0 0 20px rgba(0,212,200,0.3); transform: translateY(-2px);
}
.resend-timer-box {
  background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between;
  font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="nw-auth-page">
  <div class="nw-auth-orb" style="width:450px;height:450px;top:-80px;right:-80px;background:radial-gradient(circle,rgba(0,212,200,0.14) 0%,transparent 70%);"></div>
  <div class="nw-auth-orb" style="width:450px;height:450px;bottom:-100px;left:-100px;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>

  <div class="nw-auth-card" data-nw-animate>
    <div style="text-align:center;margin-bottom:1.5rem;">
      <div style="width:68px;height:68px;border-radius:20px;background:rgba(0,212,200,0.1);border:1px solid rgba(0,212,200,0.4);display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 1.25rem;box-shadow:0 0 25px rgba(0,212,200,0.25);">
        🛡️
      </div>
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.4rem;">المصادقة السيادية المتقدمة</div>
      <h1 style="font-size:1.5rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">التحقق من الهوية الرقمية</h1>
      <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;">
        تم إرسال رمز الأمان المكون من 6 أرقام إلى هاتفك وبريدك المعتمدين لضمان سلامة العمليات المؤسسية.
      </p>
    </div>

    <form method="POST" action="{{ route('dashboard') }}" id="verify-form" onsubmit="event.preventDefault(); window.location.href='{{ route('dashboard') }}';">
      @csrf

      <div class="otp-inputs">
        <input type="text" maxlength="1" class="otp-digit" autofocus oninput="moveNext(this, 1)" onkeydown="checkBack(event, this, 0)">
        <input type="text" maxlength="1" class="otp-digit" oninput="moveNext(this, 2)" onkeydown="checkBack(event, this, 1)">
        <input type="text" maxlength="1" class="otp-digit" oninput="moveNext(this, 3)" onkeydown="checkBack(event, this, 2)">
        <input type="text" maxlength="1" class="otp-digit" oninput="moveNext(this, 4)" onkeydown="checkBack(event, this, 3)">
        <input type="text" maxlength="1" class="otp-digit" oninput="moveNext(this, 5)" onkeydown="checkBack(event, this, 4)">
        <input type="text" maxlength="1" class="otp-digit" oninput="submitOtpIfComplete(this)" onkeydown="checkBack(event, this, 5)">
      </div>

      <div class="resend-timer-box">
        <span>إعادة إرسال الرمز خلال:</span>
        <span id="countdown" style="font-family:var(--font-latin);font-weight:700;color:var(--nawader-teal);">01:58</span>
        <button type="button" id="resend-btn" style="display:none;background:none;border:none;color:var(--nawader-gold);font-weight:700;cursor:pointer;font-family:var(--font-arabic);" onclick="resetCountdown()">
          إعادة الإرسال الآن
        </button>
      </div>

      <button type="submit" id="verify-submit-btn" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;padding:0.9rem;font-size:0.92rem;">
        <span>تأكيد الرمز والدخول إلى المنظومة</span>
        <span>←</span>
      </button>
    </form>

    <div class="nw-divider" style="margin:1.75rem 0 1.25rem;"></div>

    <div style="display:flex;flex-direction:column;gap:0.75rem;">
      <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;justify-content:center;gap:0.6rem;padding:0.75rem;background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);border-radius:12px;color:var(--text-secondary);font-size:0.82rem;text-decoration:none;transition:all 0.2s;" onmouseenter="this.style.background='rgba(255,255,255,0.06)'" onmouseleave="this.style.background='rgba(255,255,255,0.03)'">
        <span>🇸🇦</span>
        <span>المصادقة المباشرة عبر تطبيق نفاذ (الرمز 73)</span>
      </a>
      <a href="{{ route('login') }}" style="text-align:center;font-size:0.8rem;color:var(--text-muted);text-decoration:none;margin-top:0.5rem;">
        ← العودة لصفحة تسجيل الدخول
      </a>
    </div>
  </div>
</div>

<script>
function moveNext(current, nextIndex) {
  if (current.value.length >= 1) {
    const digits = document.querySelectorAll('.otp-digit');
    if (digits[nextIndex]) {
      digits[nextIndex].focus();
    }
  }
}
function checkBack(e, current, prevIndex) {
  if (e.key === 'Backspace' && !current.value) {
    const digits = document.querySelectorAll('.otp-digit');
    if (digits[prevIndex - 1]) {
      digits[prevIndex - 1].focus();
    }
  }
}
function submitOtpIfComplete(current) {
  if (current.value.length >= 1) {
    const digits = Array.from(document.querySelectorAll('.otp-digit')).map(d => d.value).join('');
    if (digits.length === 6) {
      setTimeout(() => {
        window.location.href = "{{ route('dashboard') }}";
      }, 400);
    }
  }
}

// Timer
let timeLeft = 118;
const timerEl = document.getElementById('countdown');
const resendBtn = document.getElementById('resend-btn');
const timerInterval = setInterval(() => {
  if (timeLeft <= 0) {
    clearInterval(timerInterval);
    timerEl.style.display = 'none';
    resendBtn.style.display = 'inline-block';
  } else {
    timeLeft--;
    const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
    const s = String(timeLeft % 60).padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;
  }
}, 1000);

function resetCountdown() {
  timeLeft = 120;
  resendBtn.style.display = 'none';
  timerEl.style.display = 'inline-block';
}
</script>
@endsection
