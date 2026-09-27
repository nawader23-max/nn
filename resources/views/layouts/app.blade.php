<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'نوادر — المنظومة السيادية للخدمات الحكومية والاستشارية والتقنية الكبرى بالمملكة العربية السعودية والولايات المتحدة الأمريكية.')">
    <meta name="theme-color" content="#0F6D62">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="author" content="منظومة نوادر السيادية | Nawader Sovereign Systems">
    <meta name="keywords" content="نوادر, منصة نوادر, خدمات حكومية, استشارات سيادية, تأسيس شركات ديلاوير, الاستثمار السعودي الأمريكي, منصة قوى, منصة اعتماد, منصة بلدي, زاتكا المرحلة 2, عقود رقمية, نيوم أوكساجون, رؤية 2030">
    <title>@yield('title', 'نوادر') — @yield('page_title', 'المنظومة السيادية للخدمات المتكاملة')</title>

    {{-- Canonical & Hreflang --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph / Social Media --}}
    <meta property="og:site_name" content="نوادر — المنظومة السيادية">
    <meta property="og:title" content="@yield('title', 'نوادر') — @yield('page_title', 'المنظومة السيادية للخدمات المتكاملة')">
    <meta property="og:description" content="@yield('description', 'منظومة نوادر السيادية المتكاملة لخدمة قطاعات الأعمال والجهات الحكومية والتحالفات الاستثمارية السعودية الأمريكية.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-sovereign-banner.jpg') }}">
    <meta property="og:locale" content="ar_SA">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@@NawaderHQ">
    <meta name="twitter:title" content="@yield('title', 'نوادر') — @yield('page_title', 'المنظومة السيادية للخدمات المتكاملة')">
    <meta name="twitter:description" content="@yield('description', 'المنظومة السيادية الأولى من نوعها للربط الحكومي والتوثيق والذكاء الاصطناعي المؤسسي.')">
    <meta name="twitter:image" content="{{ asset('images/og-sovereign-banner.jpg') }}">

    {{-- PWA — Progressive Web App (iOS Safari + Android/Chrome install) --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/app-icons/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="نوادر">
    <meta name="application-name" content="نوادر">
    <meta name="format-detection" content="telephone=no">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/app-icons/favicon-32.png') }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23D4A843'/><text y='.9em' font-size='72' x='50%25' text-anchor='middle' fill='%230A0F1E' font-weight='900'>ن</text></svg>">

    {{-- Sovereign Arabic & Global Fonts (IBM Plex Sans Arabic, Cairo, Amiri, Tajawal, Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@400;500;600;700;800;900&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- JSON-LD Structured Data Schema for Top Search Engines & AI Crawlers --}}
    @php
        $sovereignSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => url('/') . '#organization',
                    'name' => 'نوادر للخدمات السيادية المتكاملة',
                    'alternateName' => 'Nawader Sovereign Systems LLC',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => url('/images/logo.png'),
                        'caption' => 'شعار نوادر السيادي',
                    ],
                    'description' => 'المنظومة السيادية الأولى من نوعها للربط الحكومي السعودي والأمريكي وتوثيق العقود والذكاء الاصطناعي المؤسسي',
                    'foundingDate' => '2024',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'طريق الملك فهد، مركز الملك عبدالله المالي (KAFD)',
                        'addressLocality' => 'الرياض',
                        'addressRegion' => 'منطقة الرياض',
                        'postalCode' => '11564',
                        'addressCountry' => 'SA',
                    ],
                    'contactPoint' => [
                        '@type' => 'ContactPoint',
                        'telephone' => '+966-11-900-8888',
                        'contactType' => 'customer support',
                        'areaServed' => ['SA', 'US', 'AE', 'QA', 'KW'],
                        'availableLanguage' => ['Arabic', 'English'],
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'نوادر — المنظومة السيادية للخدمات',
                    'publisher' => [
                        '@id' => url('/') . '#organization',
                    ],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => url('/services') . '?q={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($sovereignSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>

    {{-- Third Party Analytics & Compliance Keys (Ready on API Keys) --}}
    @php
        $ga4Key = \App\Services\Integrations\SovereignIntegrationsManager::getKey('ga4', 'measurement_id');
        $csKey = \App\Services\Integrations\SovereignIntegrationsManager::getKey('contentsquare', 'project_id');
        $rcKey = \App\Services\Integrations\SovereignIntegrationsManager::getKey('recaptcha', 'site_key');
    @endphp

    @if($ga4Key)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4Key }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $ga4Key }}');
    </script>
    @endif

    @if($csKey)
    <script type="text/javascript">
        (function () {
            window._uxa = window._uxa || [];
            var c = document.createElement('script');
            c.type = 'text/javascript'; c.async = true;
            c.src = '//t.contentsquare.net/uxa/{{ $csKey }}.js';
            document.getElementsByTagName('head')[0].appendChild(c);
        })();
    </script>
    @endif

    @if($rcKey)
    <script src="https://www.google.com/recaptcha/api.js?render={{ $rcKey }}"></script>
    @endif

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/light-theme.css', 'resources/css/oasis-theme.css', 'resources/js/app.js'])

    {{-- Page-specific head --}}
    @stack('head')
