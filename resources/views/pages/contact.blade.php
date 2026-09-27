@extends('layouts.app')

@section('title', 'تواصل معنا — نوادر')
@section('page_title', 'مركز الاتصال والتنسيق الاستراتيجي')
@section('description', 'تواصل مع المستشارين التنفيذيين لمنصة نوادر في الرياض وواشنطن وديلاوير — استجابة فورية واستشارات سيادية واستثمارية.')

@push('head')
<style>
.nw-contact-hero {
  padding: 130px 0 60px; position: relative; overflow: hidden; text-align: center;
}
.contact-orb {
  position: absolute; width: 600px; height: 600px; top: -150px; left: 50%; transform: translateX(-50%);
  background: radial-gradient(circle, rgba(212,168,67,0.1) 0%, transparent 70%);
  filter: blur(80px); pointer-events: none;
}

.nw-contact-layout {
  display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem;
  margin-bottom: 6rem;
}

.nw-contact-form-card {
  background: rgba(15, 23, 40, 0.8); backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 168, 67, 0.2); border-radius: 24px;
  padding: 2.5rem; box-shadow: 0 25px 60px rgba(0,0,0,0.5);
}
.nw-form-row {
  display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;
}
.nw-form-group {
  display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.25rem;
}
.nw-form-label {
  font-size: 0.85rem; font-weight: 700; color: var(--text-secondary);
}
.nw-form-input, .nw-form-select, .nw-form-textarea {
  width: 100%; padding: 0.85rem 1.1rem;
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.09); border-radius: 12px;
  color: #FFFFFF; font-size: 0.92rem; outline: none;
  transition: all 0.25s; direction: rtl;
}
.nw-form-input:focus, .nw-form-select:focus, .nw-form-textarea:focus {
  border-color: rgba(212, 168, 67, 0.5);
  box-shadow: 0 0 0 3px rgba(212, 168, 67, 0.1);
  background: rgba(255, 255, 255, 0.06);
}
.nw-form-textarea { resize: vertical; min-height: 120px; }

.nw-contact-info-col {
  display: flex; flex-direction: column; gap: 1.5rem;
}
.nw-info-channel {
  background: rgba(15, 23, 40, 0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.07); border-radius: 18px;
  padding: 1.5rem; display: flex; align-items: flex-start; gap: 1.25rem;
  transition: all 0.3s;
}
.nw-info-channel:hover {
  border-color: rgba(0, 212, 200, 0.35); transform: translateX(-4px);
}
.channel-icon {
  width: 50px; height: 50px; border-radius: 14px;
  background: rgba(0, 212, 200, 0.1); border: 1px solid rgba(0, 212, 200, 0.25);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.6rem; flex-shrink: 0;
}
.channel-title { font-size: 1rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem; }
.channel-desc  { font-size: 0.8rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.4rem; }
.channel-value { font-size: 0.95rem; font-weight: 700; color: var(--nawader-gold); font-family: var(--font-latin); }

.emergency-triage {
  background: linear-gradient(135deg, rgba(232, 93, 138, 0.12), rgba(123, 92, 228, 0.08));
  border: 1px solid rgba(232, 93, 138, 0.3); border-radius: 18px; padding: 1.75rem;
}
.triage-title { font-size: 1.05rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem; }
.triage-desc { font-size: 0.82rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 1rem; }

