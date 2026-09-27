@extends('layouts.app')

@section('title', 'سياسة الاسترداد وإلغاء العمليات — نوادر')
@section('page_title', 'سياسة الاسترداد والضمان السيادي')

@push('head')
<style>
.nw-refund-page { padding: 120px 0 90px; position: relative; }
.refund-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.refund-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(35px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 28px; padding: 3rem;
  box-shadow: 0 35px 90px rgba(0,0,0,0.6); line-height: 1.8; color: var(--text-secondary);
}
.refund-card h2 {
  color: #fff; font-size: 1.35rem; font-weight: 800; margin: 2.25rem 0 1rem;
  padding-bottom: 0.5rem; border-bottom: 1px solid rgba(255,255,255,0.08);
}
.refund-badge-banner {
  background: linear-gradient(135deg, rgba(0,212,200,0.12) 0%, rgba(212,168,67,0.1) 100%);
  border: 1px solid rgba(0,212,200,0.3); border-radius: 20px; padding: 1.5rem 2rem;
  margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.25rem;
}
.escrow-step-grid {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin: 1.75rem 0;
}
.escrow-step-item {
  background: rgba(255,255,255,0.025); border: 1px solid rgba(255,255,255,0.06);
  border-radius: 16px; padding: 1.25rem;
}
</style>
@endpush

