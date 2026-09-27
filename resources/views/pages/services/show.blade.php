@extends('layouts.app')

@php
$serviceName = urldecode($service);
// Find service in subcategory if exists
$serviceObj = collect($sub['services'] ?? [])->first(function($s) use ($serviceName) {
    return $s['name'] === $serviceName || Str::slug($s['name']) === Str::slug($serviceName);
}) ?? ['name' => $serviceName, 'price' => 2500, 'days' => '5-10', 'target' => $cat['ministry'] ?? 'الجهات المختصة'];
@endphp

@section('title', $serviceObj['name'].' — '.$cat['title'].' — نوادر')
@section('page_title', $serviceObj['name'])
@section('description', 'تفاصيل وطلب خدمة '.$serviceObj['name'].' — نوادر المنصة الاستراتيجية العالمية')

@push('head')
<style>
.nw-service-hero {
  padding: 120px 0 60px; position: relative; overflow: hidden;
}
.service-orb {
  position: absolute; width: 600px; height: 600px; top: -100px; left: 10%;
  background: radial-gradient(circle, rgba(0,212,200,0.1) 0%, transparent 65%);
  filter: blur(80px); pointer-events: none;
}

.nw-service-main-layout {
  display: grid; grid-template-columns: 2fr 1fr; gap: 3rem; margin-bottom: 6rem;
}

.nw-service-panel {
  background: rgba(15, 23, 40, 0.78); backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.25); border-radius: 24px;
  padding: 2.5rem; margin-bottom: 2rem; position: relative;
  box-shadow: 0 25px 60px rgba(0,0,0,0.5);
}
.nw-service-panel::before {
  content: ''; position: absolute; top: 0; right: 0; left: 0; height: 3px;
  background: var(--grad-gold);
}

.nw-workflow-timeline {
  display: flex; flex-direction: column; gap: 1.5rem; margin: 2rem 0;
  position: relative; padding-right: 2rem;
}
.nw-workflow-timeline::before {
  content: ''; position: absolute; top: 10px; bottom: 10px; right: 8px;
  width: 2px; background: linear-gradient(180deg, var(--nawader-gold), var(--nawader-teal));
}
.nw-workflow-step {
  position: relative;
}
.workflow-dot {
  position: absolute; right: -2rem; top: 4px;
  width: 18px; height: 18px; border-radius: 50%;
  background: var(--nawader-dark); border: 2px solid var(--nawader-gold);
  box-shadow: 0 0 10px rgba(212, 168, 67, 0.5);
}
.workflow-step-num { font-size: 0.72rem; color: var(--nawader-gold); font-weight: 800; margin-bottom: 0.2rem; }
.workflow-step-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem; }
.workflow-step-desc { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; }

.nw-ocr-box {
  background: rgba(0, 212, 200, 0.06); border: 1px dashed rgba(0, 212, 200, 0.35);
  border-radius: 18px; padding: 2rem; text-align: center; margin: 2rem 0;
}
.ocr-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
.ocr-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem; }
.ocr-desc { font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem; }

/* Pricing Sticky Sidebar */
.nw-price-sticky-card {
  background: rgba(15, 23, 40, 0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.3); border-radius: 24px;
  padding: 2rem; position: sticky; top: 100px;
  box-shadow: 0 25px 60px rgba(0,0,0,0.6);
}
.price-display-lg {
  font-size: 2.2rem; font-weight: 900; color: var(--nawader-gold);
  margin-bottom: 0.25rem; font-family: var(--font-latin);
}
.price-currency { font-size: 1rem; font-weight: 700; color: var(--text-secondary); margin-right: 0.3rem; }
.price-meta-tag { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 1.5rem; }

@media(max-width:992px){
  .nw-service-main-layout { grid-template-columns: 1fr; }
  .nw-price-sticky-card { position: static; }
}
</style>
@endpush

