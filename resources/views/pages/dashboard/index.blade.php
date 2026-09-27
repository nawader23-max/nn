@extends('layouts.app')

@section('title', 'لوحة العميل — نوادر')
@section('page_title', 'لوحة العميل')

@push('head')
<style>
.nw-command-page { max-width: 1360px; margin: 0 auto; padding: 120px 28px 88px; }
.nw-command-hero { min-height: 330px; padding: clamp(1.7rem, 4vw, 3.2rem); border-radius: 30px; overflow: hidden; position: relative; display: flex; align-items: end; }
.nw-command-hero::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg,rgba(5,10,20,.98) 0%,rgba(5,10,20,.78) 52%,rgba(5,10,20,.12) 100%); }
.nw-command-hero__content { position:relative; z-index:1; max-width:680px; }
.nw-command-hero__art { position:absolute; left:3%; bottom:-12%; width:300px; opacity:.7; mix-blend-mode:screen; }
.nw-command-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin:1.25rem 0 2rem; }
.nw-command-card { border-radius:20px; padding:1.25rem; min-height:135px; }
.nw-command-card small { display:block; color:var(--text-muted); margin-bottom:.55rem; }
.nw-command-card strong { font:800 2rem var(--font-latin); color:#fff; }
.nw-command-card span { color:var(--nawader-teal); font-size:.8rem; }
.nw-command-content { display:grid; grid-template-columns:minmax(0,1.55fr) minmax(280px,.8fr); gap:1.25rem; }
.nw-command-panel { border-radius:24px; padding:1.5rem; }
.nw-operation { padding:1rem 0; border-bottom:1px solid rgba(255,255,255,.07); display:grid; grid-template-columns:1fr auto; gap:1rem; align-items:center; }
.nw-operation:last-child { border-bottom:0; }
.nw-operation__meta { color:var(--text-muted); font-size:.78rem; }
.nw-progress { height:5px; border-radius:99px; overflow:hidden; background:rgba(255,255,255,.08); margin-top:.7rem; }
.nw-progress > i { display:block; height:100%; border-radius:inherit; background:linear-gradient(90deg,var(--nawader-teal),var(--nawader-gold)); }
.nw-status { border:1px solid rgba(0,212,200,.3); background:rgba(0,212,200,.09); color:var(--nawader-teal); border-radius:99px; padding:.25rem .6rem; font-size:.72rem; white-space:nowrap; }
.nw-empty { border:1px dashed rgba(212,168,67,.28); border-radius:18px; padding:2rem; text-align:center; color:var(--text-secondary); }
@media(max-width:1000px){ .nw-command-grid{grid-template-columns:repeat(2,1fr)} .nw-command-content{grid-template-columns:1fr} }
@media(max-width:600px){ .nw-command-page{padding:90px 18px 60px}.nw-command-grid{grid-template-columns:1fr}.nw-command-hero__art{opacity:.28;left:-10%;width:270px}.nw-operation{grid-template-columns:1fr} }
</style>
@endpush

@section('content')
<section class="nw-command-page">
  <div class="nw-command-hero nw-cinematic-panel" style="background:url('{{ asset('images/cinematic/nawader-orbit-hub-v1.webp') }}') center/cover;">
    <img class="nw-command-hero__art" src="{{ asset('images/cinematic/nawader-moon-emblem-v1.webp') }}" alt="" aria-hidden="true">
    <div class="nw-command-hero__content">
      <div class="nw-section-eyebrow">مساحة العميل</div>
      <h1 style="font-size:clamp(2rem,4vw,3.3rem);line-height:1.15;margin:.65rem 0 1rem;">أهلاً {{ explode(' ', trim($user->name))[0] }}،<br>كل ما يخص أعمالك في مكان واحد.</h1>
      <p style="color:var(--text-secondary);max-width:590px;">تابع طلباتك ووثائقك وعملياتك المالية من سجل واضح. لا تظهر هنا إلا البيانات المرتبطة بحسابك.</p>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem;"><a class="nw-btn nw-btn-primary" href="{{ route('dashboard.requests.create') }}">ابدأ طلب خدمة</a><a class="nw-btn nw-btn-ghost" href="{{ route('dashboard.security.phone') }}">تأمين رقم الجوال</a></div>
    </div>
  </div>
  <div class="nw-command-grid">
    <article class="nw-command-card nw-cinematic-panel"><small>طلبات مفتوحة</small><strong>{{ $summary['requests_active'] }}</strong><span>قيد المتابعة</span></article>
    <article class="nw-command-card nw-cinematic-panel"><small>طلبات مكتملة</small><strong>{{ $summary['requests_completed'] }}</strong><span>سجل محفوظ</span></article>
    <article class="nw-command-card nw-cinematic-panel"><small>عقود فعالة</small><strong>{{ $summary['contracts_active'] }}</strong><span>مرتبطة بالحساب</span></article>
    <article class="nw-command-card nw-cinematic-panel"><small>رصيد المحفظة</small><strong>{{ number_format($summary['wallet_balance'], 2) }}</strong><span>ر.س — حسب دفتر العمليات</span></article>
  </div>
  <div class="nw-command-content">
    <section class="nw-command-panel nw-cinematic-panel"><div style="display:flex;justify-content:space-between;gap:1rem;align-items:start;margin-bottom:.5rem;"><div><h2 class="nw-h3">طلباتك الأخيرة</h2><p style="color:var(--text-muted);font-size:.84rem;">آخر الطلبات التي أنشأتها من حسابك.</p></div><a href="{{ route('dashboard.requests') }}" class="nw-btn nw-btn-ghost nw-btn-sm">عرض الطلبات</a></div>
      @forelse($recentRequests as $operation)<article class="nw-operation"><div><strong>{{ $operation->service_name }}</strong><div class="nw-operation__meta">{{ $operation->request_number }} · {{ $operation->submitted_at?->format('Y/m/d') }}</div><div class="nw-progress"><i style="width:{{ $operation->progress }}%"></i></div></div><div style="text-align:left"><span class="nw-status">{{ $operation->statusLabel() }}</span><div style="margin-top:.7rem"><a href="{{ route('dashboard.requests.show', $operation->request_number) }}" style="color:var(--nawader-gold);font-size:.8rem">التفاصيل</a></div></div></article>@empty<div class="nw-empty"><strong style="display:block;color:#fff;margin-bottom:.5rem;">لا توجد طلبات بعد</strong>ابدأ طلبك الأول وسنضيفه إلى هذا السجل فور استلامه.</div>@endforelse
    </section>
    <aside class="nw-command-panel nw-cinematic-panel"><div style="display:flex;justify-content:space-between;gap:1rem;align-items:start;margin-bottom:.8rem;"><div><h2 class="nw-h3">التنبيهات</h2><p style="color:var(--text-muted);font-size:.84rem;">{{ $summary['notifications_unread'] }} غير مقروءة</p></div><a href="{{ route('dashboard.notifications') }}" style="color:var(--nawader-gold);font-size:.8rem">الكل</a></div>@forelse($notifications as $notification)<article style="padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.07)"><strong style="font-size:.9rem">{{ $notification->title }}</strong><p style="font-size:.8rem;color:var(--text-secondary);margin:.35rem 0">{{ $notification->body }}</p><small style="color:var(--text-muted)">{{ $notification->created_at->diffForHumans() }}</small></article>@empty<div class="nw-empty" style="padding:1.5rem">سيظهر هنا كل تنبيه مرتبط بحسابك وطلباتك.</div>@endforelse</aside>
  </div>
</section>
@endsection
