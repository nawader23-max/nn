@extends('layouts.app')

@section('title', 'أستديو بناء المواقع والتطبيقات السيادية — نوادر للحلول البرمجية')
@section('page_title', 'أستديو هندسة البرمجيات والأنظمة السيادية')

@push('head')
<style>
.nw-builder-page { padding: 120px 0 80px; position: relative; }
.builder-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(120px); }

.builder-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 2.25rem;
  margin-bottom: 2rem; transition: all 0.3s;
}

.step-bubble {
  width: 40px; height: 40px; border-radius: 12px;
  background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.12);
  display: flex; align-items: center; justify-content: center; font-weight: 800;
  color: var(--text-muted); font-size: 1rem; transition: all 0.3s;
}
.step-bubble.active {
  background: var(--grad-gold); color: var(--nawader-navy); border-color: var(--nawader-gold);
  box-shadow: 0 0 15px rgba(212,168,67,0.35);
}
.step-bubble.completed {
  background: rgba(0,212,200,0.15); color: var(--nawader-teal); border-color: var(--nawader-teal);
}

.option-select-card {
  background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.07);
  border-radius: 16px; padding: 1.25rem; cursor: pointer; transition: all 0.25s;
  display: flex; flex-direction: column; justify-content: space-between;
}
.option-select-card:hover {
  border-color: rgba(212,168,67,0.3); background: rgba(255,255,255,0.04);
}
.option-select-card.selected {
  border-color: var(--nawader-gold); background: rgba(212,168,67,0.08);
  box-shadow: 0 0 20px rgba(212,168,67,0.15);
}

.blueprint-screen {
  background: rgba(6,10,20,0.95); border: 1px solid rgba(0,212,200,0.3);
  border-radius: 16px; padding: 1.5rem; font-family: monospace; font-size: 0.85rem;
  color: var(--nawader-teal); direction: ltr; text-align: left; line-height: 1.7;
}
</style>
@endpush

