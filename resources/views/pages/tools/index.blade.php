@extends('layouts.app')

@section('title', 'أدوات نوادر السيادية المجانية — حاسبة الضريبة، الآيبان، نطاقات، والباركود')
@section('meta_description', 'باقة الأدوات الرقمية السيادية المجانية لرواد الأعمال والشركات في السعودية: حاسبة ضريبة القيمة المضافة 15%، مولد QR، فحص الآيبان، حاسبة نطاقات، والفوترة الإلكترونية زاتكا.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container">

        {{-- Hero Header --}}
        <div class="nw-cinematic-panel" style="padding: 3rem 2.5rem; text-align: center; margin-bottom: 3rem; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 350px; height: 180px; background: radial-gradient(circle, rgba(0, 212, 200, 0.25) 0%, transparent 70%); pointer-events: none;"></div>
            
            <div class="nw-section-eyebrow" style="display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem;">
                <span>🛠️</span>
                <span>منظومة التسهيلات الرقمية العامة</span>
            </div>
            
            <h1 style="font-size: 2.6rem; font-weight: 900; color: #fff; margin-bottom: 1rem; line-height: 1.3;">
                أدوات نوادر <span class="nw-text-gradient-gold">السيادية المجانية</span> للأعمال
            </h1>
            
            <p style="color: var(--text-secondary); max-width: 740px; margin: 0 auto 2rem; font-size: 1.05rem; line-height: 1.85;">
                مجموعة متكاملة من الأدوات والآلات الحاسبة الدقيقة المصممة وفق أحدث التشريعات والأنظمة في المملكة العربية السعودية (هيئة الزكاة والضريبة، البنك المركزي، وزارة الموارد البشرية، ووزارة التجارة). خدمات مجانية 100% بدون تسجيل أو تخزين لبياناتك.
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <span class="nw-badge nw-badge-teal">
                    <span class="nw-badge-dot"></span> متوافقة مع أنظمة زاتكا وساما 2026
                </span>
                <span class="nw-badge nw-badge-gold">
                    ⚡ حسابات فورية مشفرة في المتصفح
                </span>
                <span class="nw-badge nw-badge-navy">
                    🔒 خصوصية كاملة دون حفظ بيانات
                </span>
            </div>
        </div>

        {{-- Tools Grid --}}
        <div class="nw-grid nw-grid-3" style="gap: 1.75rem; margin-bottom: 4rem;">

            {{-- 1. VAT Calculator --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-gold);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(212,168,67,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(212,168,67,0.25);">
                            🧾
                        </span>
                        <span class="nw-badge nw-badge-gold">ZATCA 15%</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">حاسبة ضريبة القيمة المضافة</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        احسب ضريبة القيمة المضافة (15%) بدقة للمبالغ الشاملة وغير الشاملة للضريبة، مع دعم التوليد الفوري لباركود الفوترة الإلكترونية زاتكا.
                    </p>
                </div>
                <a href="{{ route('tools.vat') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    فتح الحاسبة ←
                </a>
            </div>

            {{-- 2. IBAN Validator --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-teal);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(0,212,200,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(0,212,200,0.25);">
                            🏦
                        </span>
                        <span class="nw-badge nw-badge-teal">SAMA Standard</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">فحص الآيبان والبنوك السعودية</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        تحقق من صحة أرقام الآيبان البنكية السعودية والدولية بخوارزمية MOD-97 واكتشف اسم البنك، رمز السويفت (SWIFT) تلقائياً.
                    </p>
                </div>
                <a href="{{ route('tools.iban') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    فحص الآيبان ←
                </a>
            </div>

            {{-- 3. Nitaqat Saudization --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid #00C853;">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(0,200,83,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(0,200,83,0.25);">
                            🇸🇦
                        </span>
                        <span class="nw-badge nw-badge-teal">HRSD نطاقات</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">حاسبة نسب التوطين (نطاقات)</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        احسب نسبة التوطين لشركتك وتعرف على نطاق المنشأة (أحمر، أخضر، بلاتيني) وعدد الموظفين السعوديين المطلوبين للترقية للنطاق الأعلى.
                    </p>
                </div>
                <a href="{{ route('tools.nitaqat') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    حساب التوطين ←
                </a>
            </div>

            {{-- 4. QR Code Studio --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-gold);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(212,168,67,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(212,168,67,0.25);">
                            📱
                        </span>
                        <span class="nw-badge nw-badge-gold">فوري بدقة عالية</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">صانع الباركود والـ QR الذكي</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        أنشئ رموز QR احترافية للروابط، شبكات الواي فاي، بطاقات الأعمال (vCard)، أرقام الواتساب، وبيانات الفواتير بوضوح فائق جاهزة للطباعة.
                    </p>
                </div>
                <a href="{{ route('tools.qr') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    توليد QR مجاني ←
                </a>
            </div>

            {{-- 5. Currency Converter --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-teal);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(0,212,200,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(0,212,200,0.25);">
                            💱
                        </span>
                        <span class="nw-badge nw-badge-teal">سعر ساما الرسمي</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">محول العملات (الريال والدولار)</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        تحويل فوري دقيق مبني على سعر الربط الرسمي للريال بالدولار (3.7500) وأحدث أسعار العملات الخليجية والدولية (اليورو، الجنيه الإسترليني).
                    </p>
                </div>
                <a href="{{ route('tools.currency') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    تحويل العملات ←
                </a>
            </div>

            {{-- 6. Commercial Registration Checker --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-gold);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(212,168,67,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(212,168,67,0.25);">
                            🏛️
                        </span>
                        <span class="nw-badge nw-badge-gold">وزارة التجارة</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">فحص هيكل السجل التجاري</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        تحقق من صحة تنسيق رقم السجل التجاري المكون من 10 أرقام، واكتشف منطقة الإصدار والجهة القضائية المختصة، مع رابط التحقق المباشر.
                    </p>
                </div>
                <a href="{{ route('tools.cr') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    فحص السجل ←
                </a>
            </div>

            {{-- 7. ZATCA Invoice Maker --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-teal);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(0,212,200,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(0,212,200,0.25);">
                            📑
                        </span>
                        <span class="nw-badge nw-badge-teal">فاتورة معتمدة</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">صانع الفواتير المتوافقة مع زاتكا</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        أنشئ فواتير ضريبية مبسطة احترافية كاملة البنود مع الباركود المشفر TLV وخيارات التحميل والطباعة الفورية بصيغة PDF.
                    </p>
                </div>
                <a href="{{ route('tools.invoice') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    إنشاء فاتورة ←
                </a>
            </div>

            {{-- 8. Business Name Generator --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 3px solid var(--nawader-gold);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: rgba(212,168,67,0.12); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; border: 1px solid rgba(212,168,67,0.25);">
                            💡
                        </span>
                        <span class="nw-badge nw-badge-gold">متوافق نظاماً</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">مولد الأسماء التجارية المتوافق</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        اقتراحات أسماء تجارية عربية راقية متوافقة مع اشتراطات وزارة التجارة السعودية وتفادي الكلمات المحظورة مع إرفاق الكيان القانوني.
                    </p>
                </div>
                <a href="{{ route('tools.business-names') }}" class="nw-btn nw-btn-primary nw-btn-sm" style="width: 100%; justify-content: center;">
                    توليد أسماء تجارية ←
                </a>
            </div>

            {{-- 9. Custom Sovereign Builder Hub --}}
            <div class="nw-card nw-card-interactive" style="display: flex; flex-direction: column; justify-content: space-between; background: linear-gradient(135deg, rgba(212,168,67,0.1) 0%, rgba(0,212,200,0.1) 100%); border: 1px solid var(--nawader-gold);">
                <div>
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <span style="font-size: 2.2rem; background: var(--grad-gold); color: var(--nawader-navy); width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; font-weight: 900;">
                            ن
                        </span>
                        <span class="nw-badge nw-badge-gold">طلب مخصص</span>
                    </div>
                    <h3 style="font-size: 1.3rem; color: #fff; font-weight: 800; margin-bottom: 0.6rem;">هل تبحث عن حل سيادي متكامل؟</h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.75; margin-bottom: 1.25rem;">
                        انتقل إلى أستديو نوادر لتصميم وتأسيس الشركات، صياغة العقود الموثقة إلكترونياً، والربط المؤسسي مع كافة المنصات الحكومية.
                    </p>
                </div>
                <a href="{{ route('services.index') }}" class="nw-btn nw-btn-gold nw-btn-sm" style="width: 100%; justify-content: center;">
                    استكشاف الخدمات السيادية ←
                </a>
            </div>

        </div>

        {{-- Trust & Standards Banner --}}
        <div class="nw-cinematic-panel" style="padding: 2.5rem; text-align: center;">
            <div class="nw-grid nw-grid-4" style="gap: 1.5rem;">
                <div>
                    <div style="font-size: 1.8rem; margin-bottom: 0.5rem;">🇸🇦</div>
                    <h4 style="color: #fff; font-size: 1rem; margin-bottom: 0.3rem;">معايير المملكة 100%</h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">مطابقة تماماً للوائح زاتكا ومؤسسة النقد ووزارة التجارة.</p>
                </div>
                <div>
                    <div style="font-size: 1.8rem; margin-bottom: 0.5rem;">🛡️</div>
                    <h4 style="color: #fff; font-size: 1rem; margin-bottom: 0.3rem;">حماية الخصوصية PDPL</h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">العمليات الحسابية تتم محلياً دون تخزين بيانات المستخدمين.</p>
                </div>
                <div>
                    <div style="font-size: 1.8rem; margin-bottom: 0.5rem;">⚡</div>
                    <h4 style="color: #fff; font-size: 1rem; margin-bottom: 0.3rem;">استجابة لحظية</h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">حسابات فورية بضغطة زر وتصدير عالي الدقة.</p>
                </div>
                <div>
                    <div style="font-size: 1.8rem; margin-bottom: 0.5rem;">🆓</div>
                    <h4 style="color: #fff; font-size: 1rem; margin-bottom: 0.3rem;">مجانية بالكامل</h4>
                    <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">متاحة للجميع دعماً لبيئة الأعمال والشركات الناشئة.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
