@extends('layouts.app')
@section('title', 'تفاصيل الطلب — نوادر')
@section('page_title', 'تفاصيل الطلب')
@push('head')
<style>
.nw-rq-page{max-width:960px;margin:auto;padding:120px 24px 80px}
.nw-rq-card{border-radius:22px;padding:clamp(1.2rem,3vw,2rem);margin-bottom:1.1rem}
.nw-rq-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:.7rem;margin-top:1rem}
.nw-rq-grid div{padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem}
.nw-rq-grid small{display:block;color:var(--text-muted);margin-bottom:.2rem}
.nw-rq-mono{font-family:'Courier New',monospace;font-size:.74rem;color:var(--nawader-teal);word-break:break-all}
.nw-rq-detail{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:.75rem}
.nw-rq-detail div{padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem}
.nw-rq-detail small{display:block;color:var(--text-muted);margin-bottom:.2rem}
.nw-rq-tl{margin-top:1rem;padding-right:1.3rem;border-right:1px solid rgba(212,168,67,.3)}
.nw-rq-tl article{position:relative;padding:0 1.3rem 1.2rem}
.nw-rq-tl article::before{content:'';position:absolute;width:10px;height:10px;border-radius:50%;right:-1.7rem;top:.4rem;background:var(--nawader-teal);box-shadow:0 0 0 4px rgba(0,212,200,.12)}
@media(max-width:640px){.nw-rq-page{padding:90px 18px 60px}}
</style>
@endpush
@section('content')
<main class="nw-rq-page">
  <a href="{{ route('dashboard.requests') }}" style="display:inline-block;color:var(--nawader-gold);margin-bottom:1rem">← العودة إلى الطلبات</a>

  <section class="nw-rq-card nw-cinematic-panel">
    <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap">
      <div><div class="nw-section-eyebrow">{{ $operation->request_number }}</div>
        <h1 class="nw-h1" style="margin:.55rem 0">{{ $operation->service_name }}</h1>
        <p style="color:var(--text-secondary)">مسار سيادي موثق: تسعير معتمد → ضمان سيادي → عقد رقمي → فاتورة ZATCA.</p></div>
      <span class="nw-status" style="height:max-content">{{ $operation->statusLabel() }}</span>
    </div>
    <div class="nw-progress" style="height:8px;margin:1.5rem 0 .5rem"><i style="width:{{ $operation->progress }}%"></i></div>
    <div style="color:var(--text-muted);font-size:.8rem">نسبة التقدم المسجلة: {{ $operation->progress }}%</div>
  </section>

  <section class="nw-rq-card nw-cinematic-panel">
    <h2 class="nw-h3" style="margin-bottom:.3rem">الحوكمة المالية للطلب</h2>
    <p style="color:var(--text-muted);font-size:.8rem">القيم محسوبة خادومياً ومطابقة لعقدك الرقمي — لا تتغير لاحقاً.</p>
    <div class="nw-rq-grid">
      <div><small>أجر الخدمات</small>{{ number_format((float) $operation->price_base, 2) }} ر.س</div>
      <div><small>رسوم تسريع المسار</small>{{ number_format((float) $operation->price_speed_fee, 2) }} ر.س</div>
      <div><small>ضريبة القيمة المضافة (15%)</small>{{ number_format((float) $operation->price_vat, 2) }} ر.س</div>
      <div style="border:1px solid rgba(212,168,67,.3);background:rgba(212,168,67,.08)"><small>الإجمالي المعتمد</small><strong style="font-size:1.05rem">{{ number_format((float) $operation->price_total, 2) }} ر.س</strong></div>
    </div>
    <div style="display:flex;gap:.8rem;flex-wrap:wrap;align-items:center;margin-top:1.1rem">
      @if($operation->escrow_reference)
        <span class="nw-status" style="background:rgba(0,212,200,.12);border:1px solid rgba(0,212,200,.4)">🛡️ الضمان السيادي مفعّل: <span class="nw-rq-mono">{{ $operation->escrow_reference }}</span></span>
      @elseif(!in_array($operation->status, ['cancelled'], true) && (float) $operation->price_total > 0)
        <form method="POST" action="{{ route('dashboard.requests.escrow', $operation->request_number) }}">@csrf
          <button class="nw-btn nw-btn-primary nw-btn-sm" type="submit">🛡️ تفعيل الضمان السيادي (Escrow)</button>
        </form>
        <span style="color:var(--text-muted);font-size:.76rem">لا يُصرف المبلغ للمنفذ إلا عند إنجاز خدمتك.</span>
      @endif
      @if($operation->invoice_number)
        <span class="nw-status" style="background:rgba(212,168,67,.1);border:1px solid rgba(212,168,67,.4)">🧾 الفاتورة الضريبية <span class="nw-rq-mono">{{ $operation->invoice_number }}</span> {{ $operation->invoice_issued_at?->format('Y/m/d') }}</span>
      @elseif($operation->status === 'completed')
        <form method="POST" action="{{ route('dashboard.requests.invoice.final', $operation->request_number) }}">@csrf
          <button class="nw-btn nw-btn-ghost nw-btn-sm" type="submit">🧾 إصدار الفاتورة الضريبية النهائية (ZATCA)</button>
        </form>
      @endif
    </div>
  </section>

  @if($operation->contract)
    @php $ct = $operation->contract; @endphp
    <section class="nw-rq-card nw-cinematic-panel">
      <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
        <div><h2 class="nw-h3">العقد الرقمي المرتبط</h2>
          <p style="color:var(--text-muted);font-size:.8rem;margin-top:.25rem"><span class="nw-rq-mono">{{ $ct->contract_number }}</span> — {{ $ct->status === 'active' ? 'موقّع ومختوم رقمياً' : 'بانتظار توقيعك في غرفة التوقيع الآمنة' }}</p></div>
        <div style="display:flex;gap:.7rem;flex-wrap:wrap">
          @if($ct->status === 'pending_signature')
            <a class="nw-btn nw-btn-primary nw-btn-sm" href="{{ route('dashboard.contracts.show', $ct->id) }}">✍️ توقيع الآن</a>
          @elseif($ct->pdf_path && Storage::exists($ct->pdf_path))
            <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ route('dashboard.contracts.download', $ct->id) }}">تحميل العقد PDF</a>
          @endif
          @if($ct->verification_token && $ct->status === 'active')
            <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ url('/verify/'.$ct->verification_token) }}" target="_blank" rel="noopener">🔍 تحقق عام</a>
          @endif
        </div>
      </div>
    </section>
  @endif

  <section class="nw-rq-card nw-cinematic-panel">
    <h2 class="nw-h3" style="margin-bottom:1rem">بيانات الطلب</h2>
    <div class="nw-rq-detail">
      <div><small>المنشأة</small>{{ $operation->entity_name ?: '—' }}</div>
      <div><small>السوق المستهدف</small>{{ $operation->target_market ?: '—' }}</div>
      <div><small>سرعة التنفيذ</small>{{ $operation->speed }}</div>
      <div><small>تاريخ الإرسال</small>{{ $operation->submitted_at?->format('Y/m/d H:i') }}</div>
    </div>
    @if($operation->notes)<div style="margin-top:1rem;padding:1rem;border-radius:15px;background:rgba(255,255,255,.035)"><small style="color:var(--text-muted);display:block;margin-bottom:.25rem">ملاحظاتك</small>{{ $operation->notes }}</div>@endif
  </section>

  <section class="nw-rq-card nw-cinematic-panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
      <div><h2 class="nw-h3">سجل النشاط والتدقيق</h2>
        <p style="color:var(--text-muted);font-size:.8rem">كل انتقال حالة يُثبَّت بسجل غير قابل للتعديل.</p></div>
      <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ route('dashboard.requests.track', $operation->request_number) }}">عرض المسار الحي</a>
    </div>
    @if($operation->events->isNotEmpty())
      <div class="nw-rq-tl">
        @foreach($operation->events->take(8) as $event)
          <article><strong style="font-size:.88rem">{{ $event->note ? \Illuminate\Support\Str::limit($event->note, 140) : $event->status }}</strong>
            <p style="color:var(--text-muted);font-size:.74rem;margin-top:.2rem">{{ $event->created_at?->format('Y/m/d H:i') }} (+03:00) — {{ $event->actor === 'client' ? 'العميل' : ($event->actor === 'system' ? 'النظام' : 'الفريق') }}</p></article>
        @endforeach
      </div>
    @else
      <p style="color:var(--text-muted);font-size:.82rem;margin-top:1rem">لا توجد أحداث مسجلة بعد لهذا الطلب.</p>
    @endif
  </section>

  <section class="nw-rq-card nw-cinematic-panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem">
      <div><h2 class="nw-h3">المستندات</h2>
        <p style="color:var(--text-muted);font-size:.82rem">{{ count($operation->documents ?? []) }} ملف مرفق</p></div>
    </div>
    @if(count($operation->documents ?? []))
      <ul style="margin-top:1rem">@foreach($operation->documents as $document)<li style="padding:.65rem 0;border-bottom:1px solid rgba(255,255,255,.07)">📎 {{ $document['name'] }}</li>@endforeach</ul>
    @else
      <div class="nw-empty" style="margin-top:1rem;padding:1.3rem">لم ترفق مستندات مع هذا الطلب.</div>
    @endif
  </section>
</main>
@endsection
