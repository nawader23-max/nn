@extends('layouts.app')

@section('title', 'محرك استيعاب الوثائق وفك الأرشيفات السيادي')
@section('page_title', 'محرك استيعاب الوثائق الذكي')

@section('content')
<div class="nw-dashboard-page" style="padding: 2.5rem 0 5rem;">
    <div class="nw-container" style="max-width: 1350px;">

        {{-- Header & Breadcrumbs --}}
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <a href="{{ route('dashboard') }}" style="color: var(--nawader-gold); font-size: 0.85rem; text-decoration: none;">لوحة التحكم السيادية</a>
                    <span style="color: var(--text-muted);">/</span>
                    <span style="color: var(--text-primary); font-size: 0.85rem; font-weight: 600;">محرك استيعاب وفك الأرشيفات والوثائق</span>
                </div>
                <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                    <span>📂 محرك استيعاب الوثائق وفك الأرشيفات الكبرى</span>
                    <span class="nw-badge nw-badge-teal">High-Capacity Engine</span>
                </h1>
                <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.35rem;">
                    رفع تلقائي وفك ضغط فوري لأي أرشيف مضغوط (.zip, .tar.gz) أو وثيقة منفردة، وتحليل المحتوى وتوزيعه آلياً على أقسام العقود، المالية، الكوادر، والربط التقني.
                </p>
            </div>

            {{-- Export Hub --}}
            <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                <a href="{{ route('dashboard.importer.export', ['type' => 'all_zip']) }}" class="nw-btn nw-btn-primary nw-btn-sm" style="font-weight: 700;">
                    📦 تحميل الأرشيف الكامل (.ZIP)
                </a>
                <a href="{{ route('dashboard.importer.export', ['type' => 'contracts']) }}" class="nw-btn nw-btn-outline nw-btn-sm" style="border-color: rgba(212,168,67,0.3); color: var(--nawader-gold);">
                    📜 تصدير العقود (CSV)
                </a>
                <a href="{{ route('dashboard.importer.export', ['type' => 'transactions']) }}" class="nw-btn nw-btn-outline nw-btn-sm" style="border-color: rgba(0,212,200,0.3); color: var(--nawader-teal);">
                    💳 تصدير القيود المالية (CSV)
                </a>
            </div>
        </div>

        {{-- Statistics Overview --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: rgba(15,23,40,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(212,168,67,0.2); border-radius: var(--radius-md); padding: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.35rem;">📜 إجمالي العقود الرقمية</div>
                <div style="font-size: 1.85rem; font-weight: 800; color: var(--nawader-gold);">{{ number_format($stats['total_contracts']) }}</div>
                <div style="font-size: 0.72rem; color: var(--nawader-gold-light);">موثقة ببصمة SHA-256</div>
            </div>

            <div style="background: rgba(15,23,40,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(0,212,200,0.2); border-radius: var(--radius-md); padding: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.35rem;">💳 قيود الخزينة والمحفظة</div>
                <div style="font-size: 1.85rem; font-weight: 800; color: var(--nawader-teal);">{{ number_format($stats['total_transactions']) }}</div>
                <div style="font-size: 0.72rem; color: var(--nawader-teal);">مسجلة ومطابقة لسداد</div>
            </div>

            <div style="background: rgba(15,23,40,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(123,92,228,0.2); border-radius: var(--radius-md); padding: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.35rem;">🔌 مفاتيح وتكاملات الأنظمة</div>
                <div style="font-size: 1.85rem; font-weight: 800; color: var(--nawader-purple);">{{ number_format($stats['total_integrations']) }}</div>
                <div style="font-size: 0.72rem; color: rgba(240,244,255,0.6);">نشطة ومحمية بالقبو</div>
            </div>

            <div style="background: rgba(15,23,40,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-md); padding: 1.25rem;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.35rem;">✨ مخرجات ومواد الأستديو</div>
                <div style="font-size: 1.85rem; font-weight: 800; color: var(--text-primary);">{{ number_format($stats['total_generations']) }}</div>
                <div style="font-size: 0.72rem; color: var(--text-muted);">أصول ثلاثية وسينمائية</div>
            </div>
        </div>

        {{-- Success Import Summary Banner (If flash message present) --}}
        @if(session('import_summary'))
        @php $summary = session('import_summary'); @endphp
        <div style="background: rgba(0,212,200,0.08); border: 1px solid var(--nawader-teal); border-radius: var(--radius-lg); padding: 1.75rem; margin-bottom: 2rem; box-shadow: var(--shadow-teal);">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--nawader-teal); margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                        <span>✅ تم إكمال استيعاب وتحليل الأرشيف السيادي</span>
                        <span class="nw-badge nw-badge-teal">{{ $summary['batch_id'] }}</span>
                    </h3>
                    <p style="color: var(--text-secondary); font-size: 0.88rem; margin-top: 0.25rem;">
                        الملف المصدري: <strong style="color: var(--text-primary);">{{ $summary['archive_name'] }}</strong> — إجمالي الملفات المعالجة: <strong style="color: var(--nawader-gold);">{{ $summary['total_files'] }}</strong> ملف.
                    </p>
                </div>
            </div>

            {{-- Category Distribution Breakdown --}}
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem;">
                <div style="background: rgba(15,23,40,0.8); padding: 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); text-align: center;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">عقود واتفاقيات</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--nawader-gold);">{{ $summary['distribution']['contracts'] }}</div>
                </div>
                <div style="background: rgba(15,23,40,0.8); padding: 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); text-align: center;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">قيود مالية</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--nawader-teal);">{{ $summary['distribution']['transactions'] }}</div>
                </div>
                <div style="background: rgba(15,23,40,0.8); padding: 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); text-align: center;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">موظفون ومستخدمون</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #fff;">{{ $summary['distribution']['users'] }}</div>
                </div>
                <div style="background: rgba(15,23,40,0.8); padding: 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); text-align: center;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">تكاملات ومفاتيح</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--nawader-purple);">{{ $summary['distribution']['integrations'] }}</div>
                </div>
                <div style="background: rgba(15,23,40,0.8); padding: 0.85rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.06); text-align: center;">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">مواد وأصول أستديو</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: var(--nawader-rose);">{{ $summary['distribution']['studio'] }}</div>
                </div>
            </div>

            {{-- Table of Ingested Items --}}
            @if(count($summary['items']) > 0)
            <div style="background: rgba(10,15,30,0.9); border-radius: 10px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08);">
                <div style="padding: 0.75rem 1rem; background: rgba(15,23,40,0.9); font-size: 0.82rem; font-weight: 700; color: var(--text-primary); border-bottom: 1px solid rgba(255,255,255,0.08);">
                    تفاصيل السجلات الموزعة في قاعدة البيانات:
                </div>
                <div style="max-height: 250px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.82rem;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.06); color: var(--text-muted); text-align: right;">
                                <th style="padding: 0.6rem 1rem;">القسم الوجهة</th>
                                <th style="padding: 0.6rem 1rem;">البيان / العنوان</th>
                                <th style="padding: 0.6rem 1rem;">المعرف الرقمي</th>
                                <th style="padding: 0.6rem 1rem;">حالة القيد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($summary['items'] as $item)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                                <td style="padding: 0.6rem 1rem; color: var(--nawader-gold); font-weight: 600;">{{ $item['section'] }}</td>
                                <td style="padding: 0.6rem 1rem; color: var(--text-primary);">{{ $item['name'] }}</td>
                                <td style="padding: 0.6rem 1rem; font-family: monospace; color: var(--text-muted);">{{ $item['id'] }}</td>
                                <td style="padding: 0.6rem 1rem;"><span class="nw-badge nw-badge-teal" style="font-size: 0.7rem;">{{ $item['status'] }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Upload & Extraction Drag-and-Drop Card --}}
        <div style="background: rgba(15,23,40,0.85); backdrop-filter: blur(25px); border: 2px dashed rgba(212,168,67,0.3); border-radius: var(--radius-xl); padding: 3rem 2rem; text-align: center; margin-bottom: 3rem; transition: all 0.3s ease; position: relative;" id="drop-zone">
            
            <form action="{{ route('dashboard.importer.upload') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <input type="file" name="archive_file" id="archive-file-input" style="display: none;" onchange="handleFileSelected(this)">

                <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(212,168,67,0.1); border: 1px solid rgba(212,168,67,0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2.5rem;">
                    📦
                </div>

                <h2 style="font-size: 1.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.5rem;">
                    اسحب وأسقط الأرشيف أو الوثيقة هنا، أو انقر للاختيار
                </h2>
                <p style="color: var(--text-secondary); font-size: 0.92rem; max-width: 600px; margin: 0 auto 1.5rem; line-height: 1.6;">
                    يدعم المحرك حزم الأرشيف المضغوطة <strong>(.ZIP, .TAR.GZ)</strong> والوثائق الرقمية <strong>(.PDF, .DOCX, .XLSX, .CSV, .JSON)</strong> حتى سعة <strong>50 ميجابايت</strong> للملف.
                </p>

                <button type="button" class="nw-btn nw-btn-primary nw-btn-lg" onclick="document.getElementById('archive-file-input').click()" style="padding: 0.85rem 2.5rem; font-size: 1rem; font-weight: 700;">
                    📁 اختيار ملف أو أرشيف من جهازك
                </button>

                {{-- Selected File Preview Pill --}}
                <div id="file-preview-pill" style="display: none; margin-top: 1.5rem; align-items: center; justify-content: center; gap: 0.75rem;">
                    <div style="background: rgba(0,212,200,0.1); border: 1px solid var(--nawader-teal); border-radius: 30px; padding: 0.5rem 1.25rem; display: inline-flex; align-items: center; gap: 0.75rem;">
                        <span id="selected-file-name" style="color: var(--nawader-teal); font-weight: 600; font-size: 0.88rem;"></span>
                        <span id="selected-file-size" style="color: var(--text-muted); font-size: 0.78rem;"></span>
                        <button type="submit" id="start-upload-btn" class="nw-btn nw-btn-teal nw-btn-sm" style="padding: 3px 12px; font-weight: 700;">
                            ⚡ بدء المعالجة والفرز الآلي
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- How It Works --}}
        <div style="margin-top: 3rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.5rem; text-align: center;">
                آلية عمل محرك الفرز والاستيعاب السيادي الذكي
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                <div style="background: rgba(15,23,40,0.6); border: 1px solid rgba(255,255,255,0.06); border-radius: var(--radius-md); padding: 1.5rem;">
                    <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">1️⃣ فك الضغط في بيئة معزولة</div>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.7;">
                        يتم فك حزم ZIP و TAR.GZ تلقائياً داخل مسار سحابي آمن ومشفر دون تعريض خوادم الإنتاج لأي مخاطر أمنية.
                    </p>
                </div>
                <div style="background: rgba(15,23,40,0.6); border: 1px solid rgba(255,255,255,0.06); border-radius: var(--radius-md); padding: 1.5rem;">
                    <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">2️⃣ التحليل الدلالي بالذكاء الاصطناعي</div>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.7;">
                        قراءة الترويسات والنصوص والبيانات الوصفية، والتعرف التلقائي على أطراف التعاقد، المبالغ المالية، وأكواد الـ APIs.
                    </p>
                </div>
                <div style="background: rgba(15,23,40,0.6); border: 1px solid rgba(255,255,255,0.06); border-radius: var(--radius-md); padding: 1.5rem;">
                    <div style="font-size: 1.75rem; margin-bottom: 0.75rem;">3️⃣ التوزيع والتسجيل الآمن</div>
                    <p style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.7;">
                        تغذية الجداول السيادية المناسبة فورياً مع توليد بصمة SHA-256 وحفظ نسخة أصلية في الأرشيف الموثق.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function handleFileSelected(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const pill = document.getElementById('file-preview-pill');
    const nameEl = document.getElementById('selected-file-name');
    const sizeEl = document.getElementById('selected-file-size');

    nameEl.textContent = file.name;
    sizeEl.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
    pill.style.display = 'flex';
}

// Drag & drop highlight
const dropZone = document.getElementById('drop-zone');
['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.style.borderColor = 'var(--nawader-teal)';
        dropZone.style.background = 'rgba(0,212,200,0.05)';
    }, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.style.borderColor = 'rgba(212,168,67,0.3)';
        dropZone.style.background = 'rgba(15,23,40,0.85)';
    }, false);
});

dropZone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    if (files.length > 0) {
        document.getElementById('archive-file-input').files = files;
        handleFileSelected(document.getElementById('archive-file-input'));
    }
});
</script>
@endsection
