@extends('layouts.app')
@section('title', 'التحقق من عقد رقمي — نوادر')
@section('page_title', 'سجل التوثيق السيادي العام')
@push('head')
<style>
.nw-verify-page{max-width:820px;margin:auto;padding:120px 24px 80px}
.nw-cert{border-radius:26px;padding:clamp(1.5rem,4vw,2.6rem);position:relative;overflow:hidden}
.nw-cert::before{content:'';position:absolute;inset:0;border-radius:26px;padding:1.5px;background:linear-gradient(135deg,rgba(212,168,67,.6),rgba(0,212,200,.35),transparent 60%);-webkit-mask:linear-gradient(#000 0 0) content-box,linear-gradient(#000 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none}
.nw-cert-row{display:flex;justify-content:space-between;gap:1rem;padding:.85rem 0;border-bottom:1px solid rgba(255,255,255,.07);font-size:.9rem}
.nw-cert-row small{color:var(--text-muted);display:block;margin-bottom:.2rem}
.nw-mono{font-family:'Courier New',monospace;font-size:.72rem;color:var(--nawader-teal);word-break:break-all}
.nw-verify-badge{display:inline-block;padding:.4rem 1.2rem;border-radius:999px;font-weight:800;font-size:.82rem}
.nw-vb-active{background:rgba(0,212,200,.14);color:var(--nawader-teal);border:1px solid rgba(0,212,200,.4)}
.nw-vb-pending{background:rgba(212,168,67,.12);color:var(--nawader-gold-light);border:1px solid rgba(212,168,67,.4)}
</style>
@endpush
@section('content')
<main class="nw-verify-page">
  <section class="nw-cert nw-cinematic-panel">
    <div style="text-align:center;margin-bottom:1.6rem">
      <div class="nw-section-eyebrow">NAWADER SOVEREIGN · PUBLIC LEDGER</div>
      <h1 class="nw-h1" style="margin:.5rem 0">شهادة تحقق من عقد رقمي</h1>
      @if($contract->status === 'active')
        <span class="nw-verify-badge nw-vb-active">✔ سجل موقّع ومختوم رقمياً — غير قابل للإنكار</span>
      @else
        <span class="nw-verify-badge nw-vb-pending">⏳ بانتظار توقيع العميل — الوثيقة مسودة</span>
      @endif
    </div>
    <div class="nw-cert-row"><div><small>رقم العقد</small><span class="nw-mono">{{ $contract->contract_number }}</span></div></div>
    <div class="nw-cert-row"><div><small>إصدار الوثيقة</small>{{ $contract->created_at?->format('Y/m/d H:i') }} (+03:00)</div>
      <div><small>تاريخ النفاذ الإلكتروني</small>{{ $contract->signed_at?->format('Y/m/d H:i') ?? '—' }} (+03:00)</div></div>
    @foreach(($contract->parties ?? []) as $party)
      <div class="nw-cert-row"><div><small>{{ $party['role'] ?? 'طرف' }}</small>{{ $party['name'] ?? '—' }}</div></div>
    @endforeach
    @if($contract->signature_hash)
      <div class="nw-cert-row"><div><small>بصمة التوقيع الإلكتروني (SHA-256)</small><span class="nw-mono">{{ $contract->signature_hash }}</span></div></div>
    @endif
    @if($contract->document_sha256)
      <div class="nw-cert-row"><div><small>بصمة نسخة PDF المؤرشفة (SHA-256)</small><span class="nw-mono">{{ $contract->document_sha256 }}</span></div></div>
    @endif
    <p style="color:var(--text-muted);font-size:.78rem;margin-top:1.4rem;line-height:1.8">
      صدر هذا السجل وفق نظام التعاملات الإلكترونية السعودي وقانون E-SIGN الأمريكي. أي تعديل لاحق على نسخة العقد
      الموقّعة يُبطل مطابقة بصمة الوثيقة أعلاه. هذا العرض العام يُظهر أدلة الإثبات فقط ولا يكشف البيانات الشخصية أو المالية.
    </p>
    <div style="text-align:center;margin-top:1.2rem">
      <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ route('home') }}">العودة إلى نوادر</a>
    </div>
  </section>
</main>
@endsection
