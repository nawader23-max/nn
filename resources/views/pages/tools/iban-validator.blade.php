@extends('layouts.app')

@section('title', 'فحص صحة الآيبان البنكي السعودي والدولي — نوادر ساما')
@section('meta_description', 'تحقق من صحة رقم الآيبان البنكي وفق معايير البنك المركزي السعودي (ساما) وخوارزمية MOD-97 واكتشف اسم البنك ورمز السويفت SWIFT فوراً.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-teal">معايير ساما SAMA ISO 13616</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🏦</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                فحص صحة <span class="nw-text-gradient-teal">الآيبان البنكي (IBAN)</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                فحص فوري دقيق لأرقام الحسابات البنكية الدولية (IBAN) طبقاً لخوارزمية التحقق الرياضية MOD-97 المعتمدة دولياً، مع كشف هوية البنك السعودي المصدر ورمز السويفت.
            </p>
        </div>

        {{-- Card --}}
        <div class="nw-card" style="padding: 2.5rem; border-top: 3px solid var(--nawader-teal); margin-bottom: 2rem;">
            
            <label style="display: block; color: var(--text-primary); font-size: 0.95rem; font-weight: 700; margin-bottom: 0.6rem;">
                أدخل رقم الآيبان (IBAN) *
            </label>
            
            <div style="display: flex; gap: 0.75rem; margin-bottom: 1.5rem;">
                <input type="text" id="iban-input" placeholder="SA00 0000 0000 0000 0000 0000" maxlength="34"
                       style="flex: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(0,212,200,0.3); border-radius: 12px; padding: 0.9rem 1.25rem; color: #fff; font-size: 1.15rem; font-family: monospace; letter-spacing: 1px; outline: none; text-transform: uppercase;">
                <button type="button" onclick="verifyIbanNow()" class="nw-btn nw-btn-primary" style="padding: 0 1.75rem;">
                    فحص الآن
                </button>
            </div>

            {{-- Result Area (Hidden initially) --}}
            <div id="iban-result-box" style="display: none; padding: 1.5rem; border-radius: 14px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);">
                
                {{-- Status Header --}}
                <div id="iban-status-badge" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.9rem; border-radius: 20px; font-weight: 800; font-size: 0.88rem; margin-bottom: 1.25rem;">
                </div>

                <div class="nw-grid nw-grid-2" style="gap: 1.25rem;">
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">الآيبان المنسق:</div>
                        <div id="res-formatted-iban" style="color: #fff; font-family: monospace; font-size: 1.05rem; font-weight: 700;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">الدولة:</div>
                        <div id="res-country" style="color: #fff; font-size: 1rem; font-weight: 700;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">البنك المصدر:</div>
                        <div id="res-bank-name" style="color: var(--nawader-gold); font-size: 1.05rem; font-weight: 800;"></div>
                    </div>
                    <div>
                        <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 0.3rem;">رمز السويفت (SWIFT / BIC):</div>
                        <div id="res-swift-code" style="color: var(--nawader-teal); font-family: monospace; font-size: 1rem; font-weight: 800;"></div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Saudi Banks Guide Panel --}}
        <div class="nw-cinematic-panel" style="padding: 2rem;">
            <h3 style="color: #fff; font-size: 1.1rem; margin-bottom: 1rem;">
                🏛️ البنوك السعودية المعتمدة لدى البنك المركزي السعودي (ساما)
            </h3>
            <p style="color: var(--text-secondary); font-size: 0.85rem; line-height: 1.7; margin-bottom: 1rem;">
                يتكون الآيبان السعودي دائماً من 24 خانة تبدأ بـ SA متبوعة برقمي فحص، ثم رقمين يمثلان الرمز التعريفي للبنك، ثم 18 خانة لرقم الحساب.
            </p>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <span class="nw-badge nw-badge-navy">الأهلي SNB (80)</span>
                <span class="nw-badge nw-badge-navy">الراجحي Al Rajhi (85)</span>
                <span class="nw-badge nw-badge-navy">الرياض Riyad Bank (20)</span>
                <span class="nw-badge nw-badge-navy">الإنماء Alinma (76)</span>
                <span class="nw-badge nw-badge-navy">الأول SAB (30)</span>
                <span class="nw-badge nw-badge-navy">الفرنسي BSF (40)</span>
                <span class="nw-badge nw-badge-navy">العربي ANB (50)</span>
                <span class="nw-badge nw-badge-navy">البلاد Albilad (65)</span>
                <span class="nw-badge nw-badge-navy">الجزيرة Bank AlJazira (60)</span>
                <span class="nw-badge nw-badge-navy">D360 الرقمي (05)</span>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
