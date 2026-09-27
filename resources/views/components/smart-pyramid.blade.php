@props(['categories' => []])

<section class="nw-pyramid-universe" id="nw-pyramid-section">
  {{-- Ambient Nebula Flares --}}
  <div class="nw-pyramid-flare flare-gold"></div>
  <div class="nw-pyramid-flare flare-teal"></div>
  <div class="nw-pyramid-flare flare-purple"></div>

  <div class="nw-container" style="position:relative; z-index:3;">

    {{-- Top HUD Telemetry Header --}}
    <div class="nw-hud-header" data-nw-animate>
      <div class="nw-hud-badge">
        <span class="nw-hud-pulse"></span>
        <span>NAWADER SPATIAL MATRIX // HIERARCHICAL PYRAMID 5.0</span>
      </div>
      <h2 class="nw-hud-title">
        الحاويات الهرمية الديناميكية الذكية
      </h2>
      <p class="nw-hud-subtitle">
        رؤية فضائية استراتيجية تدمج 20 قطاعاً سيادياً واقتصادياً — من قمة التحالف الحكومي حتى الفروع التشغيلية الميدانية في المملكة والولايات المتحدة
      </p>

      {{-- Mode Switcher HUD --}}
      <div class="nw-mode-selector">
        <button type="button" class="nw-mode-btn active" data-pyramid-mode="pyramid" onclick="switchPyramidMode('pyramid')">
          <span class="nw-mode-icon">🏛️</span>
          <span>المجسم الهرمي 3D</span>
        </button>
        <button type="button" class="nw-mode-btn" data-pyramid-mode="matrix" onclick="switchPyramidMode('matrix')">
          <span class="nw-mode-icon">🌌</span>
          <span>المصفوفة الفضائية (20 قطاعاً)</span>
        </button>
        <button type="button" class="nw-mode-btn" data-pyramid-mode="corridor" onclick="switchPyramidMode('corridor')">
          <span class="nw-mode-icon">🇸🇦🇺🇸</span>
          <span>الممر السيادي السعودي - الأمريكي</span>
        </button>
      </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- VIEW 1: THE INTERACTIVE 3D HIERARCHICAL PYRAMID       --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="nw-pyramid-view nw-view-active" id="nw-view-pyramid">
      <div class="nw-pyramid-structure">

        {{-- Apex Beacon Light Stream --}}
        <div class="nw-apex-beam"></div>

        {{-- LEVEL 1: THE STRATEGIC APEX (القمة السيادية الاستراتيجية) --}}
        <div class="nw-pyramid-tier tier-apex" data-tier="1" onclick="openTierInfo(1)">
          <div class="nw-tier-glow"></div>
          <div class="nw-tier-inner">
            <div class="nw-tier-header">
              <span class="nw-tier-badge">المستوى 01 — القمة السيادية</span>
              <span class="nw-tier-tag">SOVEREIGN APEX</span>
            </div>
            <div class="nw-tier-content">
              <div class="nw-tier-symbol">👑</div>
              <div class="nw-tier-text">
                <h3 class="nw-tier-title">التحالف الاستراتيجي السيادي & رؤية 2030</h3>
                <p class="nw-tier-desc">العلاقات الحكومية والدبلوماسية الاستثمارية رفيعة المستوى بين المملكة العربية السعودية والولايات المتحدة الأمريكية والاتحاد الدولي.</p>
              </div>
              <div class="nw-tier-actions">
                <button type="button" class="nw-tier-btn" onclick="event.stopPropagation(); openSpaceContainer('consulting')">
                  استكشف قمة الهرم ←
                </button>
              </div>
            </div>
            <div class="nw-tier-subtags">
              <span>مجلس الوزراء</span>
              <span>رؤية المملكة 2030</span>
              <span>U.S. Federal Agencies</span>
              <span>صندوق الاستثمارات العامة PIF</span>
            </div>
          </div>
        </div>

        {{-- LEVEL 2: REGULATORY & STRATEGIC PILLARS (النواة الحكومية والمالية) --}}
        <div class="nw-pyramid-tier tier-2" data-tier="2" onclick="openTierInfo(2)">
          <div class="nw-tier-inner">
            <div class="nw-tier-header">
              <span class="nw-tier-badge">المستوى 02 — النواة التنظيمية والمالية الكبرى</span>
              <span class="nw-tier-tag">REGULATORY CORE</span>
            </div>
            <div class="nw-tier-grid-4">
              <div class="nw-tier-mini-card" onclick="event.stopPropagation(); openSpaceContainer('foreign-investment')">
                <span class="nw-mini-icon">🌐</span>
                <div>
                  <strong>الاستثمار الأجنبي MISA</strong>
                  <small>ترخيص ملكية 100% وحوافز المقرات الإقليمية</small>
                </div>
              </div>
              <div class="nw-tier-mini-card" onclick="event.stopPropagation(); openSpaceContainer('finance')">
                <span class="nw-mini-icon">🏦</span>
                <div>
                  <strong>المالية وسوق المال SAMA & CMA</strong>
                  <small>الفنتك، البيئة التجريبية، ورخص SEC الأمريكية</small>
                </div>
              </div>
              <div class="nw-tier-mini-card" onclick="event.stopPropagation(); openSpaceContainer('regulatory')">
                <span class="nw-mini-icon">🛡️</span>
                <div>
                  <strong>الامتثال والحوكمة AML</strong>
                  <small>مكافحة غسل الأموال، PDPL، والرقابة الفيدرالية</small>
                </div>
              </div>
              <div class="nw-tier-mini-card" onclick="event.stopPropagation(); openSpaceContainer('grants')">
                <span class="nw-mini-icon">💰</span>
                <div>
                  <strong>التمويل والمنح الحكومية</strong>
                  <small>صناديق التنمية SIDF، كفالة، و SBA الأمريكية</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- LEVEL 3: ECONOMIC & INDUSTRIAL ENGINES (المحركات الاقتصادية والصناعية الكبرى) --}}
        <div class="nw-pyramid-tier tier-3" data-tier="3" onclick="openTierInfo(3)">
          <div class="nw-tier-inner">
            <div class="nw-tier-header">
              <span class="nw-tier-badge">المستوى 03 — المحركات التشغيلية والصناعية الكبرى</span>
              <span class="nw-tier-tag">ECONOMIC ENGINES</span>
            </div>
            <div class="nw-tier-grid-6">
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('legal')">
                <span>🏛️</span>
                <b>تأسيس الشركات (LLC/JSC)</b>
                <span class="chip-code">Delaware & KSA</span>
              </div>
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('licenses')">
                <span>📋</span>
                <b>التراخيص التجارية والبلدية</b>
                <span class="chip-code">MOMRAH / بلدي</span>
              </div>
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('property')">
                <span>🏗️</span>
                <b>التسجيل العقاري والصكوك</b>
                <span class="chip-code">السجل العيني RER</span>
              </div>
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('trade')">
                <span>🚢</span>
                <b>التجارة والجمارك وسابر</b>
                <span class="chip-code">ZATCA & U.S. CBP</span>
              </div>
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('energy')">
                <span>⚡</span>
                <b>الطاقة والتعدين والبنية</b>
                <span class="chip-code">محطات شمسية وتعدين</span>
              </div>
              <div class="nw-tier-chip" onclick="event.stopPropagation(); openSpaceContainer('tech')">
                <span>🚀</span>
                <b>التقنية والذكاء الاصطناعي</b>
                <span class="chip-code">CST & SDAIA</span>
              </div>
            </div>
          </div>
        </div>

        {{-- LEVEL 4: SPECIALIST & VITAL SECTORS (القطاعات التخصصية والحيوية) --}}
        <div class="nw-pyramid-tier tier-4" data-tier="4" onclick="openTierInfo(4)">
          <div class="nw-tier-inner">
            <div class="nw-tier-header">
              <span class="nw-tier-badge">المستوى 04 — المنظومات التخصصية والخدمية</span>
              <span class="nw-tier-tag">SPECIALIST ECOSYSTEMS</span>
            </div>
            <div class="nw-tier-grid-7">
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('ip')">
                <span>⚡</span> الملكية الفكرية SAIP & USPTO
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('hr')">
                <span>👥</span> الموارد البشرية ومنصة قوى
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('health')">
                <span>⚕️</span> الصحة والمنشآت وSFDA
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('education')">
                <span>🎓</span> التعليم والتدريب TVTC
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('tourism')">
                <span>✈️</span> السياحة وهيئة الترفيه GEA
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('environment')">
                <span>🌿</span> البيئة والسعودية الخضراء
              </div>
              <div class="nw-tier-pill" onclick="event.stopPropagation(); openSpaceContainer('expat')">
                <span>🌍</span> الإقامة المميزة وتأشيرات US
              </div>
            </div>
          </div>
        </div>

        {{-- LEVEL 5: OPERATIONAL BRANCHES BASE (قاعدة الفروع والخدمات التنفيذية المباشرة) --}}
        <div class="nw-pyramid-tier tier-base" data-tier="5" onclick="openTierInfo(5)">
          <div class="nw-tier-inner">
            <div class="nw-tier-header">
              <span class="nw-tier-badge">المستوى 05 — قاعدة الفروع والخدمات التنفيذية الميدانية</span>
              <span class="nw-tier-tag">EXECUTION INFRASTRUCTURE</span>
            </div>
            <div class="nw-tier-base-metrics">
              <div class="base-metric">
                <span class="metric-num">+200</span>
                <span class="metric-label">فرع وخدمة تنفيذية مؤتمتة</span>
              </div>
              <div class="base-divider"></div>
              <div class="base-metric">
                <span class="metric-num">100%</span>
                <span class="metric-label">مطابقة تنظيمية وقانونية معتمدة</span>
              </div>
              <div class="base-divider"></div>
              <div class="base-metric">
                <span class="metric-num">24/7</span>
                <span class="metric-label">متابعة لحظية وتشفير سيادي</span>
              </div>
              <div class="base-divider"></div>
              <div class="base-metric">
                <span class="metric-num">🇸🇦 & 🇺🇸</span>
                <span class="metric-label">تغطية لكامل الوزارات والهيئات</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- VIEW 2: THE 20-SECTOR COSMIC MATRIX (المصفوفة الكونية) --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="nw-matrix-view" id="nw-view-matrix" style="display:none;">
      <div class="nw-matrix-grid">
        @foreach($categories as $cat)
        <div class="nw-space-card nw-tilt theme-{{ $cat['color'] ?? 'gold' }}" data-category="{{ $cat['slug'] }}" onclick="openSpaceContainer('{{ $cat['slug'] }}')">
          <div class="nw-card-border-glow"></div>
          <div class="nw-card-glare"></div>

          {{-- Top Badges --}}
          <div class="nw-card-topbar">
            <span class="nw-code-badge">{{ $cat['code'] ?? 'NW-'.str_pad($cat['number'],2,'0',STR_PAD_LEFT) }}</span>
            <span class="nw-corridor-flag">
              @if(($cat['corridor'] ?? '') === 'sa') 🇸🇦 سعودي
              @elseif(($cat['corridor'] ?? '') === 'us') 🇺🇸 أمريكي
              @else 🇸🇦 🇺🇸 دولي
              @endif
            </span>
          </div>

          {{-- 3D Isometric Holographic Icon --}}
          <div class="nw-holo-symbol-wrap">
            <div class="nw-holo-symbol">{{ $cat['icon'] }}</div>
            <div class="nw-holo-rings"></div>
          </div>

          {{-- Title & Subtitle --}}
          <h3 class="nw-space-card-title">{{ $cat['title'] }}</h3>
          <p class="nw-space-card-sub">{{ $cat['subtitle'] }}</p>

          {{-- Ministry Link --}}
          <div class="nw-card-ministry">
            <span class="ministry-dot"></span>
            <span>{{ Str::limit($cat['ministry'] ?? 'الوزارات والهيئات التنظيمية المعتمدة', 48) }}</span>
          </div>

          {{-- Marketing Copy Snippet --}}
          <p class="nw-space-card-copy">
            "{{ Str::limit($cat['marketing'], 95) }}"
          </p>

          {{-- Subcategories Branch Count --}}
          <div class="nw-card-footer-metrics">
            <span class="branch-pill">
              {{ count($cat['subcategories'] ?? []) }} أقسام فرعية
            </span>
            <span class="service-pill">
              {{ $cat['count'] ?? 10 }}+ فرع مباشر
            </span>
            <span class="arrow-indicator">فتح الحاوية ←</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- VIEW 3: SAUDI - USA BILATERAL SOVEREIGN CORRIDOR      --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div class="nw-corridor-view" id="nw-view-corridor" style="display:none;">
      <div class="nw-corridor-wrapper">

        <div class="nw-corridor-intro">
          <div class="nw-corridor-flags-row">
            <div class="corridor-flag-side">
              <span class="flag-icon">🇸🇦</span>
              <h4>المملكة العربية السعودية</h4>
              <p>رؤية 2030 • أكبر اقتصاد إقليمي • مناطق اقتصادية خاصة وحوافز 0% ضرائب</p>
            </div>
            <div class="corridor-nexus">
              <div class="nexus-ring"></div>
              <span class="nexus-label">CORRIDOR NEXUS</span>
              <span class="nexus-sub">ربط سيادي فوري</span>
            </div>
            <div class="corridor-flag-side">
              <span class="flag-icon">🇺🇸</span>
              <h4>الولايات المتحدة الأمريكية</h4>
              <p>أسواق رأس المال الكبرى • Delaware & Wyoming • SEC / USPTO / SBA</p>
            </div>
          </div>
        </div>

        {{-- Direct Parity Routing Table --}}
        <div class="nw-parity-table">
          <div class="parity-row header-row">
            <div class="parity-col sa-col">🇸🇦 المنظومة والوزارات السعودية</div>
            <div class="parity-col axis-col">المسار الاستراتيجي والخدمي</div>
            <div class="parity-col us-col">🇺🇸 المنظومة الفيدرالية الأمريكية</div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('legal')">
            <div class="parity-col sa-col">
              <strong>وزارة التجارة (السعودية)</strong>
              <small>تأسيس شركات ش.م.م، السجلات التجارية، الحوكمة</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">تأسيس الكيانات القانونية</span>
            </div>
            <div class="parity-col us-col">
              <strong>Delaware & Wyoming Divisions of Corp</strong>
              <small>Delaware LLC, C-Corp, Articles of Organization</small>
            </div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('foreign-investment')">
            <div class="parity-col sa-col">
              <strong>وزارة الاستثمار MISA</strong>
              <small>ترخيص الاستثمار الأجنبي 100% والمقرات الإقليمية RHQ</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">الاستثمار الأجنبي المباشر (FDI)</span>
            </div>
            <div class="parity-col us-col">
              <strong>SelectUSA & CFIUS Treasury</strong>
              <small>Cross-border Foreign Investment & Direct Expansion</small>
            </div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('ip')">
            <div class="parity-col sa-col">
              <strong>الهيئة السعودية للملكية الفكرية (SAIP)</strong>
              <small>تسجيل العلامات التجارية وحماية براءات الاختراع</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">الملكية الفكرية والبراءات</span>
            </div>
            <div class="parity-col us-col">
              <strong>U.S. Patent & Trademark Office (USPTO)</strong>
              <small>Federal Trademarks, Patents & Madrid Protocol</small>
            </div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('trade')">
            <div class="parity-col sa-col">
              <strong>هيئة الزكاة والضريبة والجمارك (ZATCA)</strong>
              <small>الفاتورة الإلكترونية، الجمارك، ومنصة سابر Saber</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">الجمارك والضرائب وسلاسل الإمداد</span>
            </div>
            <div class="parity-col us-col">
              <strong>Internal Revenue Service (IRS) & U.S. CBP</strong>
              <small>Federal EIN, Customs Bonds, Importer Clearance</small>
            </div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('finance')">
            <div class="parity-col sa-col">
              <strong>البنك المركزي السعودي (SAMA) & هيئة السوق CMA</strong>
              <small>تراخيص الفنتك، بوابات الدفع، وإدراج سوق نمو</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">القطاع المصرفي والأسواق المالية</span>
            </div>
            <div class="parity-col us-col">
              <strong>U.S. SEC & FINRA</strong>
              <small>Broker-Dealer, RIA Investment Advisors, Capital Raising</small>
            </div>
          </div>

          <div class="parity-row" onclick="openSpaceContainer('expat')">
            <div class="parity-col sa-col">
              <strong>مركز الإقامة المميزة والجوازات</strong>
              <small>إقامة مستثمر، رواد أعمال، كفاءات استثنائية</small>
            </div>
            <div class="parity-col axis-col">
              <span class="axis-pill">الإقامات والتأشيرات الاستثمارية</span>
            </div>
            <div class="parity-col us-col">
              <strong>USCIS Immigration Services</strong>
              <small>EB-5 Green Card, L-1 Intra-company, O-1 Extraordinary</small>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>

