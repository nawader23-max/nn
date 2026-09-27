@extends('layouts.app')

@section('title', 'حجز الاستشارات الاستثمارية السيادية — نوادر')
@section('page_title', 'المجلس الاستشاري والاستشارات السيادية')

@push('head')
<style>
.nw-consult-page { padding: 120px 0 90px; position: relative; }
.consult-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.advisor-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 1.75rem;
  transition: all 0.3s; display: flex; align-items: flex-start; gap: 1.25rem;
  margin-bottom: 1.25rem;
}
.advisor-card:hover {
  border-color: rgba(212,168,67,0.35); transform: translateY(-3px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.4);
}
.booking-panel {
  background: rgba(15,23,40,0.88); backdrop-filter: blur(35px);
  border: 1px solid rgba(212,168,67,0.25); border-radius: 28px; padding: 2.5rem;
  box-shadow: 0 35px 90px rgba(0,0,0,0.65), 0 0 35px rgba(212,168,67,0.06);
}
.time-slot-btn {
  padding: 0.6rem 0.9rem; border-radius: 10px; background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.08); color: var(--text-secondary); font-size: 0.8rem;
  font-family: var(--font-latin); cursor: pointer; transition: all 0.2s;
}
.time-slot-btn:hover, .time-slot-btn.active {
  background: rgba(0,212,200,0.15); border-color: var(--nawader-teal); color: var(--nawader-teal); font-weight: 700;
}
</style>
@endpush

