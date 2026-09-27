@extends('layouts.app')
@section('title', 'العقود — نوادر')
@section('page_title', 'العقود والتوقيع')
@push('head')
<style>
.nw-contract-page{max-width:1100px;margin:auto;padding:120px 28px 80px}.nw-contract-card{padding:1.5rem;border-radius:22px;margin-bottom:1rem}.nw-contract-meta{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-top:1rem}.nw-contract-meta div{padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem}.nw-contract-meta small{display:block;color:var(--text-muted);margin-bottom:.2rem}@media(max-width:700px){.nw-contract-page{padding:90px 18px 60px}.nw-contract-meta{grid-template-columns:1fr}}
</style>
@endpush
@section('content')
<main class="nw-contract-page">
  <header style="margin-bottom:1.3rem">
    <div class="nw-section-eyebrow">الحوكمة</div>
    <h1 class="nw-h1" style="margin:.55rem 0">العقود والتوقيع الإلكتروني</h1>
    <p style="color:var(--text-secondary)">السجلات هنا مرتبطة بالحساب الحالي فقط. لا يتم إنشاء عقد تلقائي أو عرض عقد تجريبي.</p>
  </header>
  @if(session('success'))
    <div class="nw-cinematic-panel" style="padding:1rem;margin-bottom:1rem;color:var(--nawader-teal)">{{ session('success') }}</div>
  @endif
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.25rem">
    <div class="nw-contract-card nw-cinematic-panel"><small>إجمالي العقود</small><strong style="font:800 1.8rem var(--font-latin)">{{ $contracts->count() }}</strong></div>
    <div class="nw-contract-card nw-cinematic-panel"><small>فعالة</small><strong style="font:800 1.8rem var(--font-latin)">{{ $contracts->where('status','active')->count() }}</strong></div>
    <div class="nw-contract-card nw-cinematic-panel"><small>بانتظار التوقيع</small><strong style="font:800 1.8rem var(--font-latin)">{{ $contracts->where('status','pending_signature')->count() }}</strong></div>
  </div>
  @if($contracts->isEmpty())
    <div class="nw-empty nw-cinematic-panel"><strong style="display:block;color:#fff;margin-bottom:.5rem">لا توجد عقود مرتبطة بحسابك</strong>ستظهر العقود هنا بعد إنشائها وتخصيصها لهذا الحساب.</div>
  @else
    @foreach($contracts as $contract)
      <article class="nw-contract-card nw-cinematic-panel">
        <div style="display:flex;justify-content:space-between;gap:1rem;align-items:start;flex-wrap:wrap">
          <div><div class="nw-section-eyebrow">{{ $contract->contract_number }}</div><h2 class="nw-h3" style="margin:.45rem 0">{{ $contract->title }}</h2><p style="color:var(--text-secondary);font-size:.84rem">{{ $contract->entity_name }}</p></div>
          <span class="nw-status">{{ $contract->status === 'active' ? 'فعال' : ($contract->status === 'pending_signature' ? 'بانتظار التوقيع' : $contract->status) }}</span>
        </div>
        <div class="nw-contract-meta">
          <div><small>القيمة</small>{{ number_format((float) $contract->amount, 2) }} {{ $contract->currency }}</div>
          <div><small>التوقيع</small>{{ $contract->signed_at?->format('Y/m/d H:i') ?: 'لم يوقّع بعد' }}</div>
          <div><small>البصمة</small>{{ $contract->signature_hash ? substr($contract->signature_hash, 0, 16).'…' : 'ستُنشأ بعد التوقيع' }}</div>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:.7rem;margin-top:1rem;flex-wrap:wrap">
          @if($contract->status === 'pending_signature')
            <a class="nw-btn nw-btn-primary nw-btn-sm" href="{{ route('dashboard.contracts.show', $contract->id) }}">✍️ دخول غرفة التوقيع الآمنة</a>
          @endif
          @if($contract->pdf_path && Storage::exists($contract->pdf_path))
            <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ route('dashboard.contracts.download', $contract->id) }}">تحميل PDF</a>
          @endif
          @if($contract->verification_token && $contract->status === 'active')
            <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ url('/verify/'.$contract->verification_token) }}" target="_blank" rel="noopener">🔍 سجل التوثيق العام</a>
          @endif
        </div>
      </article>
    @endforeach
  @endif
</main>
@endsection