{{-- ══════════════════════════════════════════════════════════════════════ --}}
{{-- DYNAMIC SMART SPACE CONTAINER (DRAWER / MODAL)                         --}}
{{-- ══════════════════════════════════════════════════════════════════════ --}}
<div class="nw-space-drawer" id="nw-space-drawer" aria-hidden="true">
  <div class="nw-drawer-backdrop" onclick="closeSpaceContainer()"></div>

  <div class="nw-drawer-panel">
    {{-- Header with Holographic Status --}}
    <div class="nw-drawer-header">
      <div class="nw-drawer-topline">
        <div class="nw-drawer-tag">
          <span class="tag-beacon"></span>
          <span id="drawer-code">NW-01-CORP</span>
        </div>
        <button type="button" class="nw-drawer-close" onclick="closeSpaceContainer()" aria-label="إغلاق">✕</button>
      </div>

      <div class="nw-drawer-hero-info">
        <div class="nw-drawer-icon" id="drawer-icon">🏛️</div>
        <div>
          <h2 class="nw-drawer-title" id="drawer-title">تأسيس الشركات والكيانات القانونية</h2>
          <p class="nw-drawer-subtitle" id="drawer-subtitle">Corporate & Legal Entity Formation</p>
        </div>
      </div>

      {{-- Ministerial & Corridor Bar --}}
      <div class="nw-drawer-gov-bar">
        <div class="gov-label">الجهة التنظيمية:</div>
        <div class="gov-value" id="drawer-ministry">وزارة التجارة | Delaware Secretary of State</div>
      </div>
    </div>

    {{-- Body Content --}}
    <div class="nw-drawer-body">

      {{-- Professional Marketing Copy Box --}}
      <div class="nw-drawer-marketing-box">
        <div class="marketing-badge">💡 الرؤية الاستراتيجية والقيمة المضافة</div>
        <p class="marketing-text" id="drawer-marketing">
          نحوّل حلمك التجاري إلى واقع قانوني معتمد في أسرع وقت ممكن...
        </p>
      </div>

      {{-- Detailed Description --}}
      <p class="nw-drawer-desc" id="drawer-desc"></p>

      {{-- Key Strategic Highlights --}}
      <div class="nw-drawer-section">
        <h4 class="nw-drawer-section-title">الميزات الاستراتيجية والضمانات السيادية</h4>
        <ul class="nw-drawer-highlights" id="drawer-highlights"></ul>
      </div>

      {{-- Subcategories & Branch Services Breakdown --}}
      <div class="nw-drawer-section">
        <div class="nw-section-title-row">
          <h4 class="nw-drawer-section-title">الأقسام الفرعية وجميع الفروع التنفيذية المباشرة</h4>
          <span class="nw-drawer-count" id="drawer-count-badge">12 فرع</span>
        </div>
        <div class="nw-drawer-subcats" id="drawer-subcategories"></div>
      </div>

    </div>

    {{-- Drawer Action Footer --}}
    <div class="nw-drawer-footer">
      <div class="drawer-stats-note" id="drawer-stats">أكثر من 3,800 شركة تم تأسيسها</div>
      <div class="drawer-btn-group">
        <a href="{{ route('services.index') }}" class="nw-btn nw-btn-secondary" id="drawer-link-category">
          عرض الصفحة الكاملة
        </a>
        <a href="{{ route('dashboard.requests.create') }}" class="nw-btn nw-btn-primary" id="drawer-link-wizard">
          قدّم طلبك الآن في هذا القسم ←
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Pass Categories Data Safely to JS --}}
<script>
window.__NW_CATALOG__ = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};

