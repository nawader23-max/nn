@extends('layouts.app')

@section('title', 'إشعار حماية البيانات الشخصية PDPL — نوادر')
@section('page_title', 'إشعار موافقة حماية البيانات الشخصية')

@push('head')
<style>
.nw-pdpl-page { padding: 120px 0 90px; }
.nw-pdpl-card { background: rgba(15,23,40,.85); backdrop-filter: blur(35px); border: 1px solid rgba(212,168,67,.25); border-radius: 26px; padding: clamp(1.6rem,4vw,3rem); line-height: 1.9; color: var(--text-secondary); }
.nw-pdpl-card h2 { color: var(--nawader-gold-light); font-size: 1.1rem; margin: 1.6rem 0 .6rem; }
.nw-pdpl-card ul { padding-right: 1.2rem; }
.nw-pdpl-card li { margin-bottom: .45rem; }
.nw-pdpl-ver { display: inline-block; background: rgba(0,212,200,.12); border: 1px solid rgba(0,212,200,.35); color: var(--nawader-teal); border-radius: 999px; padding: .3rem 1rem; font-size: .8rem; font-weight: 700; }
.nw-pdpl-note { background: rgba(212,168,67,.08); border: 1px solid rgba(212,168,67,.25); border-radius: 14px; padding: 1.1rem 1.3rem; font-size: .85rem; margin-top: 1.6rem; }
</style>
@endpush

@section('content')
<main class="nw-container nw-pdpl-page" style="max-width:900px">
  <div class="nw-section-eyebrow">الامتثال النظامي</div>
  <h1 class="nw-h1" style="margin:.5rem 0 1rem">لائحة حماية البيانات الشخصية — PDPL</h1>
  <span class="nw-pdpl-ver">إصدار السياسة: 1.0 — سارية</span>

  <div class="nw-pdpl-card" style="margin-top:1.4rem">
    <p>تلتزم شركة نوادر للخدمات السيادية بمعالجة بياناتك الشخصية وفق لائحة حماية البيانات الشخصية السعودية
      ولائحتها التنفيذية. توضح هذه الصفحة طبيعة البيانات، أغراض المعالجة، وحقوقك النظامية كاملةً.</p>

    <h2>1) البيانات التي نجمعها عند تقديم الطلب</h2>
    <ul>
      <li>بيانات الهوية والتواصل: الاسم، البريد الإلكتروني، رقم الجوال، وعنوان IP المتصل.</li>
      <li>المستندات التي ترفعها طوعاً (هوية، سجل تجاري، رخص) لتفعيل الخدمات الحكومية والتجارية.</li>
      <li>بيانات الجلسة الفنية: نوع المتصفح والطابع الزمني لكل إجراء موافقة أو توقيع إلكتروني.</li>
    </ul>

    <h2>2) أغراض المعالجة</h2>
    <ul>
      <li>تنفيذ عقد الخدمة السيادي وإدارة مساره المالي عبر الضمان السيادي (Escrow).</li>
      <li>إصدار العقود والفواتير الضريبية المتوافقة مع هيئة ZATCA (المرحلة الثانية).</li>
      <li>التحقق من الهوية عبر رمز واتساب العكسي (Reverse OTP) وحفظ سجلات التوقيع الإلكتروني.</li>
      <li>تحسين تجربة العميل وبرامج الولاء والاستحقاقات.</li>
    </ul>

    <h2>3) الأرشيم القياسي للموافقة</h2>
    <p>عند كل موافقة تسجّل المنصة سجلاً غير قابل للتعديل يتضمن: بصمة SHA-256 مشفرة تجمع (معرّفك + الغرض + إصدار
      السياسة + عنوان IP + متصفحك + الطابع الزمني UTC+3). هذا السجل هو حجة إثبات قانونية أمام الجهات المختصة.</p>

    <h2>4) حقوقك</h2>
    <ul>
      <li>الوصول إلى بياناتك ونسخ منها، وتصحيحها، ونسيانها عند زوال الغرض النظامي.</li>
      <li>سحب الموافقة مستقبلاً دون التأثير على مشروعية المعالجة السابقة.</li>
      <li>التقدم بشكوى للجهة المختصة (الهيئة السعودية للبيانات والذكاء الاصطناعي — سدايا).</li>
    </ul>

    <h2>5) الاحتفاظ والحماية</h2>
    <p>تُخزَّن المستندات بتشفير AES-256 في بيئة المملكة، ولا تُشارك البيانات مع الغير إلا لجهة نظامية مختصة
      أو لإتمام خدمتك (البنوك، الجهات الحكومية المزوّدة للخدمة)، وتُتلف عند انتهاء الغرض وفق الجدول الزمني المعتمد.</p>

    <div class="nw-pdpl-note">
      ⚖️ بالمتابعة في تقديم طلبك فإنك تمنح موافقتك الصريحة واللافتة هذه على المعالجة المبيّنة أعلاه،
      ويُحفظ إثبات موافقتك في سجل PDPL الخاص بحسابك ويمكنك مراجعته عبر مركز الدعم.
    </div>
  </div>
</main>
@endsection