@section('content')
<section class="nw-service-hero">
  <div class="service-orb"></div>
  <div class="nw-container" style="position:relative; z-index:2;">

    {{-- Breadcrumbs --}}
    <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem; font-size:0.85rem; color:var(--text-muted);" data-nw-animate>
      <a href="{{ route('home') }}" style="color:var(--text-secondary);">الرئيسية</a>
      <span>›</span>
      <a href="{{ route('services.index') }}" style="color:var(--text-secondary);">الكتالوج</a>
      <span>›</span>
      <a href="{{ route('services.category', $cat['slug']) }}" style="color:var(--text-secondary);">{{ $cat['title'] }}</a>
      <span>›</span>
      <a href="{{ route('services.subcategory', [$cat['slug'], $sub['slug']]) }}" style="color:var(--text-secondary);">{{ $sub['title'] }}</a>
      <span>›</span>
      <span style="color:var(--nawader-gold);">{{ $serviceObj['name'] }}</span>
    </div>

    <div class="nw-service-main-layout">

      {{-- Left Column: Service Details & Execution Steps --}}
      <div>
        <div class="nw-service-panel" data-nw-animate data-delay="100">
          <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
            <span class="nw-badge nw-badge-gold">{{ $cat['code'] ?? 'NW-SERVICE' }}</span>
            <span class="nw-badge nw-badge-teal">تنفيذ معتمد ومطابق</span>
          </div>

          <h1 class="nw-h2" style="margin-bottom:0.75rem;">{{ $serviceObj['name'] }}</h1>
          <p style="font-size:0.95rem; color:var(--text-secondary); line-height:1.8; margin-bottom:1.5rem;">
            خدمة استراتيجية متكاملة تقدمها نوادر بإشراف فريق قانوني وتنفيذي معتمد، لضمان استيفاء كافة المتطلبات التنظيمية وإتمام المعاملة في أسرع وقت وأعلى درجات الامتثال.
          </p>

          <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06); border-radius:14px; padding:1.2rem; display:flex; align-items:center; gap:1.25rem;">
            <span style="font-size:2rem;">🏛️</span>
            <div>
              <div style="font-size:0.78rem; color:var(--text-muted);">الجهة الحكومية / التنظيمية المعنية:</div>
              <div style="font-size:0.95rem; font-weight:800; color:var(--nawader-teal);">{{ $serviceObj['target'] ?? $cat['ministry'] }}</div>
            </div>
          </div>
        </div>

        {{-- Execution Workflow --}}
        <div class="nw-service-panel" data-nw-animate data-delay="150">
          <h3 class="nw-h3" style="margin-bottom:0.5rem;">مراحل التنفيذ ومسار المعاملة</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            خطة العمل المعتمدة لضمان سرعة الإنجاز ودقة المخرجات:
          </p>

          <div class="nw-workflow-timeline">
            <div class="nw-workflow-step">
              <div class="workflow-dot"></div>
              <div class="workflow-step-num">المرحلة 01</div>
              <div class="workflow-step-title">الفحص والتدقيق الفوري للوثائق بالذكاء الاصطناعي</div>
              <div class="workflow-step-desc">مراجعة مطابقة الهويات والوكالات والسجلات للتأكد من خلو الملف من أي نواقص شكلية أو قانونية.</div>
            </div>

            <div class="nw-workflow-step">
              <div class="workflow-dot"></div>
              <div class="workflow-step-num">المرحلة 02</div>
              <div class="workflow-step-title">صياغة اللوائح وإعداد العقود المعتمدة</div>
              <div class="workflow-step-desc">إعداد ملف المعاملة باللغتين العربية والإنجليزية وفق متطلبات الجهات التنظيمية والوزارية.</div>
            </div>

            <div class="nw-workflow-step">
              <div class="workflow-dot"></div>
              <div class="workflow-step-num">المرحلة 03</div>
              <div class="workflow-step-title">الإيداع الرسمي والمتابعة الحكومية اللحظية</div>
              <div class="workflow-step-desc">ربط المعاملة مع منصات الوزارة المختصة وسداد الرسوم المعتمدة ومتابعة لجان المراجعة والاعتماد.</div>
            </div>

            <div class="nw-workflow-step">
              <div class="workflow-dot"></div>
              <div class="workflow-step-num">المرحلة 04</div>
              <div class="workflow-step-title">إصدار الترخيص النهائي والأرشفة السيادية المشفرة</div>
              <div class="workflow-step-desc">تسليم الوثائق الرسمية والرخص المعتمدة وإيداع نسخة مشفرة في خزنة وثائق العميل بـ نوادر.</div>
            </div>
          </div>
        </div>

        {{-- OCR Scanner Preview --}}
        <div class="nw-ocr-box" data-nw-animate data-delay="200">
          <div class="ocr-icon">📄</div>
          <div class="ocr-title">الفحص الذكي للوثائق والمستندات (AI Document Readiness)</div>
          <div class="ocr-desc">يمكنك رفع متطلبات الخدمة أثناء تقديم الطلب ليقوم نظام نوادر الذكي بفحصها خلال 30 ثانية.</div>
          <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}&service={{ urlencode($serviceObj['name']) }}" class="nw-btn nw-btn-primary nw-btn-sm">
            بدء فحص المستندات وتقديم الطلب
          </a>
        </div>
      </div>

      {{-- Right Column: Sticky Pricing & Fast Action Card --}}
      <div>
        <div class="nw-price-sticky-card" data-nw-animate data-delay="100">
          <div style="font-size:0.8rem; font-weight:800; color:var(--nawader-gold-light); margin-bottom:0.5rem;">
            الرسوم التقديرية للخدمة
          </div>

          <div class="price-display-lg">
            {{ number_format($serviceObj['price']) }}
            <span class="price-currency">ر.س</span>
          </div>
          <div class="price-meta-tag">شامل المراجعة القانونية والمتابعة حتى الاعتماد</div>

          <div style="display:flex; flex-direction:column; gap:0.75rem; margin-bottom:1.5rem; padding-bottom:1.5rem; border-bottom:1px solid rgba(255,255,255,0.08); font-size:0.85rem;">
            <div style="display:flex; justify-content:space-between;">
              <span style="color:var(--text-muted);">⏱ المدة المتوقعة:</span>
              <span style="color:#fff; font-weight:700;">{{ $serviceObj['days'] }} أيام عمل</span>
            </div>
            <div style="display:flex; justify-content:space-between;">
              <span style="color:var(--text-muted);">🏛️ الجهة الرسمية:</span>
              <span style="color:var(--nawader-teal); font-weight:700;">{{ Str::limit($serviceObj['target'] ?? 'معتمد', 22) }}</span>
            </div>
            <div style="display:flex; justify-content:space-between;">
              <span style="color:var(--text-muted);">🛡️ الضمان:</span>
              <span style="color:#fff; font-weight:700;">التزام قانوني 100%</span>
            </div>
          </div>

          <a href="{{ route('dashboard.requests.create') }}?category={{ $cat['slug'] }}&service={{ urlencode($serviceObj['name']) }}" class="nw-btn nw-btn-primary nw-btn-lg" style="width:100%; margin-bottom:0.75rem;">
            قدّم الطلب فوراً ←
          </a>

          <a href="{{ route('pricing') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="width:100%;">
            حاسبة الرسوم المفصلة
          </a>

          <div style="margin-top:1.5rem; font-size:0.75rem; color:var(--text-muted); text-align:center; line-height:1.5;">
            🔒 بوابة مشفرة وآمنة وفق أعلى معايير الحماية المصرفية والسيادية.
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
@endsection