@section('content')
<div class="nw-builder-page">
  <div class="builder-orb" style="width:650px;height:650px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="builder-orb" style="width:600px;height:600px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Hero Header -->
    <div style="text-align:center;max-width:850px;margin:0 auto 3rem;">
      <div class="nw-section-eyebrow" style="margin-bottom:0.6rem;">البرمجيات السيادية وتطوير الأنظمة الفائقة</div>
      <h1 style="font-size:2.3rem;font-weight:900;color:#fff;line-height:1.3;margin-bottom:1rem;">
        أستديو بناء وتصميم المواقع والتطبيقات والأنظمة السحابية
      </h1>
      <p style="font-size:0.95rem;color:var(--text-secondary);line-height:1.8;">
        قم بتهيئة مواصفات مشروعك البرمجي، اختر المعمارية السحابية وبوابات الربط الحكومي، واحصل فورياً على دراسة الجدوى التقنية، المخطط المعماري (Architecture Blueprint)، والتعاقد المباشر.
      </p>
    </div>

    <!-- Stepper Navigation -->
    <div style="display:flex;align-items:center;justify-content:center;gap:1.5rem;margin-bottom:3rem;flex-wrap:wrap;">
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div id="step-btn-1" class="step-bubble active">1</div>
        <span style="font-size:0.85rem;font-weight:700;color:#fff;">نوع المنصة</span>
      </div>
      <div style="width:30px;height:2px;background:rgba(255,255,255,0.1);"></div>
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div id="step-btn-2" class="step-bubble">2</div>
        <span style="font-size:0.85rem;color:var(--text-muted);">المعمارية والتقنيات</span>
      </div>
      <div style="width:30px;height:2px;background:rgba(255,255,255,0.1);"></div>
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div id="step-btn-3" class="step-bubble">3</div>
        <span style="font-size:0.85rem;color:var(--text-muted);">بوابات الربط الحكومي</span>
      </div>
      <div style="width:30px;height:2px;background:rgba(255,255,255,0.1);"></div>
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div id="step-btn-4" class="step-bubble">4</div>
        <span style="font-size:0.85rem;color:var(--text-muted);">المخطط والتعاقد</span>
      </div>
    </div>

    <!-- Wizard Steps Container -->
    <div class="builder-card">
      
      <!-- Step 1: Platform Type -->
      <div id="wizard-step-1">
        <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">الخطوة 1: اختر نوع المنصة أو التطبيق المستهدف</h2>
        <p style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:2rem;">حدد طبيعة النظام البرمجي الذي ترغب في تشييده بمعايير سيادية عالية.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:1.25rem;margin-bottom:2.5rem;">
          
          <div class="option-select-card selected" onclick="selectPlatform(this, 'sovereign_portal', 'بوابة حكومية وسيادية متكاملة', 180000, 45)">
            <div>
              <div style="font-size:2.5rem;margin-bottom:0.8rem;">🏛️</div>
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:0.4rem;">بوابة حكومية وسيادية</h3>
              <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;">
                بوابات تفاعلية للوزارات والهيئات بمستوى أمان عسكري متوافق مع ضوابط الأمن السيبراني (NCA ECC).
              </p>
            </div>
            <div style="margin-top:1rem;font-size:0.75rem;color:var(--nawader-gold);font-weight:700;">التقدير: 180,000 ر.س | 45 يوماً</div>
          </div>

          <div class="option-select-card" onclick="selectPlatform(this, 'mobile_superapp', 'تطبيق موبايل فائق (SuperApp)', 140000, 35)">
            <div>
              <div style="font-size:2.5rem;margin-bottom:0.8rem;">📱</div>
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:0.4rem;">تطبيق جوال فائق (iOS / Android)</h3>
              <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;">
                تطبيق هجين فائق السرعة عبر Flutter أو Native مع بصمة الوجه والمحفظة الرقمية والدفع السريع.
              </p>
            </div>
            <div style="margin-top:1rem;font-size:0.75rem;color:var(--nawader-gold);font-weight:700;">التقدير: 140,000 ر.س | 35 يوماً</div>
          </div>

          <div class="option-select-card" onclick="selectPlatform(this, 'enterprise_erp', 'منظومة سحابية لإدارة المنشآت (Cloud ERP)', 220000, 60)">
            <div>
              <div style="font-size:2.5rem;margin-bottom:0.8rem;">🏢</div>
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:0.4rem;">نظام ERP وإدارة المنشآت</h3>
              <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;">
                نظام إدارة موارد الشركات، المخازن، الفوترة المتوافقة مع زاتكا، الموارد البشرية والرواتب.
              </p>
            </div>
            <div style="margin-top:1rem;font-size:0.75rem;color:var(--nawader-gold);font-weight:700;">التقدير: 220,000 ر.س | 60 يوماً</div>
          </div>

          <div class="option-select-card" onclick="selectPlatform(this, 'sovereign_ai_engine', 'منصة ذكاء اصطناعي سيادية خاصة', 290000, 60)">
            <div>
              <div style="font-size:2.5rem;margin-bottom:0.8rem;">🤖</div>
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:0.4rem;">منصة ذكاء اصطناعي مخصصة</h3>
              <p style="font-size:0.8rem;color:var(--text-secondary);line-height:1.6;">
                تدريب ونشر نماذج ذكاء اصطناعي محلية (RAG + علّام) على خوادم محلية آمنة دون خروج البيانات خارج المملكة.
              </p>
            </div>
            <div style="margin-top:1rem;font-size:0.75rem;color:var(--nawader-gold);font-weight:700;">التقدير: 290,000 ر.س | 60 يوماً</div>
          </div>

        </div>

        <div style="display:flex;justify-content:flex-end;">
          <button type="button" onclick="goToStep(2)" class="nw-btn nw-btn-primary">
            <span>متابعة لاختيار المعمارية</span>
            <span>←</span>
          </button>
        </div>
      </div>

      <!-- Step 2: Tech Architecture -->
      <div id="wizard-step-2" style="display:none;">
        <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">الخطوة 2: المعمارية السحابية وقواعد البيانات</h2>
        <p style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:2rem;">اختر المحركات والتقنيات الأساسية التي تبنى عليها بنيتك التحتية.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1.25rem;margin-bottom:2.5rem;">
          <label class="option-select-card selected" onclick="toggleTech(this)">
            <input type="checkbox" checked style="display:none;">
            <div style="font-size:1.8rem;margin-bottom:0.5rem;">⚡</div>
            <h4 style="color:#fff;font-weight:800;margin-bottom:0.3rem;">Laravel 13 Octane + PHP 8.4</h4>
            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">استجابة فائقة السرعة بالميلي ثانية مع خوادم Swoole عالية التحمل.</p>
          </label>

          <label class="option-select-card selected" onclick="toggleTech(this)">
            <input type="checkbox" checked style="display:none;">
            <div style="font-size:1.8rem;margin-bottom:0.5rem;">🗄️</div>
            <h4 style="color:#fff;font-weight:800;margin-bottom:0.3rem;">PostgreSQL / Oracle Sovereign DB</h4>
            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">قواعد بيانات مشفرة في حالة السكون مع نسخ احتياطي جغرافي موزع.</p>
          </label>

          <label class="option-select-card selected" onclick="toggleTech(this)">
            <input type="checkbox" checked style="display:none;">
            <div style="font-size:1.8rem;margin-bottom:0.5rem;">🛡️</div>
            <h4 style="color:#fff;font-weight:800;margin-bottom:0.3rem;">Cloudflare Enterprise Shield</h4>
            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">حماية متقدمة من هجمات DDoS مع جدار ناري سيبراني WAF مخصص.</p>
          </label>

          <label class="option-select-card selected" onclick="toggleTech(this)">
            <input type="checkbox" checked style="display:none;">
            <div style="font-size:1.8rem;margin-bottom:0.5rem;">🐳</div>
            <h4 style="color:#fff;font-weight:800;margin-bottom:0.3rem;">Kubernetes Microservices</h4>
            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">توسع تلقائي مرن للحاويات للتعامل مع ملايين الزيارات المتزامنة.</p>
          </label>
        </div>

        <div style="display:flex;justify-content:space-between;">
          <button type="button" onclick="goToStep(1)" class="nw-btn nw-btn-ghost">→ العودة للخطوة السابقة</button>
          <button type="button" onclick="goToStep(3)" class="nw-btn nw-btn-primary">
            <span>متابعة لبوابات الربط الحكومي</span>
            <span>←</span>
          </button>
        </div>
      </div>

      <!-- Step 3: Government Integrations -->
      <div id="wizard-step-3" style="display:none;">
        <h2 style="font-size:1.35rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">الخطوة 3: بوابات الربط الحكومي والمالي السيادي</h2>
        <p style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:2rem;">حدد الأنظمة والخدمات التي سيتم ربطها آلياً بنظامك عبر الـ APIs.</p>

        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1rem;margin-bottom:2.5rem;">
          <label class="option-select-card selected" onclick="toggleIntegration(this, 15000)">
            <input type="checkbox" checked style="display:none;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
              <span style="font-size:1.5rem;">🇸🇦</span>
              <strong style="color:#fff;font-size:0.9rem;">نفاذ الوطني الموحد (Nafath SSO)</strong>
            </div>
            <span style="font-size:0.75rem;color:var(--text-muted);">تسجيل الدخول والتحقق البيومتري للمواطنين والمقيمين</span>
          </label>

          <label class="option-select-card selected" onclick="toggleIntegration(this, 20000)">
            <input type="checkbox" checked style="display:none;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
              <span style="font-size:1.5rem;">📋</span>
              <strong style="color:#fff;font-size:0.9rem;">بوابة واثق التجارية (Wathq MOC)</strong>
            </div>
            <span style="font-size:0.75rem;color:var(--text-muted);">الاستعلام الفوري عن السجلات التجارية وتراخيص الاستثمار</span>
          </label>

          <label class="option-select-card selected" onclick="toggleIntegration(this, 25000)">
            <input type="checkbox" checked style="display:none;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
              <span style="font-size:1.5rem;">🧾</span>
              <strong style="color:#fff;font-size:0.9rem;">الفوترة الإلكترونية زاتكا مرحلة 2 (ZATCA)</strong>
            </div>
            <span style="font-size:0.75rem;color:var(--text-muted);">توليد الفواتير المشفرة ورموز الاستجابة السريعة والربط المالي</span>
          </label>

          <label class="option-select-card selected" onclick="toggleIntegration(this, 18000)">
            <input type="checkbox" checked style="display:none;">
            <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.4rem;">
              <span style="font-size:1.5rem;">💳</span>
              <strong style="color:#fff;font-size:0.9rem;">منظومة المدفوعات السيادية (Mada & Sadad)</strong>
            </div>
            <span style="font-size:0.75rem;color:var(--text-muted);">بوابة تحصيل الأموال وسداد الفواتير وحسابات الضمان Escrow</span>
          </label>
        </div>

        <div style="display:flex;justify-content:space-between;">
          <button type="button" onclick="goToStep(2)" class="nw-btn nw-btn-ghost">→ العودة للخطوة السابقة</button>
          <button type="button" onclick="generateBlueprint()" class="nw-btn nw-btn-primary">
            <span>توليد المخطط والتعاقد الفوري</span>
            <span>⚡</span>
          </button>
        </div>
      </div>

      <!-- Step 4: Blueprint & Instant Contract Execution -->
      <div id="wizard-step-4" style="display:none;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
          <div>
            <div class="nw-section-eyebrow" style="margin-bottom:0.3rem;">المخرجات الفنية للمشروع</div>
            <h2 style="font-size:1.35rem;font-weight:800;color:#fff;">المخطط المعماري السيادي ودراسة التكاليف المعتمدة</h2>
          </div>
          <div style="display:flex;gap:0.75rem;">
            <button onclick="window.print()" class="nw-btn nw-btn-sm nw-btn-ghost">طباعة المخطط 🖨️</button>
          </div>
        </div>

        <!-- Summary Metric Boxes -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1rem;margin-bottom:2rem;">
          <div style="background:rgba(0,0,0,0.3);padding:1.25rem;border-radius:14px;border:1px solid rgba(255,255,255,0.06);">
            <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.3rem;">الميزانية التقديرية الشاملة</div>
            <div id="summary-price" style="font-size:1.6rem;font-weight:900;color:var(--nawader-gold);font-family:var(--font-latin);">
              258,000 SAR
            </div>
            <div style="font-size:0.7rem;color:var(--nawader-teal);margin-top:0.2rem;">شاملة الربط الحكومي وضمان سنة كاملة</div>
          </div>

          <div style="background:rgba(0,0,0,0.3);padding:1.25rem;border-radius:14px;border:1px solid rgba(255,255,255,0.06);">
            <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.3rem;">الجدول الزمني المعتمد للتسليم</div>
            <div id="summary-timeline" style="font-size:1.6rem;font-weight:900;color:#fff;font-family:var(--font-latin);">
              45 يوماً
            </div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.2rem;">وفق منهجية Agile السيادية السريعة</div>
          </div>

          <div style="background:rgba(0,0,0,0.3);padding:1.25rem;border-radius:14px;border:1px solid rgba(255,255,255,0.06);">
            <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.3rem;">معيار الأمن والامتثال</div>
            <div style="font-size:1.6rem;font-weight:900;color:var(--nawader-teal);font-family:var(--font-latin);">
              NCA ECC-1
            </div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.2rem;">100% متوافق مع ضوابط الأمن السيبراني</div>
          </div>
        </div>

        <!-- Generated Code & Architecture Blueprint Screen -->
        <div style="margin-bottom:2rem;">
          <h3 style="font-size:0.95rem;font-weight:700;color:#fff;margin-bottom:0.75rem;">مخطط معمارية النظام (Architecture Blueprint):</h3>
          <div id="blueprint-code" class="blueprint-screen">
