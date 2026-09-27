@extends('layouts.app')

@section('title', 'ربط واتساب للمصادقة — نوادر')
@section('page_title', 'ربط قناة المصادقة')

@push('head')
<style>
.nw-pairing { padding: 120px 0 80px; }
.pairing-card { max-width: 760px; margin: auto; padding: 2.5rem; border-radius: 28px; background: rgba(15,23,40,.9); border: 1px solid rgba(255,255,255,.1); box-shadow: 0 24px 64px rgba(0,0,0,.35); text-align: center; }
.pairing-qr { width: 280px; min-height: 280px; margin: 2rem auto; padding: 14px; border-radius: 20px; background: #fff; display: grid; place-items: center; }
.pairing-qr img { max-width: 100%; display: block; }
.pairing-status { padding: .7rem 1rem; border-radius: 99px; display: inline-block; background: rgba(0,212,200,.12); color: var(--nawader-teal); font-weight: 800; }
</style>
@endpush

@section('content')
<main class="nw-pairing"><div class="nw-container"><section class="pairing-card">
  <div class="nw-section-eyebrow">إدارة محمية</div>
  <h1 style="color:#fff;font-size:1.8rem;margin:.6rem 0">ربط رقم واتساب لقناة التحقق</h1>
  <p style="color:var(--text-muted);line-height:1.8">امسح الرمز من واتساب على الهاتف المخصص: الأجهزة المرتبطة ← ربط جهاز. لا تشارك هذا الرمز أو شاشة الإدارة.</p>
  <div class="pairing-qr" id="pairing-qr"><span style="color:#182033">جاري تجهيز رمز الربط…</span></div>
  <div class="pairing-status" id="pairing-status">بانتظار خدمة الاستقبال</div>
  <p style="margin-top:1.4rem;color:var(--text-muted);font-size:.86rem">ينتهي رمز الربط تلقائياً؛ تُحدّث الصفحة نفسها كل ثلاث ثوانٍ.</p>
</section></div></main>
<script>
(() => {
  const url = @json(route('reverse-otp.pairing.status'));
  const box = document.getElementById('pairing-qr');
  const status = document.getElementById('pairing-status');
  async function refresh() {
    try {
      const response = await fetch(url, { headers: { Accept: 'application/json' }, credentials: 'same-origin' });
      const data = await response.json();
      if (data.status === 'connected') { box.innerHTML = '<strong style="color:#087f5b">تم ربط القناة بنجاح ✓</strong>'; status.textContent = 'القناة متصلة وجاهزة'; return; }
      if (data.qr) { box.innerHTML = '<img alt="رمز ربط واتساب" src="' + data.qr + '">'; status.textContent = 'امسح رمز الربط من واتساب'; return; }
      status.textContent = data.status === 'unavailable' ? 'الخدمة غير متاحة حالياً' : 'بانتظار رمز جديد…';
    } catch (_) { status.textContent = 'تعذر الوصول إلى خدمة الربط'; }
  }
  refresh(); setInterval(refresh, 3000);
})();
</script>
@endsection
