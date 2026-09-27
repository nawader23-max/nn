@extends('layouts.app')

@section('title', 'أستديو نوادر السينمائي — معرض التصاميم والمشاريع والفيديوهات السيادية')
@section('page_title', 'أستديو المعارض والتصاميم السيادية')

@push('head')
<style>
.nw-showcase-page { padding: 120px 0 80px; position: relative; }
.showcase-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(120px); }

.studio-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 2rem;
}

.studio-card-item {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(25px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; overflow: hidden;
  transition: all 0.4s cubic-bezier(0.16,1,0.3,1); position: relative;
}
.studio-card-item:hover {
  border-color: rgba(212,168,67,0.5); transform: translateY(-6px);
  box-shadow: 0 25px 60px rgba(0,0,0,0.7), 0 0 35px rgba(212,168,67,0.15);
}

.studio-media-frame {
  height: 220px; width: 100%; position: relative; overflow: hidden;
  background: linear-gradient(135deg, rgba(20,30,55,0.9), rgba(8,12,24,0.95));
  display: flex; align-items: center; justify-content: center;
}
.studio-media-frame img {
  width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s;
}
.studio-card-item:hover .studio-media-frame img {
  transform: scale(1.08);
}

.studio-play-badge {
  position: absolute; width: 50px; height: 50px; border-radius: 50%;
  background: rgba(212,168,67,0.85); color: var(--nawader-navy);
  display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
  box-shadow: 0 0 25px rgba(212,168,67,0.6); backdrop-filter: blur(8px);
}

.filter-btn {
  background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 30px; padding: 7px 18px; color: var(--text-secondary);
  font-family: var(--font-arabic); font-size: 0.84rem; cursor: pointer; transition: all 0.25s;
}
.filter-btn.active, .filter-btn:hover {
  background: rgba(212,168,67,0.18); border-color: var(--nawader-gold);
  color: #fff; font-weight: 700;
}
</style>
@endpush

@section('content')
<div class="nw-showcase-page">
  <div class="showcase-orb" style="width:650px;height:650px;top:0;right:5%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="showcase-orb" style="width:600px;height:600px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Hero Title -->
    <div style="text-align:center;max-width:850px;margin:0 auto 3rem;">
      <div class="nw-section-eyebrow" style="margin-bottom:0.6rem;">الهوية البصرية والإنتاج السينمائي ثلاثي الأبعاد</div>
      <h1 style="font-size:2.4rem;font-weight:900;color:#fff;line-height:1.3;margin-bottom:1rem;">
        أستديو نوادر السينمائي: معرض الإنجازات، الصروح، والمجسمات الفائقة
      </h1>
      <p style="font-size:0.95rem;color:var(--text-secondary);line-height:1.8;">
        استكشف محفظة الأعمال السيادية التي تجمع بين التراث المعماري الخالد لأرض الحضارات، والتقنيات الرقمية الفضائية لمشاريع المستقبل في نيوم وكافد والعلا.
      </p>
    </div>

    <!-- Category Filters -->
    <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;margin-bottom:3rem;">
      <button class="filter-btn active" onclick="filterGallery('all', this)">عرض الجميع</button>
      <button class="filter-btn" onclick="filterGallery('megaprojects', this)">🏛️ المشاريع الكبرى (نيوم & كافد)</button>
      <button class="filter-btn" onclick="filterGallery('cinema', this)">🎬 الإنتاج السينمائي والوثائقي</button>
      <button class="filter-btn" onclick="filterGallery('digital', this)">🌐 المنصات الرقمية السيادية</button>
      <button class="filter-btn" onclick="filterGallery('heritage', this)">💎 الفخامة والتراث المعماري</button>
    </div>

    <!-- Gallery Grid -->
    <div class="studio-grid" id="studio-gallery">

      <!-- Item 1: NEOM Oxagon Port 3D -->
      <div class="studio-card-item" data-cat="megaprojects">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(0,212,200,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">🌊</span>
            <span style="font-size:0.8rem;color:var(--nawader-teal);letter-spacing:2px;font-weight:700;">NEOM OXAGON 8K</span>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(0,212,200,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:var(--nawader-teal);">مجسم ثلاثي الأبعاد</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">مجمع الموانئ الذكية أوكساجون - نيوم</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            تصميم هندسي متكامل للميناء الصناعي العائم بتقنية الهولوغرام والروبوتات المائية مع معايير الاستدامة التامة.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>العميل: نيوم / أرامكو</span>
            <button onclick="openMediaModal('مجمع أوكساجون الصناعي', 'مجسم تفاعلي بدقة 8K يجسد معمارية المدينة الصناعية العائمة والربط السيادي لمنظومة سلاسل الإمداد.', 'megaprojects')" class="nw-btn nw-btn-sm nw-btn-ghost">معاينة كاملة 🔍</button>
          </div>
        </div>
      </div>

      <!-- Item 2: KAFD Sovereign Tower Cinema -->
      <div class="studio-card-item" data-cat="cinema">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(212,168,67,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">🏙️</span>
            <div class="studio-play-badge">▶</div>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(212,168,67,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:var(--nawader-gold);">فيلم وثائقي 4K</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">تدشين المقر الإقليمي RHQ بمركز كافد</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            فيلم سينمائي توثيقي يستعرض استقطاب الاستثمارات العالمية وتوقيع اتفاقيات التعاقد عبر شاشات الهولوغرام.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>المدة: 60 ثانية سينمائية</span>
            <button onclick="openMediaModal('فيلم تدشين المقر الإقليمي KAFD', 'لقطات درون حصرية بدقة سينمائية توثق فخامة مركز الملك عبدالله المالي وتوقيع الشراكات الدولية.', 'video')" class="nw-btn nw-btn-sm nw-btn-primary">تشغيل العرض 🎬</button>
          </div>
        </div>
      </div>

      <!-- Item 3: AlUla Sovereign Oasis -->
      <div class="studio-card-item" data-cat="heritage">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(245,158,11,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">🏜️</span>
            <span style="font-size:0.8rem;color:#f59e0b;letter-spacing:2px;font-weight:700;">ALULA HERITAGE</span>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(245,158,11,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:#f59e0b;">واحة العلا التراثية</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">قصر الحجر ومجمع المؤتمرات الصحراوي</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            تجسيد سينمائي فائق الدقة يدمج بين جبال الحجر النبطية الخالدة وقاعات الاجتماعات الدبلوماسية المعاصرة.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>النمط: تراث معماري ملكي</span>
            <button onclick="openMediaModal('مجمع المؤتمرات بالعلا', 'رؤية بصرية تجمع أصل الحضارة العربية العريقة مع قمة الفخامة البروتوكولية العالمية.', 'heritage')" class="nw-btn nw-btn-sm nw-btn-ghost">معاينة 🔍</button>
          </div>
        </div>
      </div>

      <!-- Item 4: Sovereign HUD Digital System -->
      <div class="studio-card-item" data-cat="digital">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(168,85,247,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">🛡️</span>
            <span style="font-size:0.8rem;color:#c084fc;letter-spacing:2px;font-weight:700;">CYBER HUD COMMAND</span>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(168,85,247,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:#c084fc;">منظومة تحكم فضائية</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">واجهة القيادة والتحكم الرقمية السيادية</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            تصميم هندسي متقدم يربط الوزارات والهيئات الحكومية وشاشات البورصة عبر واجهات بيومترية عالية الأمان.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>التقنية: Laravel + WebGL HUD</span>
            <button onclick="openMediaModal('واجهة القيادة السيادية', 'تصميم معماري لواجهات اتخاذ القرار للوزارات والصناديق السيادية.', 'digital')" class="nw-btn nw-btn-sm nw-btn-ghost">معاينة 🔍</button>
          </div>
        </div>
      </div>

      <!-- Item 5: The Line Megaproject Infrastructure -->
      <div class="studio-card-item" data-cat="megaprojects">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(0,212,200,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">⚡</span>
            <span style="font-size:0.8rem;color:var(--nawader-teal);letter-spacing:2px;font-weight:700;">THE LINE NEOM</span>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(0,212,200,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:var(--nawader-teal);">الذكاء الاصطناعي الصفري</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">المحطة الحركية الفائقة - ذا لاين</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            أنفاق قطار الهايبرلوب السريع والواجهات الزجاجية العاكسة الممتدة على مسافة 170 كم في قلب الطبيعة البكر.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>التصنيف: معمارية المستقبل</span>
            <button onclick="openMediaModal('ذا لاين - المحطة الحركية', 'محاكاة ثلاثية الأبعاد لمجسمات القطار السريع وتوليد الطاقة المتجددة في مدينة ذا لاين.', 'megaprojects')" class="nw-btn nw-btn-sm nw-btn-ghost">معاينة 🔍</button>
          </div>
        </div>
      </div>

      <!-- Item 6: Bilateral US-Saudi Corridor Cinema -->
      <div class="studio-card-item" data-cat="cinema">
        <div class="studio-media-frame">
          <div style="position:absolute;inset:0;background:radial-gradient(circle at center, rgba(212,168,67,0.2) 0%, rgba(10,15,30,0.9) 80%);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:0.5rem;">
            <span style="font-size:3.5rem;">🌐</span>
            <div class="studio-play-badge">▶</div>
          </div>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,0.6);border:1px solid rgba(212,168,67,0.4);border-radius:6px;padding:2px 8px;font-size:0.7rem;color:var(--nawader-gold);">عرض الممر الثنائي</span>
        </div>
        <div style="padding:1.5rem;">
          <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">الممر الاستثماري: الرياض — ديلاوير — نيويورك</h3>
          <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">
            فيلم ترويجي يبث الثقة ويستعرض تدفق رؤوس الأموال بين وول ستريت والشركات السعودية الكبرى.
          </p>
          <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.06);padding-top:0.9rem;font-size:0.75rem;color:var(--text-muted);">
            <span>الإنتاج: استديوهات نوادر الدولية</span>
            <button onclick="openMediaModal('الممر الاستثماري الأمريكي السعودي', 'عرض وثائقي احترافي يعكس الشراكة الاقتصادية الاستراتيجية وتسهيلات التأسيس السيادية.', 'video')" class="nw-btn nw-btn-sm nw-btn-primary">تشغيل 🎬</button>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- Interactive Media Modal -->
<div id="media-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);backdrop-filter:blur(20px);z-index:999999;align-items:center;justify-content:center;padding:1.5rem;">
  <div style="background:rgba(15,23,40,0.95);border:1px solid rgba(212,168,67,0.4);border-radius:24px;max-width:700px;width:100%;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,0.9);position:relative;">
    <button onclick="closeMediaModal()" style="position:absolute;top:16px;left:16px;background:rgba(255,255,255,0.1);border:none;color:#fff;border-radius:50%;width:36px;height:36px;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;">✕</button>
    
    <div id="modal-screen" style="height:320px;background:linear-gradient(135deg, #0f172a, #030712);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:1rem;position:relative;border-bottom:1px solid rgba(255,255,255,0.08);">
      <div id="modal-icon" style="font-size:5rem;">🏛️</div>
      <div id="modal-playback-notice" style="color:var(--nawader-gold);font-size:0.85rem;font-weight:700;">العرض السينمائي فائق الدقة (8K Ultra HD)</div>
    </div>

    <div style="padding:1.75rem;">
      <h3 id="modal-title" style="font-size:1.4rem;font-weight:900;color:#fff;margin-bottom:0.5rem;">عنوان العمل</h3>
      <p id="modal-desc" style="font-size:0.88rem;color:var(--text-secondary);line-height:1.7;margin-bottom:1.5rem;">وصف تفصيلي</p>
      <div style="display:flex;justify-content:space-between;align-items:center;">
        <span style="font-size:0.75rem;color:var(--nawader-teal);">محمي وموثق بختم نوادر السيادي للإنتاج الفني</span>
        <button onclick="closeMediaModal()" class="nw-btn nw-btn-primary">إغلاق المعاينة</button>
      </div>
    </div>
  </div>
</div>

<script>
function filterGallery(category, btn) {
  document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const items = document.querySelectorAll('.studio-card-item');
  items.forEach(item => {
    if (category === 'all' || item.getAttribute('data-cat') === category) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
}

function openMediaModal(title, desc, type) {
  document.getElementById('modal-title').textContent = title;
  document.getElementById('modal-desc').textContent = desc;
  
  const icon = document.getElementById('modal-icon');
  if (type === 'video') icon.textContent = '🎬';
  else if (type === 'heritage') icon.textContent = '🏜️';
  else if (type === 'digital') icon.textContent = '🛡️';
  else icon.textContent = '🏛️';

  const modal = document.getElementById('media-modal');
  modal.style.display = 'flex';
}

function closeMediaModal() {
  document.getElementById('media-modal').style.display = 'none';
}
</script>
@endsection