// ========================================================
// NAWADER SOVEREIGN PLATFORM BLUEPRINT v2026.4
// TARGET: SOVEREIGN GOVERNMENT PORTAL & B2B HUB
// ========================================================

[1. RUNTIME & INFRASTRUCTURE]
├── Framework: Laravel 13 Octane (Swoole Asynchronous Engine)
├── PHP: 8.4 JIT Compiled
├── Database: Sovereign Encrypted PostgreSQL Cluster (AES-256)
├── Caching & Queues: Redis 7.2 Sentinel Multi-Region Cluster
└── Defense Layer: Cloudflare Enterprise WAF + DDoS Mitigation

[2. INTEGRATED SOVEREIGN GOVERNMENT ENGINES]
├── 🇸🇦 Nafath SSO (Biometric Verification Level 4)
├── 🏢 Wathq API (Commercial Registry & License Sync)
├── 🧾 ZATCA Stage 2 (Cryptographic XML E-Invoicing)
└── 💳 Sovereign Payment Hub (Mada, Sadad, Apple Pay, Escrow)

[3. CYBERSECURITY & COMPLIANCE]
├── Compliance: National Cybersecurity Authority (NCA-ECC)
├── Data Privacy: Saudi PDPL + ISO 27001 Certified
└── Digital Signature: SHA-256 with Timestamping Authority
          </div>
        </div>

        <!-- Direct Instant Contract Button -->
        <div style="background:rgba(212,168,67,0.1);border:1px solid rgba(212,168,67,0.3);border-radius:16px;padding:1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
          <div>
            <div style="font-size:1.05rem;font-weight:800;color:#fff;margin-bottom:0.3rem;">جاهز لبدء التنفيذ والتعاقد الفوري؟</div>
            <div style="font-size:0.8rem;color:var(--text-secondary);">يمكنك نقل هذه المواصفات إلى مكتبة العقود الرقمية وتوثيق العقد إلكترونياً الآن.</div>
          </div>
          <form method="POST" action="{{ route('dashboard.contracts.sign', 'CNT-2026-NEOM-8832') }}">
            @csrf
            <button type="button" onclick="alert('تم حفظ المواصفات الفنية للمشروع وإرسال مسودة العقد السيادي إلى لوحة التحكم الخاصة بك!');window.location.href='{{ route('dashboard.contracts') }}';" class="nw-btn nw-btn-primary" style="padding:0.85rem 2rem;">
              <span>توقيع العقد الرقمي وبدء العمل 📜</span>
            </button>
          </form>
        </div>

        <div style="margin-top:1.5rem;display:flex;justify-content:flex-start;">
          <button type="button" onclick="goToStep(3)" class="nw-btn nw-btn-ghost">→ العودة لتعديل الخيارات</button>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