function switchPyramidMode(mode) {
  // Update buttons
  document.querySelectorAll('.nw-mode-btn').forEach(b => {
    b.classList.toggle('active', b.dataset.pyramidMode === mode);
  });

  // Switch view containers
  const viewPyramid  = document.getElementById('nw-view-pyramid');
  const viewMatrix   = document.getElementById('nw-view-matrix');
  const viewCorridor = document.getElementById('nw-view-corridor');

  if (viewPyramid)  viewPyramid.style.display  = mode === 'pyramid' ? 'block' : 'none';
  if (viewMatrix)   viewMatrix.style.display   = mode === 'matrix' ? 'block' : 'none';
  if (viewCorridor) viewCorridor.style.display = mode === 'corridor' ? 'block' : 'none';

  // Sound effect
  if (window.nawaderAudio) window.nawaderAudio.playWarp();
}

function openSpaceContainer(slug) {
  const cat = window.__NW_CATALOG__[slug];
  if (!cat) return;

  const drawer = document.getElementById('nw-space-drawer');
  if (!drawer) return;

  // Populate drawer
  document.getElementById('drawer-code').textContent = cat.code || ('NW-' + String(cat.number).padStart(2,'0'));
  document.getElementById('drawer-icon').textContent = cat.icon || '🏛️';
  document.getElementById('drawer-title').textContent = cat.title || '';
  document.getElementById('drawer-subtitle').textContent = cat.subtitle || '';
  document.getElementById('drawer-ministry').textContent = cat.ministry || 'الجهات الحكومية والتنظيمية المعتمدة';
  document.getElementById('drawer-marketing').textContent = cat.marketing || '';
  document.getElementById('drawer-desc').textContent = cat.description || '';
  document.getElementById('drawer-stats').textContent = cat.stats || '';

  // Highlights
  const hlList = document.getElementById('drawer-highlights');
  hlList.innerHTML = '';
  (cat.highlights || []).forEach(hl => {
    const li = document.createElement('li');
    li.innerHTML = '<span class="hl-check">✓</span><span>' + hl + '</span>';
    hlList.appendChild(li);
  });

  // Subcategories & Services
  const subContainer = document.getElementById('drawer-subcategories');
  subContainer.innerHTML = '';

  let totalServices = 0;
  (cat.subcategories || []).forEach(sub => {
    const subBlock = document.createElement('div');
    subBlock.className = 'nw-sub-block';

    let svcHtml = '';
    (sub.services || []).forEach(svc => {
      totalServices++;
      const priceFmt = Number(svc.price).toLocaleString('ar-SA');
      svcHtml += `
        <div class="nw-drawer-svc-row">
          <div class="svc-row-info">
            <span class="svc-name">${svc.name}</span>
            <span class="svc-target">${svc.target ? '🏛️ ' + svc.target : ''}</span>
          </div>
          <div class="svc-row-meta">
            <span class="svc-time">⏱ ${svc.days}</span>
            <span class="svc-price">${priceFmt} ر.س</span>
            <a href="/dashboard/requests/new?category=${cat.slug}&service=${encodeURIComponent(svc.name)}" class="svc-order-link">طلب ←</a>
          </div>
        </div>
      `;
    });

    subBlock.innerHTML = `
      <div class="sub-block-head">
        <h5 class="sub-block-title">${sub.title}</h5>
        <span class="sub-block-desc">${sub.description || ''}</span>
      </div>
      <div class="sub-block-svcs">${svcHtml}</div>
    `;
    subContainer.appendChild(subBlock);
  });

  document.getElementById('drawer-count-badge').textContent = totalServices + ' فرع تنفيذي';

  // Links
  const linkCat = document.getElementById('drawer-link-category');
  if (linkCat) linkCat.href = '/services/' + cat.slug;

  const linkWiz = document.getElementById('drawer-link-wizard');
  if (linkWiz) linkWiz.href = '/dashboard/requests/new?category=' + cat.slug;

  // Open drawer
  drawer.classList.add('open');
  drawer.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';

  // Sound effect
  if (window.nawaderAudio) window.nawaderAudio.playHologramOpen();
}

function closeSpaceContainer() {
  const drawer = document.getElementById('nw-space-drawer');
  if (!drawer) return;
  drawer.classList.remove('open');
  drawer.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}

function openTierInfo(level) {
  // Direct to relevant category representative
  const tierMap = {
    1: 'consulting',
    2: 'foreign-investment',
    3: 'legal',
    4: 'ip',
    5: 'licenses'
  };
  openSpaceContainer(tierMap[level] || 'legal');
}

// ESC to close drawer
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeSpaceContainer();
});
</script>
