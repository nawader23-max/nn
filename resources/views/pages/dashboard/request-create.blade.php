@extends('layouts.app')

@section('title', 'تقديم طلب خدمة جديد — نوادر')
@section('page_title', 'نموذج تقديم الطلب الاستراتيجي الذكي')
@section('description', 'تقديم ومتابعة طلبات الخدمات الحكومية والتجارية والاستثمارية في السعودية والولايات المتحدة — نوادر')

@push('head')
<style>
.nw-wizard-container {
  padding: 120px 0 80px; position: relative;
}
.wizard-orb {
  position: absolute; width: 600px; height: 600px; top: -100px; right: 20%;
  background: radial-gradient(circle, rgba(212,168,67,0.1) 0%, transparent 65%);
  filter: blur(90px); pointer-events: none;
}

.nw-wizard-card {
  max-width: 950px; margin: 0 auto;
  background: rgba(15, 23, 40, 0.85); backdrop-filter: blur(35px);
  border: 1px solid rgba(212, 168, 67, 0.25); border-radius: 24px;
  padding: 3rem; box-shadow: 0 30px 80px rgba(0,0,0,0.6);
  position: relative; overflow: hidden;
}
.nw-wizard-card::before {
  content: ''; position: absolute; top: 0; right: 0; left: 0; height: 4px;
  background: linear-gradient(90deg, var(--nawader-gold), var(--nawader-teal), var(--nawader-purple));
}

/* Stepper Tabs */
.nw-stepper-header {
  display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 2.5rem; position: relative; padding: 0 1rem;
}
.nw-stepper-header::before {
  content: ''; position: absolute; top: 22px; right: 3rem; left: 3rem; height: 2px;
  background: rgba(255, 255, 255, 0.08); z-index: 0;
}
.nw-step-indicator {
  display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
  position: relative; z-index: 1; cursor: pointer;
}
.step-num-circle {
  width: 44px; height: 44px; border-radius: 50%;
  background: rgba(15, 23, 40, 0.9); border: 2px solid rgba(255, 255, 255, 0.15);
  display: flex; align-items: center; justify-content: center;
  font-size: 0.95rem; font-weight: 800; color: var(--text-muted);
  transition: all 0.3s;
}
.nw-step-indicator.active .step-num-circle {
  border-color: var(--nawader-gold); background: rgba(212, 168, 67, 0.15);
  color: var(--nawader-gold-light); box-shadow: 0 0 18px rgba(212, 168, 67, 0.3);
}
.nw-step-indicator.done .step-num-circle {
  border-color: var(--nawader-teal); background: var(--nawader-teal); color: var(--nawader-navy);
}
.step-label { font-size: 0.8rem; font-weight: 700; color: var(--text-muted); transition: color 0.3s; }
.nw-step-indicator.active .step-label { color: #FFFFFF; }

/* Step Contents */
.nw-step-pane { display: none; }
.nw-step-pane.active { display: block; animation: nw-fade-in 0.4s ease; }

/* Category Grid Picker in Step 1 */
.nw-picker-grid {
  display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
  max-height: 380px; overflow-y: auto; padding: 0.5rem;
  margin-bottom: 2rem;
}
.nw-picker-card {
  background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.07);
  border-radius: 14px; padding: 1rem; text-align: center; cursor: pointer;
  transition: all 0.25s;
}
.nw-picker-card:hover {
  background: rgba(212, 168, 67, 0.08); border-color: rgba(212, 168, 67, 0.3);
  transform: translateY(-2px);
}
.nw-picker-card.selected {
  border-color: var(--nawader-gold); background: rgba(212, 168, 67, 0.15);
  box-shadow: 0 0 15px rgba(212, 168, 67, 0.2);
}
.picker-icon { font-size: 1.8rem; margin-bottom: 0.4rem; display: block; }
.picker-title { font-size: 0.82rem; font-weight: 700; color: #fff; line-height: 1.4; display: block; }

/* Form Fields */
.nw-wizard-group {
  display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.5rem;
}
.nw-wizard-label {
  font-size: 0.85rem; font-weight: 700; color: var(--text-secondary);
}
.nw-wizard-input, .nw-wizard-select, .nw-wizard-textarea {
  width: 100%; padding: 0.85rem 1.1rem;
  background: rgba(255, 255, 255, 0.035);
  border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px;
  color: #FFFFFF; font-size: 0.92rem; outline: none; direction: rtl;
  transition: all 0.25s;
}
.nw-wizard-input:focus, .nw-wizard-select:focus, .nw-wizard-textarea:focus {
  border-color: rgba(212, 168, 67, 0.5);
  box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.1);
}

