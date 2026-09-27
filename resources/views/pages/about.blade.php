@extends('layouts.app')

@section('title', 'عن نوادر — المنصة الاستراتيجية العالمية')
@section('page_title', 'عن المنصة والرؤية العالمية')
@section('description', 'نوادر — المنصة الاستراتيجية الرائدة التي تربط بيئة الأعمال السعودية بالأسواق العالمية والولايات المتحدة الأمريكية وفق رؤية 2030.')

@push('head')
<style>
.nw-about-hero {
  padding: 130px 0 70px; position: relative; overflow: hidden; text-align: center;
}
.about-orb-1 {
  position: absolute; width: 600px; height: 600px; top: -150px; right: 10%;
  background: radial-gradient(circle, rgba(212,168,67,0.12) 0%, transparent 65%);
  filter: blur(80px); pointer-events: none;
}
.about-orb-2 {
  position: absolute; width: 500px; height: 500px; bottom: 0; left: 10%;
  background: radial-gradient(circle, rgba(0,212,200,0.08) 0%, transparent 65%);
  filter: blur(80px); pointer-events: none;
}

.nw-pillars-grid {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.75rem; margin: 3.5rem 0;
}
.nw-pillar-card {
  background: rgba(15, 23, 40, 0.75); backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px;
  padding: 2.25rem 2rem; position: relative; overflow: hidden;
  transition: all 0.35s;
}
.nw-pillar-card:hover {
  transform: translateY(-8px); border-color: rgba(212, 168, 67, 0.4);
  box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 25px rgba(212, 168, 67, 0.15);
}
.pillar-icon { font-size: 2.8rem; margin-bottom: 1.25rem; }
.pillar-title { font-size: 1.25rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.75rem; }
.pillar-text { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.8; }

