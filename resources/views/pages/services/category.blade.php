@extends('layouts.app')

@section('title', $cat['title'].' — نوادر')
@section('page_title', $cat['title'])
@section('description', $cat['description'] ?? 'خدمات '.$cat['title'].' في المملكة العربية السعودية والولايات المتحدة — نوادر')

@push('head')
<style>
.nw-cat-page-universe {
  position: relative; padding: 120px 0 80px; overflow: hidden;
}
.nw-cat-bg-flare {
  position: absolute; border-radius: 50%; pointer-events: none; filter: blur(120px); opacity: 0.25;
}
.cat-flare-1 { width: 600px; height: 600px; top: -100px; right: -50px; background: var(--nawader-gold); }
.cat-flare-2 { width: 500px; height: 500px; bottom: 100px; left: -50px; background: var(--nawader-teal); }

/* ── HERO HUD ── */
.nw-cat-hero-card {
  background: rgba(15, 23, 40, 0.78);
  backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.25);
  border-radius: 24px;
  padding: 2.5rem;
  margin-bottom: 3.5rem;
  box-shadow: 0 25px 70px rgba(0,0,0,0.6), 0 0 30px rgba(212, 168, 67, 0.1);
  position: relative; overflow: hidden;
}
.nw-cat-hero-card::before {
  content: ''; position: absolute; top: 0; right: 0; left: 0; height: 3px;
  background: linear-gradient(90deg, var(--nawader-gold), var(--nawader-teal), var(--nawader-purple));
}

.nw-cat-hud-topline {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
}
.nw-cat-breadcrumbs {
  display: flex; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: var(--text-muted);
}
.nw-cat-breadcrumbs a { color: var(--text-secondary); transition: color 0.2s; }
.nw-cat-breadcrumbs a:hover { color: var(--nawader-gold); }

.nw-cat-meta-pills { display: flex; align-items: center; gap: 0.6rem; }
.nw-pill-code {
  font-family: var(--font-latin); font-size: 0.72rem; font-weight: 800;
  color: var(--nawader-gold-light); background: rgba(212, 168, 67, 0.12);
  padding: 0.3rem 0.75rem; border-radius: 6px; border: 1px solid rgba(212, 168, 67, 0.25);
}
.nw-pill-corridor {
  font-size: 0.75rem; font-weight: 700; color: #FFFFFF;
  background: rgba(255, 255, 255, 0.05); padding: 0.3rem 0.75rem; border-radius: 6px;
}

.nw-cat-hero-grid {
  display: grid; grid-template-columns: auto 1fr auto;
  gap: 2rem; align-items: center;
}
.nw-cat-hero-symbol {
  width: 90px; height: 90px; border-radius: 24px;
  background: rgba(212, 168, 67, 0.15); border: 1px solid rgba(212, 168, 67, 0.35);
  display: flex; align-items: center; justify-content: center;
  font-size: 3rem; filter: drop-shadow(0 0 20px rgba(212, 168, 67, 0.4));
  flex-shrink: 0;
}
.nw-cat-hero-info h1 {
  font-size: clamp(1.8rem, 3.2vw, 2.8rem); font-weight: 900; color: #FFFFFF;
  margin-bottom: 0.3rem; line-height: 1.2;
}
.nw-cat-hero-info p {
  font-size: 0.95rem; color: var(--nawader-gold-light); font-family: var(--font-latin); font-weight: 600;
}

.nw-cat-hero-cta {
  display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end;
}

/* ── MINISTERIAL ROUTING BANNER ── */
.nw-cat-gov-banner {
  display: flex; align-items: center; gap: 1rem;
  background: rgba(0, 212, 200, 0.06); border: 1px solid rgba(0, 212, 200, 0.2);
  border-radius: 12px; padding: 0.9rem 1.4rem; margin-top: 1.5rem;
  font-size: 0.85rem;
}
.nw-cat-gov-banner strong { color: var(--nawader-teal); font-weight: 800; flex-shrink: 0; }
.nw-cat-gov-banner span { color: var(--text-secondary); }