/* Upload Dropzone */
.nw-dropzone-box {
  background: rgba(255, 255, 255, 0.02);
  border: 2px dashed rgba(212, 168, 67, 0.3);
  border-radius: 16px; padding: 2.5rem; text-align: center;
  cursor: pointer; transition: all 0.3s; margin-bottom: 1.5rem;
}
.nw-dropzone-box:hover {
  background: rgba(212, 168, 67, 0.05); border-color: var(--nawader-gold);
}
.drop-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
.drop-text { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 0.3rem; }
.drop-sub { font-size: 0.78rem; color: var(--text-muted); }

/* Speed / Tier Radios */
.nw-speed-options {
  display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;
}
.nw-speed-card {
  background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 14px; padding: 1.25rem; text-align: center; cursor: pointer;
  transition: all 0.25s;
}
.nw-speed-card:hover { border-color: rgba(0, 212, 200, 0.3); }
.nw-speed-card.selected {
  border-color: var(--nawader-teal); background: rgba(0, 212, 200, 0.1);
}
.speed-title { font-size: 0.95rem; font-weight: 800; color: #fff; margin-bottom: 0.3rem; }
.speed-time { font-size: 0.78rem; color: var(--nawader-teal); font-weight: 700; margin-bottom: 0.3rem; }
.speed-note { font-size: 0.72rem; color: var(--text-muted); }

/* Summary Box */
.nw-summary-review {
  background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px; padding: 1.75rem; margin-bottom: 2rem;
}
.review-row {
  display: flex; justify-content: space-between; padding: 0.65rem 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05); font-size: 0.9rem;
}
.review-row.total {
  border-bottom: none; padding-top: 1rem; font-size: 1.15rem; font-weight: 900;
  color: var(--nawader-gold);
}

/* Nav Buttons */
.nw-wizard-nav-btns {
  display: flex; justify-content: space-between; align-items: center;
  margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08);
}

@media(max-width:900px){
  .nw-picker-grid { grid-template-columns: repeat(2, 1fr); }
  .nw-speed-options { grid-template-columns: 1fr; }
  .nw-stepper-header::before { display: none; }
}
</style>
@endpush

