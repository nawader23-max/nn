@extends('layouts.app')

@section('title', ($sub['title'] ?? 'القسم الفرعي').' — '.$cat['title'].' — نوادر')
@section('page_title', $sub['title'] ?? 'القسم الفرعي')
@section('description', $sub['description'] ?? 'تفاصيل وخدمات '.$cat['title'].' — نوادر')

@push('head')
<style>
.nw-subcat-hero {
  padding: 120px 0 60px; position: relative; overflow: hidden;
}
.subcat-orb {
  position: absolute; width: 500px; height: 500px; top: -100px; right: -50px;
  background: radial-gradient(circle, rgba(212,168,67,0.12) 0%, transparent 70%);
  filter: blur(80px); pointer-events: none;
}

.nw-subcat-card-main {
  background: rgba(15, 23, 40, 0.78); backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.25); border-radius: 24px;
  padding: 2.5rem; margin-bottom: 3.5rem; position: relative;
  box-shadow: 0 25px 60px rgba(0,0,0,0.5);
}
.nw-services-breakdown-grid {
  display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem;
}
.nw-svc-detail-card {
  background: rgba(15, 23, 40, 0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.07); border-radius: 18px;
  padding: 1.5rem 1.75rem; margin-bottom: 1.25rem;
  transition: all 0.3s; display: flex; align-items: center; justify-content: space-between;
}
.nw-svc-detail-card:hover {
  background: rgba(212, 168, 67, 0.06); border-color: rgba(212, 168, 67, 0.3);
  transform: translateX(-4px);
}
.svc-info-title { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 0.35rem; }
.svc-info-target { font-size: 0.78rem; color: var(--nawader-teal); }
.svc-info-price-box { text-align: left; display: flex; flex-direction: column; align-items: flex-end; gap: 0.3rem; }
.svc-price-tag { font-size: 1.15rem; font-weight: 900; color: var(--nawader-gold); }
.svc-time-tag { font-size: 0.75rem; color: var(--text-muted); }

@media(max-width:992px){
  .nw-services-breakdown-grid { grid-template-columns: 1fr; }
  .nw-svc-detail-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
  .svc-info-price-box { align-items: flex-start; width: 100%; flex-direction: row; justify-content: space-between; }
}
</style>
@endpush

@section('content')
<section class="nw-subcat-hero">
  <div class="subcat-orb"></div>
  <div class="nw-container" style="position:relative; z-index:2;">

    {{-- Breadcrumbs --}}
    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem; font-size:0.85rem; color:var(--text-muted);" data-nw-animate>
      <a href="{{ route('home') }}" style="color:var(--text-secondary);">الرئيسية</a>
      <span>›</span>
      <a href="{{ route('services.index') }}" style="color:var(--text-secondary);">الكتالوج</a>
      <span>›</span>
      <a href="{{ route('services.category', $cat['slug']) }}" style="color:var(--text-secondary);">{{ $cat['title'] }}</a>
      <span>›</span>
      <span style="color:var(--nawader-gold);">{{ $sub['title'] }}</span>
    </div>

    {{-- Subcategory Card --}}
    <div class="nw-subcat-card-main" data-nw-animate data-delay="100">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
        <span class="nw-badge nw-badge-gold">{{ $cat['title'] }} — فرع تخصصي</span>
        <span class="nw-badge nw-badge-teal">{{ count($sub['services'] ?? []) }} خدمات متاحة</span>
      </div>

      <h1 class="nw-h2" style="margin-bottom:0.75rem;">{{ $sub['title'] }}</h1>
      <p class="nw-lead" style="max-width:720px; margin-bottom:1.75rem;">{{ $sub['description'] }}</p>

      <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
        <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}" class="nw-btn nw-btn-primary">
          قدّم طلباً في هذا القسم الفرعي ←
        </a>
        <a href="{{ route('services.category', $cat['slug']) }}" class="nw-btn nw-btn-ghost">
          العودة لكافة فروع {{ $cat['title'] }}
        </a>
      </div>
    </div>

    {{-- Breakdown Layout --}}
    <div class="nw-services-breakdown-grid">

      {{-- Left Side: Services List --}}
      <div>
        <h3 class="nw-h3" style="margin-bottom:1.5rem;" data-nw-animate>
          الخدمات التنفيذية المباشرة المتاحة
        </h3>

        @foreach($sub['services'] as $svc)
        <div class="nw-svc-detail-card nw-tilt" data-nw-animate data-delay="{{ $loop->index * 80 }}">
          <div>
            <div class="svc-info-title">{{ $svc['name'] }}</div>
            @if(!empty($svc['target']))
            <div class="svc-info-target">🏛️ الجهة الرسمية: {{ $svc['target'] }}</div>
            @endif
          </div>
          <div class="svc-info-price-box">
            <span class="svc-price-tag">{{ number_format($svc['price']) }} ر.س</span>
            <span class="svc-time-tag">⏱ المدة المقدرة: {{ $svc['days'] }}</span>
            <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}&service={{ urlencode($svc['name']) }}" class="nw-btn nw-btn-primary nw-btn-sm" style="margin-top:0.4rem;">
              طلب الخدمة
            </a>
          </div>
        </div>
        @endforeach
      </div>

      {{-- Right Side: Fast Facts & Guarantees --}}
      <div>
        <div class="nw-sidebar-card" data-nw-animate>
          <h4 class="nw-sidebar-title"><span>🛡️</span> ضمانات نوادر التنفيذية</h4>
          <ul class="nw-highlights-list">
            <li><span class="hl-bullet">✓</span> شفافية تامة في الرسوم بدون تكاليف خفية</li>
            <li><span class="hl-bullet">✓</span> مدة إنجاز مضمونة بالعقد والتزام رسمي</li>
            <li><span class="hl-bullet">✓</span> متابعة لحظية عبر لوحة تحكم العميل 360</li>
            <li><span class="hl-bullet">✓</span> محامون ومستشارون معتمدون في السعودية وأمريكا</li>
          </ul>

          <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid rgba(255,255,255,0.08); text-align:center;">
            <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1rem;">تحتاج استشارة خاصة في هذا القسم؟</div>
            <a href="{{ route('contact') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="width:100%;">تواصل مع المستشار المختص</a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
@endsection