@media(max-width:992px){
  .nw-contact-layout { grid-template-columns: 1fr; }
  .nw-form-row { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<section class="nw-contact-hero">
  <div class="contact-orb"></div>
  <div class="nw-container" style="position:relative; z-index:2;">
    <div class="nw-section-eyebrow" data-nw-animate>مركز التنسيق المباشر</div>
    <h1 class="nw-h1" style="margin:1rem 0 1.25rem;" data-nw-animate data-delay="100">
      تواصل مع المستشارين التنفيذيين
    </h1>
    <p class="nw-lead" style="max-width:680px; margin:0 auto;" data-nw-animate data-delay="200">
      استشارات استراتيجية، صفقات استثمارية كبرى، أو استفسارات فورية للوزارات والشركات — فريقنا متاح على مدار الساعة في الرياض والولايات المتحدة.
    </p>
  </div>
</section>

<section>
  <div class="nw-container">
    <div class="nw-contact-layout">

      {{-- Left Side: Interactive Dispatch Form --}}
      <div class="nw-contact-form-card" data-nw-animate data-delay="100">
        <h3 class="nw-h3" style="margin-bottom:0.5rem;">إرسال طلب استشارة أو تنسيق سيادي</h3>
        <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:2rem;">
          سيتم توجيه طلبك فوراً للمستشار القانوني أو الاستثماري المختص بالقطاع المطلوب.
        </p>

        <form action="{{ route('contact.send') }}" method="POST" id="nw-contact-form">
          @csrf
          <div class="nw-form-row">
            <div class="nw-form-group">
              <label class="nw-form-label">الاسم الكريم / ممثل المنشأة *</label>
              <input type="text" name="name" required class="nw-form-input" placeholder="مثال: م. سعود القحطاني">
            </div>
            <div class="nw-form-group">
              <label class="nw-form-label">البريد الإلكتروني المؤسسي *</label>
              <input type="email" name="email" required class="nw-form-input" placeholder="name@company.com">
            </div>
          </div>

          <div class="nw-form-row">
            <div class="nw-form-group">
              <label class="nw-form-label">رقم الهاتف / الواتساب الدولي *</label>
              <input type="tel" name="phone" required class="nw-form-input" placeholder="+966 5X XXX XXXX" dir="ltr">
            </div>
            <div class="nw-form-group">
              <label class="nw-form-label">القطاع الاستراتيجي المعني *</label>
              <select name="category" class="nw-form-select">
                <option value="legal">تأسيس الشركات والكيانات القانونية (01)</option>
                <option value="foreign-investment">الاستثمار الأجنبي المباشر MISA (04)</option>
                <option value="licenses">التراخيص التجارية والتشغيلية (02)</option>
                <option value="ip">الملكية الفكرية وبراءات الاختراع (07)</option>
                <option value="finance">الخدمات المالية والتقنية المصرفية (18)</option>
                <option value="expat">الإقامة المميزة وتأشيرات US (19)</option>
                <option value="consulting">الاستشارات الاستراتيجية الكبرى (20)</option>
                <option value="other">قطاعات أخرى من الـ 20 قطاعاً</option>
              </select>
            </div>
          </div>

          <div class="nw-form-group">
            <label class="nw-form-label">طبيعة الكيان أو التمثيل *</label>
            <select name="entity_type" class="nw-form-select">
              <option value="gov">جهة حكومية أو وزارة أو هيئة سيادية</option>
              <option value="corp">شركة كبرى / مجموعة قابضة متعددة الجنسيات</option>
              <option value="sme">منشأة صغيرة أو متوسطة / شركة ناشئة</option>
              <option value="investor">مستثمر فردي / مكتب عائلي دولي</option>
            </select>
          </div>

          <div class="nw-form-group">
            <label class="nw-form-label">تفاصيل الموضوع أو نطاق المشروع المطلوب *</label>
            <textarea name="message" required class="nw-form-textarea" placeholder="يرجى كتابة موجز عن طلبك أو جدولك الزمني المقترح..."></textarea>
          </div>

          <button type="submit" class="nw-btn nw-btn-primary nw-btn-lg" style="width:100%; margin-top:1rem;">
            إرسال الطلب والتواصل الفوري ←
          </button>
        </form>
      </div>

      {{-- Right Side: Fast Response Channels --}}
      <div class="nw-contact-info-col" data-nw-animate data-delay="200">

        <div class="nw-info-channel">
          <div class="channel-icon">📞</div>
          <div>
            <div class="channel-title">هاتف العمليات السيادية (الرياض)</div>
            <div class="channel-desc">متاح طيلة أيام الأسبوع لمعاملات الوزارات والشركات الكبرى</div>
            <div class="channel-value">+966 11 800 2030</div>
          </div>
        </div>

        <div class="nw-info-channel">
          <div class="channel-icon">🇺🇸</div>
          <div>
            <div class="channel-title">المكتب الاستشاري الأمريكي (Delaware & NY)</div>
            <div class="channel-desc">تأسيس Delaware LLC، تراخيص SEC، وبراءات USPTO</div>
            <div class="channel-value">+1 (302) 555-0199</div>
          </div>
        </div>

        <div class="nw-info-channel">
          <div class="channel-icon">💬</div>
          <div>
            <div class="channel-title">المحادثة الفورية والمستشار المباشر</div>
            <div class="channel-desc">ارتباط فوري بالمستشار القانوني المناوب عبر البوابة المشفرة</div>
            <div class="channel-value">متصل الآن (استجابة خلال 5 دقائق)</div>
          </div>
        </div>

        <div class="emergency-triage">
          <div class="triage-title">🚨 خط الاستجابة العاجلة والنزاعات التجارية</div>
          <p class="triage-desc">
            للمعاملات الطارئة، الحجز التحفظي، الاعتراضات الجمركية السريعة، أو المهل القضائية المحددة:
          </p>
          <a href="tel:+966118002030" class="nw-btn nw-btn-primary nw-btn-sm" style="background:var(--grad-gold); color:var(--nawader-navy);">
            الاتصال بالخط الساخن للطوارئ 24/7
          </a>
        </div>

      </div>

    </div>
  </div>
</section>
@endsection
