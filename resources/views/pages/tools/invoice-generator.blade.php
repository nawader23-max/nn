@extends('layouts.app')

@section('title', 'صانع الفواتير الإلكترونية المتوافقة مع زاتكا — نوادر')
@section('meta_description', 'أنشئ فواتير ضريبية مبسطة متوافقة مع متطلبات هيئة الزكاة والضريبة والجمارك (زاتكا) مع التوليد الفوري لباركود الفوترة المشفر TLV والطباعة المباشرة مجاناً.')

@section('content')
<div class="nw-page-section" style="padding: 130px 0 90px;">
    <div class="nw-container" style="max-width: 1100px;">

        {{-- Breadcrumb & Back --}}
        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
            <a href="{{ route('tools.index') }}" class="nw-btn nw-btn-ghost nw-btn-sm" style="gap: 0.4rem;">
                → العودة لمركز الأدوات
            </a>
            <span class="nw-badge nw-badge-teal">متوافقة مع متطلبات الفوترة الإلكترونية زاتكا</span>
        </div>

        {{-- Header --}}
        <div class="nw-cinematic-panel" style="padding: 2.25rem 2rem; margin-bottom: 2rem; text-align: center;">
            <span style="font-size: 2.5rem; display: block; margin-bottom: 0.5rem;">📑</span>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: #fff; margin-bottom: 0.6rem;">
                صانع الفواتير الضريبية <span class="nw-text-gradient-teal">المتوافقة مع زاتكا</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 680px; margin: 0 auto; font-size: 0.95rem; line-height: 1.8;">
                أنشئ فواتيرك الضريبية المبسطة واحتسب ضريبة القيمة المضافة 15% تلقائياً، مع توليد شفرة الباركود المشفرة بنظام TLV المعتمد من هيئة الزكاة والضريبة والجمارك والطباعة الفورية.
            </p>
        </div>

        {{-- Main Builder & Live Preview Grid --}}
        <div class="nw-grid nw-grid-2" style="gap: 2rem; align-items: start;">
            
            {{-- Form Inputs --}}
            <div class="nw-card" style="padding: 2rem; border-top: 3px solid var(--nawader-gold);">
                <h3 style="color: #fff; font-size: 1.15rem; margin-bottom: 1.5rem;">
                    📝 بيانات الفاتورة
                </h3>

                {{-- Seller Info --}}
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">اسم المنشأة أو البائع *</label>
                    <input type="text" id="inv-seller" value="مؤسسة الأعمال المبتكرة" oninput="updateInvoicePreview()"
                           style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; outline: none;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">الرقم الضريبي (15 رقم) *</label>
                        <input type="text" id="inv-vat-no" value="310000000000003" maxlength="15" oninput="updateInvoicePreview()"
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; font-family: monospace; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">رقم السجل التجاري</label>
                        <input type="text" id="inv-cr" value="1010123456" maxlength="10" oninput="updateInvoicePreview()"
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; font-family: monospace; outline: none;">
                    </div>
                </div>

                {{-- Buyer Info --}}
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">اسم العميل / المشتري</label>
                    <input type="text" id="inv-buyer" value="شركة الرياض العالمية" oninput="updateInvoicePreview()"
                           style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; outline: none;">
                </div>

                {{-- Invoice Meta --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">رقم الفاتورة</label>
                        <input type="text" id="inv-number" value="INV-2026-001" oninput="updateInvoicePreview()"
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; font-family: monospace; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; color: var(--text-primary); font-size: 0.85rem; font-weight: 700; margin-bottom: 0.4rem;">تاريخ الإصدار</label>
                        <input type="date" id="inv-date" value="{{ date('Y-m-d') }}" onchange="updateInvoicePreview()"
                               style="width: 100%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 10px; padding: 0.75rem 1rem; color: #fff; outline: none;">
                    </div>
                </div>

                {{-- Line Items --}}
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                        <span style="color: var(--text-primary); font-size: 0.9rem; font-weight: 700;">بنود الفاتورة والخدمات</span>
                        <button type="button" onclick="addInvoiceItem()" class="nw-btn nw-btn-ghost nw-btn-sm" style="font-size: 0.75rem; padding: 2px 8px;">
                            + إضافة بند جديد
                        </button>
                    </div>

                    <div id="inv-items-container" style="display: flex; flex-direction: column; gap: 0.6rem;">
                        <div class="inv-item-row" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 0.5rem; align-items: center;">
                            <input type="text" class="item-desc" value="خدمات استشارية وتوثيق عقود" placeholder="الوصف" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
                            <input type="number" class="item-qty" value="1" min="1" placeholder="الكمية" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
                            <input type="number" class="item-price" value="2500" min="0" step="any" placeholder="السعر" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
                            <button type="button" onclick="removeInvoiceItem(this)" style="background: none; border: none; color: #ff5555; cursor: pointer; font-size: 1.1rem; padding: 0 4px;">✕</button>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="button" onclick="window.print()" class="nw-btn nw-btn-primary" style="flex: 1; justify-content: center;">
                        🖨️ طباعة الفاتورة أو حفظها PDF
                    </button>
                </div>
            </div>

            {{-- Printable Preview Panel --}}
            <div id="printable-invoice" style="background: #ffffff; color: #111827; border-radius: 16px; padding: 2.5rem; box-shadow: 0 20px 60px rgba(0,0,0,0.6); font-family: 'Tajawal', sans-serif;">
                
                {{-- Header --}}
                <div style="display: flex; justify-content: space-between; align-items: start; border-bottom: 2px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <h2 id="prev-seller" style="font-size: 1.4rem; font-weight: 900; color: #0f172a; margin: 0 0 0.4rem;">مؤسسة الأعمال المبتكرة</h2>
                        <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.2rem;">الرقم الضريبي: <span id="prev-vat-no" style="font-family: monospace; font-weight: 700; color: #0f172a;">310000000000003</span></div>
                        <div style="font-size: 0.85rem; color: #64748b;">السجل التجاري: <span id="prev-cr" style="font-family: monospace; font-weight: 700; color: #0f172a;">1010123456</span></div>
                    </div>
                    <div style="text-align: left;">
                        <span style="display: inline-block; background: #f1f5f9; color: #0f172a; font-weight: 800; padding: 4px 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 0.5rem;">
                            فاتورة ضريبية مبسطة
                        </span>
                        <div style="font-size: 0.82rem; color: #64748b;">رقم: <strong id="prev-number" style="color: #0f172a;">INV-2026-001</strong></div>
                        <div style="font-size: 0.82rem; color: #64748b;">التاريخ: <strong id="prev-date" style="color: #0f172a;">{{ date('Y-m-d') }}</strong></div>
                    </div>
                </div>

                {{-- Buyer Details --}}
                <div style="background: #f8fafc; border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between;">
                    <div>
                        <span style="font-size: 0.78rem; color: #64748b; display: block;">العميل / المشتري:</span>
                        <strong id="prev-buyer" style="color: #0f172a; font-size: 0.95rem;">شركة الرياض العالمية</strong>
                    </div>
                    <div style="text-align: left;">
                        <span style="font-size: 0.78rem; color: #64748b; display: block;">العملة:</span>
                        <strong style="color: #0f172a; font-size: 0.95rem;">ريال سعودي (SAR)</strong>
                    </div>
                </div>

                {{-- Table --}}
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; font-size: 0.85rem;">
                    <thead>
                        <tr style="background: #f1f5f9; text-align: right; color: #475569;">
                            <th style="padding: 8px 12px; border-radius: 0 8px 8px 0;">البند / الوصف</th>
                            <th style="padding: 8px; text-align: center;">الكمية</th>
                            <th style="padding: 8px; text-align: left;">السعر</th>
                            <th style="padding: 8px 12px; text-align: left; border-radius: 8px 0 0 8px;">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody id="prev-items-tbody">
                    </tbody>
                </table>

                {{-- Totals & ZATCA QR --}}
                <div style="display: flex; justify-content: space-between; align-items: flex-end; border-top: 2px solid #e5e7eb; padding-top: 1.5rem;">
                    
                    {{-- QR Code (ZATCA compliant TLV base64) --}}
                    <div>
                        <canvas id="inv-zatca-qr" width="110" height="110" style="display: block; border: 1px solid #cbd5e1; border-radius: 8px; padding: 4px;"></canvas>
                        <span style="font-size: 0.68rem; color: #94a3b8; display: block; margin-top: 4px; text-align: center;">رمز زاتكا المشفر ZATCA TLV</span>
                    </div>

                    {{-- Financials --}}
                    <div style="width: 240px; display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.88rem;">
                        <div style="display: flex; justify-content: space-between; color: #64748b;">
                            <span>المجموع الصافي:</span>
                            <span id="prev-subtotal" style="font-weight: 700; color: #0f172a;">0.00 ر.س</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: #64748b;">
                            <span>ضريبة القيمة المضافة (15%):</span>
                            <span id="prev-vat" style="font-weight: 700; color: #0f172a;">0.00 ر.س</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: #0f172a; font-weight: 900; font-size: 1.1rem; border-top: 2px solid #0f172a; padding-top: 0.5rem; margin-top: 0.3rem;">
                            <span>الإجمالي الكلي:</span>
                            <span id="prev-total" style="color: #0f172a;">0.00 ر.س</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }
    #printable-invoice, #printable-invoice * {
        visibility: visible !important;
    }
    #printable-invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
