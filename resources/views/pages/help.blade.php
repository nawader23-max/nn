@extends('layouts.app')

@section('title', 'مركز المعرفة والأدلة السيادية — نوادر')
@section('page_title', 'مركز المعرفة والأنظمة السيادية')

@push('head')
<style>
.nw-help-page { padding: 120px 0 90px; position: relative; }
.help-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.help-hero-box {
  background: linear-gradient(135deg, rgba(15,23,40,0.92) 0%, rgba(20,32,60,0.85) 100%);
  border: 1px solid rgba(212,168,67,0.3); border-radius: 28px; padding: 3rem;
  backdrop-filter: blur(35px); text-align: center; position: relative; overflow: hidden;
  box-shadow: 0 35px 90px rgba(0,0,0,0.6); margin-bottom: 3.5rem;
}
.help-search-input {
  width: 100%; max-width: 680px; padding: 1.1rem 1.75rem; border-radius: 50px;
  background: rgba(10,15,30,0.85); border: 1.5px solid rgba(0,212,200,0.35);
  color: #fff; font-size: 1rem; font-family: var(--font-arabic); outline: none;
  box-shadow: 0 10px 30px rgba(0,0,0,0.4), 0 0 25px rgba(0,212,200,0.1);
  transition: all 0.3s;
}
.help-search-input:focus {
  border-color: var(--nawader-teal); box-shadow: 0 10px 40px rgba(0,0,0,0.6), 0 0 35px rgba(0,212,200,0.25);
}
.help-cat-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 2rem;
  transition: all 0.3s; height: 100%; display: flex; flex-direction: column; justify-content: space-between;
}
.help-cat-card:hover {
  border-color: rgba(212,168,67,0.35); transform: translateY(-4px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
.faq-accordion-item {
  background: rgba(15,23,40,0.8); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 16px; margin-bottom: 0.9rem; overflow: hidden; transition: all 0.25s;
}
.faq-question-btn {
  width: 100%; padding: 1.25rem 1.5rem; text-align: right; background: none; border: none;
  color: #fff; font-weight: 700; font-size: 0.98rem; font-family: var(--font-arabic);
  cursor: pointer; display: flex; align-items: center; justify-content: space-between;
}
.faq-answer-body {
  padding: 0 1.5rem 1.25rem; color: var(--text-secondary); font-size: 0.88rem; line-height: 1.7; display: none;
}
.faq-accordion-item.active .faq-answer-body { display: block; }
.faq-accordion-item.active { border-color: rgba(0,212,200,0.3); background: rgba(18,28,50,0.85); }
</style>
@endpush

@section('content')
<div class="nw-help-page">
  <div class="help-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="help-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Hero Box with Search -->
    <div class="help-hero-box" data-nw-animate>
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.75rem;">
        <span>📚</span>
        <span>الموسوعة السيادية والتشريعية المزدوجة</span>
      </div>
      <h1 style="font-size:2.5rem;font-weight:900;color:#fff;margin-bottom:1rem;">
        مركز المعرفة والأنظمة السيادية
      </h1>
      <p style="font-size:1.05rem;color:var(--text-secondary);max-width:720px;margin:0 auto 2.25rem;line-height:1.7;">
        دليلك الشامل والشامل للأنظمة الحكومية السعودية (رؤية 2030) ولوائح الشركات والضرائب الأمريكية، وإجراءات التأسيس عبر الممر الثنائي.
      </p>

      <form action="{{ route('help.search') }}" method="GET" style="display:flex;justify-content:center;margin-bottom:1.5rem;">
        <input type="text" name="q" value="{{ $query ?? '' }}" class="help-search-input" placeholder="ابحث في الأنظمة، التراخيص، الضرائب، أو أدلة التأسيس...">
      </form>

      <div style="display:flex;gap:0.6rem;justify-content:center;flex-wrap:wrap;font-size:0.8rem;">
        <span style="color:var(--text-muted);">الأكثر بحثاً:</span>
        <a href="{{ route('help.article', 'saudi-misa-license') }}" style="color:var(--nawader-gold);text-decoration:none;">ترخيص الاستثمار MISA</a>
        <span style="color:rgba(255,255,255,0.2);">•</span>
        <a href="{{ route('help.article', 'us-delaware-c-corp') }}" style="color:var(--nawader-teal);text-decoration:none;">تأسيس ديلاوير C-Corp</a>
        <span style="color:rgba(255,255,255,0.2);">•</span>
        <a href="{{ route('help.article', 'zatca-phase-2') }}" style="color:var(--nawader-gold);text-decoration:none;">فوترة زاتكا المرحلة الثانية</a>
        <span style="color:rgba(255,255,255,0.2);">•</span>
        <a href="{{ route('help.article', 'bilateral-banking') }}" style="color:var(--nawader-teal);text-decoration:none;">الحسابات المصرفية السيادية</a>
      </div>
    </div>

    <!-- 4 Main Knowledge Hubs -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1.75rem;margin-bottom:4rem;">
      
      <!-- Hub 1: Saudi Regulatory -->
      <div class="help-cat-card">
        <div>
          <div style="width:52px;height:52px;border-radius:16px;background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.3);display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin-bottom:1.25rem;">
            🇸🇦
          </div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.6rem;">الأنظمة والتراخيص السعودية</h2>
          <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;margin-bottom:1.5rem;">
            أدلة شاملة لنظام الشركات السعودي الجديد، تراخيص وزارة الاستثمار (MISA)، متطلبات المحتوى المحلي، وإجراءات هيئة السوق المالية (CMA).
          </p>
        </div>
        <ul style="list-style:none;padding:0;margin:0 0 1.25rem;display:flex;flex-direction:column;gap:0.6rem;font-size:0.84rem;">
          <li><a href="{{ route('help.article', 'saudi-misa-license') }}" style="color:var(--nawader-teal);text-decoration:none;">← دليل ترخيص المستثمر الأجنبي 2026</a></li>
          <li><a href="{{ route('help.article', 'saudi-companies-law') }}" style="color:var(--text-secondary);text-decoration:none;">← نظام الشركات الجديد والمساهمة المبسطة</a></li>
          <li><a href="{{ route('help.article', 'zatca-phase-2') }}" style="color:var(--text-secondary);text-decoration:none;">← الربط والتكامل مع منصة فاتورة (ZATCA)</a></li>
        </ul>
      </div>

      <!-- Hub 2: US Corporate & Federal -->
      <div class="help-cat-card">
        <div>
          <div style="width:52px;height:52px;border-radius:16px;background:rgba(120,169,255,0.12);border:1px solid rgba(120,169,255,0.3);display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin-bottom:1.25rem;">
            🇺🇸
          </div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.6rem;">الكيانات والضرائب الأمريكية</h2>
          <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;margin-bottom:1.5rem;">
            تأسيس شركات ديلاوير ووايومنغ، استخراج الرقم الضريبي الفيدرالي EIN، الامتثال لقانون الشفافية المؤسسية (BOI/FinCEN)، وفتح الحسابات البنكية.
          </p>
        </div>
        <ul style="list-style:none;padding:0;margin:0 0 1.25rem;display:flex;flex-direction:column;gap:0.6rem;font-size:0.84rem;">
          <li><a href="{{ route('help.article', 'us-delaware-c-corp') }}" style="color:#78a9ff;text-decoration:none;">← تأسيس كيان Delaware C-Corp خطوة بخطوة</a></li>
          <li><a href="{{ route('help.article', 'us-ein-tax-guide') }}" style="color:var(--text-secondary);text-decoration:none;">← استخراج EIN لغير المقيمين من IRS</a></li>
          <li><a href="{{ route('help.article', 'us-fincen-boi-compliance') }}" style="color:var(--text-secondary);text-decoration:none;">← إفصاح المستفيد الحقيقي FinCEN BOI</a></li>
        </ul>
      </div>

      <!-- Hub 3: Sovereign Banking & Treasury -->
      <div class="help-cat-card">
        <div>
          <div style="width:52px;height:52px;border-radius:16px;background:rgba(212,168,67,0.12);border:1px solid rgba(212,168,67,0.3);display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin-bottom:1.25rem;">
            🏦
          </div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.6rem;">الخزينة والتحويلات الثنائية</h2>
          <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;margin-bottom:1.5rem;">
            الربط بين الشبكات المصرفية السعودية (سداد، سريع، ساما) والشبكات الفيدرالية الأمريكية (Fedwire، ACH)، وحسابات الضمان السيادي (Escrow).
          </p>
        </div>
        <ul style="list-style:none;padding:0;margin:0 0 1.25rem;display:flex;flex-direction:column;gap:0.6rem;font-size:0.84rem;">
          <li><a href="{{ route('help.article', 'bilateral-banking') }}" style="color:var(--nawader-gold);text-decoration:none;">← آليات فتح الحسابات البنكية الثنائية</a></li>
          <li><a href="{{ route('help.article', 'escrow-protection') }}" style="color:var(--text-secondary);text-decoration:none;">← بروتوكول حماية أموال الصفقات بالضمان</a></li>
          <li><a href="{{ route('help.article', 'fx-currency-hedging') }}" style="color:var(--text-secondary);text-decoration:none;">← تثبيت الصرف والتحويل بين الريال والدولار</a></li>
        </ul>
      </div>

      <!-- Hub 4: IP & Tech Sovereignty -->
      <div class="help-cat-card">
        <div>
          <div style="width:52px;height:52px;border-radius:16px;background:rgba(232,93,138,0.12);border:1px solid rgba(232,93,138,0.3);display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin-bottom:1.25rem;">
            💡
          </div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.6rem;">الملكية الفكرية والسيادة الرقمية</h2>
          <p style="font-size:0.85rem;color:var(--text-muted);line-height:1.6;margin-bottom:1.5rem;">
            تسجيل براءات الاختراع والعلامات التجارية دولياً لدى الهيئة السعودية للملكية الفكرية (SAIP) ومكتب براءات الاختراع الأمريكي (USPTO).
          </p>
        </div>
        <ul style="list-style:none;padding:0;margin:0 0 1.25rem;display:flex;flex-direction:column;gap:0.6rem;font-size:0.84rem;">
          <li><a href="{{ route('help.article', 'saip-uspto-patent') }}" style="color:#ff9bc0;text-decoration:none;">← الحماية المزدوجة للاختراعات SAIP + USPTO</a></li>
          <li><a href="{{ route('help.article', 'sdaia-data-residency') }}" style="color:var(--text-secondary);text-decoration:none;">← اشتراطات استضافة البيانات داخل المملكة</a></li>
          <li><a href="{{ route('help.article', 'cyber-defense-framework') }}" style="color:var(--text-secondary);text-decoration:none;">← ضوابط الهيئة الوطنية للأمن السيبراني (NCA)</a></li>
        </ul>
      </div>

    </div>

    <!-- Frequently Asked Questions Accordion -->
    <div style="max-width:880px;margin:0 auto 4rem;">
      <div style="text-align:center;margin-bottom:2.5rem;">
        <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.4rem;">استفسارات شائعة</div>
        <h2 style="font-size:1.85rem;font-weight:900;color:#fff;">الأسئلة الأكثر تداولاً بين المستثمرين والشركات</h2>
      </div>

      <div class="faq-accordion-item active">
        <button class="faq-question-btn" onclick="toggleFaq(this)">
          <span>ما هي المدة الزمنية لإصدار ترخيص الاستثمار الأجنبي (MISA) وتأسيس الشركة؟</span>
          <span style="font-size:1.2rem;">▾</span>
        </button>
        <div class="faq-answer-body">
          من خلال منصة نوادر وبالتكامل الرقمي المباشر مع وزارة الاستثمار ووزارة التجارة، يتم إصدار ترخيص MISA خلال 3 ساعات عمل، وإتمام السجل التجاري وعقد التأسيس الإلكتروني خلال 24 ساعة، مع إصدار الرقم الضريبي فورياً.
        </div>
      </div>

      <div class="faq-accordion-item">
        <button class="faq-question-btn" onclick="toggleFaq(this)">
          <span>هل يمكن لمواطن سعودي أو خليجي تأسيس شركة أمريكية في ديلاوير بدون السفر إلى الولايات المتحدة؟</span>
          <span style="font-size:1.2rem;">▾</span>
        </button>
        <div class="faq-answer-body">
          نعم بالكامل. نوادر توفر منظومة تأسيس رقمية عن بعد تشمل تعيين وكيل قانوني معتمد (Registered Agent)، وتوثيق المستندات، واستخراج الرقم الضريبي الفيدرالي EIN من مصلحة الضرائب الأمريكية (IRS) دون الحاجة للسفر أو اشتراط رقم ضمان اجتماعي أمريكي (SSN).
        </div>
      </div>

      <div class="faq-accordion-item">
        <button class="faq-question-btn" onclick="toggleFaq(this)">
          <span>كيف يتم ضمان حقوق رؤوس الأموال في صفقات الممر الاستثماري المشترك؟</span>
          <span style="font-size:1.2rem;">▾</span>
        </button>
        <div class="faq-answer-body">
          تدار كافة التدفقات المالية من خلال حسابات ضمان مصرفي سيادي (Escrow) خاضعة لإشراف مؤسسي، مع عقود استثمارية موحدة متوافقة مع لوائح هيئة السوق المالية السعودية (CMA) وقواعد هيئة الأوراق المالية الأمريكية (SEC Reg D / Reg S)، مع اختصاص قضائي وتحكيمي معتمد لدى المركز السعودي للتحكيم التجاري (SCCA) في الرياض.
        </div>
      </div>

      <div class="faq-accordion-item">
        <button class="faq-question-btn" onclick="toggleFaq(this)">
          <span>ما هي متطلبات الامتثال للمرحلة الثانية من الفوترة الإلكترونية (زاتكا)؟</span>
          <span style="font-size:1.2rem;">▾</span>
        </button>
        <div class="faq-answer-body">
          تتطلب المرحلة الثانية الربط البرمجي عبر API مع منصة "فاتورة" لإرسال الفواتير الضريبية بصيغة XML مشفرة مع ختم رقمي Cryptographic Stamp ورمز استجابة سريع QR Code مشفر. منصة نوادر تقدم هذا الربط بصورة مدمجة وتلقائية لكافة عملائها.
        </div>
      </div>
    </div>

    <!-- 24/7 Sovereign Support Banner -->
    <div style="background:rgba(15,23,40,0.85);border:1px solid rgba(212,168,67,0.3);border-radius:24px;padding:2.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
      <div>
        <h3 style="font-size:1.3rem;font-weight:800;color:#fff;margin-bottom:0.35rem;">هل تحتاج إلى مساعدة متخصصة من مستشار نظامي؟</h3>
        <p style="font-size:0.85rem;color:var(--text-secondary);margin:0;">فريق الاستجابة السيادي متاح على مدار الساعة للإجابة على استفساراتكم الاستراتيجية.</p>
      </div>
      <div style="display:flex;gap:0.75rem;">
        <a href="{{ route('contact') }}" class="nw-btn nw-btn-primary">
          <span>تواصل مع الدعم السيادي</span>
          <span>←</span>
        </a>
      </div>
    </div>

  </div>
</div>

<script>
function toggleFaq(btn) {
  const item = btn.parentElement;
  item.classList.toggle('active');
}
</script>
@endsection
