@extends('layouts.app')

@section('title', 'سياسة الخصوصية وحماية البيانات السيادية — نوادر')
@section('page_title', 'ميثاق الخصوصية والسيادة الرقمية')

@push('head')
<style>
.nw-legal-page { padding: 120px 0 90px; position: relative; }
.legal-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.legal-content-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(35px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 28px; padding: 3rem;
  box-shadow: 0 35px 90px rgba(0,0,0,0.6); line-height: 1.8; color: var(--text-secondary);
}
.legal-content-card h2 {
  color: #fff; font-size: 1.35rem; font-weight: 800; margin: 2.25rem 0 1rem;
  padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.08);
}
.legal-content-card h3 {
  color: var(--nawader-gold); font-size: 1.1rem; font-weight: 700; margin: 1.25rem 0 0.5rem;
}
.legal-banner-badge {
  background: linear-gradient(135deg, rgba(0,212,200,0.12) 0%, rgba(212,168,67,0.1) 100%);
  border: 1px solid rgba(0,212,200,0.3); border-radius: 18px; padding: 1.5rem 2rem;
  margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
</style>
@endpush

@section('content')
<div class="nw-legal-page">
  <div class="legal-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(0,212,200,0.12) 0%,transparent 70%);"></div>
  <div class="legal-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(212,168,67,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;max-width:960px;">
    
    <!-- Header -->
    <div style="text-align:center;margin-bottom:3rem;">
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.75rem;">
        <span>🛡️</span>
        <span>الامتثال للأنظمة السيادية السعودية والدولية</span>
      </div>
      <h1 style="font-size:2.5rem;font-weight:900;color:#fff;margin-bottom:1rem;">
        سياسة الخصوصية وميثاق حماية البيانات السيادية
      </h1>
      <p style="font-size:1rem;color:var(--text-muted);max-width:700px;margin:0 auto;">
        تلتزم منصة نوادر التزاماً صارماً بنظام حماية البيانات الشخصية السعودي (PDPL) والضوابط الصادرة عن الهيئة الوطنية للأمن السيبراني (NCA) والهيئة السعودية للبيانات والذكاء الاصطناعي (SDAIA).
      </p>
    </div>

    <!-- Compliance Banner -->
    <div class="legal-banner-badge">
      <div style="display:flex;align-items:center;gap:1.25rem;">
        <span style="font-size:2rem;">🇸🇦</span>
        <div>
          <div style="font-weight:800;color:#fff;font-size:1.05rem;">توطين البيانات السيادية بالكامل داخل المملكة العربية السعودية</div>
          <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.2rem;">
            مراكز بيانات Tier IV مشفرة ومصنفة سيادياً في الرياض وجدة مع مطابقة معايير US FedRAMP للممر الثنائي.
          </div>
        </div>
      </div>
      <span style="background:rgba(0,212,200,0.15);color:var(--nawader-teal);border:1px solid rgba(0,212,200,0.3);padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:800;">
        معتمد من SDAIA & NCA
      </span>
    </div>

    <!-- Main Legal Document Body -->
    <div class="legal-content-card">
      
      <h2>01. النطاق والمبادئ الحاكمة</h2>
      <p>
        تسري هذه السياسة على كافة البيانات والمعلومات والمستندات المؤسسية والمالية التي يتم جمعها أو معالجتها أو تبادلها عبر بوابة "نوادر" الإلكترونية وتطبيقاتها وخدمات الربط البرمجي (APIs)، سواء من جانب الأفراد أو المنشآت والجهات الحكومية أو الشركات الدولية المستثمرة في الممر المشترك (المملكة العربية السعودية والولايات المتحدة الأمريكية).
      </p>

      <h2>02. البيانات التي يتم جمعها والغرض النظامي من معالجتها</h2>
      <p>
        تجمع منصة نوادر فقط الحد الأدنى اللازم من البيانات لتحقيق الأغراض المشروعة وفق الأنظمة السارية، بما يشمل:
      </p>
      <ul style="padding-right:1.25rem;margin-bottom:1.5rem;">
        <li><strong>بيانات الهوية الرقمية:</strong> الاسم الرباعي، رقم الهوية الوطنية أو الإقامة، رقم الجواز الدبلوماسي/التجاري، ومعرفات المصادقة عبر نفاذ الوطني أو معرفات الكيانات الأمريكية (US EIN).</li>
        <li><strong>بيانات السجل التجاري والمؤسسي:</strong> أرقام السجلات التجارية (CR)، التراخيص الاستثمارية (MISA)، ملفات ولاية ديلاوير، والأرقام الضريبية (ZATCA VAT).</li>
        <li><strong>البيانات المالية والخزينة:</strong> أرقام الآيبان البنكي، قيود الإيداعات والضمان السيادي (Escrow)، وتفاصيل تسوية الفواتير الضريبية.</li>
        <li><strong>البيانات التقنية والأمنية:</strong> عناوين IP، بصمات الأجهزة، سجلات التوقيع الرقمي، وسجلات التدقيق الجنائي للعمليات.</li>
      </ul>

      <h2>03. التشفير والحصانة السيادية للبيانات</h2>
      <p>
        تطبق منصة نوادر أعلى معايير التشفير العسكري والمصرفي:
      </p>
      <ul style="padding-right:1.25rem;margin-bottom:1.5rem;">
        <li>تشفير البيانات أثناء النقل عبر بروتوكول TLS 1.3 مع شهادات تشفير سيادية خاضعة لإدارة مفاتيح الأمان في خوادم HSM فيزيائية مستقلة.</li>
        <li>تشفير البيانات أثناء التخزين (Data at Rest) باستخدام خوارزميات AES-256 GCM المعتمدة دولياً.</li>
        <li>العزل التام لقواعد البيانات متعددة المستأجرين (Multi-Tenant Isolation) بحيث لا يمكن لأي طرف الاطلاع على مستندات أو طلبات الشركاء الآخرين.</li>
      </ul>

      <h2>04. حقوق أصحاب البيانات والشركات</h2>
      <p>
        بموجب نظام حماية البيانات الشخصية السعودي (PDPL)، يتمتع أصحاب الحسابات بالحقوق التالية:
      </p>
      <ul style="padding-right:1.25rem;margin-bottom:1.5rem;">
        <li><strong>حق العلم والإحاطة:</strong> معرفة الأساس النظامي لجمع البيانات وكيفية استخدامها.</li>
        <li><strong>حق الوصول والاستخراج:</strong> تصدير نسخة رقمية من كافة البيانات والمستندات المسجلة بصيغ قياسية فورياً.</li>
        <li><strong>حق التصحيح والتحديث:</strong> تعديل أي بيانات غير مكتملة أو غير دقيقة عبر لوحة التحكم.</li>
        <li><strong>حق الإتلاف ومحو البيانات:</strong> طلب إتلاف البيانات عند انتهاء الغرض النظامي منها، ما لم تكن هناك متطلبات نظامية ملزمة بحفظها لدى الجهات الحكومية أو الضريبية.</li>
      </ul>

      <h2>05. مسؤول حماية البيانات والاتصال الرقابي</h2>
      <p>
        تم تعيين مسؤول مستقل لحماية البيانات (Data Protection Officer - DPO) لمراقبة الامتثال والرد على أي طلبات أو شكاوى تتعلق بالخصوصية:
      </p>
      <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:1.25rem;font-size:0.88rem;">
        <div><strong>مكتب الامتثال وحماية البيانات السيادية — نوادر</strong></div>
        <div style="color:var(--text-muted);margin-top:0.3rem;">البريد المعتمد: dpo@nawadersrv.com</div>
        <div style="color:var(--text-muted);">العنوان: مركز الملك عبدالله المالي (KAFD)، البرج السيادي 4، الرياض، المملكة العربية السعودية</div>
      </div>

    </div>

  </div>
</div>
@endsection
