@extends('layouts.app')

@section('title', 'نوادر')
@section('page_title', 'منصة الخدمات الاستراتيجية العالمية')
@section('description', 'نوادر — المنصة الاستراتيجية العالمية لخدمات الأعمال والحكومة. تأسيس شركات، تراخيص، استثمار، ملكية فكرية في السعودية والولايات المتحدة. شفافية كاملة، نتائج موثوقة.')

@push('head')
<style>
/* ── HERO ── */
.nw-hero-wrap {
  min-height: 100vh;
  display: flex;
  align-items: center;
  position: relative;
  overflow: hidden;
  padding: 100px 0 60px;
}

.nw-hero-orb { position: absolute; border-radius: 50%; pointer-events: none; }
.orb-1 { width: 700px; height: 700px; top: -200px; right: -150px;
  background: radial-gradient(circle, rgba(212,168,67,0.1) 0%, transparent 65%); filter: blur(60px); }
.orb-2 { width: 600px; height: 600px; bottom: -100px; left: -100px;
  background: radial-gradient(circle, rgba(0,212,200,0.08) 0%, transparent 65%); filter: blur(60px); }
.orb-3 { width: 400px; height: 400px; top: 30%; left: 40%;
  background: radial-gradient(circle, rgba(123,92,228,0.06) 0%, transparent 65%); filter: blur(80px); }

.nw-hero-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
  align-items: center;
}

.nw-hero-eyebrow {
  display: inline-flex; align-items: center; gap: 0.75rem;
  padding: 0.5rem 1.25rem;
  background: rgba(212, 168, 67, 0.07);
  border: 1px solid rgba(212, 168, 67, 0.2);
  border-radius: 100px;
  font-size: 0.78rem; font-weight: 700; letter-spacing: 0.1em;
  color: var(--nawader-gold-light); margin-bottom: 2rem;
}
.nw-eyebrow-dot {
  width: 6px; height: 6px; background: var(--nawader-gold);
  border-radius: 50%; animation: nw-pulse 2s ease-in-out infinite;
}

.nw-hero-title {
  font-size: clamp(3rem, 5.5vw, 5.5rem);
  font-weight: 900; line-height: 1.08;
  letter-spacing: -0.03em; margin-bottom: 1.5rem;
}

.nw-hero-title .line-1 { display: block; color: var(--text-primary); }
.nw-hero-title .line-2 {
  display: block;
  background: linear-gradient(135deg, #D4A843 0%, #F0C869 40%, #00D4C8 80%, #7B5CE4 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text;
}
.nw-hero-title .line-3 { display: block; color: rgba(240,244,255,0.7); font-size: 0.65em; font-weight: 600; margin-top: 0.4rem; }

.nw-hero-desc {
  font-size: 1.05rem; color: var(--text-secondary); line-height: 1.9;
  max-width: 520px; margin-bottom: 2.5rem;
}

.nw-hero-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem; }

.nw-hero-trust {
  display: flex; align-items: center; gap: 1rem;
  font-size: 0.78rem; color: var(--text-muted);
}
.nw-trust-avatars {
  display: flex; margin-left: 0.25rem;
}
.nw-trust-avatar {
  width: 30px; height: 30px; border-radius: 50%;
  border: 2px solid var(--nawader-navy);
  background: linear-gradient(135deg, var(--nawader-gold), var(--nawader-teal));
  margin-right: -8px; display: flex; align-items: center;
  justify-content: center; font-size: 0.6rem; color: var(--nawader-navy); font-weight: 700;
}

/* ── HERO VISUAL ── */
.nw-hero-visual { position: relative; }

.nw-platform-mockup {
  position: relative; z-index: 2;
  background: rgba(15, 23, 40, 0.8);
  backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.15);
  border-radius: 24px;
  padding: 1.5rem;
  box-shadow: 0 40px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(212,168,67,0.08);
  animation: nw-float 8s ease-in-out infinite;
}

.nw-mockup-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 1.25rem; padding-bottom: 1rem;
  border-bottom: 1px solid rgba(255,255,255,0.05);
}

