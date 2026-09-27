@extends('layouts.app')

@section('title', 'تفاصيل القيد المالي — نوادر')
@section('page_title', 'تفاصيل القيد المالي')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:900px;">
    <div style="display:flex;justify-content:space-between;gap:1rem;align-items:center;flex-wrap:wrap;margin-bottom:1.25rem;"><a href="{{ route('dashboard.payments') }}" class="nw-btn nw-btn-ghost">العودة للمدفوعات</a><button class="nw-btn nw-btn-primary" onclick="window.print()">طباعة</button></div>
    <div class="nw-cinematic-panel" style="padding:2.5rem;">
      @if(!$transaction)
        <div class="nw-section-eyebrow">لا يوجد سجل مطابق</div>
        <h1 style="color:#fff;font-size:1.8rem;margin:.35rem 0 .8rem;">القيد المالي غير متاح</h1>
        <p style="color:var(--text-secondary);line-height:1.8;margin:0;">لم يتم العثور على قيد مالي بهذا المعرّف ضمن حسابك. لن نعرض فاتورة أو بيانات غير مرتبطة بسجلك الحقيقي.</p>
      @else
      <div class="nw-section-eyebrow">سجل مالي مرتبط بحسابك</div>
      <h1 style="color:#fff;font-size:1.8rem;margin:.35rem 0 1.5rem;">{{ $transaction->transaction_number ?: 'قيد مالي #'.$transaction->id }}</h1>
      <div class="nw-grid nw-grid-2" style="gap:1rem;">
        <div><div class="nw-kpi-label">الوصف</div><div style="color:#fff;">{{ $transaction->description ?: 'قيد محفظة' }}</div></div>
        <div><div class="nw-kpi-label">التاريخ</div><div style="color:#fff;">{{ $transaction->created_at?->format('Y-m-d H:i') }}</div></div>
        <div><div class="nw-kpi-label">القيمة</div><div style="color:var(--nawader-gold);font-size:1.5rem;font-weight:900;">{{ number_format((float) $transaction->amount, 2) }} {{ $transaction->currency ?: 'SAR' }}</div></div>
        <div><div class="nw-kpi-label">الحالة</div><div><span class="nw-badge nw-badge-teal">{{ $transaction->status }}</span></div></div>
      </div>
      <div style="border-top:1px solid rgba(255,255,255,.08);margin-top:2rem;padding-top:1rem;color:var(--text-muted);font-size:.82rem;line-height:1.8;">هذا العرض يقرأ سجلاً محفوظاً في حسابك. لا يمثل فاتورة ضريبية ما لم تُصدر فاتورة رسمية مرتبطة بهذا القيد من النظام المحاسبي.</div>
      @endif
    </div>
  </div>
</div>
@endsection
