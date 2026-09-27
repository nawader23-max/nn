@extends('layouts.app')

@php
  $slug = $slug ?? 'saudi-misa-license';
  $titles = [
    'saudi-misa-license' => [
      'title' => 'الدليل الشامل لإصدار ترخيص الاستثمار الأجنبي (MISA) وتأسيس الشركات 2026',
      'category' => '🇸🇦 وزارة الاستثمار (MISA)',
      'time' => '8 دقائق قراءة',
      'updated' => '2026-03-15',
      'entity' => 'وزارة الاستثمار السعودية + وزارة التجارة',
      'fee' => '2,000 ريال (رخصة سنوية) + رسوم السجل التجاري'
    ],
    'us-delaware-c-corp' => [
      'title' => 'دليل تأسيس شركة Delaware C-Corp للمستثمرين الدوليين وحسابات البنوك',
      'category' => '🇺🇸 ولاية ديلاوير & IRS',
      'time' => '10 دقائق قراءة',
      'updated' => '2026-03-10',
      'entity' => 'Delaware Division of Corporations + US IRS',
      'fee' => '$300 رسوم ولاية + وكيل معتمد'
    ],
    'zatca-phase-2' => [
      'title' => 'متطلبات الربط والتكامل مع منصة فاتورة (ZATCA Phase 2) للشركات والمنشآت',
      'category' => '🇸🇦 هيئة الزكاة والضريبة والجمارك',
      'time' => '6 دقائق قراءة',
      'updated' => '2026-03-01',
      'entity' => 'هيئة الزكاة والضريبة والجمارك (ZATCA)',
      'fee' => 'مشمول ضمن حزمة الربط التقني بنوادر'
    ],
    'bilateral-banking' => [
      'title' => 'بروتوكول فتح الحسابات البنكية الثنائية وخزائن الضمان السيادي (KSA & USA)',
      'category' => '🏦 البنوك المركزية (SAMA & US Fed)',
      'time' => '7 دقائق قراءة',
      'updated' => '2026-02-28',
      'entity' => 'البنك المركزي السعودي SAMA + JP Morgan Chase',
      'fee' => 'حسب نوع الحساب وحجم الإيداع'
    ]
  ];
  $info = $titles[$slug] ?? [
    'title' => 'الدليل الإجرائي والتشريعي السيادي — ' . str_replace('-', ' ', $slug),
    'category' => '📜 الأدلة والأنظمة السيادية',
    'time' => '7 دقائق قراءة',
    'updated' => '2026-03-18',
    'entity' => 'الهيئات والوزارات السيادية المعتمدة',
    'fee' => 'حسب اللائحة التنفيذية'
  ];
@endphp

@section('title', $info['title'] . ' — نوادر')
@section('page_title', $info['title'])