.nw-mockup-dots { display: flex; gap: 6px; }
.nw-mockup-dot {
  width: 10px; height: 10px; border-radius: 50%;
}
.nw-mockup-dot:nth-child(1) { background: #FF5F56; }
.nw-mockup-dot:nth-child(2) { background: #FFBD2E; }
.nw-mockup-dot:nth-child(3) { background: #27C93F; }

.nw-mockup-title {
  font-size: 0.75rem; color: var(--text-muted); font-weight: 500;
}

.nw-mockup-stats {
  display: grid; grid-template-columns: 1fr 1fr;
  gap: 0.75rem; margin-bottom: 1rem;
}

.nw-mockup-stat {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 12px; padding: 0.85rem;
}

.nw-mockup-stat-val {
  font-size: 1.5rem; font-weight: 800;
  margin-bottom: 0.15rem;
}

.nw-mockup-stat-lbl { font-size: 0.68rem; color: var(--text-muted); }

.nw-mockup-progress-list { display: flex; flex-direction: column; gap: 0.6rem; }

.nw-mockup-prog-item { display: flex; flex-direction: column; gap: 0.3rem; }
.nw-mockup-prog-label {
  display: flex; align-items: center; justify-content: space-between;
  font-size: 0.72rem; color: var(--text-secondary);
}
.nw-mockup-prog-bar { height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px; overflow: hidden; }
.nw-mockup-prog-fill { height: 100%; border-radius: 2px; }

/* ── Floating elements around mockup ── */
.nw-float-badge {
  position: absolute;
  backdrop-filter: blur(16px);
  background: rgba(10,15,30,0.85);
  border-radius: 14px;
  padding: 0.75rem 1rem;
  border: 1px solid rgba(212,168,67,0.2);
  box-shadow: 0 10px 30px rgba(0,0,0,0.4);
  font-size: 0.78rem;
  white-space: nowrap;
}

.nw-float-badge-1 {
  top: -20px; left: -40px;
  animation: nw-float 6s ease-in-out infinite;
}
.nw-float-badge-2 {
  bottom: 30px; right: -45px;
  animation: nw-float 7s ease-in-out infinite 1.5s;
}
.nw-float-badge-3 {
  top: 40%; right: -55px;
  animation: nw-float 5.5s ease-in-out infinite 0.8s;
}

/* ── STATS BAR ── */
.nw-stats-bar {
  display: flex; align-items: center; justify-content: center;
  gap: 0; flex-wrap: wrap;
  background: rgba(15,23,40,0.6); backdrop-filter: blur(20px);
  border: 1px solid rgba(212,168,67,0.1); border-radius: 20px;
  padding: 2rem 3rem; margin-bottom: 6rem;
}

.nw-stat-item {
  text-align: center; padding: 0 3rem;
  position: relative;
}

.nw-stat-item:not(:last-child)::after {
  content: '';
  position: absolute; right: 0; top: 20%; height: 60%;
  width: 1px; background: rgba(255,255,255,0.06);
}

.nw-stat-num {
  font-size: 2.5rem; font-weight: 900; line-height: 1;
  background: var(--grad-gold);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text; margin-bottom: 0.4rem;
  display: block;
}

.nw-stat-lbl { font-size: 0.82rem; color: var(--text-muted); font-weight: 500; }

/* ── SERVICES PREVIEW ── */
.nw-services-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.nw-service-card {
  background: rgba(15,23,40,0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;
  padding: 1.75rem; cursor: pointer;
  transition: all 0.35s var(--ease-smooth);
  text-decoration: none; display: block;
  position: relative; overflow: hidden;
}

.nw-service-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0;
  height: 2px; background: var(--card-grad, var(--grad-gold));
  transform: scaleX(0); transform-origin: right;
  transition: transform 0.4s var(--ease-smooth);
}

.nw-service-card:hover { transform: translateY(-6px); border-color: rgba(212,168,67,0.2); }
.nw-service-card:hover::before { transform: scaleX(1); }

.nw-service-card.color-teal:hover { border-color: rgba(0,212,200,0.25); }
.nw-service-card.color-purple:hover { border-color: rgba(123,92,228,0.25); }

.nw-sc-icon {
  font-size: 2rem; margin-bottom: 1rem;
  width: 56px; height: 56px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
}
.nw-sc-icon.gold  { background: rgba(212,168,67,0.12); border: 1px solid rgba(212,168,67,0.2); }
.nw-sc-icon.teal  { background: rgba(0,212,200,0.12);  border: 1px solid rgba(0,212,200,0.2); }
.nw-sc-icon.purple{ background: rgba(123,92,228,0.12); border: 1px solid rgba(123,92,228,0.2); }

.nw-sc-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--text-primary); }
.nw-sc-desc  { font-size: 0.8rem; color: var(--text-muted); line-height: 1.6; }
.nw-sc-meta  { display: flex; align-items: center; justify-content: space-between; margin-top: 1.2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05); }
.nw-sc-price { font-size: 0.8rem; color: var(--nawader-gold); font-weight: 700; }
.nw-sc-arrow { font-size: 0.85rem; color: var(--text-muted); transition: transform 0.2s; }
.nw-service-card:hover .nw-sc-arrow { transform: translateX(-4px); }