@section('content')
<div class="nw-refund-page">
  <div class="refund-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(0,212,200,0.12) 0%,transparent 70%);"></div>
  <div class="refund-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(212,168,67,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;max-width:960px;">
    
    <!-- Header -->
    <div style="text-align:center;margin-bottom:3rem;">
      <div class="nw-section-eyebrow" style="justify-content:center;margin-bottom:0.75rem;">
        <span>🛡️</span>
        <span>الضمان المالي وحماية حقوق العملاء</span>
      </div>
      <h1 style="font-size:2.5rem;font-weight:900;color:#fff;margin-bottom:1rem;">
        سياسة الاسترداد وإلغاء العمليات والضمان السيادي
      </h1>
      <p style="font-size:1rem;color:var(--text-muted);max-width:720px;margin:0 auto;">
        ضمان مالي شامل يحمي مدفوعاتك واستثماراتك وفق ضوابط وزارة التجارة، والبنك المركزي السعودي (SAMA)، ومبادئ حسابات الضمان المصرفي السيادي (Escrow).
      </p>
    </div>

    <!-- Escrow Protection Banner -->
    <div class="refund-badge-banner">
      <div style="display:flex;align-items:center;gap:1.25rem;">
        <div style="width:56px;height:56px;border-radius:18px;background:rgba(0,212,200,0.15);border:1px solid rgba(0,212,200,0.4);display:flex;align-items:center;justify-content:center;font-size:1.8rem;">
          🔒
        </div>
        <div>
          <div style="font-weight:800;color:#fff;font-size:1.1rem;">ضمان استرداد 100% في حال عدم صدور التراخيص أو عدم اكتمال المعاملة</div>
          <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.2rem;">
            أموال أتعاب الخدمات تظل محجوزة في حساب الضمان السيادي ولا يتم تحريرها للمنصة إلا بعد تسليم المخرجات الرسمية المعتمدة.
          </div>
        </div>
      </div>
      <span style="background:rgba(212,168,67,0.15);color:var(--nawader-gold);border:1px solid rgba(212,168,67,0.3);padding:4px 14px;border-radius:20px;font-size:0.75rem;font-weight:800;">
        Escrow Protected
      </span>
    </div>

    <!-- Main Content -->
    <div class="refund-card">
      
      <h2>01. المبادئ العامة لسياسة الاسترداد</h2>
      <p>
        حرصاً على تقديم أعلى درجات الشفافية والاحترافية لشركائنا وعملائنا، تعتمد "نوادر" سياسة مالية محكمة تفصل بدقة متناهية بين:
      </p>
      <ul style="padding-right:1.25rem;">
        <li><strong>أتعاب المنصة والاستشارات:</strong> مستردة بالكامل بنسبة 100% في حال عدم قدرة المنصة على إنجاز الخدمة وفق اتفاقية مستوى الخدمة (SLA).</li>
        <li><strong>الرسوم الحكومية والوزارية المدفوعة:</strong> تخضع لسياسات الاسترداد المعتمدة لدى الوزارة المعنية (مثل وزارة التجارة، هيئة الزكاة، مصلحة الضرائب الأمريكية IRS، أو ولاية ديلاوير) بعد سدادها الفعلي.</li>
      </ul>

      <h2>02. آلية حماية الضمان السيادي (Sovereign Escrow Protocol)</h2>
      <div class="escrow-step-grid">
        <div class="escrow-step-item">
          <div style="font-weight:800;color:var(--nawader-gold);font-size:0.9rem;margin-bottom:0.3rem;">01. الإيداع والحجز</div>
          <p style="font-size:0.82rem;color:var(--text-muted);margin:0;">يودع العميل قيمة الخدمة بأمان عبر (مدى، سداد، Apple Pay، أو Stripe) ويتم حجزها في حساب الضمان.</p>
        </div>
        <div class="escrow-step-item">
          <div style="font-weight:800;color:var(--nawader-teal);font-size:0.9rem;margin-bottom:0.3rem;">02. التنفيذ الحكومي</div>
          <p style="font-size:0.82rem;color:var(--text-muted);margin:0;">يقوم فريق المستشارين ومحركات الذكاء الاصطناعي بربط الطلب بالوزارات المختصة وإتمام الإجراءات.</p>
        </div>
        <div class="escrow-step-item">
          <div style="font-weight:800;color:#fff;font-size:0.9rem;margin-bottom:0.3rem;">03. التسليم والتحرير</div>
          <p style="font-size:0.82rem;color:var(--text-muted);margin:0;">يتم تحرير الأتعاب فقط بعد صدور السجل أو الترخيص المعتمد وإتاحته في خزينة المستندات الرقمية للعميل.</p>
        </div>
      </div>

      <h2>03. الحالات المستحقة للاسترداد الفوري</h2>
      <ul style="padding-right:1.25rem;margin-bottom:1.5rem;">
        <li><strong>إلغاء الطلب قبل بدء التنفيذ:</strong> يحق للعميل إلغاء الطلب واسترداد كامل المبلغ بنسبة 100% إذا تم الإلغاء قبل بدء مراجعة المستندات أو تقديمها لدى الوزارات.</li>
        <li><strong>رفض الطلب لسبب يعود للمنصة:</strong> في حال تعذر إنجاز المعاملة نتيجة خطأ إجرائي غير قابل للتصحيح صادر عن المنصة، يسترد العميل كافة الأتعاب فورياً.</li>
        <li><strong>تجاوز المدة الزمنية المحددة (SLA):</strong> يحق للعميل طلب الاسترداد إذا تأخر إنجاز الطلب عن المدة المتفق عليها في العقد دون مبرر نظامي خارج عن الإرادة.</li>
      </ul>

      <h2>04. المدد الزمنية وقنوات استرجاع الأموال</h2>
      <p>
        تتم معالجة طلبات الاسترداد المعتمدة عبر نفس وسيلة الدفع الأصلية وفق الآتي:
      </p>
      <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:1.25rem;font-size:0.86rem;">
        <div style="display:flex;justify-content:space-between;padding:0.4rem 0;border-bottom:1px solid rgba(255,255,255,0.06);">
          <span>المحفظة الرقمية الداخلية (رصيد نوادر):</span>
          <strong style="color:var(--nawader-teal);">استرداد فوري (خلال دقائق)</strong>
        </div>
        <div style="display:flex;justify-content:space-between;padding:0.4rem 0;border-bottom:1px solid rgba(255,255,255,0.06);">
          <span>بطاقات مدى وApple Pay السعودية:</span>
          <strong style="color:#fff;">من 1 إلى 3 أيام عمل مصرفية</strong>
        </div>
        <div style="display:flex;justify-content:space-between;padding:0.4rem 0;border-bottom:1px solid rgba(255,255,255,0.06);">
          <span>البطاقات الائتمانية الدولية (Visa / Mastercard / Stripe):</span>
          <strong style="color:#fff;">من 3 إلى 7 أيام عمل مصرفية</strong>
        </div>
        <div style="display:flex;justify-content:space-between;padding:0.4rem 0;">
          <span>دفعات تمارا وتابي (BNPL):</span>
          <strong style="color:var(--nawader-gold);">إلغاء فوري للأقساط وإعادة المبالغ المسددة</strong>
        </div>
      </div>

      <h2>05. تقديم طلب الاسترداد والشكاوى</h2>
      <p>
        يمكنك تقديم طلب استرداد مالي مباشرة من خلال لوحة التحكم الخاصة بك عبر قسم "المدفوعات والمحفظة" أو بالتواصل المباشر مع فريق الخزينة السيادية عبر:
      </p>
      <div style="background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:1.25rem;font-size:0.86rem;">
        <div><strong>مكتب الخزينة وتسوية المعاملات السيادية</strong></div>
        <div style="color:var(--text-muted);margin-top:0.25rem;">البريد الإلكتروني المعتمد: finance@nawadersrv.com</div>
        <div style="color:var(--text-muted);">الهاتف المجاني الموحد: 800-123-4567</div>
      </div>

    </div>

  </div>
</div>
@endsection
