@extends('layouts.app')

@section('title', 'الفرص المنشورة — نوادر')
@section('page_title', 'الفرص الاستثمارية')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1180px;">
    <div class="nw-cinematic-panel" style="padding:2.25rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">الفرص الاستثمارية</div>
      <h1 style="color:#fff;font-size:2rem;margin:.35rem 0 .75rem;">الفرص المعتمدة للنشر</h1>
      <p style="color:var(--text-secondary);max-width:740px;line-height:1.85;margin:0;">لا توجد فرص استثمارية منشورة في هذه اللحظة. سيتم عرض كل فرصة بعد اعتماد بياناتها ومستنداتها من إدارة المنصة.</p>
    </div>
    <div class="nw-cinematic-panel" style="padding:3rem;text-align:center;">
      <div style="font-size:3rem;margin-bottom:1rem;">◌</div>
      <h2 style="color:#fff;font-size:1.35rem;margin:0 0 .75rem;">قائمة الفرص فارغة حالياً</h2>
      <p style="color:var(--text-secondary);max-width:620px;margin:0 auto 1.5rem;line-height:1.8;">للتعرف على مسارات الشراكة المتاحة، تواصل مع فريق نوادر عبر جلسة استشارية موثقة.</p>
      <a href="{{ route('investor.consultations') }}" class="nw-btn nw-btn-primary">طلب جلسة استشارية</a>
    </div>
  </div>
</div>
@endsection