let currentStep = 1;
let selectedBasePrice = 180000;
let selectedDays = 45;
let extraIntegrationCost = 78000;

function goToStep(step) {
  for (let i = 1; i <= 4; i++) {
    document.getElementById('wizard-step-' + i).style.display = 'none';
    const btn = document.getElementById('step-btn-' + i);
    btn.classList.remove('active');
    if (i < step) btn.classList.add('completed');
    else btn.classList.remove('completed');
  }

  document.getElementById('wizard-step-' + step).style.display = 'block';
  document.getElementById('step-btn-' + step).classList.add('active');
  currentStep = step;
  window.scrollTo({ top: 200, behavior: 'smooth' });
}

function selectPlatform(card, key, label, price, days) {
  document.querySelectorAll('#wizard-step-1 .option-select-card').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');
  selectedBasePrice = price;
  selectedDays = days;
}

function toggleTech(card) {
  card.classList.toggle('selected');
}

function toggleIntegration(card, cost) {
  card.classList.toggle('selected');
  if (card.classList.contains('selected')) {
    extraIntegrationCost += cost;
  } else {
    extraIntegrationCost -= cost;
  }
}

function generateBlueprint() {
  const totalPrice = selectedBasePrice + extraIntegrationCost;
  document.getElementById('summary-price').textContent = totalPrice.toLocaleString() + ' SAR';
  document.getElementById('summary-timeline').textContent = selectedDays + ' يوماً';
  goToStep(4);
}
</script>
@endsection