/* ── FEATURES ── */
.nw-features-grid {
  display: grid; grid-template-columns: repeat(2, 1fr);
  gap: 2rem;
}

.nw-feature-item {
  display: flex; gap: 1.25rem;
  padding: 1.75rem;
  background: rgba(15,23,40,0.5); backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.05); border-radius: 18px;
  transition: all 0.3s;
}
.nw-feature-item:hover {
  border-color: rgba(212,168,67,0.15);
  background: rgba(15,23,40,0.8);
}

.nw-feature-icon-wrap {
  width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
}

.nw-feature-body h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.4rem; }
.nw-feature-body p  { font-size: 0.8rem; color: var(--text-muted); line-height: 1.6; }

/* ── PROCESS ── */
.nw-process-steps {
  display: grid; grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem; position: relative;
}

.nw-process-steps::before {
  content: ''; position: absolute;
  top: 40px; right: 12%; left: 12%;
  height: 1px;
  background: linear-gradient(90deg, var(--nawader-gold), var(--nawader-teal));
  opacity: 0.25; z-index: 0;
}

.nw-process-step { text-align: center; position: relative; z-index: 1; }

.nw-process-num {
  width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 1.25rem;
  background: rgba(15,23,40,0.8); backdrop-filter: blur(16px);
  border: 2px solid rgba(212,168,67,0.2);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; position: relative;
}

.nw-process-num .step-num {
  position: absolute; top: -8px; left: -8px;
  width: 24px; height: 24px; border-radius: 50%;
  background: var(--grad-gold); color: var(--nawader-navy);
  font-size: 0.65rem; font-weight: 800;
  display: flex; align-items: center; justify-content: center;
}

.nw-process-step h4 { font-size: 0.9rem; font-weight: 700; margin-bottom: 0.4rem; }
.nw-process-step p  { font-size: 0.78rem; color: var(--text-muted); line-height: 1.6; }