@push('head')
<style>
.nw-article-page { padding: 120px 0 90px; position: relative; }
.art-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.article-body-panel {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(35px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 28px; padding: 2.75rem;
  box-shadow: 0 30px 80px rgba(0,0,0,0.55); line-height: 1.8; color: var(--text-secondary);
}
.article-body-panel h2 { color: #fff; font-size: 1.4rem; font-weight: 800; margin: 2rem 0 1rem; }
.article-body-panel h3 { color: var(--nawader-gold); font-size: 1.15rem; font-weight: 800; margin: 1.5rem 0 0.75rem; }
.article-step-box {
  background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px; padding: 1.25rem 1.5rem; margin-bottom: 1.25rem;
}
.article-sidebar-box {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(212,168,67,0.25); border-radius: 24px; padding: 2rem;
  box-shadow: 0 20px 50px rgba(0,0,0,0.5); position: sticky; top: 110px;
}
</style>
@endpush

@section('content')
<div class="nw-article-page">
  <div class="art-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="art-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Breadcrumb -->
    <div style="display:flex;align-items:center;gap:0.6rem;font-size:0.82rem;color:var(--text-muted);margin-bottom:1.5rem;">
      <a href="{{ route('home') }}" style="color:var(--text-muted);text-decoration:none;">الرئيسية</a>
      <span>/</span>
      <a href="{{ route('help') }}" style="color:var(--text-muted);text-decoration:none;">مركز المعرفة</a>
      <span>/</span>
      <span style="color:var(--nawader-gold);">{{ $info['category'] }}</span>
    </div>

    <!-- Article Header -->
    <div style="margin-bottom:2.5rem;max-width:900px;">
      <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;flex-wrap:wrap;">
        <span style="background:rgba(0,212,200,0.12);color:var(--nawader-teal);border:1px solid rgba(0,212,200,0.3);padding:3px 12px;border-radius:20px;font-size:0.78rem;font-weight:700;">
          {{ $info['category'] }}
        </span>
        <span style="font-size:0.78rem;color:var(--text-muted);">⏱️ {{ $info['time'] }}</span>
        <span style="font-size:0.78rem;color:var(--text-muted);">📅 آخر تحديث تشريعي: {{ $info['updated'] }}</span>
      </div>

      <h1 style="font-size:2.25rem;font-weight:900;color:#fff;line-height:1.3;margin-bottom:1rem;">
        {{ $info['title'] }}
      </h1>
      <p style="font-size:1.05rem;color:var(--text-secondary);line-height:1.7;">
        دليل تنفيذي موثق بالأنظمة واللوائح الرسمية صادر عن المجلس الاستشاري لمنصة نوادر لتيسير إجراءات الأعمال والمستثمرين.
      </p>
    </div>

    <!-- Article Main Layout -->
    <div style="display:grid;grid-template-columns:1fr 340px;gap:2.5rem;" class="nw-article-grid">
      
      <!-- Content Body -->
      <div class="article-body-panel">
        
        <h2>01. الأهمية الاستراتيجية والإطار النظامي</h2>
        <p>
          يعد هذا المسار أحد أهم الركائز في جذب وتدفق الاستثمارات النوعية بين المملكة العربية السعودية والأسواق الدولية، حيث يتيح للكيانات الاستثمارية والشركات متعددة الجنسيات التملك بنسبة 100% دون اشتراط شريك محلي، والاستفادة الكاملة من الحوافز الضريبية واللوجستية في المناطق الاقتصادية الخاصة ومشاريع رؤية المملكة 2030.
        </p>

        <h2>02. الاشتراطات والمستندات المطلوبة</h2>
        <div class="article-step-box">
          <ul style="margin:0;padding-right:1.25rem;display:flex;flex-direction:column;gap:0.6rem;font-size:0.88rem;">
            <li><strong>السجل التجاري أو عقد التأسيس:</strong> للشركة الأم موثقاً من السفارة السعودية أو مصدقاً بنظام أبوستيل (Apostille).</li>
            <li><strong>القوائم المالية المدققة:</strong> لآخر سنة مالية توضح الملاءة المالية وحجم رأس المال.</li>
            <li><strong>خطة العمل الاستراتيجية (Business Plan):</strong> توضح الأثر التنموي، وحجم الاستثمار المباشر، وفرص العمل المستهدفة.</li>
            <li><strong>تفويض وكيل نظامي:</strong> وكالة شرعية أو تفويض رسمي إلكتروني عبر منصة نوادر.</li>
          </ul>
        </div>

        <h2>03. خطوات التنفيذ عبر منصة نوادر (SLA خلال 24 ساعة)</h2>
        
        <div class="article-step-box">
          <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <span style="width:28px;height:28px;border-radius:8px;background:var(--grad-gold);color:var(--nawader-navy);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:0.85rem;">1</span>
            <strong style="color:#fff;font-size:0.95rem;">الفحص الرقمي والتحقق من المستندات بالذكاء الاصطناعي</strong>
          </div>
          <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">
            يقوم نظام نوادر السيادي بفحص وتدقيق كافة الأوراق ومطابقتها مع اشتراطات وزارة الاستثمار لتجنب أي رفض إجرائي.
          </p>
        </div>

        <div class="article-step-box">
          <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <span style="width:28px;height:28px;border-radius:8px;background:var(--grad-gold);color:var(--nawader-navy);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:0.85rem;">2</span>
            <strong style="color:#fff;font-size:0.95rem;">إصدار الترخيص الاستثماري المبدئي والنهائي</strong>
          </div>
          <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">
            تقديم الطلب عبر المسار الوزاري السريع المخصص لشركاء نوادر، واستلام رخصة MISA المعتمدة رقمياً خلال ساعات.
          </p>
        </div>

        <div class="article-step-box">
          <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.5rem;">
            <span style="width:28px;height:28px;border-radius:8px;background:var(--grad-gold);color:var(--nawader-navy);display:flex;align-items:center;justify-content:center;font-weight:900;font-size:0.85rem;">3</span>
            <strong style="color:#fff;font-size:0.95rem;">إصدار السجل التجاري وفتح الملفات الحكومية الموحدة</strong>
          </div>
          <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">
            إصدار السجل التجاري من وزارة التجارة، وتفعيل ملفات (الزكاة والضريبة ZATCA، التأمينات الاجتماعية GOSI، وزارة الموارد البشرية، والغرفة التجارية) تلقائياً.
          </p>
        </div>

        <h2>04. الرسوم الحكومية والتكاليف النظامية</h2>
        <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.25rem;font-size:0.88rem;">
          <div style="display:flex;justify-content:space-between;padding:0.5rem 0;border-bottom:1px solid rgba(255,255,255,0.06);">
            <span>الجهة الحكومية المختصة:</span>
            <strong style="color:#fff;">{{ $info['entity'] }}</strong>
          </div>
          <div style="display:flex;justify-content:space-between;padding:0.5rem 0;">
            <span>الرسوم التقديرية المقررة:</span>
            <strong style="color:var(--nawader-gold);font-family:var(--font-latin);">{{ $info['fee'] }}</strong>
          </div>
        </div>

        <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
          <div>
            <div style="color:#fff;font-weight:700;">هل تود البدء في تنفيذ هذا الإجراء فورياً؟</div>
            <div style="font-size:0.8rem;color:var(--text-muted);">يقوم مستشارو نوادر بإتمام المعاملة نيابة عنك بأعلى معايير الدقة والسرعة.</div>
          </div>
          <a href="{{ route('dashboard.requests.create') }}" class="nw-btn nw-btn-primary">
            <span>ابدأ تقديم الطلب الآن</span>
            <span>←</span>
          </a>
        </div>

      </div>

      <!-- Article Sidebar -->
      <div>
        <div class="article-sidebar-box">
          <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin-bottom:1.25rem;">ملخص الإجراء السيادي</h3>

          <div style="display:flex;flex-direction:column;gap:1rem;font-size:0.84rem;margin-bottom:1.75rem;">
            <div>
              <span style="color:var(--text-muted);display:block;margin-bottom:0.2rem;">زمن الإنجاز القياسي:</span>
              <strong style="color:var(--nawader-teal);">من 24 إلى 48 ساعة عمل</strong>
            </div>
            <div>
              <span style="color:var(--text-muted);display:block;margin-bottom:0.2rem;">طريقة التقديم:</span>
              <strong style="color:#fff;">رقمي 100% بدون حضور شخصي</strong>
            </div>
            <div>
              <span style="color:var(--text-muted);display:block;margin-bottom:0.2rem;">الاعتماد الدولي:</span>
              <strong style="color:var(--nawader-gold);">شهادات موثقة بنظام أبوستيل</strong>
            </div>
          </div>

          <button class="nw-btn nw-btn-ghost" style="width:100%;justify-content:center;margin-bottom:0.75rem;font-size:0.82rem;" onclick="alert('جاري تنزيل نسخة الدليل المعتمدة بصيغة PDF...')">
            <span>📄</span>
            <span>تحميل الدليل بصيغة PDF</span>
          </button>

          <a href="{{ route('contact') }}" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;font-size:0.82rem;">
            <span>استشارة مستشار نوادر</span>
          </a>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection
