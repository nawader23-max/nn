@extends('layouts.app')

@section('title', 'الكتالوج الاستراتيجي — نوادر')
@section('page_title', 'كتالوج الخدمات')
@section('description', 'كتالوج شامل لـ 20 قطاعاً استراتيجياً في المملكة العربية السعودية والولايات المتحدة الأمريكية — خدمات حكومية، تجارية، استثمارية، وقانونية.')

@push('head')
<style>
/* ── PAGE HEADER ── */
.nw-cat-header {
  padding: 120px 0 60px;
  position: relative; overflow: hidden; text-align: center;
}
.nw-cat-header-orb {
  position: absolute; border-radius: 50%; pointer-events: none;
}
.cat-orb-1 {
  width: 500px; height: 500px; top: -150px; right: 10%;
  background: radial-gradient(circle, rgba(212,168,67,0.1) 0%, transparent 70%);
  filter: blur(60px);
}
.cat-orb-2 {
  width: 400px; height: 400px; bottom: -100px; left: 10%;
  background: radial-gradient(circle, rgba(0,212,200,0.08) 0%, transparent 70%);
  filter: blur(60px);
}

/* ── SEARCH & FILTER ── */
.nw-catalog-search-wrap {
  display: flex; align-items: center; gap: 1rem;
  max-width: 700px; margin: 0 auto 3rem;
}

.nw-search-box {
  flex: 1; position: relative;
}

.nw-search-icon {
  position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
  color: var(--text-muted); font-size: 1.1rem; pointer-events: none;
}

#nw-catalog-search {
  width: 100%; padding: 0.9rem 3rem 0.9rem 1.25rem;
  background: rgba(15,23,40,0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(212,168,67,0.15); border-radius: 14px;
  color: var(--text-primary); font-family: var(--font-arabic); font-size: 0.95rem;
  outline: none; direction: rtl; transition: var(--transition-fast);
}
#nw-catalog-search:focus {
  border-color: rgba(212,168,67,0.4);
  box-shadow: 0 0 0 3px rgba(212,168,67,0.06);
}

/* ── FILTER PILLS ── */
.nw-filter-pills {
  display: flex; align-items: center; justify-content: center;
  gap: 0.5rem; flex-wrap: wrap; margin-bottom: 4rem;
}

.nw-filter-pill {
  padding: 0.5rem 1.25rem; border-radius: 100px;
  font-size: 0.82rem; font-weight: 600; cursor: pointer;
  border: 1px solid rgba(255,255,255,0.08);
  background: transparent; color: var(--text-muted);
  transition: all 0.25s; font-family: var(--font-arabic);
}
.nw-filter-pill:hover { border-color: rgba(212,168,67,0.3); color: var(--text-secondary); }
.nw-filter-pill.active {
  background: var(--grad-gold); color: var(--nawader-navy);
  border-color: transparent; font-weight: 700;
}

/* ── CATALOG GRID ── */
.nw-catalog-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.25rem;
}

/* ── CATEGORY CARD ── */
.nw-cat-card {
  position: relative; border-radius: 20px; overflow: hidden;
  background: rgba(15,23,40,0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.06);
  padding: 1.75rem; cursor: pointer;
  transition: all 0.4s var(--ease-smooth);
  text-decoration: none; display: flex; flex-direction: column;
  min-height: 240px;
}

.nw-cat-card::before {
  content: ''; position: absolute; inset: 0;
  background: var(--card-bg, transparent);
  opacity: 0; transition: opacity 0.4s;
}

.nw-cat-card:hover { transform: translateY(-8px) scale(1.01); }
.nw-cat-card:hover::before { opacity: 1; }

.nw-cat-card:hover .nw-cat-card-border { opacity: 1; }

.nw-cat-card-border {
  position: absolute; inset: 0; border-radius: 20px;
  border: 1px solid var(--card-border, rgba(212,168,67,0.3));
  opacity: 0; transition: opacity 0.4s; pointer-events: none;
}

.nw-cat-num {
  position: absolute; top: 1rem; left: 1rem;
  font-size: 0.65rem; font-weight: 800; letter-spacing: 0.1em;
  color: var(--text-muted); opacity: 0.5;
}

.nw-cat-icon {
  font-size: 2.2rem; margin-bottom: 1rem;
  width: 60px; height: 60px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  background: var(--icon-bg);
  border: 1px solid var(--icon-border);
  position: relative; z-index: 1;
}