@section('content')
<div class="nw-consult-page">
  <div class="consult-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="consult-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Header -->
    <div style="margin-bottom:2.5rem;">
      <div class="nw-section-eyebrow" style="margin-bottom:0.4rem;">المجلس الاستشاري السيادي</div>
      <h1 style="font-size:2rem;font-weight:900;color:#fff;margin-bottom:0.5rem;">حجز جلسات الاستشارة السيادية والاستثمارية</h1>
      <p style="font-size:0.95rem;color:var(--text-secondary);max-width:780px;line-height:1.7;">
        جلسات استراتيجية رفيعة المستوى تجمعك مباشرة مع كبار الشركاء القانونيين، وخبراء الاستثمار المعتمدين في المملكة والولايات المتحدة الأمريكية، لمناقشة هيكلة الصفقات، تدفق رؤوس الأموال، والامتثال للأنظمة.
      </p>
    </div>

    @if(session('success'))
    <div style="background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.4);border-radius:18px;padding:1.25rem 1.75rem;margin-bottom:2.5rem;display:flex;align-items:center;gap:1rem;">
      <span style="font-size:1.8rem;color:var(--nawader-teal);">✓</span>
      <div>
        <h3 style="font-size:1.05rem;font-weight:800;color:#fff;margin:0 0 0.2rem;">{{ session('success') }}</h3>
        <p style="font-size:0.84rem;color:var(--text-secondary);margin:0;">
          تم تسجيل موعد الجلسة الاستشارية وإرسال رابط القاعة المشفر وتفاصيل الحضور إلى بريدك المؤسسي المعتمد.
        </p>
      </div>
    </div>
    @endif

    <!-- 2 Columns: Advisors List & Booking Panel -->
    <div style="display:grid;grid-template-columns:1fr 440px;gap:2.5rem;" class="nw-consult-grid">
      
      <!-- Left: Senior Advisors -->
      <div>
        <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.6rem;">
          <span>⚖️</span>
          <span>فريق كبار المستشارين السياديين</span>
        </h2>

        <!-- Advisor 1 -->
        <div class="advisor-card">
          <div style="width:60px;height:60px;border-radius:18px;background:rgba(212,168,67,0.12);border:1px solid rgba(212,168,67,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0;">
            🇸🇦
          </div>
          <div>
            <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.25rem;">
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin:0;">معالي الدكتور / سلمان بن خالد الشمري</h3>
              <span style="background:rgba(212,168,67,0.15);color:var(--nawader-gold);padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:700;">كبير الشركاء</span>
            </div>
            <div style="font-size:0.8rem;color:var(--nawader-teal);margin-bottom:0.5rem;">
              المستشار الأول لهيكلة صفقات الرؤية 2030 واستثمارات MISA وصندوق الاستثمارات العامة
            </div>
            <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;margin:0;">
              خبرة تتجاوز 22 عاماً في تأسيس الصناديق السيادية والتحكيم التجاري الدولي وحوكمة الكيانات العملاقة.
            </p>
          </div>
        </div>

        <!-- Advisor 2 -->
        <div class="advisor-card">
          <div style="width:60px;height:60px;border-radius:18px;background:rgba(120,169,255,0.12);border:1px solid rgba(120,169,255,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0;">
            🇺🇸
          </div>
          <div>
            <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.25rem;">
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin:0;">Hon. Marcus Vance, J.D.</h3>
              <span style="background:rgba(120,169,255,0.15);color:#78a9ff;padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:700;">US Managing Partner</span>
            </div>
            <div style="font-size:0.8rem;color:#78a9ff;margin-bottom:0.5rem;">
              رئيس ممارسات الاستثمار الأمريكي والشرق الأوسط — نيويورك وواشنطن (SEC & CFIUS Counsel)
            </div>
            <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;margin:0;">
              خبير معتمد في موافقات لجنة الاستثمار الأجنبي في الولايات المتحدة (CFIUS)، وتأسيس شركات ديلاوير وهياكل الضرائب المزدوجة.
            </p>
          </div>
        </div>

        <!-- Advisor 3 -->
        <div class="advisor-card">
          <div style="width:60px;height:60px;border-radius:18px;background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.3);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0;">
            ⚡
          </div>
          <div>
            <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.25rem;">
              <h3 style="font-size:1.1rem;font-weight:800;color:#fff;margin:0;">م. نورة بنت فهد الفيصل</h3>
              <span style="background:rgba(0,212,200,0.15);color:var(--nawader-teal);padding:2px 8px;border-radius:6px;font-size:0.7rem;font-weight:700;">مستشارة الحوسبة والسيادة</span>
            </div>
            <div style="font-size:0.8rem;color:var(--nawader-teal);margin-bottom:0.5rem;">
              مديرة استشارات التقنيات العميقة والبيانات الفائقة والامتثال لنظام SDAIA
            </div>
            <p style="font-size:0.82rem;color:var(--text-muted);line-height:1.6;margin:0;">
              متخصصة في صفقات مراكز البيانات المتقدمة ونماذج الذكاء الاصطناعي السيادي ونقل التكنولوجيا الاستراتيجية.
            </p>
          </div>
        </div>

      </div>

      <!-- Right: Booking Form Panel -->
      <div class="booking-panel">
        <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.35rem;">تنسيق جلسة استشارية مغلقة</h2>
        <p style="font-size:0.8rem;color:var(--text-muted);margin-bottom:1.5rem;">اختر نوع الاستشارة والوقت المناسب لحجز الجلسة</p>

        <form method="POST" action="{{ route('investor.consultations.book') }}">
          @csrf

          <div class="nw-input-group" style="margin-bottom:1.2rem;">
            <label class="nw-label">موضوع الجلسة الاستشارية</label>
            <select name="topic" class="nw-input" style="background:rgba(15,23,40,0.95);" required>
              <option value="ai">مراكز الحوسبة والذكاء الاصطناعي السيادي (OPP-901)</option>
              <option value="green">مجمع الهيدروجين الأخضر وسفن الشحن بنيوم (OPP-902)</option>
              <option value="space">كوكبة الأقمار الصناعية للمدار المنخفض (OPP-903)</option>
              <option value="legal">هيكلة وتأسيس الكيانات الثنائية (Delaware + KSA)</option>
              <option value="general">استشارة مخصصة لإدارة المحافظ السيادية</option>
            </select>
          </div>

          <div class="nw-input-group" style="margin-bottom:1.2rem;">
            <label class="nw-label">المستشار المطلوب</label>
            <select name="advisor" class="nw-input" style="background:rgba(15,23,40,0.95);" required>
              <option value="dr_salman">د. سلمان الشمري (الرياض — صفقات الرؤية وMISA)</option>
              <option value="marcus_vance">Marcus Vance, Esq. (نيويورك — SEC & CFIUS)</option>
              <option value="noura_faisal">م. نورة الفيصل (الرياض — DeepTech & SDAIA)</option>
            </select>
          </div>

          <div class="nw-input-group" style="margin-bottom:1.2rem;">
            <label class="nw-label">طريقة الانعقاد</label>
            <select name="format" class="nw-input" style="background:rgba(15,23,40,0.95);" required>
              <option value="virtual">جلسة فيديو مشفرة عالية السرية (Nawader Quantum Meet)</option>
              <option value="kafd">حضور شخصي — مركز الملك عبدالله المالي (KAFD) بالرياض</option>
              <option value="nyc">حضور شخصي — مانهاتن بارك أفينيو، نيويورك</option>
            </select>
          </div>

          <div class="nw-input-group" style="margin-bottom:1.2rem;">
            <label class="nw-label">التاريخ المقترح</label>
            <input type="date" name="date" class="nw-input" value="2026-03-26" required>
          </div>

          <div style="margin-bottom:1.5rem;">
            <label class="nw-label">الفترة الزمنية المفضلة (توقيت الرياض / UTC+3)</label>
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
              <button type="button" class="time-slot-btn active" onclick="selectSlot(this)">10:00 AM</button>
              <button type="button" class="time-slot-btn" onclick="selectSlot(this)">12:30 PM</button>
              <button type="button" class="time-slot-btn" onclick="selectSlot(this)">03:00 PM</button>
              <button type="button" class="time-slot-btn" onclick="selectSlot(this)">06:00 PM (NY Cross)</button>
            </div>
          </div>

          <div class="nw-input-group" style="margin-bottom:1.75rem;">
            <label class="nw-label">ملاحظات أولية أو محاور النقاش المطلوبة</label>
            <textarea name="notes" class="nw-input" rows="3" placeholder="أرفق أي استفسارات محددة أو حجم الاستثمار المستهدف لتحضير الملف الاستثماري مسبقاً..."></textarea>
          </div>

          <button type="submit" class="nw-btn nw-btn-primary" style="width:100%;justify-content:center;padding:0.9rem;">
            <span>تأكيد حجز الجلسة الاستشارية</span>
            <span>⚡</span>
          </button>
        </form>
      </div>

    </div>

  </div>
</div>

<script>
function selectSlot(btn) {
  document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>
@endsection