.nw-hq-grid {
  display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin: 3rem 0;
}
.nw-hq-box {
  background: rgba(15, 23, 40, 0.75); backdrop-filter: blur(25px);
  border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 20px;
  padding: 2.25rem; position: relative; overflow: hidden;
}
.nw-hq-box::before {
  content: ''; position: absolute; top: 0; right: 0; left: 0; height: 3px;
  background: var(--hq-grad, var(--grad-gold));
}
.hq-city { font-size: 1.35rem; font-weight: 900; color: #fff; margin-bottom: 0.25rem; }
.hq-country { font-size: 0.85rem; color: var(--nawader-gold); font-weight: 700; margin-bottom: 1rem; }
.hq-address { font-size: 0.85rem; color: var(--text-muted); line-height: 1.7; margin-bottom: 1rem; }
.hq-tags { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.hq-tag {
  font-size: 0.72rem; padding: 0.25rem 0.65rem; border-radius: 6px;
  background: rgba(255, 255, 255, 0.04); color: var(--text-secondary);
}

@media(max-width:992px){
  .nw-pillars-grid { grid-template-columns: 1fr; }
  .nw-hq-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
{{-- ── HERO ── --}}
<section class="nw-about-hero">
  <div class="about-orb-1"></div>
  <div class="about-orb-2"></div>

  <div class="nw-container" style="position:relative; z-index:2;">
    <div class="nw-section-eyebrow" data-nw-animate>الرؤية والسيادة المؤسسية</div>
    <h1 class="nw-h1" style="margin:1rem 0 1.25rem;" data-nw-animate data-delay="100">
      ربط سيادي عالمي بين <span class="nw-gradient-text">الرياض وواشنطن</span>
    </h1>
    <p class="nw-lead" style="max-width:750px; margin:0 auto 2.5rem;" data-nw-animate data-delay="200">
      تأسست نوادر لتكون الجسر الاستراتيجي الأكثر تطوراً وموثوقية في العالم، لخدمة الوزارات والهيئات الحكومية السعودية والشركات متعددة الجنسيات وصناديق الاستثمار الكبرى.
    </p>

    <div style="display:flex; justify-content:center; gap:1.25rem; flex-wrap:wrap;" data-nw-animate data-delay="300">
      <a href="{{ route('services.index') }}" class="nw-btn nw-btn-primary nw-btn-lg">استكشف الكتالوج الهرمي (20 قطاعاً)</a>
      <a href="{{ route('contact') }}" class="nw-btn nw-btn-ghost nw-btn-lg">تواصل مع الإدارة التنفيذية</a>
    </div>
  </div>
</section>

{{-- ── 3 PILLARS ── --}}
<section class="nw-section-sm">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">أركان الريادة</div>
      <h2 class="nw-h2">المعايير الثلاثة التي نبني عليها كل قرار</h2>
    </div>

    <div class="nw-pillars-grid">
      <div class="nw-pillar-card nw-tilt" data-nw-animate data-delay="100">
        <div class="pillar-icon">🏛️</div>
        <h3 class="pillar-title">الامتثال السيادي والموثوقية</h3>
        <p class="pillar-text">
          ترتبط منصتنا تنظيمياً بأحدث أطر الحوكمة الصادرة عن وزارة التجارة، هيئة الاستثمار MISA، البنك المركزي SAMA، والمحاكم الفيدرالية الأمريكية لضمان أعلى درجات الأمان.
        </p>
      </div>

      <div class="nw-pillar-card nw-tilt" data-nw-animate data-delay="200">
        <div class="pillar-icon">⚡</div>
        <h3 class="pillar-title">السرعة والذكاء الاصطناعي</h3>
        <p class="pillar-text">
          تعتمد نوادر على خوارزميات أتمتة الفحص النافي للجهالة، وتحليل الوثائق الفوري بالذكاء الاصطناعي (OCR)، مما يقلص أزمنة تأسيس الكيانات وإصدار الرخص بنسبة تتجاوز 70%.
        </p>
      </div>

      <div class="nw-pillar-card nw-tilt" data-nw-animate data-delay="300">
        <div class="pillar-icon">🌐</div>
        <h3 class="pillar-title">الممر الاقتصادي المزدوج</h3>
        <p class="pillar-text">
          نوفر حضوراً قانونياً وميدانياً متزامناً في المملكة العربية السعودية والولايات المتحدة الأمريكية، لتمكين التوسع العابر للقارات وتدفق رؤوس الأموال بلا احتكاك.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- ── GLOBAL HEADQUARTERS ── --}}
<section class="nw-section-sm" style="padding-bottom:6rem;">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">المقرات العالمية</div>
      <h2 class="nw-h2">حضور استراتيجي في مراكز القرار</h2>
    </div>

    <div class="nw-hq-grid">
      <div class="nw-hq-box nw-tilt" style="--hq-grad: var(--grad-gold);" data-nw-animate data-delay="100">
        <div class="hq-city">الرياض — المقر الرئيسي الإقليمي</div>
        <div class="hq-country">🇸🇦 المملكة العربية السعودية</div>
        <p class="hq-address">
          طريق الملك فهد، حي الصحافة، برج نوادر السيادي للأعمال، الرياض 13321.
          <br>هاتف العمليات السيادية: +966 11 800 2030
        </p>
        <div class="hq-tags">
          <span class="hq-tag">الوزارات السعودية</span>
          <span class="hq-tag">برنامج المقرات الإقليمية RHQ</span>
          <span class="hq-tag">المركز المالي KAFD</span>
        </div>
      </div>

      <div class="nw-hq-box nw-tilt" style="--hq-grad: var(--grad-teal);" data-nw-animate data-delay="200">
        <div class="hq-city">Wilmington & New York — المقر الأمريكي والدولي</div>
        <div class="hq-country">🇺🇸 الولايات المتحدة الأمريكية</div>
        <p class="hq-address">
          1201 North Market St, Suite 1400, Wilmington, DE 19801 & Wall Street, New York.
          <br>هاتف التنسيق الفيدرالي: +1 (302) 555-0199
        </p>
        <div class="hq-tags">
          <span class="hq-tag">Delaware Division of Corp</span>
          <span class="hq-tag">SEC & USPTO Liaison</span>
          <span class="hq-tag">Wall Street Corridor</span>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