function addInvoiceItem() {
    const container = document.getElementById('inv-items-container');
    const row = document.createElement('div');
    row.className = 'inv-item-row';
    row.style.cssText = "display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 0.5rem; align-items: center;";
    row.innerHTML = `
        <input type="text" class="item-desc" placeholder="الوصف" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
        <input type="number" class="item-qty" value="1" min="1" placeholder="الكمية" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
        <input type="number" class="item-price" value="500" min="0" step="any" placeholder="السعر" oninput="updateInvoicePreview()" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.6rem; color: #fff; font-size: 0.85rem;">
        <button type="button" onclick="removeInvoiceItem(this)" style="background: none; border: none; color: #ff5555; cursor: pointer; font-size: 1.1rem; padding: 0 4px;">✕</button>
    `;
    container.appendChild(row);
    updateInvoicePreview();
}

function removeInvoiceItem(btn) {
    const rows = document.querySelectorAll('.inv-item-row');
    if (rows.length > 1) {
        btn.closest('.inv-item-row').remove();
        updateInvoicePreview();
    }
}

// ZATCA TLV encoding helper in pure JS
function toTlvJs(tag, val) {
    const enc = new TextEncoder();
    const bytes = enc.encode(val);
    const tagByte = new Uint8Array([tag]);
    const lenByte = new Uint8Array([bytes.length]);
    const combined = new Uint8Array(2 + bytes.length);
    combined.set(tagByte, 0);
    combined.set(lenByte, 1);
    combined.set(bytes, 2);
    return combined;
}

