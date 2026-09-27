@extends('layouts.app')

@section('title', 'الشروط والأحكام والاتفاقية السيادية — نوادر')
@section('page_title', 'اتفاقية الاستخدام والخدمات السيادية الموحدة')

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
  background: linear-gradient(135deg, rgba(212,168,67,0.14) 0%, rgba(0,212,200,0.1) 100%);
  border: 1px solid rgba(212,168,67,0.35); border-radius: 18px; padding: 1.5rem 2rem;
  margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
</style>
@endpush

@section('content')
<div class="nw-legal-page">
  <div class="legal-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="legal-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;max-width:960px;">
    
    <!-- Header -->
    <div style="text-align:center;margin-bottom:3rem;">
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.75rem;">
        <span>⚖️</span>
        <span>الإطار التعاقدي السيادي الموحد</span>
      </div>
      <h1 style="font-size:2.5rem;font-weight:900;color:#fff;margin-bottom:1rem;">
        شروط الاستخدام والاتفاقية السيادية الموحدة
      </h1>
      <p style="font-size:1rem;color:var(--text-muted);max-width:720px;margin:0 auto;">
        وثيقة تعاقدية ملزمة تنظم تقديم الخدمات الحكومية واللوجستية والاستثمارية بين منصة نوادر والعملاء والشركاء والمستثمرين في الممر الاستراتيجي الثنائي.
      </p>
    </div>

    <!-- Legal Framework Banner -->
    <div class="legal-banner-badge">
      <div style="display:flex;align-items:center;gap:1.25rem;">
        <span style="font-size:2rem;">📜</span>
        <div>
          <div style="font-weight:800;color:#fff;font-size:1.05rem;">حجية التوقيع والتعاقد الإلكتروني السيادي</div>
          <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.2rem;">
            معتمد وفق نظام التعاملات الإلكترونية السعودي وقانون التوقيع الإلكتروني الأمريكي (US E-SIGN Act).
          </div>
        </div>
      </div>
      <span style="background:rgba(212,168,67,0.15);color:var(--nawader-gold);border:1px solid rgba(212,168,67,0.3);padding:4px 12px;border-radius:20px;font-size:0.75rem;font-weight:800;">
        التحكيم: SCCA بالرياض
      </span>
    </div>

    <!-- Main Legal Text -->
    <div class="legal-content-card">
      
      <h2>01. التمهيد والتعريفات</h2>
      <p>
        تعتبر هذه الشروط والأحكام ("الاتفاقية") عقداً نظامياً ملزماً بين منصة "نوادر" للخدمات السيادية والاستثمارية ("المنصة" أو "المزود") وبين أي شخص طبيعي أو كيان اعتباري أو مؤسسة حكومية ("العميل" أو "المستخدم") يقوم بالتسجيل أو طلب أي من الخدمات أو تفويض المنصة في إنهاء الإجراءات الرسمية.
      </p>

      <h2>02. طبيعة الخدمات والتفويض النظامي</h2>
      <p>
        تقوم منصة نوادر بتقديم منظومة متكاملة من الخدمات الإدارية والتقنية واللوجستية والاستثمارية، وتمثيل العملاء ومتابعة طلباتهم لدى الوزارات والهيئات السعودية (وزارة التجارة، وزارة الاستثمار MISA، الزكاة والضريبة ZATCA، البنك المركزي SAMA، الهيئة السعودية للملكية الفكرية SAIP) والجهات الأمريكية الفيدرالية والمحلية (ولاية ديلاوير، مصلحة الضرائب IRS، مكتب براءات الاختراع USPTO، وهيئة الأوراق المالية SEC).
      </p>
      <p>
        يمنح العميل المنصة ومستشاريها تفويضاً إلكترونياً صريحاً لإعداد ومراجعة وتقديم المستندات والطلبات نيابة عنه ومتابعتها حتى صدور الشهادات أو التراخيص الرسمية.
      </p>

      <h2>03. اتفاقية مستوى الخدمة (SLA) وسرعة الإنجاز</h2>
      <p>
        تلتزم نوادر بتطبيق أسرع معايير التنفيذ في السوق، مع ضمان مطابقة كافة الطلبات للاشتراطات التنظيمية لتفادي أي تأخير. ولا تعتبر المنصة مسؤولة عن أي تأخير خارج عن إرادتها ناتج عن توقف مؤقت لأنظمة الوزارات أو طلب الجهات الحكومية مستندات إضافية أو تدقيقات أمنية خاصة بالعميل.
      </p>

      <h2>04. الأتعاب، الرسوم الحكومية، والضمان السيادي (Escrow)</h2>
      <ul style="padding-right:1.25rem;margin-bottom:1.5rem;">
        <li>تتضمن الفواتير الصادرة عن المنصة تفصيلاً دقيقاً بين "الرسوم الحكومية الرسمية" وبين "أتعاب المنصة والاستشارات".</li>
        <li>تخضع أتعاب الخدمات لضريبة القيمة المضافة (VAT) المقررة نظاماً بنسبة 15%، وتصدر بها فاتورة ضريبية إلكترونية معتمدة من هيئة الزكاة والضريبة والجمارك (ZATCA Phase 2).</li>
        <li>يتم الاحتفاظ بأموال الصفقات والخدمات الكبرى في حسابات ضمان مصرفي سيادي (Escrow)، ولا يتم تحرير الأتعاب إلا بعد تسليم المخرجات أو صدور التراخيص الرسمية المعتمدة.</li>
      </ul>

      <h2>05. السرية وحماية الأسرار التجارية</h2>
      <p>
        تلتزم المنصة بالمحافظة على السرية المطلقة لكافة المعلومات، والخطط الاستثمارية، والبيانات المالية، وبراءات الاختراع التي يطلع عليها فريق العمل، وتعتبرها أسراراً تجارية مصانة بموجب الأنظمة، ولا يحق للمنصة الإفصاح عنها إلا للجهات الحكومية المعنية لغرض إنجاز الخدمة أو بأمر قضائي ملزم.
      </p>

      <h2>06. القانون الواجب التطبيق وتسوية النزاعات</h2>
      <p>
        تخضع هذه الاتفاقية وتفسر وفقاً للأنظمة واللوائح المعمول بها في المملكة العربية السعودية. وفي حال نشوء أي خلاف أو نزاع ينشأ عن تنفيذ هذه الاتفاقية أو يرتبط بها، يتم حله ودياً خلال 15 يوماً، وفي حال تعذر ذلك يحال النزاع إلى التحكيم وفق قواعد <strong>المركز السعودي للتحكيم التجاري (SCCA)</strong> في مدينة الرياض بالمملكة العربية السعودية، وتكون قرارات التحكيم نهائية وملزمة للطرفين.
      </p>

      <h2>07. التعديلات وسريان الاتفاقية</h2>
      <p>
        تحتفظ نوادر بالحق في تحديث هذه الشروط بما يتماشى مع التحديثات التشريعية للوزارات والجهات الرقابية، ويتم إشعار العملاء عبر المنصة أو البريد المعتمد قبل سريان التعديلات بـ 14 يوماً.
      </p>

    </div>

  </div>
</div>
@endsection
