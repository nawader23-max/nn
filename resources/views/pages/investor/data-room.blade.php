@extends('layouts.app')

@section('title', 'غرفة البيانات — نوادر')
@section('page_title', 'غرفة البيانات الافتراضية')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1100px;">
    <div class="nw-cinematic-panel" style="padding:2.5rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">الوصول المصرح به فقط</div>
      <h1 style="color:#fff;font-size:2rem;margin:.4rem 0 .8rem;">غرفة البيانات الافتراضية</h1>
      <p style="color:var(--text-secondary);max-width:760px;line-height:1.9;margin:0;">تظهر هنا مستندات الفحص النافي للجهالة بعد ربط حسابك بفرصة منشورة ومنحك صلاحية صريحة. لا يتم إنشاء ملفات أو سجلات تدقيق وهمية.</p>
    </div>
    <div class="nw-cinematic-panel" style="padding:3rem;text-align:center;">
      <div style="font-size:3rem;margin-bottom:1rem;">🔐</div>
      <h2 style="color:#fff;font-size:1.35rem;margin:0 0 .75rem;">لا توجد مستندات متاحة لحسابك حالياً</h2>
      <p style="color:var(--text-secondary);max-width:640px;margin:0 auto 1.5rem;line-height:1.8;">اطلب تفعيل الوصول من فريق نوادر بعد تحديد الفرصة المناسبة لك.</p>
      <a href="{{ route('investor.consultations') }}" class="nw-btn nw-btn-primary">طلب تفعيل الوصول</a>
    </div>
  </div>
</div>
@endsection