/* ── TESTIMONIALS ── */
.nw-testimonials-track {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.nw-testimonial {
  background: rgba(15,23,40,0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;
  padding: 2rem;
}

.nw-testimonial-stars { display: flex; gap: 3px; margin-bottom: 1rem; }
.nw-testimonial-stars span { color: var(--nawader-gold); font-size: 1rem; }
.nw-testimonial-text { font-size: 0.9rem; color: var(--text-secondary); line-height: 1.8; margin-bottom: 1.5rem; font-style: italic; }
.nw-testimonial-author { display: flex; align-items: center; gap: 0.75rem; }
.nw-testimonial-avatar {
  width: 44px; height: 44px; border-radius: 50%;
  background: var(--grad-gold); display: flex;
  align-items: center; justify-content: center;
  font-size: 1rem; font-weight: 800; color: var(--nawader-navy); flex-shrink: 0;
}
.nw-testimonial-name { font-size: 0.85rem; font-weight: 700; }
.nw-testimonial-title { font-size: 0.72rem; color: var(--text-muted); }
.nw-testimonial-service { font-size: 0.7rem; color: var(--nawader-teal); margin-top: 0.2rem; }

/* ── PARTNERS ── */
.nw-partners-grid {
  display: flex; flex-wrap: wrap;
  align-items: center; justify-content: center; gap: 1.5rem;
}

.nw-partner-chip {
  display: flex; align-items: center; gap: 0.6rem;
  padding: 0.6rem 1.25rem;
  background: rgba(15,23,40,0.6); backdrop-filter: blur(16px);
  border: 1px solid rgba(255,255,255,0.07); border-radius: 100px;
  font-size: 0.82rem; font-weight: 600; color: var(--text-secondary);
  transition: all 0.3s;
}
.nw-partner-chip:hover { border-color: rgba(212,168,67,0.2); color: var(--text-primary); }
.nw-partner-flag { font-size: 1.1rem; }

/* ── CTA SECTION ── */
.nw-cta-section {
  position: relative; border-radius: 30px; overflow: hidden;
  padding: 5rem; text-align: center;
  background: radial-gradient(ellipse at center, rgba(212,168,67,0.12) 0%, rgba(0,212,200,0.06) 40%, transparent 70%);
  border: 1px solid rgba(212,168,67,0.15);
  backdrop-filter: blur(30px);
}
.nw-cta-section::before {
  content: ''; position: absolute; inset: 0;
  background: linear-gradient(135deg, rgba(212,168,67,0.03) 0%, transparent 50%, rgba(0,212,200,0.03) 100%);
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .nw-hero-grid { grid-template-columns: 1fr; text-align: center; }
  .nw-hero-visual { display: none; }
  .nw-services-grid { grid-template-columns: repeat(2, 1fr); }
  .nw-process-steps { grid-template-columns: repeat(2, 1fr); }
  .nw-process-steps::before { display: none; }
  .nw-testimonials-track { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
  .nw-services-grid, .nw-features-grid, .nw-testimonials-track { grid-template-columns: 1fr; }
  .nw-stats-bar { gap: 0; }
  .nw-stat-item { padding: 1rem 1.5rem; }
  .nw-cta-section { padding: 3rem 1.5rem; }
  .nw-hero-actions { justify-content: center; }
}
</style>
@endpush

@section('content')

{{-- ═══ HERO ══════════════════════════════════════════════ --}}
<section class="nw-hero-wrap">
  <div class="nw-hero-orb orb-1"></div>
  <div class="nw-hero-orb orb-2"></div>
  <div class="nw-hero-orb orb-3"></div>

  <div class="nw-container" style="position:relative;z-index:2;width:100%;">
    <div class="nw-hero-grid">

      {{-- Left: Text --}}
      <div>
        <div class="nw-hero-eyebrow" data-nw-animate>
          <span class="nw-eyebrow-dot"></span>
          <span>{{ \App\Services\ContentBlockService::get('home', 'hero_badge', 'المنصة الاستراتيجية العالمية — السعودية 🇸🇦 والولايات المتحدة 🇺🇸') }}</span>
        </div>

        <h1 class="nw-hero-title" data-nw-animate data-delay="100">
          @if($customTitle = \App\Services\ContentBlockService::get('home', 'hero_title'))
            <span class="line-1">{{ $customTitle }}</span>
            <span class="line-3">Your Gateway to World-Class Business</span>
          @else
            <span class="line-1">بوابتك نحو</span>
            <span class="line-2">الأعمال العالمية</span>
            <span class="line-3">Your Gateway to World-Class Business</span>
          @endif
        </h1>

        <p class="nw-hero-desc" data-nw-animate data-delay="200">
          {{ \App\Services\ContentBlockService::get('home', 'hero_subtitle', 'منصة استراتيجية متكاملة تخدم 20 قطاعاً حكومياً وتجارياً في المملكة العربية السعودية والولايات المتحدة — من تأسيس الشركات حتى الاستثمار الأجنبي، بشفافية كاملة وسرعة استثنائية.') }}
        </p>

        <div class="nw-hero-actions" data-nw-animate data-delay="300">
          <a href="{{ route('services.index') }}" id="hero-explore-btn" class="nw-btn nw-btn-primary nw-btn-lg">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
            {{ \App\Services\ContentBlockService::get('home', 'cta_primary_text', 'استكشف الكتالوج') }}
          </a>
          <a href="{{ route('register') }}" id="hero-start-btn" class="nw-btn nw-btn-ghost nw-btn-lg">
            ابدأ مجاناً
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="#nw-demo" id="hero-demo-btn" class="nw-btn nw-btn-ghost nw-btn-lg" style="border-color:rgba(0,212,200,0.3);color:var(--nawader-teal);">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            شاهد العرض
          </a>
        </div>

        <div class="nw-hero-trust" data-nw-animate data-delay="400">
          <div class="nw-trust-avatars">
            <div class="nw-trust-avatar">خ</div>
            <div class="nw-trust-avatar">س</div>
            <div class="nw-trust-avatar">م</div>
            <div class="nw-trust-avatar">ف</div>
          </div>
          <span>+15,000 عميل يثقون بنوادر</span>
          <span style="color:rgba(255,255,255,0.15)">|</span>
          <div style="display:flex;gap:2px;">
            @for($i=0;$i<5;$i++)<span style="color:#D4A843;font-size:0.85rem;">★</span>@endfor
          </div>
          <span>4.9/5</span>
        </div>
      </div>

      {{-- Right: Platform Mockup --}}
      <div class="nw-hero-visual">

        {{-- Floating Badge 1 --}}
        <div class="nw-float-badge nw-float-badge-1">
          <div style="display:flex;align-items:center;gap:0.6rem;">
            <span style="font-size:1.2rem;">✅</span>
            <div>
              <div style="font-size:0.72rem;font-weight:700;color:var(--nawader-teal);">طلب مكتمل</div>
              <div style="font-size:0.65rem;color:var(--text-muted);">تأسيس شركة — 8 أيام</div>
            </div>
          </div>
        </div>

        {{-- Platform Card --}}
        <div class="nw-platform-mockup">
          <div class="nw-mockup-header">
            <div class="nw-mockup-dots">
              <div class="nw-mockup-dot"></div>
              <div class="nw-mockup-dot"></div>
              <div class="nw-mockup-dot"></div>
            </div>
            <div class="nw-mockup-title">nawader.sa — لوحة العميل</div>
            <div class="nw-badge nw-badge-teal" style="font-size:0.62rem;padding:0.2rem 0.6rem;">
              <span class="nw-badge-dot"></span> مباشر
            </div>
          </div>

          <div class="nw-mockup-stats">
            <div class="nw-mockup-stat">
              <div class="nw-mockup-stat-val" style="background:var(--grad-gold);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">12</div>
              <div class="nw-mockup-stat-lbl">طلب منجز</div>
            </div>
            <div class="nw-mockup-stat">
              <div class="nw-mockup-stat-val" style="color:var(--nawader-teal);">4</div>
              <div class="nw-mockup-stat-lbl">قيد المعالجة</div>
            </div>
          </div>

          <div class="nw-mockup-progress-list">
            @foreach([
              ['label'=>'تأسيس شركة LLC','pct'=>85,'color'=>'#D4A843'],
              ['label'=>'ترخيص تجاري','pct'=>60,'color'=>'#00D4C8'],
              ['label'=>'علامة تجارية','pct'=>100,'color'=>'#7B5CE4'],
              ['label'=>'استثمار أجنبي','pct'=>35,'color'=>'#E85D8A'],
            ] as $prog)
            <div class="nw-mockup-prog-item">
              <div class="nw-mockup-prog-label">
                <span>{{ $prog['label'] }}</span>
                <span style="color:{{ $prog['color'] }};font-weight:700;">{{ $prog['pct'] }}%</span>
              </div>
              <div class="nw-mockup-prog-bar">
                <div class="nw-mockup-prog-fill" style="width:{{ $prog['pct'] }}%;background:{{ $prog['color'] }};"></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Floating Badge 2 --}}
        <div class="nw-float-badge nw-float-badge-2">
          <div style="display:flex;align-items:center;gap:0.6rem;">
            <span style="font-size:1.1rem;">🌐</span>
            <div>
              <div style="font-size:0.72rem;font-weight:700;color:var(--nawader-gold);">20 قطاع</div>
              <div style="font-size:0.65rem;color:var(--text-muted);">SA 🇸🇦 & USA 🇺🇸</div>
            </div>
          </div>
        </div>

        {{-- Floating Badge 3 --}}
        <div class="nw-float-badge nw-float-badge-3">
          <div style="display:flex;align-items:center;gap:0.5rem;">
            <span style="font-size:1rem;">🛡️</span>
            <div style="font-size:0.7rem;font-weight:700;color:var(--nawader-teal);">امتثال 100%</div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

{{-- ═══ STATS BAR ══════════════════════════════════════════ --}}
<div class="nw-container">
  <div class="nw-stats-bar" data-nw-animate>
    @foreach($stats as $s)
    <div class="nw-stat-item">
      <span class="nw-stat-num" data-counter="{{ $s['value'] }}" data-suffix="{{ $s['suffix'] }}">0</span>
      <div class="nw-stat-lbl">{{ $s['label'] }}</div>
    </div>
    @endforeach
  </div>
</div>

{{-- ═══ DYNAMIC HIERARCHICAL SPACE PYRAMID (20 CATEGORIES & SOVEREIGN MINISTRIES) ═══ --}}
<x-smart-pyramid :categories="$categories" />

{{-- ═══ SERVICES PREVIEW ════════════════════════════════════ --}}
<section class="nw-section" id="services-preview">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">الكتالوج الاستراتيجي</div>
      <h2 class="nw-h2" style="margin-bottom:1rem;">
        <span class="nw-gradient-text">20 قطاعاً</span> في منصة واحدة
      </h2>
      <p class="nw-lead" style="max-width:600px;margin:0 auto;">
        من تأسيس الشركات في Delaware حتى استخراج الإقامة المميزة في الرياض — كل ما تحتاجه في مكان واحد.
      </p>
    </div>

    <div class="nw-services-grid">
      @foreach($featuredServices as $svc)
      <a href="{{ route('services.category', $svc['category']) }}"
         class="nw-service-card color-{{ $svc['color'] }}"
         style="--card-grad: {{ $svc['color'] === 'gold' ? 'var(--grad-gold)' : ($svc['color'] === 'teal' ? 'var(--grad-teal)' : 'linear-gradient(135deg, #7B5CE4, #A989FF)') }}"
         data-nw-animate data-delay="{{ $loop->index * 100 }}">

        @if($svc['popular'])
        <div style="position:absolute;top:1rem;left:1rem;">
          <span class="nw-badge nw-badge-gold" style="font-size:0.62rem;">الأكثر طلباً</span>
        </div>
        @endif

        <div class="nw-sc-icon {{ $svc['color'] }}">{{ $svc['icon'] }}</div>
        <div class="nw-sc-title">{{ $svc['title'] }}</div>
        <div class="nw-sc-desc">{{ $svc['description'] }}</div>
        <div class="nw-sc-meta">
          <span class="nw-sc-price">من {{ number_format($svc['price_from']) }} ر.س</span>
          <div style="display:flex;align-items:center;gap:0.6rem;">
            <span style="font-size:0.7rem;color:var(--text-muted);">⏱ {{ $svc['duration'] }}</span>
            <span class="nw-sc-arrow">←</span>
          </div>
        </div>
      </a>
      @endforeach
    </div>

    <div style="text-align:center;margin-top:2.5rem;" data-nw-animate>
      <a href="{{ route('services.index') }}" class="nw-btn nw-btn-ghost nw-btn-lg" id="view-all-services-btn">
        استعرض كل الـ 20 قطاع
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

{{-- ═══ WHY NAWADER ═════════════════════════════════════════ --}}
<section class="nw-section" style="background:rgba(10,15,30,0.4);">
  <div class="nw-container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;" class="nw-why-grid">

      <div data-nw-animate>
        <div class="nw-section-eyebrow" style="justify-content:flex-start;">لماذا نوادر</div>
        <h2 class="nw-h2" style="margin:1rem 0 1.5rem;">
          الشفافية ليست وعداً —<br><span class="nw-gradient-text">إنها بنيتنا الأساسية</span>
        </h2>
        <p class="nw-lead" style="margin-bottom:2rem;">
          لا وعود فارغة ولا رسوم مخفية. كل ريال وكل يوم وكل خطوة موثقة ومتاحة لك في أي لحظة، من أول نقرة حتى آخر توقيع.
        </p>

        <div style="display:flex;flex-direction:column;gap:1rem;" data-nw-animate data-delay="200">
          @foreach([
            ['icon'=>'🔍','title'=>'شفافية الأسعار','desc'=>'رى التكلفة الكاملة قبل أي التزام — بلا مفاجآت'],
            ['icon'=>'⚡','title'=>'سرعة استثنائية','desc'=>'أسرع معالجة في السوق بفضل علاقاتنا المباشرة مع الجهات'],
            ['icon'=>'🛡️','title'=>'ضمان النجاح','desc'=>'إذا لم ينجح طلبك لأسباب إدارية نعيد رسومنا كاملة'],
            ['icon'=>'🌐','title'=>'غطاء دولي','desc'=>'SA & USA وأكثر من 50 دولة عبر شبكة شركاء معتمدين'],
          ] as $f)
          <div style="display:flex;align-items:flex-start;gap:1rem;padding:1rem;border-radius:14px;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.04);transition:all 0.3s;" onmouseenter="this.style.borderColor='rgba(212,168,67,0.15)'" onmouseleave="this.style.borderColor='rgba(255,255,255,0.04)'">
            <div style="font-size:1.5rem;flex-shrink:0;">{{ $f['icon'] }}</div>
            <div>
              <div style="font-weight:700;margin-bottom:0.25rem;font-size:0.95rem;">{{ $f['title'] }}</div>
              <div style="font-size:0.8rem;color:var(--text-muted);">{{ $f['desc'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="nw-features-grid" data-nw-animate data-delay="300">
        @foreach([
          ['icon'=>'📋','color'=>'rgba(212,168,67,0.1)','border'=>'rgba(212,168,67,0.2)','title'=>'طلب موحّد','desc'=>'نموذج ذكي يتكيف مع خدمتك — لا أوراق زائدة'],
          ['icon'=>'📡','color'=>'rgba(0,212,200,0.1)','border'=>'rgba(0,212,200,0.2)','title'=>'تتبع لحظي','desc'=>'Timeline مرئي لكل خطوة في طلبك الآن'],
          ['icon'=>'🔒','color'=>'rgba(123,92,228,0.1)','border'=>'rgba(123,92,228,0.2)','title'=>'دفع آمن','desc'=>'حقول دفع مستضافة — لا نلمس بياناتك المالية'],
          ['icon'=>'🤖','color'=>'rgba(212,168,67,0.1)','border'=>'rgba(212,168,67,0.2)','title'=>'OCR ذكي','desc'=>'رفع مستندات بالكاميرا مع تحسين وتحقق فوري'],
          ['icon'=>'🌙','color'=>'rgba(0,212,200,0.1)','border'=>'rgba(0,212,200,0.2)','title'=>'Offline First','desc'=>'أكمل طلبك دون إنترنت ويُرسل عند الاتصال'],
          ['icon'=>'♿','color'=>'rgba(123,92,228,0.1)','border'=>'rgba(123,92,228,0.2)','title'=>'إتاحة WCAG 2.2','desc'=>'مصمم للجميع — دعم قارئ الشاشة RTL كامل'],
        ] as $feat)
        <div class="nw-feature-item">
          <div class="nw-feature-icon-wrap" style="background:{{ $feat['color'] }};border:1px solid {{ $feat['border'] }};">{{ $feat['icon'] }}</div>
          <div class="nw-feature-body">
            <h3>{{ $feat['title'] }}</h3>
            <p>{{ $feat['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</section>

{{-- ═══ HOW IT WORKS ════════════════════════════════════════ --}}
<section class="nw-section">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">العملية</div>
      <h2 class="nw-h2">من الفكرة إلى النتيجة <span class="nw-gradient-text">في 4 خطوات</span></h2>
    </div>

    <div class="nw-process-steps">
      @foreach([
        ['num'=>'1','icon'=>'🔍','title'=>'اكتشف واحسب','desc'=>'استعرض الكتالوج، اقرأ تفاصيل خدمتك، واحسب رسومك فوراً بلا تسجيل'],
        ['num'=>'2','icon'=>'📋','title'=>'قدِّم طلبك','desc'=>'نموذج ذكي بخطوات واضحة مع حفظ تلقائي وOCR للمستندات'],
        ['num'=>'3','icon'=>'📡','title'=>'تابع لحظة بلحظة','desc'=>'Timeline مرئي وإشعارات فورية عند كل تغيير في حالة طلبك'],
        ['num'=>'4','icon'=>'🏆','title'=>'استلم نتيجتك','desc'=>'مستند موثق بـ QR، فاتورة رسمية، وأرشفة دائمة في ملفك'],
      ] as $step)
      <div class="nw-process-step" data-nw-animate data-delay="{{ $loop->index * 150 }}">
        <div class="nw-process-num">
          <span>{{ $step['icon'] }}</span>
          <div class="step-num">{{ $step['num'] }}</div>
        </div>
        <h4>{{ $step['title'] }}</h4>
        <p>{{ $step['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ GLOBAL REACH ═════════════════════════════════════════ --}}
<section class="nw-section" style="background:rgba(10,15,30,0.5);">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">الحضور العالمي</div>
      <h2 class="nw-h2">نخدم <span class="nw-gradient-text">القطاعات الحكومية</span><br>في أكبر اقتصادين بالعالم</h2>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:3rem;" data-nw-animate>
      {{-- Saudi Arabia --}}
      <div class="nw-card" style="background:linear-gradient(135deg, rgba(0,100,0,0.08), rgba(255,255,255,0.03));">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
          <span style="font-size:2.5rem;">🇸🇦</span>
          <div>
            <div style="font-size:1.1rem;font-weight:800;">المملكة العربية السعودية</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">رؤية 2030 | Vision 2030</div>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
          @foreach(['وزارة التجارة','MISA','SAMA','هيئة السوق المالية','وزارة الاستثمار','وزارة العدل','CITC','الهيئة العامة للاستثمار'] as $p)
          <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:var(--text-secondary);">
            <span style="color:var(--nawader-gold);">✓</span> {{ $p }}
          </div>
          @endforeach
        </div>
      </div>

      {{-- USA --}}
      <div class="nw-card" style="background:linear-gradient(135deg, rgba(0,50,150,0.08), rgba(200,0,0,0.04));">
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
          <span style="font-size:2.5rem;">🇺🇸</span>
          <div>
            <div style="font-size:1.1rem;font-weight:800;">الولايات المتحدة الأمريكية</div>
            <div style="font-size:0.82rem;color:var(--text-muted);">Federal & State Level</div>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
          @foreach(['SEC','USPTO','SBA','IRS EIN','Delaware SOS','California SOS','USCIS','FDA & DEA'] as $p)
          <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:var(--text-secondary);">
            <span style="color:var(--nawader-teal);">✓</span> {{ $p }}
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="nw-partners-grid" data-nw-animate>
      @foreach($partners as $p)
      <div class="nw-partner-chip">
        <span class="nw-partner-flag">{{ $p['country'] === 'SA' ? '🇸🇦' : '🇺🇸' }}</span>
        {{ $p['name'] }}
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ TESTIMONIALS ════════════════════════════════════════ --}}
<section class="nw-section">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">تجارب حقيقية</div>
      <h2 class="nw-h2">عملاؤنا يتكلمون عن <span class="nw-gradient-text">تجربتهم الفعلية</span></h2>
    </div>

    <div class="nw-testimonials-track">
      @foreach($testimonials as $t)
      <div class="nw-testimonial" data-nw-animate data-delay="{{ $loop->index * 150 }}">
        <div class="nw-testimonial-stars">
          @for($i=0;$i<$t['rating'];$i++)<span>★</span>@endfor
        </div>
        <p class="nw-testimonial-text">"{{ $t['text'] }}"</p>
        <div class="nw-testimonial-author">
          <div class="nw-testimonial-avatar">{{ mb_substr($t['name'],0,1) }}</div>
          <div>
            <div class="nw-testimonial-name">{{ $t['name'] }}</div>
            <div class="nw-testimonial-title">{{ $t['title'] }}</div>
            <div class="nw-testimonial-service">{{ $t['service'] }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ CTA ════════════════════════════════════════════════ --}}
<section class="nw-section">
  <div class="nw-container">
    <div class="nw-cta-section" data-nw-animate>
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:1.5rem;">ابدأ الآن</div>
      <h2 class="nw-h2" style="margin-bottom:1rem;font-size:clamp(2rem,4vw,3.5rem);">
        جاهز لتحويل فكرتك<br><span class="nw-gradient-text">إلى واقع قانوني؟</span>
      </h2>
      <p class="nw-lead" style="max-width:550px;margin:0 auto 2.5rem;">
        أكثر من 15,000 شركة ومستثمر وثقوا بنوادر. الفرصة التالية لك — ابدأ بخطوة واحدة.
      </p>
      <div style="display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap;">
        <a href="{{ route('register') }}" id="cta-register-btn" class="nw-btn nw-btn-primary nw-btn-lg" style="font-size:1.1rem;padding:1.1rem 3rem;">
          أنشئ حسابك مجاناً
          <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ route('contact') }}" id="cta-contact-btn" class="nw-btn nw-btn-ghost nw-btn-lg">تحدث مع خبير</a>
      </div>

      <div style="display:flex;align-items:center;justify-content:center;gap:2.5rem;margin-top:2.5rem;flex-wrap:wrap;">
        @foreach(['لا رسوم مخفية','ضمان استرداد كامل','دعم عربي 24/7','امتثال 100%'] as $g)
        <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-muted);">
          <span style="color:var(--nawader-teal);">✓</span> {{ $g }}
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
// Responsive fix for why-grid on mobile
document.addEventListener('DOMContentLoaded', () => {
  const whyGrid = document.querySelector('.nw-why-grid');
  if(whyGrid && window.innerWidth < 1024) {
    whyGrid.style.gridTemplateColumns = '1fr';
    whyGrid.style.gap = '3rem';
  }
  window.addEventListener('resize', () => {
    if(whyGrid) {
      whyGrid.style.gridTemplateColumns = window.innerWidth < 1024 ? '1fr' : '1fr 1fr';
  });

  // Live content update from visual editor iframe
  window.addEventListener('message', (e) => {
    if (e.data && e.data.type === 'NAWADER_LIVE_CONTENT_UPDATE') {
      if (e.data.key === 'hero_badge') {
        const el = document.querySelector('.nw-hero-eyebrow span:last-child');
        if (el) el.textContent = e.data.value;
      } else if (e.data.key === 'hero_subtitle') {
        const el = document.querySelector('.nw-hero-desc');
        if (el) el.textContent = e.data.value;
      } else if (e.data.key === 'hero_title') {
        const el = document.querySelector('.nw-hero-title .line-1');
        if (el) el.textContent = e.data.value;
      } else if (e.data.key === 'cta_primary_text') {
        const el = document.getElementById('hero-explore-btn');
        if (el) {
          el.innerHTML = '<svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg> ' + e.data.value;
        }
      }
    }
  });
});
</script>
@endpush