const saudiBanksMap = {
    '80': { name: 'البنك الأهلي السعودي (SNB)', swift: 'NCBKSARI' },
    '10': { name: 'البنك المركزي السعودي (SAMA)', swift: 'SABBSARI' },
    '20': { name: 'بنك الرياض (Riyad Bank)', swift: 'RIBLSARI' },
    '30': { name: 'البنك السعودي البريطاني (SABB / الأول)', swift: 'SABBSARI' },
    '40': { name: 'البنك السعودي الفرنسي (BSF)', swift: 'BSFRSARI' },
    '50': { name: 'البنك العربي الوطني (ANB)', swift: 'ARNBSARI' },
    '60': { name: 'بنك الجزيرة (Bank AlJazira)', swift: 'BJAZSARI' },
    '65': { name: 'بنك البلاد (Bank Albilad)', swift: 'ALBISARI' },
    '76': { name: 'مصرف الإنماء (Alinma Bank)', swift: 'INMASARI' },
    '85': { name: 'مصرف الراجحي (Al Rajhi Bank)', swift: 'RJHISARI' },
    '90': { name: 'بنك الخليج الدولي (GIB)', swift: 'GULFSARI' },
    '05': { name: 'بنك D360 الرقمي', swift: 'D360SARI' },
};

function verifyIbanNow() {
    const input = document.getElementById('iban-input');
    const raw = input.value.trim().toUpperCase().replace(/[^A-Z0-9]/g, '');
    const resultBox = document.getElementById('iban-result-box');
    const statusBadge = document.getElementById('iban-status-badge');

    if (!raw || raw.length < 5) {
        alert("يرجى إدخال رقم آيبان صالح.");
        return;
    }

    resultBox.style.display = 'block';

    // Format with spaces
    const formatted = raw.match(/.{1,4}/g)?.join(' ') || raw;
    document.getElementById('res-formatted-iban').textContent = formatted;

    const countryCode = raw.substring(0, 2);
    document.getElementById('res-country').textContent = countryCode === 'SA' ? '🇸🇦 المملكة العربية السعودية' : countryCode;

    // ISO 7064 Mod-97 check
    const isValid = checkIbanMod97(raw);

    if (countryCode === 'SA') {
        const bankCode = raw.substring(4, 6);
        const bank = saudiBanksMap[bankCode];

        if (raw.length !== 24) {
            statusBadge.style.background = 'rgba(255, 50, 50, 0.15)';
            statusBadge.style.color = '#ff5555';
            statusBadge.textContent = '❌ آيبان غير صالح — طول الآيبان السعودي يجب أن يكون 24 خانة بالضبط (حالياً ' + raw.length + ')';
            document.getElementById('res-bank-name').textContent = bank ? bank.name : 'غير محدد';
            document.getElementById('res-swift-code').textContent = bank ? bank.swift : '—';
            return;
        }

        if (isValid && bank) {
            statusBadge.style.background = 'rgba(0, 212, 200, 0.15)';
            statusBadge.style.color = 'var(--nawader-teal)';
            statusBadge.textContent = '✅ آيبان سعودي معتمد ومطابق رياضياً (MOD-97 Valid)';
            document.getElementById('res-bank-name').textContent = bank.name;
            document.getElementById('res-swift-code').textContent = bank.swift;
        } else if (!bank) {
            statusBadge.style.background = 'rgba(255, 180, 0, 0.15)';
            statusBadge.style.color = 'var(--nawader-gold)';
            statusBadge.textContent = '⚠️ رمز البنك غير مسجل لدى البنوك السعودية المرخصة';
            document.getElementById('res-bank-name').textContent = 'رمز غير معروف (' + bankCode + ')';
            document.getElementById('res-swift-code').textContent = '—';
        } else {
            statusBadge.style.background = 'rgba(255, 50, 50, 0.15)';
            statusBadge.style.color = '#ff5555';
            statusBadge.textContent = '❌ آيبان غير صحيح — فشل فحص خانات التحقق (MOD-97 Failed)';
            document.getElementById('res-bank-name').textContent = bank.name;
            document.getElementById('res-swift-code').textContent = bank.swift;
        }
    } else {
        if (isValid) {
            statusBadge.style.background = 'rgba(0, 212, 200, 0.15)';
            statusBadge.style.color = 'var(--nawader-teal)';
            statusBadge.textContent = '✅ آيبان دولي مطابق رياضياً لمعايير ISO 13616';
            document.getElementById('res-bank-name').textContent = 'بنك دولي معتمد';
            document.getElementById('res-swift-code').textContent = '—';
        } else {
            statusBadge.style.background = 'rgba(255, 50, 50, 0.15)';
            statusBadge.style.color = '#ff5555';
            statusBadge.textContent = '❌ آيبان دولي غير صالح';
            document.getElementById('res-bank-name').textContent = '—';
            document.getElementById('res-swift-code').textContent = '—';
        }
    }
}

function checkIbanMod97(iban) {
    if (iban.length < 15 || iban.length > 34) return false;
    const rearranged = iban.slice(4) + iban.slice(0, 4);
    let numeric = '';
    for (let i = 0; i < rearranged.length; i++) {
        const code = rearranged.charCodeAt(i);
        if (code >= 65 && code <= 90) {
            numeric += (code - 55).toString();
        } else if (code >= 48 && code <= 57) {
            numeric += rearranged[i];
        } else {
            return false;
        }
    }
    // Large integer mod 97
    let remainder = 0;
    for (let i = 0; i < numeric.length; i += 7) {
        const chunk = remainder.toString() + numeric.substring(i, i + 7);
        remainder = parseInt(chunk, 10) % 97;
    }
    return remainder === 1;
}

// Auto format input on type
document.getElementById('iban-input')?.addEventListener('input', function(e) {
    let val = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
    e.target.value = formatted;
});
</script>
@endpush
@endsection
