@extends('layouts.app')

@section('title', 'مولد الأسماء التجارية المتوافق مع وزارة التجارة السعودية — نوادر')
@section('meta_description', 'ابتكر أسماء تجارية عربية راقية متوافقة مع نظام الأسماء التجارية السعودي والكيانات النظامية (ذ.م.م، مساهمة مبسطة، مؤسسة) مع فحص المحظورات.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-gold">نظام الأسماء التجارية السعودي</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">💡</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                مولد <span class="nw-text-gradient-gold">الأسماء التجارية</span> المتوافق
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                ابتكر اسماً تجارياً مميزاً لشركتك يتوافق تماماً مع اشتراطات وزارة التجارة السعودية وقواعد حجز الأسماء التجارية، مع تحديد الكيان النظامي والنشاط الاقتصادي.
            </p>
        </div>

        {{-- Generator Card --}}
        <div class="nw-card" style="padding: 2.5rem; border-top: 3px solid var(--nawader-gold); margin-bottom: 2rem;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                {{-- Sector --}}
                <div>
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">القطاع ومجال العمل *</label>
                    <select id="biz-sector" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; outline: none; font-family: var(--font-arabic);">
                        <option value="tech" style="background:#0c1222;">التقنية والذكاء الاصطناعي والحلول الرقمية</option>
                        <option value="consulting" style="background:#0c1222;">الاستشارات الإدارية والقانونية والمالية</option>
                        <option value="realestate" style="background:#0c1222;">العقارات والمقاولات والتطوير العمراني</option>
                        <option value="logistics" style="background:#0c1222;">الخدمات اللوجستية وسلاسل الإمداد</option>
                        <option value="trade" style="background:#0c1222;">التجارة العامة والاستيراد والتصدير</option>
                        <option value="hospitality" style="background:#0c1222;">السياحة والفعاليات والضيافة</option>
                    </select>
                </div>

                {{-- Legal Entity --}}
                <div>
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">الكيان القانوني المقترح *</label>
                    <select id="biz-legal" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; outline: none; font-family: var(--font-arabic);">
                        <option value="llc" style="background:#0c1222;">شركة ذات مسؤولية محدودة (ذ.م.م)</option>
                        <option value="sjc" style="background:#0c1222;">شركة مساهمة مبسطة</option>
                        <option value="single" style="background:#0c1222;">شركة الشخص الواحد (ذ.م.م)</option>
                        <option value="est" style="background:#0c1222;">مؤسسة فردية</option>
                        <option value="holding" style="background:#0c1222;">شركة قابضة</option>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">طابع وهوية الاسم</label>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="biz-style-btn active" data-style="sovereign" onclick="setBizStyle('sovereign', this)">فخم وسيادي</button>
                    <button type="button" class="biz-style-btn" data-style="modern" onclick="setBizStyle('modern', this)">عصري ومبتكر</button>
                    <button type="button" class="biz-style-btn" data-style="authentic" onclick="setBizStyle('authentic', this)">عربي أصيل</button>
                    <button type="button" class="biz-style-btn" data-style="global" onclick="setBizStyle('global', this)">عالمي النطاق</button>
                </div>
            </div>

            <button type="button" onclick="generateNamesLive()" class="nw-btn nw-btn-primary" style="width: 100%; justify-content: center; font-size: 1.05rem;">
                توليد اقتراحات الأسماء التجارية ⚡
            </button>

            {{-- Results Area --}}
            <div id="biz-results-container" style="margin-top: 2rem; display: none;">
                <h4 style="color: #fff; font-size: 1.05rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: space-between;">
                    <span>✨ الأسماء المقترحة مع التوصيف القانوني</span>
                    <span class="nw-badge nw-badge-teal">جاهزة للحجز المبدئي</span>
                </h4>

                <div id="biz-cards-grid" style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                </div>
            </div>

        </div>

        {{-- Ministry Rules Info --}}
        <div class="nw-cinematic-panel" style="padding: 2rem;">
            <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1rem;">
                📜 ضوابط حجز الاسم التجاري لدى وزارة التجارة السعودية
            </h3>
            <ul style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.85; padding-right: 1.25rem;">
                <li>يجب أن يتكون الاسم التجاري من ألفاظ عربية ذات معنى وألا يكون مخالفاً للنظام العام أو الآداب.</li>
                <li>يُحظر استخدام لفظ الجلالة أو أسماء الهيئات الحكومية أو الشعارات السيادية بدون إذن رسمي.</li>
                <li>يجب ألا يكون الاسم مطابقاً أو مشابهاً لاسم تجاري مقيد أو علامة تجارية مسجلة مسبقاً.</li>
                <li>يجب أن ينتهي الاسم بالصفة القانونية للكيان (مثل: ذ.م.م أو مساهمة مبسطة).</li>
            </ul>
        </div>

    </div>
</div>

<style>
.biz-style-btn {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    color: var(--text-secondary);
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
    font-family: var(--font-arabic);
    cursor: pointer;
    transition: all 0.2s;
}
.biz-style-btn.active {
    background: rgba(212,168,67,0.18);
    border-color: var(--nawader-gold);
    color: #fff;
    font-weight: 700;
}
</style>

@push('scripts')
<script>
let currentBizStyle = 'sovereign';

const nameBank = {
    tech: {
        sovereign: ['سند للحلول البرمجية', 'رائد للذكاء والأنظمة', 'آفاق السيادة الرقمية', 'وسام التقنية المتقدمة', 'أركان الحوسبة السحابية'],
        modern: ['نوفا تك', 'سينرجيا للبرمجيات', 'كلاودكس الرقمية', 'أومني للذكاء الاصطناعي', 'لوجيكس تكنولوجي'],
        authentic: ['بصيرة للتقنية', 'منارة البيانات', 'إتقان للحلول الذكية', 'فصيح للذكاء الاصطناعي', 'برهان للأنظمة'],
        global: ['غلوبال تيك السعودية', 'أكسيس الدولية للبرمجيات', 'إنفينيتي كلاود', 'نيكست سولوشنز', 'ماتريكس العالمية']
    },
    consulting: {
        sovereign: ['دار الحكمة للاستشارات', 'مرساة الأعمال والحلول', 'نخبة المستشارين', 'وثيق للاستشارات القانونية', 'سداد للإدارة المالية'],
        modern: ['برايم كونسلتنج', 'فيجن 360 للاستشارات', 'أكسيل الاستشارية', 'ستراتيجي بارتنرز', 'كابيتال ون للاستشارات'],
        authentic: ['شورى للحلول الاستشارية', 'رشاد لإدارة الأعمال', 'حصافة للاستشارات', 'سديد للخبرات الإدارية', 'منهاج للحوكمة'],
        global: ['غلوبال أدفايزرز', 'إنترناشيونال بارتنرز', 'ألاينس الاستشارية', 'بريميير كونسلتنج', 'كريدنس الدولية']
    },
    realestate: {
        sovereign: ['رواسي للتطوير العمراني', 'شوامخ العقارية', 'صروح الرياض للتطوير', 'أوتاد للاستثمار العقاري', 'ديار النخبة'],
        modern: ['إربان سبيس للتطوير', 'أوبيكس العقارية', 'متروبوليس لإدارة الأصول', 'فيوتشر هومز', 'برايم بروبيرتيز'],
        authentic: ['منازل الأصالة', 'عمران ورياض', 'الدار العامرة', 'سكنى للتطوير', 'مرباع العقارية'],
        global: ['غلوبال استيتس', 'إنترناشيونال لاندز', 'ريالتي بارتنرز', 'كراون بروبيرتيز', 'أطلس العقارية']
    },
    logistics: {
        sovereign: ['جواسر للخدمات اللوجستية', 'أسرع للنقل والتخزين', 'معراج لسلاسل الإمداد', 'طريق الحرير للخدمات اللوجستية', 'قافلة النقل'],
        modern: ['فاست تراك لوجستكس', 'كارغو بلس', 'أومني فريت', 'إكسبريس واي', 'فلكس لوجستيك'],
        authentic: ['بريد وسفانة', 'ركائب للنقل', 'مدار لسلاسل التوريد', 'مسار اللوجستية', 'وصول السريعة'],
        global: ['غلوبال لوجستكس نتورك', 'إنترناشيونال كارغو', 'عالم الشحن السريع', 'ترانس وورلد', 'كونتيننتال فريت']
    },
    trade: {
        sovereign: ['روافد التجارة العامة', 'ثروات الشرق للاستيراد', 'ذروة التجارة والاستثمار', 'المورد السيادي للتجارة', 'أمجاد التجارية'],
        modern: ['تريدينغ هاب', 'إمبورت إكس', 'أبيكس تريدرز', 'نكست كونسيبت', 'إليت للتجارة'],
        authentic: ['أسواق اليمامة', 'خيرات نجد', 'بركة للتجارة العامة', 'تجارة المجد', 'رحاب التوريد'],
        global: ['غلوبال تريدينغ كورب', 'إنترناشيونال ميرشانتس', 'ورلد وايد إمبورتس', 'ترانس تريد', 'أوشن التجارية']
    },
    hospitality: {
        sovereign: ['قصور الضيافة العربية', 'مكارم للفعاليات والسياحة', 'أصول الترفيه', 'ضيافة النبلاء', 'واحة الفخامة'],
        modern: ['إكسبيرينس بلس', 'إيفنت مايندز', 'هوسبيتاليتي لاب', 'فايبز إنترتينمنت', 'رويال فيستفال'],
        authentic: ['حفاوة ومهباش', 'ديوان الكرم', 'مجلس الوفاء', 'ليالي طويق', 'عبير الخزامى للضيافة'],
        global: ['غلوبال إيفنتس أند هوسبيتاليتي', 'إنترناشيونال ريزورتس', 'لوكسوري ترافل', 'أواسيس العالمية', 'جراند هوسبيتاليتي']
    }
};

const legalSuffixMap = {
    llc: 'شركة ذات مسؤولية محدودة',
    sjc: 'شركة مساهمة مبسطة',
    single: 'شركة شخص واحد ذات مسؤولية محدودة',
    est: 'مؤسسة فردية',
    holding: 'شركة قابضة (ذ.م.م)'
};

function setBizStyle(style, btn) {
    currentBizStyle = style;
    document.querySelectorAll('.biz-style-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    generateNamesLive();
}

function generateNamesLive() {
    const sector = document.getElementById('biz-sector').value;
    const legal = document.getElementById('biz-legal').value;
    const suffix = legalSuffixMap[legal] || '';

    const list = (nameBank[sector] && nameBank[sector][currentBizStyle]) || nameBank.tech.sovereign;
    const container = document.getElementById('biz-results-container');
    const grid = document.getElementById('biz-cards-grid');

    container.style.display = 'block';
    grid.innerHTML = '';

    list.forEach(name => {
        const fullName = `${name} — ${suffix}`;
        const card = document.createElement('div');
        card.style.cssText = "padding: 1.25rem 1.5rem; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;";
        card.innerHTML = `
            <div>
                <div style="font-size: 1.15rem; font-weight: 800; color: #fff; margin-bottom: 0.25rem;">${fullName}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">متوافق مع اشتراطات وزارة التجارة السعودية وتصنيف الأنشطة ISIC4</div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button type="button" onclick="copyName('${fullName}')" class="nw-btn nw-btn-ghost nw-btn-sm">نسخ الاسم 📋</button>
                <a href="https://mc.gov.sa/ar/eservices/Pages/ServiceDetails.aspx?sId=18" target="_blank" rel="noopener noreferrer" class="nw-btn nw-btn-primary nw-btn-sm">حجز لدى الوزارة ↗</a>
            </div>
        `;
        grid.appendChild(card);
    });
}

function copyName(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert("تم نسخ الاسم التجاري بنجاح!");
    });
}
</script>
@endpush
@endsection
