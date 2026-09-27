@extends('layouts.app')

@section('title', 'بوابة المستثمرين — نوادر')
@section('page_title', 'بوابة المستثمرين')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1180px;">
    <div class="nw-cinematic-panel" style="padding:2.5rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">بوابة المستثمرين والشركاء</div>
      <h1 style="color:#fff;font-size:2.15rem;margin:.4rem 0 .8rem;">قرارات استثمارية مبنية على بيانات موثقة</h1>
      <p style="color:var(--text-secondary);max-width:760px;line-height:1.9;margin:0 0 1.5rem;">نفتح غرف الفرص والوثائق بعد اعتمادها ونشرها من إدارة المنصة. لن تظهر أرقام أو فرص افتراضية في حسابك.</p>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap;"><a class="nw-btn nw-btn-primary" href="{{ route('investor.opportunities') }}">الفرص المنشورة</a><a class="nw-btn nw-btn-ghost" href="{{ route('investor.consultations') }}">احجز جلسة استشارية</a></div>
    </div>
    <div class="nw-grid nw-grid-3">
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div style="font-size:1.7rem;">🛡️</div><h3 style="color:#fff;margin:.5rem 0;">وصول مضبوط</h3><p style="color:var(--text-secondary);line-height:1.7;margin:0;">صلاحيات منفصلة لكل مستخدم وغرفة بيانات.</p></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div style="font-size:1.7rem;">📑</div><h3 style="color:#fff;margin:.5rem 0;">مستندات أصلية</h3><p style="color:var(--text-secondary);line-height:1.7;margin:0;">يتم نشر الملفات بعد التحقق من مصدرها وتاريخها.</p></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div style="font-size:1.7rem;">🤝</div><h3 style="color:#fff;margin:.5rem 0;">تواصل مباشر</h3><p style="color:var(--text-secondary);line-height:1.7;margin:0;">يمكنك طلب جلسة مع الفريق المختص دون التزام.</p></div>
    </div>
  </div>
</div>
@endsection