@section('content')
<div class="nw-wizard-container">
  <div class="wizard-orb"></div>
  <div class="nw-container" style="position:relative; z-index:2;">

    <div class="nw-wizard-card" data-nw-animate>

      {{-- Stepper Progress Header --}}
      <div class="nw-stepper-header">
        <div class="nw-step-indicator active" data-step="1" onclick="jumpToStep(1)">
          <div class="step-num-circle">1</div>
          <span class="step-label">القطاع</span>
        </div>
        <div class="nw-step-indicator" data-step="2" onclick="jumpToStep(2)">
          <div class="step-num-circle">2</div>
          <span class="step-label">الخدمة والتفاصيل</span>
        </div>
        <div class="nw-step-indicator" data-step="3" onclick="jumpToStep(3)">
          <div class="step-num-circle">3</div>
          <span class="step-label">المستندات وAI</span>
        </div>
        <div class="nw-step-indicator" data-step="4" onclick="jumpToStep(4)">
          <div class="step-num-circle">4</div>
          <span class="step-label">سرعة الإنجاز</span>
        </div>
        <div class="nw-step-indicator" data-step="5" onclick="jumpToStep(5)">
          <div class="step-num-circle">5</div>
          <span class="step-label">المراجعة والاعتماد</span>
        </div>
      </div>

      {{-- Wizard Form --}}
      <form action="{{ route('dashboard.requests.store') }}" method="POST" id="nw-main-wizard-form" enctype="multipart/form-data">
        @csrf

        {{-- Hidden input for chosen category --}}
        <input type="hidden" name="category" id="hidden-category" value="{{ request('category', 'legal') }}">
        <input type="hidden" name="speed" id="hidden-speed" value="standard">

        {{-- ── STEP 1: CHOOSE SECTOR (الـ 20 قطاعاً) ── --}}
        <div class="nw-step-pane active" id="step-pane-1">
          <h3 class="nw-h3" style="margin-bottom:0.4rem;">اختر القطاع الاستراتيجي المطلوب</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            تغطي نوادر 20 قطاعاً حيوياً للجهات الحكومية والشركات في السعودية والولايات المتحدة:
          </p>

          <div class="nw-picker-grid">
            @foreach($services as $slug => $c)
            <div class="nw-picker-card {{ request('category') === $slug || (!request('category') && $loop->first) ? 'selected' : '' }}"
                 data-slug="{{ $slug }}" onclick="selectCategory('{{ $slug }}', this)">
              <span class="picker-icon">{{ $c['icon'] }}</span>
              <span class="picker-title">{{ $c['title'] }}</span>
            </div>
            @endforeach
          </div>

          <div class="nw-wizard-nav-btns">
            <div></div>
            <button type="button" class="nw-btn nw-btn-primary" onclick="jumpToStep(2)">
              متابعة لتفاصيل الخدمة ←
            </button>
          </div>
        </div>

        {{-- ── STEP 2: SERVICE & OPERATIONAL SPECS ── --}}
        <div class="nw-step-pane" id="step-pane-2">
          <h3 class="nw-h3" style="margin-bottom:0.4rem;">تفاصيل الخدمة والكيان التجاري</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            حدد نوع المعاملة والبيانات الأساسية للبدء في صياغة الملف:
          </p>

          <div class="nw-wizard-group">
            <label class="nw-wizard-label">الخدمة المحددة *</label>
            <input type="text" name="service_name" id="wizard-service-name" class="nw-wizard-input"
                   value="{{ request('service', 'تأسيس شركة ذات مسؤولية محدودة — سعودية (ش.م.م)') }}"
                   placeholder="مثال: تأسيس شركة ذات مسؤولية محدودة، ترخيص MISA...">
          </div>

          <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div class="nw-wizard-group">
              <label class="nw-wizard-label">الاسم المقترح للكيان / المنشأة *</label>
              <input type="text" name="entity_name" required class="nw-wizard-input" placeholder="مثال: شركة نوادر التقنية العالمية">
            </div>
            <div class="nw-wizard-group">
              <label class="nw-wizard-label">السوق المستهدف *</label>
              <select name="target_market" class="nw-wizard-select">
                <option value="sa">🇸🇦 المملكة العربية السعودية</option>
                <option value="us">🇺🇸 الولايات المتحدة الأمريكية (Delaware/Wyoming)</option>
                <option value="both">🇸🇦 🇺🇸 استثمار سعودي - أمريكي مشترك</option>
                <option value="intl">🌐 دولي / متعدد الجنسيات</option>
              </select>
            </div>
          </div>

          <div class="nw-wizard-group">
            <label class="nw-wizard-label">وصف تفصيلي للنشاط أو متطلبات خاصة</label>
            <textarea name="notes" class="nw-wizard-textarea" placeholder="يرجى كتابة أي تفاصيل إضافية مثل الأنشطة المراد ترخيصها، أو أي اشتراطات خاصة بالشركاء..."></textarea>
          </div>

          <div class="nw-wizard-nav-btns">
            <button type="button" class="nw-btn nw-btn-ghost" onclick="jumpToStep(1)">→ العودة للقطاع</button>
            <button type="button" class="nw-btn nw-btn-primary" onclick="jumpToStep(3)">متابعة لرفع المستندات ←</button>
          </div>
        </div>

        {{-- ── STEP 3: DOCUMENT UPLOAD & AI OCR ── --}}
        <div class="nw-step-pane" id="step-pane-3">
          <h3 class="nw-h3" style="margin-bottom:0.4rem;">رفع المستندات والفحص الذكي (AI OCR)</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            ارفع الهوية الوطنية أو جواز السفر، أو السجل التجاري القائم للتحقق الفوري الآلي:
          </p>

          <div class="nw-dropzone-box" onclick="document.getElementById('wizard-file-input').click()">
            <div class="drop-icon">📤</div>
            <div class="drop-text">اسحب وأفلت الملفات هنا، أو انقر للاختيار من جهازك</div>
            <div class="drop-sub">يدعم صيغ PDF, PNG, JPG حتى 25 ميجابايت (مشفر بتشفير AES-256)</div>
            <input type="file" name="documents[]" multiple id="wizard-file-input" style="display:none;" onchange="showUploadedFiles(this)">
          </div>

          <div id="uploaded-files-preview" style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.5rem;"></div>

          <div style="background:rgba(0,212,200,0.06); border:1px solid rgba(0,212,200,0.2); border-radius:12px; padding:1rem 1.25rem; display:flex; align-items:center; gap:0.75rem; font-size:0.82rem; color:var(--nawader-teal);">
            <span>⚡</span>
            <span>نظام الذكاء الاصطناعي يقوم بالتحقق التلقائي من وضوح المستند ومطابقة البيانات فور الرفع.</span>
          </div>

          <div class="nw-wizard-nav-btns">
            <button type="button" class="nw-btn nw-btn-ghost" onclick="jumpToStep(2)">→ العودة للتفاصيل</button>
            <button type="button" class="nw-btn nw-btn-primary" onclick="jumpToStep(4)">متابعة لسرعة الإنجاز ←</button>
          </div>
        </div>

        {{-- ── STEP 4: SLA / SPEED SELECTION ── --}}
        <div class="nw-step-pane" id="step-pane-4">
          <h3 class="nw-h3" style="margin-bottom:0.4rem;">اختر خطة وسرعة التنفيذ</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            تتيح نوادر مستويات إنجاز متعددة تلائم جداول أعمالكم ومواعيد الصفقات:
          </p>

          <div class="nw-speed-options">
            <div class="nw-speed-card selected" onclick="selectSpeed('standard', this, 0)">
              <div class="speed-title">المسار القياسي (Standard)</div>
              <div class="speed-time">⏱ 5 - 10 أيام عمل</div>
              <div class="speed-note">إنجاز شامل وفق الإجراءات التنظيمية العادية وبلا تكاليف تسريع.</div>
            </div>

            <div class="nw-speed-card" onclick="selectSpeed('express', this, 1200)">
              <div class="speed-title">المسار السريع VIP</div>
              <div class="speed-time">⏱ 3 - 5 أيام عمل</div>
              <div class="speed-note">أولوية مراجعة وتعيين مستشار متفرغ لمتابعة الإجراءات أولاً بأول (+1,200 ر.س).</div>
            </div>

            <div class="nw-speed-card" onclick="selectSpeed('sovereign', this, 2800)">
              <div class="speed-title">المسار السيادي الفوري (48 ساعة)</div>
              <div class="speed-time">⏱ 24 - 48 ساعة فقط</div>
              <div class="speed-note">فريق عمل طوارئ 24/7 مع تنسيق فوري مع مكاتب الوزارة المعنية (+2,800 ر.س).</div>
            </div>
          </div>

          <div class="nw-wizard-nav-btns">
            <button type="button" class="nw-btn nw-btn-ghost" onclick="jumpToStep(3)">→ العودة للمستندات</button>
            <button type="button" class="nw-btn nw-btn-primary" onclick="jumpToStep(5)">متابعة لملخص الطلب ←</button>
          </div>
        </div>

        {{-- ── STEP 5: REVIEW & SUBMIT ── --}}
        <div class="nw-step-pane" id="step-pane-5">
          <h3 class="nw-h3" style="margin-bottom:0.4rem;">مراجعة واعتماد الطلب</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1.5rem;">
            تأكد من صحة البيانات تمهيداً للإيداع ومباشرة ملفك فوراً:
          </p>

          <div class="nw-summary-review">
            <div class="review-row">
              <span style="color:var(--text-muted);">القطاع الاستراتيجي:</span>
              <strong style="color:#fff;" id="sum-category">تأسيس الشركات والكيانات القانونية</strong>
            </div>
            <div class="review-row">
              <span style="color:var(--text-muted);">الخدمة المطلوبة:</span>
              <strong style="color:var(--nawader-gold-light);" id="sum-service">تأسيس شركة ذات مسؤولية محدودة</strong>
            </div>
            <div class="review-row">
              <span style="color:var(--text-muted);">مسار التنفيذ المختار:</span>
              <strong style="color:var(--nawader-teal);" id="sum-speed">المسار القياسي (5-10 أيام)</strong>
            </div>
            <div class="review-row">
              <span style="color:var(--text-muted);">الأتعاب الاستشارية والتنفيذية:</span>
              <strong style="color:#fff;" id="sum-base-fee">3,500 ر.س</strong>
            </div>
            <div class="review-row">
              <span style="color:var(--text-muted);">رسوم تسريع المسار:</span>
              <strong style="color:#fff;" id="sum-speed-fee">0 ر.س</strong>
            </div>
            <div class="review-row">
              <span style="color:var(--text-muted);">ضريبة القيمة المضافة (15%):</span>
              <strong style="color:#fff;" id="sum-vat">525 ر.س</strong>
            </div>
            <div class="review-row total">
              <span>المجموع النهائي المقدر:</span>
              <span id="sum-total">4,025 ر.س</span>
            </div>
          </div>

          <div style="background:rgba(212,168,67,0.08); border:1px solid rgba(212,168,67,0.25); border-radius:12px; padding:1rem; font-size:0.82rem; color:var(--text-secondary); line-height:1.6; margin-bottom:1.5rem;">
            ✓ بالنقر على اعتماد وإرسال الطلب، يتم فتح ملف معتمد في لوحة التحكم وتعيين مستشار رسمي وإصدار فاتورة إلكترونية معتمدة من هيئة ZATCA.
          </div>

          <div class="nw-wizard-nav-btns">
            <button type="button" class="nw-btn nw-btn-ghost" onclick="jumpToStep(4)">→ تعديل البيانات</button>
            <button type="submit" class="nw-btn nw-btn-primary nw-btn-lg">
              اعتماد وإرسال الطلب الآن ←
            </button>
          </div>
        </div>

      </form>

    </div>

  </div>
