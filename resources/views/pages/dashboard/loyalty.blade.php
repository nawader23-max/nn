@extends('layouts.app')

@section('title', 'برنامج الولاء والمكافآت — نوادر')
@section('page_title', 'برنامج الولاء السيادي')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1200px;">
    <div class="nw-cinematic-panel" style="padding:2.25rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">المكافآت وتقدير الشركاء</div>
      <div style="display:flex;justify-content:space-between;gap:1.25rem;align-items:flex-start;flex-wrap:wrap;">
        <div>
          <h1 style="margin:.35rem 0 .7rem;color:#fff;font-size:2rem;">برنامج الولاء والمكافآت السيادية</h1>
          <p style="max-width:680px;color:var(--text-secondary);margin:0;line-height:1.8;">نحتسب المزايا من العمليات المسجلة فعلياً في حسابك. لا يتم عرض نقاط أو خصومات أو مكافآت ما لم تكن مفعّلة ومثبتة في النظام.</p>
        </div>
        <a href="{{ route('dashboard.wallet') }}" class="nw-btn nw-btn-ghost">💳 عرض المحفظة</a>
      </div>
    </div>

    <div class="nw-grid nw-grid-3" style="margin-bottom:1.5rem;">
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">الفئة الحالية</div><div style="font-size:1.45rem;font-weight:900;color:var(--nawader-gold);">{{ $account->tier_name ?: 'غير محددة' }}</div></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">رصيد النقاط</div><div style="font-size:1.9rem;font-weight:900;color:var(--nawader-teal);">{{ number_format((int) ($account->points_balance ?? 0)) }}</div></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">نسبة الخصم</div><div style="font-size:1.9rem;font-weight:900;color:#fff;">{{ number_format((float) ($account->discount_rate ?? 0), 2) }}%</div></div>
    </div>

    <div class="nw-cinematic-panel" style="padding:2rem;">
      <div class="nw-section-eyebrow">الاستبدال</div>
      <h2 style="color:#fff;font-size:1.35rem;margin:.35rem 0 .75rem;">لا توجد مكافآت مفعّلة حالياً</h2>
      <p style="color:var(--text-secondary);max-width:720px;line-height:1.8;margin:0;">سيظهر هنا كتالوج المكافآت عند تفعيله من إدارة المنصة وربطه بقواعد احتساب موثقة. رصيدك الحالي محفوظ كما هو دون إنشاء بيانات افتراضية.</p>
    </div>
  </div>
</div>
@endsection
