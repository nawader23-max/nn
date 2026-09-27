@extends('layouts.app')

@section('title', 'صانع ومولد رموز QR الذكي فائق الدقة — نوادر')
@section('meta_description', 'أنشئ باركود QR عالي الدقة مجاناً للروابط، شبكات الواي فاي، بطاقات الأعمال، وأرقام الواتساب، مع خيارات التحميل بصيغة PNG و SVG فائقة الوضوح.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 980px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-gold">توليد فوري مشفر محلياً</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">📱</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                صانع رموز <span class="nw-text-gradient-gold">الـ QR والباركود</span> الذكي
            </h1>
            <p style="color: var(--text-secondary); max-width: 620px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                توليد فوري فائق الدقة لرموز الاستجابة السريعة (QR Code) متعدد الأغراض للشركات والمنشآت ورواد الأعمال. يتم التوليد بالكامل داخل متصفحك دون حفظ أي بيانات على الخوادم.
            </p>
        </div>

        <div class="nw-grid nw-grid-2" style="gap: 2rem; align-items: start;">
            
            {{-- Form Settings --}}
            <div class="nw-card" style="padding: 2rem; border-top: 3px solid var(--nawader-gold);">
                
                {{-- Type Selection Tabs --}}
                <div style="display: flex; gap: 0.4rem; overflow-x: auto; margin-bottom: 1.5rem; padding-bottom: 0.5rem;">
                    <button type="button" class="qr-tab active" data-type="url" onclick="setQrType('url', this)">رابط URL</button>
                    <button type="button" class="qr-tab" data-type="text" onclick="setQrType('text', this)">نص حر</button>
                    <button type="button" class="qr-tab" data-type="wifi" onclick="setQrType('wifi', this)">واي فاي</button>
                    <button type="button" class="qr-tab" data-type="vcard" onclick="setQrType('vcard', this)">بطاقة عمل vCard</button>
                    <button type="button" class="qr-tab" data-type="whatsapp" onclick="setQrType('whatsapp', this)">واتساب</button>
                </div>

                {{-- Dynamic Inputs --}}
                <div id="qr-input-container" style="margin-bottom: 1.5rem;">
                    <div id="field-url">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">رابط الموقع أو الصفحة *</label>
                        <input type="url" id="input-url" value="https://nawadersrv.com" placeholder="https://example.com"
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-family: monospace; outline: none;">
                    </div>

                    <div id="field-text" style="display: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">النص أو الرسالة *</label>
                        <textarea id="input-text" rows="3" placeholder="اكتب النص هنا..."
                                  style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; font-family: var(--font-arabic); outline: none;"></textarea>
                    </div>

                    <div id="field-wifi" style="display: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">اسم الشبكة (SSID) *</label>
                        <input type="text" id="wifi-ssid" placeholder="اسم الشبكة" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; margin-bottom: 0.75rem; outline: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">كلمة المرور</label>
                        <input type="text" id="wifi-pass" placeholder="كلمة المرور" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; outline: none;">
                    </div>

                    <div id="field-vcard" style="display: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">الاسم الكامل *</label>
                        <input type="text" id="vcard-name" placeholder="مثال: د. سلمان الفهد" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; margin-bottom: 0.75rem; outline: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">رقم الجوال</label>
                        <input type="text" id="vcard-phone" placeholder="+966500000000" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; margin-bottom: 0.75rem; outline: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">البريد الإلكتروني</label>
                        <input type="email" id="vcard-email" placeholder="contact@example.com" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; outline: none;">
                    </div>

                    <div id="field-whatsapp" style="display: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">رقم الواتساب مع المفتاح الدولي *</label>
                        <input type="text" id="wa-phone" placeholder="966501234567" style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; margin-bottom: 0.75rem; outline: none;">
                        <label style="display: block; color: var(--text-primary); font-size: 0.88rem; font-weight: 700; margin-bottom: 0.5rem;">رسالة البدء التلقائية</label>
                        <input type="text" id="wa-msg" placeholder="مرحباً، أود الاستفسار عن..." style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 0.85rem 1rem; color: #fff; outline: none;">
                    </div>
                </div>

                {{-- Color Customization --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.82rem; font-weight: 700; margin-bottom: 0.4rem;">لون الباركود</label>
                        <input type="color" id="qr-color-dark" value="#0c1222" style="width: 100%; height: 42px; border: none; border-radius: 10px; cursor: pointer; background: transparent;">
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.82rem; font-weight: 700; margin-bottom: 0.4rem;">لون الخلفية</label>
                        <input type="color" id="qr-color-light" value="#ffffff" style="width: 100%; height: 42px; border: none; border-radius: 10px; cursor: pointer; background: transparent;">
                    </div>
                </div>

                <button type="button" onclick="renderQrLive()" class="nw-btn nw-btn-primary" style="width: 100%; justify-content: center; font-size: 1rem;">
                    تحديث الـ QR الآن ⚡
                </button>
            </div>

            {{-- Live Preview & Download --}}
            <div class="nw-card" style="padding: 2.25rem; text-align: center; border-top: 3px solid var(--nawader-teal); background: rgba(12,18,34,0.7);">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem;">
                    معاينة الـ QR الفورية
                </h3>

                {{-- Canvas / SVG Container --}}
                <div id="qr-canvas-holder" style="padding: 1.5rem; background: #fff; border-radius: 18px; display: inline-block; box-shadow: 0 15px 40px rgba(0,0,0,0.5); margin-bottom: 1.75rem;">
                    <canvas id="qr-canvas" width="220" height="220"></canvas>
                </div>

                <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="downloadQr('png')" class="nw-btn nw-btn-gold nw-btn-sm" style="padding: 0.6rem 1.25rem;">
                        ⬇️ تحميل كصورة PNG
                    </button>
                    <button type="button" onclick="downloadQr('svg')" class="nw-btn nw-btn-ghost nw-btn-sm" style="padding: 0.6rem 1.25rem;">
                        ⬇️ تحميل بصيغة SVG
                    </button>
                </div>

                <div style="margin-top: 1.25rem; font-size: 0.8rem; color: var(--text-muted);">
                    🔒 متوافق مع كافة الهواتف الذكية وتطبيقات الكاميرا والقارئات الضوئية.
                </div>
            </div>

        </div>

    </div>
</div>

<style>
.qr-tab {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    color: var(--text-secondary);
    border-radius: 10px;
    padding: 0.5rem 0.9rem;
    font-size: 0.8rem;
    font-family: var(--font-arabic);
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
}
.qr-tab.active {
    background: rgba(212,168,67,0.2);
    border-color: var(--nawader-gold);
    color: #fff;
    font-weight: 700;
}
</style>

@push('scripts')
{{-- Embed lightweight, robust pure-JS QR generator library --}}
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
let currentQrType = 'url';

function setQrType(type, btn) {
    currentQrType = type;
    document.querySelectorAll('.qr-tab').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    ['url', 'text', 'wifi', 'vcard', 'whatsapp'].forEach(t => {
        const el = document.getElementById('field-' + t);
        if (el) el.style.display = (t === type) ? 'block' : 'none';
    });

    renderQrLive();
}

function getQrPayload() {
    switch (currentQrType) {
        case 'url':
            return document.getElementById('input-url').value.trim() || 'https://nawadersrv.com';
        case 'text':
            return document.getElementById('input-text').value.trim() || 'نوادر للخدمات السيادية';
        case 'wifi':
            const ssid = document.getElementById('wifi-ssid').value.trim() || 'MyNetwork';
            const pass = document.getElementById('wifi-pass').value.trim();
            return `WIFI:T:WPA;S:${ssid};P:${pass};;`;
        case 'vcard':
            const name = document.getElementById('vcard-name').value.trim() || 'نوادر للأعمال';
            const phone = document.getElementById('vcard-phone').value.trim();
            const email = document.getElementById('vcard-email').value.trim();
            return `BEGIN:VCARD\nVERSION:3.0\nFN:${name}\nTEL:${phone}\nEMAIL:${email}\nEND:VCARD`;
        case 'whatsapp':
            const waPhone = document.getElementById('wa-phone').value.replace(/[^0-9]/g, '') || '966501234567';
            const waMsg = encodeURIComponent(document.getElementById('wa-msg').value.trim());
            return `https://wa.me/${waPhone}?text=${waMsg}`;
        default:
            return 'https://nawadersrv.com';
    }
}

function renderQrLive() {
    const text = getQrPayload();
    const canvas = document.getElementById('qr-canvas');
    const darkColor = document.getElementById('qr-color-dark').value;
    const lightColor = document.getElementById('qr-color-light').value;

    if (window.QRCode && window.QRCode.toCanvas) {
        QRCode.toCanvas(canvas, text, {
            width: 220,
            margin: 1,
            color: {
                dark: darkColor,
                light: lightColor
            }
        }, function (error) {
            if (error) console.error(error);
        });
    }
}

function downloadQr(format) {
    const canvas = document.getElementById('qr-canvas');
    if (format === 'png') {
        const link = document.createElement('a');
        link.download = 'nawader-qrcode.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    } else {
        // SVG representation
        const text = getQrPayload();
        if (window.QRCode && window.QRCode.toString) {
            QRCode.toString(text, { type: 'svg' }, function (err, svg) {
                if (err) return;
                const blob = new Blob([svg], { type: 'image/svg+xml' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.download = 'nawader-qrcode.svg';
                link.href = url;
                link.click();
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Wait for script to load
    let checkInterval = setInterval(() => {
        if (window.QRCode) {
            clearInterval(checkInterval);
            renderQrLive();
        }
    }, 100);
});
</script>
@endpush
@endsection