</div>

<script>
let currentStep = 1;
let baseFee = 3500;
let speedFee = 0;

function jumpToStep(step) {
  if (step < 1 || step > 5) return;

  // Update indicators
  document.querySelectorAll('.nw-step-indicator').forEach(ind => {
    const s = parseInt(ind.dataset.step);
    ind.classList.toggle('active', s === step);
    ind.classList.toggle('done', s < step);
  });

  // Update panes
  document.querySelectorAll('.nw-step-pane').forEach((p, idx) => {
    p.classList.toggle('active', idx === (step - 1));
  });

  currentStep = step;
  if (step === 5) updateSummary();

  if (window.nawaderAudio) window.nawaderAudio.playBlip(950 + step * 80, 0.03);
}

function selectCategory(slug, cardEl) {
  document.querySelectorAll('.nw-picker-card').forEach(c => c.classList.remove('selected'));
  cardEl.classList.add('selected');
  document.getElementById('hidden-category').value = slug;

  // Update base fee approximation
  const feeMap = {
    'legal': 3500, 'licenses': 1800, 'property': 2500, 'foreign-investment': 6500,
    'local-investment': 4500, 'grants': 3500, 'ip': 2800, 'regulatory': 5500,
    'trade': 2200, 'hr': 2800, 'environment': 9500, 'tech': 6500,
    'health': 8500, 'education': 12000, 'tourism': 6500, 'energy': 14000,
    'agriculture': 6500, 'finance': 18000, 'expat': 4500, 'consulting': 15000
  };
  baseFee = feeMap[slug] || 3500;

  // Auto-fill suggested service
  const titles = {
    'legal': 'تأسيس شركة ذات مسؤولية محدودة (ش.م.م)',
    'foreign-investment': 'ترخيص استثمار أجنبي مباشر MISA',
    'licenses': 'إصدار وتجديد رخصة تجارية وبلدية',
    'ip': 'تسجيل علامة تجارية محلية ودولية',
    'finance': 'ترخيص بيئة تجريبية وتقنية مالية SAMA',
    'expat': 'ملف الإقامة المميزة السعودية',
    'consulting': 'استراتيجية توسع واستشارة قانونية كبرى'
  };
  if (titles[slug]) {
    document.getElementById('wizard-service-name').value = titles[slug];
  }
}