.nw-cat-title {
  font-size: 0.95rem; font-weight: 700; color: var(--text-primary);
  margin-bottom: 0.4rem; position: relative; z-index: 1;
}

.nw-cat-subtitle {
  font-size: 0.7rem; color: var(--text-muted);
  margin-bottom: auto; padding-bottom: 1rem; position: relative; z-index: 1;
}

.nw-cat-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);
  position: relative; z-index: 1;
}

.nw-cat-count {
  font-size: 0.72rem; color: var(--text-muted);
  display: flex; align-items: center; gap: 0.3rem;
}

.nw-cat-arrow {
  width: 30px; height: 30px; border-radius: 50%;
  border: 1px solid rgba(255,255,255,0.1);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.8rem; color: var(--text-muted);
  transition: all 0.3s;
}

.nw-cat-card:hover .nw-cat-arrow {
  background: var(--arrow-bg, var(--grad-gold));
  color: var(--nawader-navy); border-color: transparent;
  transform: rotate(-45deg);
}

/* ── COLOR THEMES ── */
.theme-gold  { --icon-bg: rgba(212,168,67,0.12); --icon-border: rgba(212,168,67,0.25); --card-bg: radial-gradient(circle at 80% 20%, rgba(212,168,67,0.06) 0%, transparent 60%); --card-border: rgba(212,168,67,0.35); --arrow-bg: var(--grad-gold); }
.theme-teal  { --icon-bg: rgba(0,212,200,0.12);  --icon-border: rgba(0,212,200,0.25);  --card-bg: radial-gradient(circle at 80% 20%, rgba(0,212,200,0.06) 0%, transparent 60%);  --card-border: rgba(0,212,200,0.35);  --arrow-bg: var(--grad-teal); }
.theme-purple{ --icon-bg: rgba(123,92,228,0.12); --icon-border: rgba(123,92,228,0.25); --card-bg: radial-gradient(circle at 80% 20%, rgba(123,92,228,0.06) 0%, transparent 60%); --card-border: rgba(123,92,228,0.35); --arrow-bg: linear-gradient(135deg,#7B5CE4,#A989FF); }
.theme-blue  { --icon-bg: rgba(30,100,255,0.12); --icon-border: rgba(30,100,255,0.25); --card-bg: radial-gradient(circle at 80% 20%, rgba(30,100,255,0.06) 0%, transparent 60%); --card-border: rgba(30,100,255,0.35); --arrow-bg: linear-gradient(135deg,#1E64FF,#5B9BFF); }
.theme-green { --icon-bg: rgba(0,200,100,0.12);  --icon-border: rgba(0,200,100,0.25);  --card-bg: radial-gradient(circle at 80% 20%, rgba(0,200,100,0.06) 0%, transparent 60%);  --card-border: rgba(0,200,100,0.35);  --arrow-bg: linear-gradient(135deg,#00C864,#50E8A0); }
.theme-rose  { --icon-bg: rgba(232,93,138,0.12); --icon-border: rgba(232,93,138,0.25); --card-bg: radial-gradient(circle at 80% 20%, rgba(232,93,138,0.06) 0%, transparent 60%); --card-border: rgba(232,93,138,0.35); --arrow-bg: linear-gradient(135deg,#E85D8A,#FF9BC0); }
.theme-orange{ --icon-bg: rgba(255,140,0,0.12);  --icon-border: rgba(255,140,0,0.25);  --card-bg: radial-gradient(circle at 80% 20%, rgba(255,140,0,0.06) 0%, transparent 60%);  --card-border: rgba(255,140,0,0.35);  --arrow-bg: linear-gradient(135deg,#FF8C00,#FFC050); }

/* ── FEATURED CARD (larger) ── */
.nw-cat-card.featured {
  grid-column: span 2; min-height: 200px;
}

/* ── COUNTRY BADGE ── */
.nw-country-badges {
  position: absolute; top: 1rem; right: 1rem;
  display: flex; gap: 0.25rem;
}
.nw-country-badge {
  font-size: 0.85rem; line-height: 1;
}

/* ── RESPONSIVE ── */
@media (max-width: 1200px) { .nw-catalog-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .nw-catalog-grid { grid-template-columns: repeat(2, 1fr); } .nw-cat-card.featured { grid-column: span 1; } }
@media (max-width: 576px)  { .nw-catalog-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER ── --}}
<section class="nw-cat-header">
  <div class="nw-cat-header-orb cat-orb-1"></div>
  <div class="nw-cat-header-orb cat-orb-2"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    <div class="nw-section-eyebrow" data-nw-animate>الكتالوج الاستراتيجي العالمي</div>
    <h1 class="nw-h1" style="margin:1rem 0 1.25rem;" data-nw-animate data-delay="100">
      <span class="nw-gradient-text">20 قطاعاً</span> — رؤية هرمية شاملة
    </h1>
    <p class="nw-lead" style="max-width:650px;margin:0 auto 2.5rem;" data-nw-animate data-delay="200">
      كل قطاع يضم أقساماً فرعية، وكل قسم يحتوي على خدماته الكاملة بأسعار شفافة ومدد محددة — للسوق السعودي والأمريكي والعالمي.
    </p>

    {{-- Search --}}
    <div class="nw-catalog-search-wrap" data-nw-animate data-delay="300">
      <div class="nw-search-box">
        <span class="nw-search-icon">🔍</span>
        <input type="text" id="nw-catalog-search" placeholder="ابحث عن خدمة أو قطاع..." autocomplete="off">
      </div>
    </div>

    {{-- Filter Pills --}}
    <div class="nw-filter-pills" data-nw-animate data-delay="400">
      <button class="nw-filter-pill active" data-filter="all">جميع القطاعات</button>
      <button class="nw-filter-pill" data-filter="sa">🇸🇦 سعودية</button>
      <button class="nw-filter-pill" data-filter="us">🇺🇸 أمريكية</button>
      <button class="nw-filter-pill" data-filter="legal">قانوني وتأسيس</button>
      <button class="nw-filter-pill" data-filter="investment">استثمار</button>
      <button class="nw-filter-pill" data-filter="tech">تقنية</button>
      <button class="nw-filter-pill" data-filter="regulatory">امتثال</button>
    </div>
  </div>
</section>

{{-- ── DYNAMIC HIERARCHICAL SPACE PYRAMID (20 SECTORS) ── --}}
<x-smart-pyramid :categories="$categories" />

{{-- ── CATALOG GRID ── --}}
<section class="nw-section-sm" style="padding-bottom:6rem;">
  <div class="nw-container">

    {{-- Count Badge --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;" data-nw-animate>
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <span class="nw-badge nw-badge-gold">{{ count($categories) }} قطاع</span>
        <span style="font-size:0.82rem;color:var(--text-muted);">{{ array_sum(array_column($categories, 'count')) }}+ خدمة متاحة</span>
      </div>
      <div style="font-size:0.8rem;color:var(--text-muted);">
        🇸🇦 السوق السعودي &nbsp;|&nbsp; 🇺🇸 السوق الأمريكي &nbsp;|&nbsp; 🌐 دولي
      </div>
    </div>

    <div class="nw-catalog-grid" id="nw-catalog-grid">

      @php
      $colorMap = [
        'gold'=>'theme-gold','teal'=>'theme-teal','purple'=>'theme-purple',
        'blue'=>'theme-blue','green'=>'theme-green','rose'=>'theme-rose',
        'orange'=>'theme-orange',
      ];
      $featuredSlugs = ['legal','ip','foreign-investment','consulting'];
      $countryMap = [
        'legal'=>['SA','US'],'licenses'=>['SA'],'property'=>['SA'],
        'foreign-investment'=>['SA','US'],'local-investment'=>['SA'],
        'grants'=>['SA','US'],'ip'=>['SA','US'],'regulatory'=>['SA','US'],
        'trade'=>['SA','US','INTL'],'hr'=>['SA'],'environment'=>['SA','US'],
        'tech'=>['SA','US'],'health'=>['SA'],'education'=>['SA'],
        'tourism'=>['SA'],'energy'=>['SA','US'],'agriculture'=>['SA'],
        'finance'=>['SA','US'],'expat'=>['SA','US'],'consulting'=>['SA','US'],
      ];
      $countryFlags = ['SA'=>'🇸🇦','US'=>'🇺🇸','INTL'=>'🌐'];
      @endphp

      @foreach($categories as $slug => $cat)
      <a href="{{ route('services.category', $slug) }}"
         class="nw-cat-card {{ $colorMap[$cat['color']] ?? 'theme-gold' }} {{ in_array($slug, $featuredSlugs) ? 'featured' : '' }}"
         data-category="{{ $cat['color'] === 'gold' ? 'legal investment' : ($cat['color'] === 'teal' ? 'regulatory' : '') }}"
         data-nw-animate data-delay="{{ ($loop->index % 4) * 100 }}"
         id="cat-{{ $slug }}">

        {{-- Gradient border on hover --}}
        <div class="nw-cat-card-border"></div>

        {{-- Number --}}
        <div class="nw-cat-num">{{ str_pad($cat['number'], 2, '0', STR_PAD_LEFT) }}</div>

        {{-- Country flags --}}
        <div class="nw-country-badges">
          @foreach($countryMap[$slug] ?? ['SA'] as $country)
          <span class="nw-country-badge">{{ $countryFlags[$country] ?? '' }}</span>
          @endforeach
        </div>

        {{-- Icon --}}
        <div class="nw-cat-icon">{{ $cat['icon'] }}</div>

        {{-- Title & Subtitle --}}
        <div class="nw-cat-title">{{ $cat['title'] }}</div>
        <div class="nw-cat-subtitle">{{ $cat['subtitle'] }}</div>

        {{-- Marketing snippet for featured --}}
        @if(in_array($slug, $featuredSlugs))
        <div style="font-size:0.75rem;color:var(--text-muted);line-height:1.6;margin-bottom:0.75rem;position:relative;z-index:1;">
          {{ Str::limit($cat['marketing'], 80) }}
        </div>
        @endif

        {{-- Footer --}}
        <div class="nw-cat-footer">
          <div class="nw-cat-count">
            <span>📦</span>
            <span>{{ $cat['count'] }}+ خدمة</span>
          </div>
          <div style="display:flex;align-items:center;gap:0.75rem;">
            <span style="font-size:0.7rem;color:var(--text-muted);">{{ count($cat['subcategories']) }} قسم فرعي</span>
            <div class="nw-cat-arrow">←</div>
          </div>
        </div>
      </a>
      @endforeach

    </div>

    {{-- No results message --}}
    <div id="nw-no-results" style="display:none;text-align:center;padding:4rem;color:var(--text-muted);">
      <div style="font-size:3rem;margin-bottom:1rem;">🔍</div>
      <div style="font-size:1.1rem;font-weight:600;">لا توجد نتائج للبحث</div>
      <div style="font-size:0.85rem;margin-top:0.5rem;">جرّب كلمات مختلفة أو تصفح الكتالوج يدوياً</div>
    </div>

  </div>
</section>

{{-- ── HOW TO USE CATALOG ── --}}
<section class="nw-section" style="background:rgba(10,15,30,0.5);">
  <div class="nw-container">
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:2rem;text-align:center;" data-nw-animate>
      @foreach([
        ['icon'=>'1️⃣','title'=>'اختر القطاع','desc'=>'تصفح الـ 20 قطاع واختر ما يناسب حاجتك'],
        ['icon'=>'2️⃣','title'=>'استعرض الخدمات','desc'=>'كل قطاع يضم أقساماً فرعية بخدمات مفصّلة وأسعار واضحة'],
        ['icon'=>'3️⃣','title'=>'قدّم طلبك','desc'=>'نموذج ذكي في خطوات واضحة مع حفظ تلقائي'],
      ] as $s)
      <div class="nw-card" style="text-align:center;">
        <div style="font-size:2rem;margin-bottom:1rem;">{{ $s['icon'] }}</div>
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:0.5rem;">{{ $s['title'] }}</h3>
        <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;">{{ $s['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
// Enhanced catalog search with card visibility
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('nw-catalog-search');
  const grid = document.getElementById('nw-catalog-grid');
  const noResults = document.getElementById('nw-no-results');
  const cards = grid.querySelectorAll('.nw-cat-card');
  const filterPills = document.querySelectorAll('.nw-filter-pill');

  function filterCards() {
    const query = searchInput.value.toLowerCase();
    const activeFilter = document.querySelector('.nw-filter-pill.active')?.dataset.filter || 'all';
    let visibleCount = 0;

    cards.forEach(card => {
      const text = card.textContent.toLowerCase();
      const matchQ = !query || text.includes(query);
      const matchF = activeFilter === 'all' ||
                     (activeFilter === 'sa' && card.querySelector('.nw-country-badge')?.textContent.includes('🇸🇦')) ||
                     (activeFilter === 'us' && card.querySelector('.nw-country-badge')?.textContent.includes('🇺🇸')) ||
                     true; // simplified for demo

      if(matchQ && matchF) {
        card.style.display = '';
        card.style.animation = 'nw-fade-in 0.3s ease';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });

    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
  }

  if(searchInput) searchInput.addEventListener('input', filterCards);

  filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
      filterPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      filterCards();
    });
  });
});
</script>
@endpush
