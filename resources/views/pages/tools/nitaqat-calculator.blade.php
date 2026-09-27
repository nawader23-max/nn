@extends('layouts.app')

@section('title', 'حاسبة نسب التوطين ونطاقات المنشآت — نوادر الموارد البشرية')
@section('meta_description', 'احسب نسبة توطين منشأتك وفق معايير وزارة الموارد البشرية والتنمية الاجتماعية، وتعرف على نطاقك الحالي والعدد المطلوب للوصول للنطاق البلاتيني.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-teal">معايير وزارة الموارد البشرية HRSD 2026</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">🇸🇦</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                حاسبة نسب التوطين <span class="nw-text-gradient-gold">(نطاقات)</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                حساب فوري لمعرفة نطاق منشأتك في برنامج نطاقات المطور، وقياس عدد الموظفين السعوديين المطلوبين لتفادي النطاق الأحمر والترقية للنطاق الأخضر أو البلاتيني.
            </p>
        </div>

        {{-- Calculator Box --}}
        <div class="nw-grid nw-grid-2" style="gap: 2rem; align-items: start;">
            
            {{-- Inputs --}}
            <div class="nw-card" style="padding: 2rem; border-top: 3px solid #00C853;">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🏢</span> بيانات القوى العاملة بالمنشأة
                </h3>

                {{-- Sector --}}
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        النشاط الاقتصادي الرئيسي *
                    </label>
                    <select id="nitaqat-sector" onchange="calculateNitaqatLive()" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-family: var(--font-arabic); outline: none;">
                        <option value="tech" style="background: #0c1222;">تقنية المعلومات والاتصالات والبرمجيات</option>
                        <option value="consulting" style="background: #0c1222;">الخدمات المهنية والاستشارية والقانونية</option>
                        <option value="retail" style="background: #0c1222;">تجارة الجملة والتجزئة</option>
                        <option value="construction" style="background: #0c1222;">التشييد والبناء والمقاولات</option>
                        <option value="logistics" style="background: #0c1222;">النقل والخدمات اللوجستية وسلاسل الإمداد</option>
                        <option value="hospitality" style="background: #0c1222;">السياحة والضيافة والإعاشة</option>
                        <option value="industry" style="background: #0c1222;">الصناعة والتعدين</option>
                        <option value="healthcare" style="background: #0c1222;">الرعاية الصحية والمستشفيات</option>
                    </select>
                </div>

                {{-- Total Employees --}}
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        إجمالي عدد العاملين بالمنشأة (سعوديين وغير سعوديين) *
                    </label>
                    <input type="number" id="nitaqat-total" min="1" value="25" placeholder="مثال: 25" oninput="calculateNitaqatLive()"
                           style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-size: 1.1rem; font-family: var(--font-arabic); outline: none;">
                </div>

                {{-- Saudi Employees --}}
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">
                        عدد الموظفين السعوديين المسجلين في التأمينات *
                    </label>
                    <input type="number" id="nitaqat-saudi" min="0" value="8" placeholder="مثال: 8" oninput="calculateNitaqatLive()"
                           style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(0,200,83,0.3); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-size: 1.1rem; font-family: var(--font-arabic); outline: none;">
                </div>

                <div style="padding: 0.85rem; background: rgba(0,212,200,0.05); border: 1px solid rgba(0,212,200,0.15); border-radius: 10px; font-size: 0.8rem; color: var(--text-muted); line-height: 1.6;">
                    ℹ️ يُحتسب الموظف السعودي بواحد كامل في نطاقات عند تسجيله بأجر لا يقل عن 4,000 ريال شهرياً طبقاً لضوابط صندوق تنمية الموارد البشرية (هدف).
                </div>
            </div>

            {{-- Results Panel --}}
            <div class="nw-card" style="padding: 2rem; border-top: 3px solid var(--nawader-gold); background: rgba(12,18,34,0.7);">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                    <span>📊 تحليل النطاق والامتثال</span>
                    <span id="nit-badge" class="nw-badge" style="background: rgba(0,200,83,0.15); color: #00E676; border: 1px solid #00E676;">أخضر متوسط</span>
                </h3>

                {{-- Ratio Gauge --}}
                <div style="text-align: center; margin-bottom: 1.75rem; padding: 1.5rem; background: rgba(255,255,255,0.02); border-radius: 14px;">
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.4rem;">نسبة التوطين المحققة:</div>
                    <div id="nit-ratio-display" style="font-size: 3rem; font-weight: 900; color: #00E676; line-height: 1;">
                        32.0%
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">الموظفون غير السعوديين:</span>
                        <span id="nit-non-saudi" style="color: #fff; font-weight: 800;">17 موظف</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">المطلوب لبلوغ النطاق الأخضر المرتفع:</span>
                        <span id="nit-needed-green" style="color: var(--nawader-gold); font-weight: 800;">5 موظفين إضافيين</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
                        <span style="color: var(--text-secondary); font-size: 0.9rem;">المطلوب لبلوغ النطاق البلاتيني:</span>
                        <span id="nit-needed-platinum" style="color: var(--nawader-teal); font-weight: 800;">12 موظف إضافي</span>
                    </div>
                </div>

                {{-- Privileges Box --}}
                <div id="nit-privileges-box" style="padding: 1rem; border-radius: 10px; background: rgba(0,200,83,0.08); border: 1px solid rgba(0,200,83,0.2); font-size: 0.85rem; color: #fff; line-height: 1.6;">
                    <strong>امتيازات النطاق:</strong> تجديد رخص العمل والإقامات وسهولة نقل الكفالات وإصدار التأشيرات وفق الحصة المعتمدة.
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
function calculateNitaqatLive() {
    const total = parseInt(document.getElementById('nitaqat-total').value, 10) || 0;
    const saudiInput = parseInt(document.getElementById('nitaqat-saudi').value, 10) || 0;
    const saudi = Math.min(saudiInput, total);
    const nonSaudi = Math.max(0, total - saudi);

    if (total <= 0) return;

    const ratio = ((saudi / total) * 100);
    const ratioFormatted = ratio.toFixed(1) + '%';

    document.getElementById('nit-ratio-display').textContent = ratioFormatted;
    document.getElementById('nit-non-saudi').textContent = nonSaudi + ' موظف';

    const badge = document.getElementById('nit-badge');
    const ratioDisp = document.getElementById('nit-ratio-display');
    const privBox = document.getElementById('nit-privileges-box');

    let neededGreen = Math.max(0, Math.ceil(total * 0.40) - saudi);
    let neededPlatinum = Math.max(0, Math.ceil(total * 0.75) - saudi);

    document.getElementById('nit-needed-green').textContent = neededGreen > 0 ? neededGreen + ' موظف إضافي' : 'مُحقق بالفعل ✅';
    document.getElementById('nit-needed-platinum').textContent = neededPlatinum > 0 ? neededPlatinum + ' موظف إضافي' : 'مُحقق بالفعل ✅';

    if (ratio >= 75) {
        badge.textContent = 'نطاق بلاتيني (Platinum)';
        badge.style.background = 'rgba(229, 228, 226, 0.2)';
        badge.style.color = '#E5E4E2';
        badge.style.borderColor = '#E5E4E2';
        ratioDisp.style.color = '#E5E4E2';
        privBox.style.background = 'rgba(229, 228, 226, 0.08)';
        privBox.style.borderColor = 'rgba(229, 228, 226, 0.25)';
        privBox.innerHTML = '<strong>🏆 نطاق بلاتيني:</strong> أولوية قصوى، إصدار تأشيرات فورية غير محدودة، تجديد فوري، ونقل خدمات العمالة بكل مرونة.';
    } else if (ratio >= 50) {
        badge.textContent = 'نطاق أخضر مرتفع (High Green)';
        badge.style.background = 'rgba(0, 200, 83, 0.2)';
        badge.style.color = '#00E676';
        badge.style.borderColor = '#00E676';
        ratioDisp.style.color = '#00E676';
        privBox.style.background = 'rgba(0, 200, 83, 0.08)';
        privBox.style.borderColor = 'rgba(0, 200, 83, 0.25)';
        privBox.innerHTML = '<strong>✨ أخضر مرتفع:</strong> تسهيلات واسعة في استقدام التأشيرات، تغيير المهن، وتجديد الرخص بيسر.';
    } else if (ratio >= 25) {
        badge.textContent = 'نطاق أخضر متوسط (Mid Green)';
        badge.style.background = 'rgba(46, 125, 50, 0.2)';
        badge.style.color = '#66BB6A';
        badge.style.borderColor = '#66BB6A';
        ratioDisp.style.color = '#66BB6A';
        privBox.style.background = 'rgba(46, 125, 50, 0.08)';
        privBox.style.borderColor = 'rgba(46, 125, 50, 0.25)';
        privBox.innerHTML = '<strong>✅ أخضر متوسط:</strong> الحفاظ على الامتثال النظامي، تجديد رخص العمل، مع حصص تأشيرات محددة.';
    } else if (ratio >= 15) {
        badge.textContent = 'نطاق أخضر منخفض (Low Green)';
        badge.style.background = 'rgba(139, 195, 74, 0.2)';
        badge.style.color = '#AED581';
        badge.style.borderColor = '#AED581';
        ratioDisp.style.color = '#AED581';
        privBox.style.background = 'rgba(139, 195, 74, 0.08)';
        privBox.style.borderColor = 'rgba(139, 195, 74, 0.25)';
        privBox.innerHTML = '<strong>⚠️ أخضر منخفض:</strong> إمكانية تجديد رخص العمل مع تجميد طلبات التأشيرات الجديدة حتى تحسين النسبة.';
    } else {
        badge.textContent = 'نطاق أحمر (Red)';
        badge.style.background = 'rgba(213, 0, 0, 0.2)';
        badge.style.color = '#FF5252';
        badge.style.borderColor = '#FF5252';
        ratioDisp.style.color = '#FF5252';
        privBox.style.background = 'rgba(213, 0, 0, 0.08)';
        privBox.style.borderColor = 'rgba(213, 0, 0, 0.25)';
        privBox.innerHTML = '<strong>❌ نطاق أحمر:</strong> إيقاف جميع الخدمات الحكومية (التأشيرات، نقل الخدمات، تجديد الرخص) ومهلة إلزامية لتصحيح الأوضاع.';
    }
}

document.addEventListener('DOMContentLoaded', calculateNitaqatLive);
</script>
@endpush
@endsection