/* ── MARKETING COPY BANNER ── */
.nw-cat-marketing-quote {
  background: linear-gradient(135deg, rgba(212, 168, 67, 0.1), rgba(123, 92, 228, 0.06));
  border: 1px solid rgba(212, 168, 67, 0.25);
  border-radius: 18px; padding: 1.5rem 2rem;
  margin-bottom: 3.5rem;
  display: flex; align-items: center; gap: 1.5rem;
}
.quote-icon { font-size: 2.2rem; flex-shrink: 0; }
.quote-text {
  font-size: 1.05rem; font-weight: 600; color: #FFFFFF; line-height: 1.7;
}

/* ── LAYOUT: SUBCATEGORIES + SIDEBAR ── */
.nw-cat-content-layout {
  display: grid; grid-template-columns: 2fr 1fr;
  gap: 2.5rem;
}

/* Subcategory Cards */
.nw-cat-sub-card {
  background: rgba(15, 23, 40, 0.75);
  backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.07);
  border-radius: 20px; padding: 2rem;
  margin-bottom: 2rem;
  transition: all 0.35s;
}
.nw-cat-sub-card:hover {
  border-color: rgba(212, 168, 67, 0.35);
  box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
.nw-sub-header {
  display: flex; align-items: flex-start; justify-content: space-between;
  margin-bottom: 1.5rem; padding-bottom: 1rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.nw-sub-title { font-size: 1.2rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.3rem; }
.nw-sub-desc  { font-size: 0.85rem; color: var(--text-muted); }

.nw-branch-table {
  display: flex; flex-direction: column; gap: 0.65rem;
}
.nw-branch-row {
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(255, 255, 255, 0.025);
  border: 1px solid rgba(255, 255, 255, 0.04);
  border-radius: 12px; padding: 0.9rem 1.25rem;
  transition: all 0.25s;
}
.nw-branch-row:hover {
  background: rgba(212, 168, 67, 0.06); border-color: rgba(212, 168, 67, 0.25);
  transform: translateX(-4px);
}
.branch-name { font-size: 0.92rem; font-weight: 700; color: var(--text-primary); }
.branch-target { font-size: 0.72rem; color: var(--nawader-teal); margin-top: 0.2rem; }

.branch-action-side {
  display: flex; align-items: center; gap: 1.25rem;
}
.branch-time { font-size: 0.78rem; color: var(--text-muted); }
.branch-price { font-size: 0.95rem; font-weight: 800; color: var(--nawader-gold); white-space: nowrap; }
.branch-req-btn {
  padding: 0.4rem 0.9rem; border-radius: 8px;
  background: var(--grad-gold); color: var(--nawader-navy);
  font-size: 0.75rem; font-weight: 800; text-decoration: none;
  transition: all 0.2s; white-space: nowrap;
}
.branch-req-btn:hover {
  transform: scale(1.05); box-shadow: 0 0 15px rgba(212, 168, 67, 0.4);
}

/* Sidebar Widgets */
.nw-cat-sidebar {
  display: flex; flex-direction: column; gap: 2rem;
}
.nw-sidebar-card {
  background: rgba(15, 23, 40, 0.75);
  backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 20px; padding: 1.75rem;
}
.nw-sidebar-title {
  font-size: 1rem; font-weight: 800; color: #FFFFFF; margin-bottom: 1.2rem;
  display: flex; align-items: center; gap: 0.5rem;
}
.nw-highlights-list {
  display: flex; flex-direction: column; gap: 0.85rem; list-style: none;
}
.nw-highlights-list li {
  display: flex; align-items: flex-start; gap: 0.75rem;
  font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6;
}
.nw-highlights-list .hl-bullet { color: var(--nawader-teal); font-weight: 900; }

.nw-sidebar-action-box {
  background: linear-gradient(135deg, rgba(212, 168, 67, 0.15), rgba(0, 212, 200, 0.1));
  border: 1px solid rgba(212, 168, 67, 0.35); text-align: center;
}
.action-box-icon { font-size: 2.5rem; margin-bottom: 0.8rem; }
.action-box-title { font-size: 1.1rem; font-weight: 800; color: #fff; margin-bottom: 0.4rem; }
.action-box-desc { font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 1.25rem; line-height: 1.6; }

@media (max-width: 992px) {
  .nw-cat-content-layout { grid-template-columns: 1fr; }
  .nw-cat-hero-grid { grid-template-columns: 1fr; text-align: center; justify-items: center; }
  .nw-cat-hero-cta { align-items: center; width: 100%; }
  .nw-cat-meta-pills { justify-content: center; }
  .branch-action-side { flex-direction: column; align-items: flex-end; gap: 0.4rem; }
}
</style>
@endpush

@section('content')
<div class="nw-cat-page-universe">
  <div class="nw-cat-bg-flare cat-flare-1"></div>
  <div class="nw-cat-bg-flare cat-flare-2"></div>

  <div class="nw-container" style="position:relative; z-index:3;">

    {{-- ═══ HERO HUD ════════════════════════════════════════════ --}}
    <div class="nw-cat-hero-card" data-nw-animate>
      <div class="nw-cat-hud-topline">
        <div class="nw-cat-breadcrumbs">
          <a href="{{ route('home') }}">الرئيسية</a>
          <span>›</span>
          <a href="{{ route('services.index') }}">الكتالوج الاستراتيجي</a>
          <span>›</span>
          <span style="color:var(--nawader-gold);">{{ $cat['title'] }}</span>
        </div>

        <div class="nw-cat-meta-pills">
          <span class="nw-pill-code">{{ $cat['code'] ?? 'NW-'.str_pad($cat['number'],2,'0',STR_PAD_LEFT) }}</span>
          <span class="nw-pill-corridor">
            @if(($cat['corridor'] ?? '') === 'sa') 🇸🇦 المملكة العربية السعودية
            @elseif(($cat['corridor'] ?? '') === 'us') 🇺🇸 الولايات المتحدة الأمريكية
            @else 🇸🇦 🇺🇸 التحالف السعودي - الأمريكي
            @endif
          </span>
          <span class="nw-badge nw-badge-gold">المستوى الهرمي {{ $cat['tier'] ?? 3 }}</span>
        </div>
      </div>

      <div class="nw-cat-hero-grid">
        <div class="nw-cat-hero-symbol">{{ $cat['icon'] }}</div>
        <div class="nw-cat-hero-info">
          <h1>{{ $cat['title'] }}</h1>
          <p>{{ $cat['subtitle'] }}</p>
          <p style="font-size:0.95rem; color:var(--text-secondary); line-height:1.7; margin-top:0.8rem; max-width:700px;">
            {{ $cat['description'] }}
          </p>
        </div>
        <div class="nw-cat-hero-cta">
          <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}" class="nw-btn nw-btn-primary nw-btn-lg">
            ابدأ الطلب الفوري الآن ←
          </a>
          <span style="font-size:0.75rem; color:var(--text-muted); text-align:center;">{{ $cat['stats'] ?? 'ضمان توافق قانوني 100%' }}</span>
        </div>
      </div>

      {{-- Ministerial & Regulatory Linkage --}}
      <div class="nw-cat-gov-banner">
        <strong>🏛️ المنظومة التنظيمية والوزارية المعنية:</strong>
        <span>{{ $cat['ministry'] ?? 'الوزارات والهيئات الحكومية المعتمدة' }}</span>
      </div>
    </div>

    {{-- ═══ MARKETING COPY VALUE BANNER ════════════════════════ --}}
    <div class="nw-cat-marketing-quote" data-nw-animate data-delay="100">
      <div class="quote-icon">💡</div>
      <div class="quote-text">
        "{{ $cat['marketing'] }}"
      </div>
    </div>

    {{-- ═══ MAIN CONTENT LAYOUT ═════════════════════════════════ --}}
    <div class="nw-cat-content-layout">

      {{-- Left Side: Subcategories and Branch Services --}}
      <div class="nw-cat-main-col">
        <h2 class="nw-h3" style="margin-bottom:1.5rem;" data-nw-animate>
          الأقسام الفرعية وجميع الفروع والخدمات التنفيذية
        </h2>

        @foreach($cat['subcategories'] as $sub)
        <div class="nw-cat-sub-card nw-tilt" data-nw-animate data-delay="{{ $loop->index * 100 }}">
          <div class="nw-sub-header">
            <div>
              <h3 class="nw-sub-title">{{ $sub['title'] }}</h3>
              <p class="nw-sub-desc">{{ $sub['description'] }}</p>
            </div>
            <span class="nw-badge nw-badge-teal">{{ count($sub['services']) }} فرع تنفيذي</span>
          </div>

          <div class="nw-branch-table">
            @foreach($sub['services'] as $svc)
            <div class="nw-branch-row">
              <div>
                <div class="branch-name">{{ $svc['name'] }}</div>
                @if(!empty($svc['target']))
                <div class="branch-target">🏛️ الجهة المستهدفة: {{ $svc['target'] }}</div>
                @endif
              </div>
              <div class="branch-action-side">
                <span class="branch-time">⏱ {{ $svc['days'] }}</span>
                <span class="branch-price">من {{ number_format($svc['price']) }} ر.س</span>
                <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}&service={{ urlencode($svc['name']) }}" class="branch-req-btn">
                  طلب الخدمة ←
                </a>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endforeach
      </div>

      {{-- Right Side: Strategic Highlights, Guarantees & Calculator --}}
      <div class="nw-cat-sidebar">

        {{-- Strategic Highlights --}}
        <div class="nw-sidebar-card" data-nw-animate>
          <h4 class="nw-sidebar-title">
            <span>🛡️</span> الضمانات والمزايا السيادية
          </h4>
          <ul class="nw-highlights-list">
            @if(!empty($cat['highlights']))
              @foreach($cat['highlights'] as $hl)
              <li>
                <span class="hl-bullet">✓</span>
                <span>{{ $hl }}</span>
              </li>
              @endforeach
            @else
              <li><span class="hl-bullet">✓</span> مطابقة فورية لأحدث اللوائح والأنظمة الحكومية</li>
              <li><span class="hl-bullet">✓</span> حماية سيادية ومتابعة دورية مع كتابات العدل والوزارات</li>
              <li><span class="hl-bullet">✓</span> توفير الوقت وتفادي أي غرامات أو تأخير</li>
            @endif
          </ul>
        </div>

        {{-- Direct Action Box --}}
        <div class="nw-sidebar-card nw-sidebar-action-box" data-nw-animate data-delay="150">
          <div class="action-box-icon">🚀</div>
          <h4 class="action-box-title">جاهز لإطلاق أعمالك؟</h4>
          <p class="action-box-desc">
            فريق خبرائنا ومحامونا المعتمدون بالمملكة والولايات المتحدة مستعدون لمباشرة ملفك خلال أقل من ساعتين.
          </p>
          <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}" class="nw-btn nw-btn-primary" style="width:100%;">
            تقديم الطلب الفوري الآن
          </a>
        </div>

        {{-- Related Sectors --}}
        @if(!empty($related))
        <div class="nw-sidebar-card" data-nw-animate data-delay="200">
          <h4 class="nw-sidebar-title">
            <span>🌐</span> قطاعات ذات صلة
          </h4>
          <div style="display:flex; flex-direction:column; gap:0.75rem;">
            @foreach($related as $rel)
            <a href="{{ route('services.category', $rel['slug']) }}" style="display:flex; align-items:center; gap:0.75rem; padding:0.6rem 0.8rem; background:rgba(255,255,255,0.03); border-radius:10px; border:1px solid rgba(255,255,255,0.05); transition:all 0.2s;" onmouseenter="this.style.background='rgba(212,168,67,0.1)'" onmouseleave="this.style.background='rgba(255,255,255,0.03)'">
              <span style="font-size:1.4rem;">{{ $rel['icon'] }}</span>
              <div style="flex:1;">
                <div style="font-size:0.85rem; font-weight:700; color:#fff;">{{ $rel['title'] }}</div>
                <div style="font-size:0.7rem; color:var(--text-muted);">{{ $rel['count'] }}+ خدمة</div>
              </div>
              <span style="color:var(--nawader-gold); font-size:0.8rem;">←</span>
            </a>
            @endforeach
          </div>
        </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection
