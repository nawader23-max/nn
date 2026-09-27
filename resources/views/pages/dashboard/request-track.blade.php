@extends('layouts.app')
@section('title', 'تتبع الطلب — نوادر')
@section('page_title', 'تتبع الطلب')
@push('head')
<style>.nw-track-page{max-width:900px;margin:auto;padding:120px 28px 80px}.nw-track-card{border-radius:28px;padding:clamp(1.5rem,4vw,2.5rem)}.nw-track-rail{margin-top:2rem;padding-right:1.4rem;border-right:1px solid rgba(212,168,67,.35)}.nw-track-step{position:relative;padding:0 1.4rem 1.8rem}.nw-track-step::before{content:'';position:absolute;width:12px;height:12px;border-radius:50%;right:-1.78rem;top:.35rem;background:var(--nawader-teal);box-shadow:0 0 0 5px rgba(0,212,200,.13)}.nw-track-step.future::before{background:rgba(255,255,255,.25);box-shadow:none}@media(max-width:640px){.nw-track-page{padding:90px 18px 60px}}</style>
@endpush
@section('content')
<main class="nw-track-page"><a href="{{route('dashboard.requests.show',$operation->request_number)}}" style="display:inline-block;color:var(--nawader-gold);margin-bottom:1rem">← تفاصيل الطلب</a><section class="nw-track-card nw-cinematic-panel"><div class="nw-section-eyebrow">{{ $operation->request_number }}</div><h1 class="nw-h1" style="margin:.55rem 0">مسار الطلب</h1><p style="color:var(--text-secondary)">المراحل أدناه مشتقة من الحالة الحالية للطلب، وليست اتصالاً مباشراً بأي جهة خارجية.</p><div class="nw-progress" style="height:8px;margin-top:1.4rem"><i style="width:{{ $operation->progress }}%"></i></div><div class="nw-track-rail"><article class="nw-track-step"><strong>تم استلام الطلب</strong><p style="color:var(--text-muted);font-size:.84rem;margin-top:.25rem">{{ $operation->submitted_at?->format('Y/m/d H:i') }}</p></article><article class="nw-track-step {{ $operation->progress < 30 ? 'future' : '' }}"><strong>المراجعة الأولية</strong><p style="color:var(--text-muted);font-size:.84rem;margin-top:.25rem">تُحدّث عند بدء المراجعة من فريق العمل.</p></article><article class="nw-track-step {{ $operation->progress < 70 ? 'future' : '' }}"><strong>التنفيذ والمتابعة</strong><p style="color:var(--text-muted);font-size:.84rem;margin-top:.25rem">الحالة الحالية: {{ $operation->statusLabel() }}</p></article><article class="nw-track-step {{ $operation->status !== 'completed' ? 'future' : '' }}"><strong>الإنجاز والإغلاق</strong><p style="color:var(--text-muted);font-size:.84rem;margin-top:.25rem">تظهر عند اكتمال الطلب وتوثيق النتيجة.</p></article></div></section>
<section class="nw-track-card nw-cinematic-panel" style="margin-top:1.1rem" id="liveCard">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
    <h2 class="nw-h3">التحديثات المباشرة</h2>
    <span id="livePill" class="nw-status" style="height:max-content">{{ $operation->statusLabel() }}</span>
  </div>
  <div id="liveFeed" style="margin-top:1rem"></div>
</section>
</main>
@endsection
@push('scripts')
<script>
(function(){
  const FEED='{{ route("dashboard.requests.events", $operation->request_number) }}';
  const fmt=iso=>iso?new Date(iso).toLocaleString('ar-SA',{dateStyle:'short',timeStyle:'short'}):'';
  const esc=s=>{const d=document.createElement('div');d.textContent=s??'';return d.innerHTML;};
  function render(d){
    const pill=document.getElementById('livePill');
    if(pill&&d.label){pill.textContent=d.label;if(d.status==='completed'){pill.style.background='rgba(0,212,200,.13)';pill.style.borderColor='rgba(0,212,200,.45)';}}
    document.querySelectorAll('.nw-progress i').forEach(el=>{if(typeof d.progress==='number')el.style.width=d.progress+'%';});
    const feed=document.getElementById('liveFeed');if(!feed||!Array.isArray(d.events))return;
    feed.innerHTML=d.events.slice(0,8).map(e=>'<div style="padding:.7rem 0;border-bottom:1px solid rgba(255,255,255,.07)"><strong style="font-size:.84rem">'+esc(e.label||e.status)+'</strong><p style="color:var(--text-secondary);font-size:.78rem;margin:.2rem 0 0">'+esc(e.note)+'</p><small style="color:var(--text-muted);font-size:.7rem">'+fmt(e.at)+' — '+(e.actor==='client'?'العميل':e.actor==='system'?'النظام':'الفريق')+'</small></div>').join('')||'<p style="color:var(--text-muted);font-size:.8rem">بانتظار أول حدث…</p>';
  }
  async function poll(){
    try{const r=await fetch(FEED,{headers:{'Accept':'application/json'}});if(r.ok)render(await r.json());}catch(e){}
  }
  poll();setInterval(poll,8000);
})();
</script>
@endpush
