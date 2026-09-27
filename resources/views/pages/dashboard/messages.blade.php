@extends('layouts.app')

@section('title', 'التواصل والمتابعة — نوادر')
@section('page_title', 'التواصل والمتابعة')

@section('content')
<div class="nw-dashboard-page" style="padding:120px 0 80px;">
  <div class="nw-container" style="max-width:1150px;">
    <div class="nw-cinematic-panel" style="padding:2.25rem;margin-bottom:1.5rem;">
      <div class="nw-section-eyebrow">مركز المتابعة</div>
      <h1 style="color:#fff;font-size:2rem;margin:.35rem 0 .7rem;">التواصل والمتابعة الموثقة</h1>
      <p style="color:var(--text-secondary);max-width:760px;line-height:1.85;margin:0;">تظهر هنا تحديثات طلباتك وإشعارات الحساب المسجلة فعلياً. المحادثات الفورية ستظهر عند تفعيل قناة المستشار لحسابك.</p>
    </div>
    <div class="nw-grid nw-grid-2">
      <div class="nw-cinematic-panel" style="padding:1.5rem;">
        <div class="nw-section-eyebrow">طلبات الخدمة</div>
        @forelse($requests as $requestItem)
          <a href="{{ route('dashboard.requests.show', $requestItem->request_number) }}" style="display:block;padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.07);text-decoration:none;"><strong style="color:var(--nawader-gold);">{{ $requestItem->request_number }}</strong><div style="color:#fff;margin-top:.35rem;">{{ $requestItem->service_name }}</div><div style="font-size:.75rem;color:var(--text-muted);margin-top:.25rem;">{{ $requestItem->status }} · {{ optional($requestItem->submitted_at)->format('Y-m-d H:i') }}</div></a>
        @empty
          <div style="padding:2rem 0;color:var(--text-muted);">لا توجد طلبات خدمة مسجلة بعد.</div>
        @endforelse
        @if($requests->hasPages())<div style="margin-top:1rem;">{{ $requests->links() }}</div>@endif
      </div>
      <div class="nw-cinematic-panel" style="padding:1.5rem;">
        <div class="nw-section-eyebrow">آخر الإشعارات</div>
        @forelse($notifications as $notification)
          <div style="padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.07);"><strong style="color:#fff;">{{ $notification->title }}</strong><div style="font-size:.82rem;color:var(--text-secondary);line-height:1.7;margin-top:.35rem;">{{ $notification->body }}</div><div style="font-size:.72rem;color:var(--text-muted);margin-top:.3rem;">{{ $notification->created_at?->format('Y-m-d H:i') }}</div></div>
        @empty
          <div style="padding:2rem 0;color:var(--text-muted);">لا توجد إشعارات مسجلة بعد.</div>
        @endforelse
      </div>
    </div>
    <div class="nw-cinematic-panel" style="padding:1.5rem;margin-top:1.5rem;display:flex;justify-content:space-between;gap:1rem;align-items:center;flex-wrap:wrap;"><span style="color:var(--text-secondary);">هل تريد بدء معاملة جديدة؟</span><a href="{{ route('dashboard.requests.create') }}" class="nw-btn nw-btn-primary">إنشاء طلب خدمة</a></div>
  </div>
</div>
@endsection