</head>
@php
    // Sovereign Oasis scene engine — cinematic world-city & nature backdrops
    // curated from the Nawader asset vault (see resources/css/oasis-theme.css).
    $nwScene = match (true) {
        request()->routeIs('home') => 'kafd',
        request()->routeIs('services.*') => 'neom',
        request()->routeIs('pricing') => 'alula',
        request()->routeIs('about') => 'mandala',
        request()->routeIs('contact') => 'sea',
        request()->routeIs('studio') => 'cyber',
        request()->routeIs('app-builder') => 'bio',
        request()->routeIs('investor.*') => 'oasis',
        request()->routeIs('login', 'register', 'forgot', 'password.*', 'verify*') => 'aurora',
        request()->routeIs('help*') => 'glass',
        request()->routeIs('dashboard*') => 'abyss',
        default => 'kafd',
    };
@endphp
<body data-scene="{{ $nwScene }}" data-scene-persist="nw_landscape" class="{{ request()->routeIs('home') ? 'nw-page-home' : '' }} {{ request()->routeIs('dashboard.*') ? 'nw-dashboard-shell' : '' }}">

    {{-- 3D Dynamic Scenic Landscape Canvas Background --}}
    <canvas id="nw-canvas"></canvas>
    <div class="nw-cinematic-atmosphere" aria-hidden="true">
        <div class="nw-cinematic-atmosphere__grid"></div>
        <div class="nw-cinematic-atmosphere__orb nw-cinematic-atmosphere__orb--one"></div>
        <div class="nw-cinematic-atmosphere__orb nw-cinematic-atmosphere__orb--two"></div>
    </div>

    {{-- Dynamic Atmospheric Lighting Overlays --}}
    <div id="nw-atmosphere-glow" style="position:fixed;inset:0;pointer-events:none;z-index:0;transition:all 1.2s ease;"></div>

    {{-- Navbar --}}
    <nav class="nw-navbar" id="nw-navbar">
        <div class="nw-container">
            <div class="nw-navbar-inner">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="nw-logo" id="nw-logo">
                    <div class="nw-logo-mark">ن</div>
                    <span class="nw-logo-text"><span>نوادر</span></span>
                </a>

                {{-- Desktop Navigation --}}
                <ul class="nw-nav-links" id="nw-nav-links">
                    <li><a href="{{ route('services.index') }}" class="nw-nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">الخدمات</a></li>
                    <li><a href="{{ route('app-builder') }}" class="nw-nav-link {{ request()->routeIs('app-builder') ? 'active' : '' }}">بناء الأنظمة</a></li>
                    <li><a href="{{ route('studio') }}" class="nw-nav-link {{ request()->routeIs('studio') ? 'active' : '' }}">الأستديو السينمائي</a></li>
                    <li><a href="{{ route('pricing') }}" class="nw-nav-link {{ request()->routeIs('pricing') ? 'active' : '' }}">الأسعار</a></li>
                    <li><a href="{{ route('about') }}" class="nw-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">عن نوادر</a></li>
                    <li><a href="{{ route('contact') }}" class="nw-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">تواصل معنا</a></li>
                    <li><a href="{{ route('help') }}" class="nw-nav-link {{ request()->routeIs('help*') ? 'active' : '' }}">مركز المعرفة</a></li>
                    @auth
                    <li><a href="{{ route('dashboard') }}" class="nw-nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}">لوحتي</a></li>
                    @endauth
                </ul>

                {{-- CTA Buttons --}}
                <div class="nw-nav-cta">
                    @auth
                        <a href="{{ route('dashboard') }}" class="nw-btn nw-btn-ghost nw-btn-sm">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            لوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nw-btn nw-btn-ghost nw-btn-sm">دخول</a>
                        <a href="{{ route('register') }}" class="nw-btn nw-btn-primary nw-btn-sm">ابدأ الآن</a>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button class="nw-hamburger" id="nw-menu-toggle" aria-label="القائمة" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

            </div>
        </div>

        {{-- Mobile Drawer --}}
        <div class="nw-mobile-menu" id="nw-mobile-menu" aria-hidden="true">
            <div class="nw-mobile-menu-inner">
                <ul class="nw-mobile-links">
                    <li><a href="{{ route('services.index') }}">الخدمات</a></li>
                    <li><a href="{{ route('app-builder') }}">بناء الأنظمة السيادية</a></li>
                    <li><a href="{{ route('studio') }}">الأستديو السينمائي</a></li>
                    <li><a href="{{ route('pricing') }}">الأسعار</a></li>
                    <li><a href="{{ route('about') }}">عن نوادر</a></li>
                    <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
                    <li><a href="{{ route('help') }}">مركز المعرفة</a></li>
                    @auth
                    <li><a href="{{ route('dashboard') }}">لوحتي</a></li>
                    @else
                    <li><a href="{{ route('login') }}">دخول</a></li>
                    <li><a href="{{ route('register') }}">إنشاء حساب</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="nw-page-content" id="nw-main">
        @yield('content')
    </main>

    {{-- Dynamic Landscape & Sovereign Typography Floating Controls --}}
    <div id="nw-floating-controls" style="position:fixed;bottom:24px;left:24px;z-index:99990;font-family:var(--font-arabic);display:flex;flex-direction:column;gap:8px;">
        {{-- Sovereign Typography Switcher --}}
        <div style="background:rgba(15,23,40,0.92);backdrop-filter:blur(25px);border:1px solid rgba(0,212,200,0.3);border-radius:30px;padding:4px 10px;display:flex;align-items:center;gap:5px;box-shadow:0 10px 30px rgba(0,0,0,0.5);">
            <span style="font-size:0.75rem;color:var(--nawader-teal);font-weight:700;padding-right:2px;">الخط:</span>
            <button class="ls-btn font-switch-btn active" data-font="tajawal" onclick="changeSovereignFont('tajawal', this)">تجوّل</button>
            <button class="ls-btn font-switch-btn" data-font="plex" onclick="changeSovereignFont('plex', this)">بليكس</button>
            <button class="ls-btn font-switch-btn" data-font="cairo" onclick="changeSovereignFont('cairo', this)">القاهرة</button>
            <button class="ls-btn font-switch-btn" data-font="amiri" onclick="changeSovereignFont('amiri', this)">الأميري</button>
            <span style="border-left:1px solid rgba(255,255,255,0.1);height:14px;margin:0 2px;"></span>
            <button class="ls-btn" onclick="adjustFontSize(-1)" title="تصغير حجم الخط" style="padding:2px 6px;">A-</button>
            <button class="ls-btn" onclick="adjustFontSize(1)" title="تكبير حجم الخط" style="padding:2px 6px;">A+</button>
        </div>

        {{-- Dynamic Landscape Atmosphere Switcher — real scenes from the sovereign vault --}}
        <div>
            <span style="font-size:0.75rem;color:var(--text-muted);padding-right:4px;">المنظر:</span>
            <button class="ls-btn scene-btn active" data-scene-name="kafd" onclick="changeLandscape('kafd', this)" title="أفق الرياض ومركز الملك عبدالله المالي">🏙️ الرياض</button>
            <button class="ls-btn scene-btn" data-scene-name="alula" onclick="changeLandscape('alula', this)" title="رمال العلا الذهبية">🏜️ العلا</button>
            <button class="ls-btn scene-btn" data-scene-name="neom" onclick="changeLandscape('neom', this)" title="مدن نيوم الذكية">🌆 نيوم</button>
            <button class="ls-btn scene-btn" data-scene-name="sea" onclick="changeLandscape('sea', this)" title="محيط البحر وجدة">🌊 البحر</button>
            <button class="ls-btn scene-btn" data-scene-name="oasis" onclick="changeLandscape('oasis', this)" title="واحة الصحراء البلورية">🐪 الواحة</button>
            <button class="ls-btn scene-btn" data-scene-name="mandala" onclick="changeLandscape('mandala', this)" title="المدينة العربية الهندسية">🕌 عالمية</button>
        </div>
    </div>

    {{-- Floating Sovereign AI Chat Assistant --}}
    @include('components.ai-chat-widget')

    {{-- Sovereign Privacy & CookieYes Consent Banner --}}
    @include('components.cookie-banner')

    {{-- Footer --}}
    @unless(isset($hideFooter) && $hideFooter)
    <footer class="nw-footer">
        <div class="nw-container">
            <div class="nw-footer-grid">
                {{-- Brand --}}
                <div>
                    <div class="nw-logo" style="margin-bottom: 1.25rem;">
                        <div class="nw-logo-mark">ن</div>
                        <span class="nw-logo-text"><span>نوادر</span></span>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.8; max-width: 280px;">
                        منصة الخدمات الحكومية والاستشارية السيادية المتكاملة — شفافية كاملة، أمان مصرفي، بلا احتكاك.
                    </p>
                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <a href="https://x.com" target="_blank" class="nw-footer-social" aria-label="منصة X">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.258 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://linkedin.com" target="_blank" class="nw-footer-social" aria-label="لينكدإن">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="https://wa.me/966501234567" target="_blank" class="nw-footer-social" aria-label="واتساب">
                            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Services --}}
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem;">القطاعات والخدمات</h4>
                    <ul style="display: flex; flex-direction: column; gap: 0.6rem; list-style: none;">
                        <li><a href="{{ route('services.index') }}" class="nw-footer-link">الكتالوج الهرمي (20 قطاعاً)</a></li>
                        <li><a href="{{ route('studio') }}" class="nw-footer-link">أستديو نوادر السينمائي</a></li>
                        <li><a href="{{ route('app-builder') }}" class="nw-footer-link">بناء الأنظمة والتطبيقات</a></li>
                        <li><a href="{{ route('services.category', 'legal') }}" class="nw-footer-link">تأسيس الشركات والقانون</a></li>
                        <li><a href="{{ route('pricing') }}" class="nw-footer-link">حاسبة الأسعار الفورية</a></li>
                        <li><a href="{{ route('investor.index') }}" class="nw-footer-link">بوابة المستثمر السيادي</a></li>
                    </ul>
                </div>

                {{-- Company & Ecosystem --}}
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem;">المنظومة والربط</h4>
                    <ul style="display: flex; flex-direction: column; gap: 0.6rem; list-style: none;">
                        <li><a href="{{ route('dashboard.affiliate') }}" class="nw-footer-link">التسويق بالعمولة</a></li>
                        <li><a href="{{ route('dashboard.developer') }}" class="nw-footer-link">بوابة المطورين و الـ APIs</a></li>
                        <li><a href="{{ route('dashboard.ai-studio') }}" class="nw-footer-link">أستديو الذكاء الاصطناعي</a></li>
                        <li><a href="{{ route('about') }}" class="nw-footer-link">عن نوادر ورؤية 2030</a></li>
                        <li><a href="{{ route('contact') }}" class="nw-footer-link">تواصل معنا ومراكزنا</a></li>
                        <li><a href="{{ route('help') }}" class="nw-footer-link">مركز المعرفة والتشريعات</a></li>
                    </ul>
                </div>

                {{-- Legal --}}
                <div>
                    <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1.25rem;">الامتثال والقانون</h4>
                    <ul style="display: flex; flex-direction: column; gap: 0.6rem; list-style: none;">
                        <li><a href="{{ route('privacy') }}" class="nw-footer-link">سياسة الخصوصية (PDPL)</a></li>
                        <li><a href="{{ route('terms') }}" class="nw-footer-link">شروط الاستخدام والتحكيم</a></li>
                        <li><a href="{{ route('refund') }}" class="nw-footer-link">سياسة الاسترداد والضمان</a></li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Bar --}}
            <div class="nw-footer-bottom">
                <span>© {{ date('Y') }} نوادر — المملكة العربية السعودية والولايات المتحدة الأمريكية. جميع الحقوق محفوظة.</span>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="nw-badge nw-badge-teal">
                        <span class="nw-badge-dot"></span>
                        جميع الأنظمة والمحركات تعمل
                    </span>
                    <span style="color: var(--text-muted); font-size: 0.78rem;">SDAIA & SAMA & SEC Compliant</span>
                </div>
            </div>
        </div>
    </footer>
    @endunless

    {{-- Landscape Switcher Styles --}}
    <style>
    .ls-btn {
        background: transparent; border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;
        padding: 3px 8px; font-size: 0.72rem; color: var(--text-muted); cursor: pointer;
        transition: all 0.2s; font-family: var(--font-arabic);
    }
    .ls-btn:hover, .ls-btn.active {
        background: rgba(212,168,67,0.18); border-color: var(--nawader-gold); color: var(--nawader-gold); font-weight: 700;
    }
    </style>

    <script>
    function changeLandscape(name, btn) {
        document.querySelectorAll('#nw-floating-controls .ls-btn:not(.font-switch-btn):not([onclick^="adjustFontSize"])').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        localStorage.setItem('nw_landscape', name);
        if (window.nawaderSpace && window.nawaderSpace.setLandscape) {
            window.nawaderSpace.setLandscape(name);
        }
    }

    function changeSovereignFont(fontName, btn) {
        document.querySelectorAll('.font-switch-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        document.documentElement.setAttribute('data-font', fontName);
        document.body.setAttribute('data-font', fontName);
        localStorage.setItem('nw_font', fontName);
    }

    let currentFontScale = 100;
    function adjustFontSize(delta) {
        currentFontScale = Math.max(85, Math.min(130, currentFontScale + (delta * 5)));
        document.documentElement.style.fontSize = currentFontScale + '%';
        localStorage.setItem('nw_font_scale', currentFontScale);
    }

    // ── Sovereign Oasis scene switcher (real vault backdrops) ──
    const NW_SCENE_LEGACY = { bilateral: 'sea', kafd: 'kafd', alula: 'alula', neom: 'neom' };

    window.changeLandscape = function (name, btn) {
        const valid = ['kafd', 'alula', 'neom', 'sea', 'oasis', 'mandala'];
        const scene = valid.includes(name) ? name : 'kafd';
        document.body.dataset.scene = scene;
        localStorage.setItem('nw_landscape', scene);
        document.querySelectorAll('#nw-floating-controls .scene-btn').forEach(b => b.classList.remove('active'));
        if (btn) btn.classList.add('active');
        const img = new Image();
        img.src = '/images/scenes/' + ({
            kafd: 'home-city', alula: 'desert-gold', neom: 'smart-city',
            sea: 'ocean', oasis: 'oasis', mandala: 'mandala-city'
        }[scene]) + '.webp';
    };

    document.addEventListener('DOMContentLoaded', () => {
        const raw = localStorage.getItem('nw_landscape') || 'kafd';
        const savedLandscape = NW_SCENE_LEGACY[raw] || raw;
        const targetLsBtn = document.querySelector(`.scene-btn[data-scene-name="${savedLandscape}"]`);
        document.querySelectorAll('#nw-floating-controls .scene-btn').forEach(b => b.classList.remove('active'));
        if (targetLsBtn) {
            changeLandscape(savedLandscape, targetLsBtn);
        } else {
            localStorage.setItem('nw_landscape', 'kafd');
            const fallback = document.querySelector('.scene-btn[data-scene-name="kafd"]');
            changeLandscape('kafd', fallback);
        }

        // PWA Service Worker — offline shell & instant repeat visits
        if ('serviceWorker' in navigator && !window.location.hostname.startsWith('127.')) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js', { scope: '/' }).catch(() => {});
            });
        }

        const savedFont = localStorage.getItem('nw_font') || 'tajawal';
        const targetFontBtn = document.querySelector(`.font-switch-btn[data-font="${savedFont}"]`);
        changeSovereignFont(savedFont, targetFontBtn);

        const savedScale = localStorage.getItem('nw_font_scale');
        if (savedScale) {
            currentFontScale = parseInt(savedScale, 10);
            document.documentElement.style.fontSize = currentFontScale + '%';
        }
    });
    </script>

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>
