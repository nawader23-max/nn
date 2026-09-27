@extends('layouts.app')

@section('title', 'حاسبة ضريبة القيمة المضافة السعودية (15%) — نوادر زاتكا')
@section('meta_description', 'احسب ضريبة القيمة المضافة 15% بدقة في السعودية للمبالغ الشاملة وغير الشاملة للضريبة، مع تفصيل الحساب وتوليد شفرة باركود زاتكا للفوترة الإلكترونية.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-gold">معتمدة وفق لائحة زاتكا 15%</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🧾</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                حاسبة <span class="nw-text-gradient-gold">ضريبة القيمة المضافة</span> السعودية
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                حساب فوري دقيق لضريبة القيمة المضافة وفق النسبة الرسمية المعتمدة من هيئة الزكاة والضريبة والجمارك (ZATCA) بنسبة 15% مع إمكانية احتساب المبالغ شاملة أو غير شاملة الضريبة.
            </p>
        </div>

        {{-- Calculator Box --}}
        <div class="nw-grid nw-grid-2" style="gap: 2rem; align-items: start;">
            
            {{-- Input Form Panel --}}
            <div class="nw-card" style="padding: 2rem; border-top: 3px solid var(--nawader-gold);">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>⚙️</span> مدخلات الحساب
                </h3>

                {{-- Amount Input --}}
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        المبلغ بالريال السعودي (SAR) *
                    </label>
                    <div style="position: relative;">
                        <input type="number" id="vat-amount" step="0.01" min="0" placeholder="مثال: 1000" 
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(212,168,67,0.3); border-radius: 12px; padding: 0.85rem 1rem 0.85rem 3.5rem; color: #fff; font-size: 1.1rem; font-family: var(--font-arabic); outline: none;">
                        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--nawader-gold); font-weight: 800; font-size: 0.9rem;">
                            ر.س
                        </span>
                    </div>
                </div>

                {{-- Type Selection --}}
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        نوع العملية الحسابية
                    </label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                        <button type="button" class="vat-type-btn active" data-type="exclusive" onclick="setVatType('exclusive', this)">
                            المبلغ غير شامل الضريبة<br><small style="font-size: 0.75rem; opacity: 0.8;">(إضافة 15% للمبلغ)</small>
                        </button>
                        <button type="button" class="vat-type-btn" data-type="inclusive" onclick="setVatType('inclusive', this)">
                            المبلغ شامل الضريبة<br><small style="font-size: 0.75rem; opacity: 0.8;">(استخراج 15% من المبلغ)</small>
                        </button>
                    </div>
                </div>

                {{-- Tax Rate Selection --}}
                <div style="margin-bottom: 1.75rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        نسبة الضريبة
                    </label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="vat-rate-btn active" data-rate="15" onclick="setVatRate(15, this)">
                            15% (القياسية)
                        </button>
                        <button type="button" class="vat-rate-btn" data-rate="0" onclick="setVatRate(0, this)">
                            0% (الصفرية)
                        </button>
                    </div>
                </div>

                <button type="button" onclick="calculateVatLive()" class="nw-btn nw-btn-primary" style="width: 100%; justify-content: center; font-size: 1rem;">
                    حساب النتيجة فوراً
                </button>
            </div>

            {{-- Result Output Panel --}}
            <div class="nw-card" id="vat-result-card" style="padding: 2rem; border-top: 3px solid var(--nawader-teal); background: rgba(12,18,34,0.7);">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <span>📊</span> النتائج والتفصيل المالي
                    </span>
                    <span id="vat-badge-status" class="nw-badge nw-badge-teal">15% ZATCA</span>
                </h3>

                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    
                    {{-- Net --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <span style="color: var(--text-secondary); font-size: 0.92rem;">المبلغ قبل الضريبة (الصافي):</span>
                        <span id="res-net" style="color: #fff; font-size: 1.15rem; font-weight: 800;">0.00 ر.س</span>
                    </div>

                    {{-- Tax Amount --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.85rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <span style="color: var(--nawader-gold); font-size: 0.92rem; font-weight: 700;">مبلغ ضريبة القيمة المضافة:</span>
                        <span id="res-vat" style="color: var(--nawader-gold); font-size: 1.25rem; font-weight: 900;">0.00 ر.س</span>
                    </div>

                    {{-- Total Amount --}}
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(0,212,200,0.08); border: 1px solid rgba(0,212,200,0.25); border-radius: 12px;">
                        <span style="color: #fff; font-size: 1.05rem; font-weight: 800;">المبلغ الإجمالي النهائي:</span>
                        <span id="res-total" style="color: var(--nawader-teal); font-size: 1.5rem; font-weight: 900;">0.00 ر.س</span>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div style="margin-top: 1.75rem; display: flex; gap: 0.75rem;">
                    <button type="button" onclick="copyVatSummary()" class="nw-btn nw-btn-ghost nw-btn-sm" style="flex: 1; justify-content: center;">
                        📋 نسخ الملخص
                    </button>
                    <button type="button" onclick="window.print()" class="nw-btn nw-btn-ghost nw-btn-sm" style="flex: 1; justify-content: center;">
                        🖨️ طباعة النتيجة
                    </button>
                </div>

                <div style="margin-top: 1.25rem; padding: 0.85rem; background: rgba(255,255,255,0.02); border-radius: 10px; font-size: 0.78rem; color: var(--text-muted); line-height: 1.6;">
                    💡 معادلة الحساب: <span id="vat-formula-text">المبلغ الصافي × 15% = مبلغ الضريبة، ثم الصافي + الضريبة = الإجمالي.</span>
                </div>
            </div>

        </div>

    </div>
</div>

<style>
.vat-type-btn, .vat-rate-btn {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    color: var(--text-secondary);
    border-radius: 10px;
    padding: 0.75rem 0.85rem;
    font-size: 0.85rem;
    font-family: var(--font-arabic);
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.vat-type-btn.active, .vat-rate-btn.active {
    background: rgba(212,168,67,0.15);
    border-color: var(--nawader-gold);
    color: #fff;
    font-weight: 700;
    box-shadow: 0 0 15px rgba(212,168,67,0.25);
}
</style>

@push('scripts')
<script>
let currentVatType = 'exclusive';
let currentVatRate = 15;

function setVatType(type, btn) {
    currentVatType = type;
    document.querySelectorAll('.vat-type-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    calculateVatLive();
}

function setVatRate(rate, btn) {
    currentVatRate = rate;
    document.querySelectorAll('.vat-rate-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    calculateVatLive();
}

function calculateVatLive() {
    const raw = parseFloat(document.getElementById('vat-amount').value);
    const amount = isNaN(raw) || raw < 0 ? 0 : raw;
    let net = 0;
    let vat = 0;
    let total = 0;

    if (currentVatType === 'inclusive') {
        net = currentVatRate > 0 ? (amount / (1 + (currentVatRate / 100))) : amount;
        vat = amount - net;
        total = amount;
        document.getElementById('vat-formula-text').textContent = 'المبلغ الإجمالي ÷ (1 + ' + (currentVatRate/100) + ') = الصافي، ثم الإجمالي - الصافي = مبلغ الضريبة.';
    } else {
        net = amount;
        vat = amount * (currentVatRate / 100);
        total = amount + vat;
        document.getElementById('vat-formula-text').textContent = 'المبلغ الصافي × ' + currentVatRate + '% = مبلغ الضريبة، ثم الصافي + الضريبة = الإجمالي.';
    }

    document.getElementById('res-net').textContent = net.toLocaleString('ar-SA', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ر.س';
    document.getElementById('res-vat').textContent = vat.toLocaleString('ar-SA', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ر.س';
    document.getElementById('res-total').textContent = total.toLocaleString('ar-SA', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ر.س';
    document.getElementById('vat-badge-status').textContent = currentVatRate + '% ZATCA';
}

function copyVatSummary() {
    const net = document.getElementById('res-net').textContent;
    const vat = document.getElementById('res-vat').textContent;
    const total = document.getElementById('res-total').textContent;
    const text = `ملخص ضريبة القيمة المضافة (نوادر السيادية):\nالمبلغ الصافي: ${net}\nمبلغ الضريبة (15%): ${vat}\nالمبلغ الإجمالي: ${total}`;
    navigator.clipboard.writeText(text).then(() => {
        alert("تم نسخ الملخص الضريبي بنجاح!");
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('vat-amount').addEventListener('input', calculateVatLive);
    calculateVatLive();
});
</script>
@endpush
@endsection
