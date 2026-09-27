@extends('layouts.app')

@section('title', 'محول العملات — سعر صرف الريال السعودي والعملات العالمية')
@section('meta_description', 'تحويل فوري دقيق للريال السعودي مقابل الدولار الأمريكي واليورو والعملات الخليجية بناءً على سعر ربط البنك المركزي السعودي (ساما) الرسمي 3.7500.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-teal">سعر ربط ساما الرسمي 3.7500</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">💱</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                محول العملات <span class="nw-text-gradient-teal">السيادي المالي</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                حساب فوري لمعادلة الريال السعودي أمام سلة العملات الإقليمية والعالمية الرئيسية، بالاستناد إلى سعر الربط الثابت للبنك المركزي السعودي (1 USD = 3.7500 SAR) وأحدث أسعار الصرف الرسمية.
            </p>
        </div>

        {{-- Converter Card --}}
        <div class="nw-card" style="padding: 2.5rem; border-top: 3px solid var(--nawader-teal); margin-bottom: 2.5rem;">
            
            <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                
                {{-- From --}}
                <div>
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        المبلغ والعملة الأساس
                    </label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="number" id="curr-amount" value="1000" min="0.01" step="any" oninput="convertCurrencyLive()"
                               style="flex: 1; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-size: 1.15rem; font-family: var(--font-arabic); outline: none;">
                        <select id="curr-from" onchange="convertCurrencyLive()" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-weight: 800; outline: none;">
                            <option value="SAR" selected>🇸🇦 SAR (ريال)</option>
                            <option value="USD">🇺🇸 USD (دولار)</option>
                            <option value="EUR">🇪🇺 EUR (يورو)</option>
                            <option value="GBP">🇬🇧 GBP (جنيه)</option>
                            <option value="AED">🇦🇪 AED (درهم)</option>
                            <option value="KWD">🇰🇼 KWD (دينار)</option>
                            <option value="QAR">🇶🇦 QAR (ريال)</option>
                            <option value="BHD">🇧🇭 BHD (دينار)</option>
                            <option value="OMR">🇴🇲 OMR (ريال)</option>
                            <option value="CNY">🇨🇳 CNY (يوان)</option>
                        </select>
                    </div>
                </div>

                {{-- Swap Button --}}
                <div style="padding-top: 1.5rem;">
                    <button type="button" onclick="swapCurrencies()" class="nw-btn nw-btn-ghost nw-btn-sm" style="width: 44px; height: 44px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;" title="عكس العملات">
                        ⇄
                    </button>
                </div>

                {{-- To --}}
                <div>
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        العملة المحول إليها
                    </label>
                    <select id="curr-to" onchange="convertCurrencyLive()" style="width: 100%; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.2); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-weight: 800; font-size: 1.15rem; outline: none;">
                        <option value="USD" selected>🇺🇸 USD (دولار أمريكي)</option>
                        <option value="SAR">🇸🇦 SAR (ريال سعودي)</option>
                        <option value="EUR">🇪🇺 EUR (يورو أوروبي)</option>
                        <option value="GBP">🇬🇧 GBP (جنيه إسترليني)</option>
                        <option value="AED">🇦🇪 AED (درهم إماراتي)</option>
                        <option value="KWD">🇰🇼 KWD (دينار كويتي)</option>
                        <option value="QAR">🇶🇦 QAR (ريال قطري)</option>
                        <option value="BHD">🇧🇭 BHD (دينار بحريني)</option>
                        <option value="OMR">🇴🇲 OMR (ريال عماني)</option>
                        <option value="CNY">🇨🇳 CNY (يوان صيني)</option>
                    </select>
                </div>

            </div>

            {{-- Conversion Result Display --}}
            <div style="padding: 1.75rem; background: rgba(0,212,200,0.06); border: 1px solid rgba(0,212,200,0.25); border-radius: 16px; text-align: center;">
                <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.4rem;">القيمة المحسوبة:</div>
                <div id="curr-result-text" style="font-size: 2.4rem; font-weight: 900; color: var(--nawader-teal); line-height: 1.2; margin-bottom: 0.5rem;">
                    266.67 USD
                </div>
                <div id="curr-rate-info" style="color: var(--text-secondary); font-size: 0.85rem;">
                    1 SAR = 0.266667 USD (سعر الربط الرسمي 1 USD = 3.7500 SAR)
                </div>
            </div>

        </div>

        {{-- SAMA Peg Factsheet --}}
        <div class="nw-cinematic-panel" style="padding: 2rem;">
            <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <span>🛡️</span> سياسة ربط الريال بالدولار لدى البنك المركزي السعودي (ساما)
            </h3>
            <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.85; margin-bottom: 1.25rem;">
                يحافظ البنك المركزي السعودي (ساما) منذ عام 1986 على سياسة سعر الصرف الثابت للريال السعودي مقابل الدولار الأمريكي عند سعر رسمي محدد بـ <strong>3.7500 ريال لكل دولار أمريكي</strong>، مما يمنح الاقتصاد واستثمارات الشركات وتجارة الواردات والصادرات استقراراً نقدياً ومالياً استثنائياً.
            </p>
            <div class="nw-grid nw-grid-3" style="gap: 1rem;">
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 10px;">
                    <div style="color: var(--nawader-gold); font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">1 USD = 3.75 SAR</div>
                    <div style="color: var(--text-muted); font-size: 0.8rem;">سعر الشراء والبيع الرسمي</div>
                </div>
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 10px;">
                    <div style="color: var(--nawader-teal); font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">1 SAR = 0.2667 USD</div>
                    <div style="color: var(--text-muted); font-size: 0.8rem;">معامل التحويل المباشر</div>
                </div>
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 10px;">
                    <div style="color: #00E676; font-weight: 800; font-size: 1.1rem; margin-bottom: 0.25rem;">صفر تقلبات</div>
                    <div style="color: var(--text-muted); font-size: 0.8rem;">استقرار نقدي كامل للعقود</div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
const ratesToSar = {
    'SAR': 1.0000,
    'USD': 3.7500, // Fixed SAMA peg
    'EUR': 4.0850,
    'GBP': 4.8250,
    'AED': 1.0210,
    'KWD': 12.2300,
    'QAR': 1.0300,
    'BHD': 9.9480,
    'OMR': 9.7400,
    'CNY': 0.5210
};

function convertCurrencyLive() {
    const raw = parseFloat(document.getElementById('curr-amount').value);
    const amount = isNaN(raw) || raw < 0 ? 0 : raw;
    const from = document.getElementById('curr-from').value;
    const to = document.getElementById('curr-to').value;

    const fromRate = ratesToSar[from] || 1;
    const toRate = ratesToSar[to] || 1;

    const amountInSar = amount * fromRate;
    const converted = amountInSar / toRate;
    const unitRate = fromRate / toRate;

    document.getElementById('curr-result-text').textContent = converted.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + to;
    document.getElementById('curr-rate-info').textContent = `1 ${from} = ${unitRate.toFixed(6)} ${to} (المعادل المالي بالريال: ${amountInSar.toFixed(2)} SAR)`;
}

function swapCurrencies() {
    const fromSelect = document.getElementById('curr-from');
    const toSelect = document.getElementById('curr-to');
    const temp = fromSelect.value;
    fromSelect.value = toSelect.value;
    toSelect.value = temp;
    convertCurrencyLive();
}

document.addEventListener('DOMContentLoaded', convertCurrencyLive);
</script>
@endpush
@endsection