function selectSpeed(speed, cardEl, fee) {
  document.querySelectorAll('.nw-speed-card').forEach(c => c.classList.remove('selected'));
  cardEl.classList.add('selected');
  document.getElementById('hidden-speed').value = speed;
  speedFee = fee;
}

function showUploadedFiles(input) {
  const container = document.getElementById('uploaded-files-preview');
  container.innerHTML = '';
  if (!input.files || !input.files.length) return;

  Array.from(input.files).forEach(f => {
    const row = document.createElement('div');
    row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:8px;padding:0.6rem 1rem;font-size:0.85rem;';
    row.innerHTML = `
      <span style="color:#fff;">📄 ${f.name} (${(f.size/1024).toFixed(1)} KB)</span>
      <span style="color:var(--nawader-teal);font-weight:700;">✓ جاهز للفحص</span>
    `;
    container.appendChild(row);
  });
}

function updateSummary() {
  const subtotal = baseFee + speedFee;
  const vat = subtotal * 0.15;
  const total = subtotal + vat;

  document.getElementById('sum-service').textContent = document.getElementById('wizard-service-name').value || 'خدمة استراتيجية';
  document.getElementById('sum-base-fee').textContent = baseFee.toLocaleString('ar-SA') + ' ر.س';
  document.getElementById('sum-speed-fee').textContent = speedFee.toLocaleString('ar-SA') + ' ر.س';
  document.getElementById('sum-vat').textContent = vat.toLocaleString('ar-SA') + ' ر.س';
  document.getElementById('sum-total').textContent = total.toLocaleString('ar-SA') + ' ر.س';
}
</script>
@endsection
