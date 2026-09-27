@extends('layouts.app')

@section('title', 'المدفوعات والفواتير — نوادر')
@section('page_title', 'المدفوعات والفواتير')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1200px;">
    <div class="nw-cinematic-panel" style="padding:2.25rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">الإدارة المالية</div>
      <div style="display:flex;justify-content:space-between;gap:1rem;align-items:flex-start;flex-wrap:wrap;">
        <div><h1 style="color:#fff;font-size:2rem;margin:.35rem 0 .7rem;">المدفوعات والفواتير</h1><p style="color:var(--text-secondary);margin:0;line-height:1.8;">يعرض هذا القسم القيود المالية المسجلة فعلياً لحسابك فقط.</p></div>
        <a href="{{ route('dashboard.wallet') }}" class="nw-btn nw-btn-primary">عرض المحفظة</a>
      </div>
    </div>
    <div class="nw-grid nw-grid-3" style="margin-bottom:1.5rem;">
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">الرصيد الحالي</div><div style="font-size:1.75rem;font-weight:900;color:var(--nawader-teal);">{{ number_format((float) ($wallet['balance'] ?? 0), 2) }} ر.س</div></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">المدفوع والمسوى</div><div style="font-size:1.75rem;font-weight:900;color:var(--nawader-gold);">{{ number_format((float) $paid, 2) }} ر.س</div></div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;"><div class="nw-kpi-label">قيد الاستحقاق</div><div style="font-size:1.75rem;font-weight:900;color:#fff;">{{ number_format((float) $due, 2) }} ر.س</div></div>
    </div>
    <div class="nw-cinematic-panel" style="padding:1.5rem;overflow:auto;">
      <h2 style="color:#fff;font-size:1.25rem;margin:0 0 1rem;">سجل القيود المالية</h2>
      @forelse($transactions as $transaction)
        <div style="display:grid;grid-template-columns:1.2fr 1.8fr 1fr 1fr;gap:1rem;align-items:center;padding:1rem;border-bottom:1px solid rgba(255,255,255,.07);min-width:680px;">
          <div><strong style="color:var(--nawader-gold);font-family:var(--font-latin);">{{ $transaction->transaction_number ?: '—' }}</strong><div style="font-size:.75rem;color:var(--text-muted);">{{ $transaction->created_at?->format('Y-m-d H:i') }}</div></div>
          <div style="color:#fff;">{{ $transaction->description ?: 'قيد محفظة' }}<div style="font-size:.75rem;color:var(--text-muted);">{{ $transaction->payment_method ?: 'غير محدد' }}</div></div>
          <div style="font-weight:800;color:var(--nawader-teal);">{{ number_format((float) $transaction->amount, 2) }} {{ $transaction->currency ?: 'SAR' }}</div>
          <div><span class="nw-badge nw-badge-teal">{{ $transaction->status }}</span></div>
        </div>
      @empty
        <div style="padding:2.5rem;text-align:center;color:var(--text-muted);">لا توجد قيود مالية مسجلة لحسابك حتى الآن.</div>
      @endforelse
      @if($transactions->hasPages())<div style="margin-top:1rem;">{{ $transactions->links() }}</div>@endif
    </div>
  </div>
</div>
@endsection