function buildZatcaTlvBase64(seller, vatNo, timestamp, total, vat) {
    const p1 = toTlvJs(1, seller);
    const p2 = toTlvJs(2, vatNo);
    const p3 = toTlvJs(3, timestamp);
    const p4 = toTlvJs(4, total.toFixed(2));
    const p5 = toTlvJs(5, vat.toFixed(2));

    const totalLen = p1.length + p2.length + p3.length + p4.length + p5.length;
    const all = new Uint8Array(totalLen);
    let offset = 0;
    [p1, p2, p3, p4, p5].forEach(p => {
        all.set(p, offset);
        offset += p.length;
    });

    let binary = '';
    for (let i = 0; i < all.length; i++) {
        binary += String.fromCharCode(all[i]);
    }
    return btoa(binary);
}

function updateInvoicePreview() {
    const seller = document.getElementById('inv-seller').value || 'مؤسسة تجارية';
    const vatNo = document.getElementById('inv-vat-no').value || '300000000000003';
    const cr = document.getElementById('inv-cr').value || '1010000000';
    const buyer = document.getElementById('inv-buyer').value || 'العميل';
    const invNo = document.getElementById('inv-number').value || 'INV-001';
    const invDate = document.getElementById('inv-date').value || '{{ date("Y-m-d") }}';

    document.getElementById('prev-seller').textContent = seller;
    document.getElementById('prev-vat-no').textContent = vatNo;
    document.getElementById('prev-cr').textContent = cr;
    document.getElementById('prev-buyer').textContent = buyer;
    document.getElementById('prev-number').textContent = invNo;
    document.getElementById('prev-date').textContent = invDate;

    const tbody = document.getElementById('prev-items-tbody');
    tbody.innerHTML = '';
    let subtotal = 0;

    document.querySelectorAll('.inv-item-row').forEach(row => {
        const desc = row.querySelector('.item-desc').value || 'بند خدمة';
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const price = parseFloat(row.querySelector('.item-price').value) || 0;
        const lineTotal = qty * price;
        subtotal += lineTotal;

        const tr = document.createElement('tr');
        tr.style.borderBottom = '1px solid #f1f5f9';
        tr.innerHTML = `
            <td style="padding: 8px 12px; color: #1e293b;">${desc}</td>
            <td style="padding: 8px; text-align: center; color: #64748b;">${qty}</td>
            <td style="padding: 8px; text-align: left; color: #64748b;">${price.toFixed(2)}</td>
            <td style="padding: 8px 12px; text-align: left; font-weight: 700; color: #0f172a;">${lineTotal.toFixed(2)}</td>
        `;
        tbody.appendChild(tr);
    });

    const vat = subtotal * 0.15;
    const total = subtotal + vat;

    document.getElementById('prev-subtotal').textContent = subtotal.toFixed(2) + ' ر.س';
    document.getElementById('prev-vat').textContent = vat.toFixed(2) + ' ر.س';
    document.getElementById('prev-total').textContent = total.toFixed(2) + ' ر.س';

    // Render ZATCA QR
    const qrCanvas = document.getElementById('inv-zatca-qr');
    const isoDate = new Date(invDate).toISOString();
    const tlvBase64 = buildZatcaTlvBase64(seller, vatNo, isoDate, total, vat);

    if (window.QRCode && window.QRCode.toCanvas) {
        QRCode.toCanvas(qrCanvas, tlvBase64, {
            width: 110,
            margin: 0
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    let checkInterval = setInterval(() => {
        if (window.QRCode) {
            clearInterval(checkInterval);
            updateInvoicePreview();
        }
    }, 100);
});
</script>
@endpush
@endsection
