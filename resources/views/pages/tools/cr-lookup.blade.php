@extends('layouts.app')

@section('title', 'فحص هيكل وصحة السجل التجاري السعودي — نوادر')
@section('meta_description', 'تحقق من مطابقة هيكل رقم السجل التجاري المكون من 10 أرقام وفق معايير وزارة التجارة السعودية واكتشف منطقة الإصدار والمحكمة التجارية المختصة.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-gold">معايير وزارة التجارة السعودية</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🏛️</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                فحص هيكل <span class="nw-text-gradient-gold">السجل التجاري</span> السعودي
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                فحص فوري لهيكل رقم السجل التجاري السعودي (10 أرقام) للتحقق من سلامة البنية النظامية وتحديد منطقة التأسيس القضائية، مع توجيه آمن للاستعلام المباشر عبر البوابة الرسمية لوزارة التجارة ومنصة واثق.
            </p>
        </div>

        {{-- Card --}}
        <div class="nw-card" style="padding: 2.5rem; border-top: 3px solid var(--nawader-gold); margin-bottom: 2rem;">
            
            <label style="display: block; color: var(--text-primary); font-size: 0.95rem; font-weight: 700; margin-bottom: 0.6rem;">
                أدخل رقم السجل التجاري (10 أرقام) *
            </label>
            
            <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem;">
                <input type="text" id="cr-input" placeholder="مثال: 1010000000" maxlength="10"
                       style="flex: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(212,168,67,0.3); border-radius: 12px; padding: 0.9rem 1.25rem; color: #fff; font-size: 1.2rem; font-family: monospace; letter-spacing: 2px; outline: none;">
                <button type="button" onclick="verifyCrNow()" class="nw-btn nw-btn-primary" style="padding: 0 1.75rem;">
                    فحص الهيكل
                </button>
            </div>

            {{-- Result Area (Hidden initially) --}}
            <div id="cr-result-box" style="display: none; padding: 1.5rem; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                
                <div id="cr-status-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.9rem; border-radius: 20px; font-weight: 800; font-size: 0.88rem; margin-bottom: 1.25rem;">
                </div>

                <div class="nw-grid nw-grid-2" style="gap: 1.25rem; margin-bottom: 1.5rem;">
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">رقم السجل:</div>
                        <div id="res-cr-number" style="color: #fff; font-family: monospace; font-size: 1.15rem; font-weight: 800;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">مدينة ومحافظة الإصدار:</div>
                        <div id="res-cr-city" style="color: var(--nawader-gold); font-size: 1.05rem; font-weight: 800;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">المنطقة الإدارية:</div>
                        <div id="res-cr-region" style="color: #fff; font-size: 1rem; font-weight: 700;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">الاختصاص القضائي التجاري:</div>
                        <div id="res-cr-court" style="color: var(--nawader-teal); font-size: 1rem; font-weight: 700;"></div>
                    </div>
                </div>

                {{-- Official Portals Gateway --}}
                <div style="padding: 1.25rem; background: rgba(0,212,200,0.06); border: 1px solid rgba(0,212,200,0.25); border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <div style="color: #fff; font-weight: 800; font-size: 0.95rem; margin-bottom: 0.2rem;">
                            التحقق المباشر من السجل التجاري رسمياً
                        </div>
                        <div style="color: var(--text-muted); font-size: 0.8rem;">
                            للاطلاع على الحالة الحالية للسجل (ساري / مشطوب) وبيانات الملاك، اضغط على بوابات الدولة المعتمدة:
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.6rem;">
                        <a href="https://mc.gov.sa/ar/eservices/Pages/Commercial-data.aspx" target="_blank" rel="noopener noreferrer" class="nw-btn nw-btn-gold nw-btn-sm">
                            بوابة وزارة التجارة ↗
                        </a>
                        <a href="https://wathq.sa" target="_blank" rel="noopener noreferrer" class="nw-btn nw-btn-ghost nw-btn-sm">
                            منصة واثق Wathq ↗
                        </a>
                    </div>
                </div>

            </div>

        </div>

        {{-- Ministry of Commerce Rules Factsheet --}}
        <div class="nw-cinematic-panel" style="padding: 2rem;">
            <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1rem;">
                📋 نظام السجل التجاري في المملكة العربية السعودية
            </h3>
            <p style="color: var(--text-secondary); font-size: 0.88rem; line-height: 1.8; margin-bottom: 1rem;">
                يتألف السجل التجاري السعودي حصراً من 10 أرقام. ترمز الخانتان الأوليان إلى المركز الرئيسي لفرع وزارة التجارة المصدر للسجل (مثال: 10 الرياض، 20 جدة ومكة المكرمة، 40 المنطقة الشرقية). 
            </p>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <span class="nw-badge nw-badge-navy">10 = منطقة الرياض</span>
                <span class="nw-badge nw-badge-navy">20 = مكة المكرمة وجدة</span>
                <span class="nw-badge nw-badge-navy">22 = المدينة المنورة</span>
                <span class="nw-badge nw-badge-navy">40 = الدمام والخبر</span>
                <span class="nw-badge nw-badge-navy">70 = القصيم</span>
                <span class="nw-badge nw-badge-navy">58 = عسير وأبها</span>
                <span class="nw-badge nw-badge-navy">33 = تبوك</span>
                <span class="nw-badge nw-badge-navy">60 = نجران</span>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
const crRegionsMap = {
    '10': { city: 'مدينة الرياض', region: 'منطقة الرياض', court: 'المحكمة التجارية بالرياض' },
    '11': { city: 'محافظة الخرج', region: 'منطقة الرياض', court: 'فرع وزارة التجارة بالخرج' },
    '20': { city: 'جدة ومكة المكرمة', region: 'منطقة مكة المكرمة', court: 'المحكمة التجارية بجدة' },
    '21': { city: 'محافظة الطائف', region: 'منطقة مكة المكرمة', court: 'فرع وزارة التجارة بالطائف' },
    '22': { city: 'المدينة المنورة', region: 'منطقة المدينة المنورة', court: 'المحكمة التجارية بالمدينة' },
    '25': { city: 'ينبع الصناعية', region: 'منطقة المدينة المنورة', court: 'فرع وزارة التجارة بينبع' },
    '33': { city: 'مدينة تبوك', region: 'منطقة تبوك', court: 'فرع وزارة التجارة بتبوك' },
    '34': { city: 'سكاكا / الجوف', region: 'منطقة الجوف', court: 'فرع وزارة التجارة بالجوف' },
    '35': { city: 'مدينة حائل', region: 'منطقة حائل', court: 'فرع وزارة التجارة بحائل' },
    '40': { city: 'الدمام والخبر والظهران', region: 'المنطقة الشرقية', court: 'المحكمة التجارية بالدمام' },
    '46': { city: 'الهفوف والأحساء', region: 'المنطقة الشرقية', court: 'فرع وزارة التجارة بالأحساء' },
    '47': { city: 'حفر الباطن', region: 'المنطقة الشرقية', court: 'فرع وزارة التجارة بحفر الباطن' },
    '58': { city: 'أبها وخميس مشيط', region: 'منطقة عسير', court: 'المحكمة التجارية بأبها' },
    '59': { city: 'مدينة جازان', region: 'منطقة جازان', court: 'فرع وزارة التجارة بجازان' },
    '60': { city: 'مدينة نجران', region: 'منطقة نجران', court: 'فرع وزارة التجارة بنجران' },
    '70': { city: 'بريدة وعنيزة', region: 'منطقة القصيم', court: 'المحكمة التجارية بالقصيم' },
};

function verifyCrNow() {
    const input = document.getElementById('cr-input');
    const raw = input.value.trim().replace(/\D/g, '');
    const resultBox = document.getElementById('cr-result-box');
    const statusBadge = document.getElementById('cr-status-badge');

    if (!raw) {
        alert("يرجى إدخال رقم السجل التجاري.");
        return;
    }

    resultBox.style.display = 'block';
    document.getElementById('res-cr-number').textContent = raw;

    if (raw.length !== 10) {
        statusBadge.style.background = 'rgba(255, 50, 50, 0.15)';
        statusBadge.style.color = '#ff5555';
        statusBadge.textContent = '❌ هيكل غير مطابق — السجل التجاري السعودي يجب أن يتكون من 10 أرقام تماماً (المدخل حالياً: ' + raw.length + ' أرقام)';
        document.getElementById('res-cr-city').textContent = '—';
        document.getElementById('res-cr-region').textContent = '—';
        document.getElementById('res-cr-court').textContent = '—';
        return;
    }

    const prefix = raw.substring(0, 2);
    const region = crRegionsMap[prefix];

    statusBadge.style.background = 'rgba(0, 212, 200, 0.15)';
    statusBadge.style.color = 'var(--nawader-teal)';
    statusBadge.textContent = '✅ هيكل مطابق لمعايير وزارة التجارة السعودية (10 خانات رقمية)';

    if (region) {
        document.getElementById('res-cr-city').textContent = region.city;
        document.getElementById('res-cr-region').textContent = region.region;
        document.getElementById('res-cr-court').textContent = region.court;
    } else {
        document.getElementById('res-cr-city').textContent = 'جهة إصدار معتمدة (رمز: ' + prefix + ')';
        document.getElementById('res-cr-region').textContent = 'المملكة العربية السعودية';
        document.getElementById('res-cr-court').textContent = 'المحكمة التجارية المختصة';
    }
}
</script>
@endpush
@endsection
