@extends('layouts.app')

@section('title', 'محرر المحتوى والصفحات المرئي المباشر')
@section('page_title', 'المحرر السيادي المباشر')

@section('content')
<div class="nw-dashboard-page" style="padding: 2.5rem 0 5rem;">
    <div class="nw-container" style="max-width: 1500px;">

        {{-- Top Header & Navigation --}}
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <a href="{{ route('dashboard') }}" style="color: var(--nawader-gold); font-size: 0.85rem; text-decoration: none;">لوحة التحكم السيادية</a>
                    <span style="color: var(--text-muted);">/</span>
                    <span style="color: var(--text-primary); font-size: 0.85rem; font-weight: 600;">محرر الصفحات والمحتوى الحي</span>
                </div>
                <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin: 0; display: flex; align-items: center; gap: 0.75rem;">
                    <span>🎨 محرر الصفحات والمحتوى السيادي الحي</span>
                    <span class="nw-badge nw-badge-gold">Live Visual CMS</span>
                </h1>
                <p style="color: var(--text-secondary); font-size: 0.95rem; margin-top: 0.35rem;">
                    تحكم فوري ومباشر في نصوص، شارات، عناوين، وأزرار المنظومة مع معاينة حية لحظية بنظام تقسيم الشاشة.
                </p>
            </div>

            {{-- Actions --}}
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <a href="{{ route('dashboard.editor.export') }}" class="nw-btn nw-btn-outline nw-btn-sm" style="border-color: rgba(212,168,67,0.3); color: var(--nawader-gold);">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    تصدير JSON
                </a>
                <label class="nw-btn nw-btn-outline nw-btn-sm" style="border-color: rgba(0,212,200,0.3); color: var(--nawader-teal); cursor: pointer;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    استيراد JSON
                    <input type="file" id="import-json-file" accept=".json" style="display: none;" onchange="importContentJson(this)">
                </label>
                <button type="button" class="nw-btn nw-btn-danger nw-btn-sm" onclick="resetCurrentPage()">
                    🔄 استعادة الافتراضي
                </button>
            </div>
        </div>

        {{-- Page Switcher Tabs --}}
        <div style="display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06);">
            @foreach($schema as $pKey => $pData)
            <a href="{{ route('dashboard.editor', ['page' => $pKey]) }}" 
               class="nw-btn nw-btn-sm {{ $currentPage === $pKey ? 'nw-btn-primary' : 'nw-btn-ghost' }}"
               style="border-radius: 20px; padding: 0.45rem 1.15rem; white-space: nowrap; font-size: 0.88rem;">
                {{ $pData['title'] }}
            </a>
            @endforeach
        </div>

        {{-- Split-Screen Editor Layout --}}
        <div style="display: grid; grid-template-columns: 480px 1fr; gap: 1.5rem; align-items: start;">

            {{-- Left Side (Right in RTL): Form Fields Control Panel --}}
            <div style="background: rgba(15,23,40,0.85); backdrop-filter: blur(25px); border: 1px solid rgba(212,168,67,0.2); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--shadow-card);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.85rem;">
                    <div>
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--nawader-gold); margin: 0;">
                            تعديل: {{ $currentSchema['title'] }}
                        </h2>
                        <span style="font-size: 0.78rem; color: var(--text-muted);">التغييرات تنعكس فورياً في المعاينة</span>
                    </div>
                    <span class="nw-badge nw-badge-teal" id="save-status-indicator">جاهز للتعديل</span>
                </div>

                <form id="editor-form" onsubmit="event.preventDefault(); savePageContent();">
                    <input type="hidden" name="page" id="editor-page-name" value="{{ $currentPage }}">

                    <div style="display: flex; flex-direction: column; gap: 1.15rem; max-height: 65vh; overflow-y: auto; padding-left: 0.5rem;">
                        @foreach($mergedFields as $key => $field)
                        <div class="editor-field-group">
                            <label for="field-{{ $key }}" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 0.35rem;">
                                <span>{{ $field['label'] }}</span>
                                <span style="font-size: 0.72rem; color: var(--text-muted); font-family: monospace;">{{ $key }}</span>
                            </label>

                            @if($field['type'] === 'textarea')
                            <textarea id="field-{{ $key }}" 
                                      name="fields[{{ $key }}]" 
                                      rows="3" 
                                      class="nw-input" 
                                      style="width: 100%; border-radius: var(--radius-sm); font-size: 0.88rem; line-height: 1.5;"
                                      oninput="handleFieldLiveUpdate('{{ $key }}', this.value)">{{ $field['value'] }}</textarea>
                            @else
                            <input type="text" 
                                   id="field-{{ $key }}" 
                                   name="fields[{{ $key }}]" 
                                   value="{{ $field['value'] }}" 
                                   class="nw-input" 
                                   style="width: 100%; border-radius: var(--radius-sm); font-size: 0.88rem;"
                                   oninput="handleFieldLiveUpdate('{{ $key }}', this.value)">
                            @endif

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.25rem;">
                                <span style="font-size: 0.72rem; color: var(--text-muted); max-width: 80%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    الافتراضي: {{ $field['default'] }}
                                </span>
                                <button type="button" 
                                        onclick="restoreFieldDefault('{{ $key }}', '{{ addslashes($field['default']) }}')" 
                                        style="background: none; border: none; font-size: 0.72rem; color: var(--nawader-gold); cursor: pointer; text-decoration: underline;">
                                    استعادة
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.06); display: flex; gap: 0.75rem;">
                        <button type="submit" id="save-content-btn" class="nw-btn nw-btn-primary" style="flex: 1; font-weight: 700;">
                            💾 حفظ التغييرات السيادية
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right Side (Left in RTL): Live Responsive Viewport & Iframe Preview --}}
            <div style="background: rgba(10,15,30,0.92); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius-lg); overflow: hidden; display: flex; flex-direction: column; height: 80vh; box-shadow: var(--shadow-card);">
                
                {{-- Viewport Top Toolbar --}}
                <div style="padding: 0.75rem 1.25rem; background: rgba(15,23,40,0.95); border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.35rem;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #00D4C8; display: inline-block;"></span>
                            معاينة حية للمتصفح:
                        </span>
                        <span style="font-size: 0.78rem; font-family: monospace; color: var(--nawader-gold); background: rgba(212,168,67,0.1); padding: 2px 8px; border-radius: 4px;">
                            {{ $previewUrl }}
                        </span>
                    </div>

                    {{-- Responsive Screen Device Buttons --}}
                    <div style="display: flex; align-items: center; gap: 0.4rem;">
                        <button type="button" class="ls-btn active preview-device-btn" onclick="setPreviewSize('100%', this)" title="شاشة سطح المكتب الكبرى">
                            🖥️ سطح المكتب
                        </button>
                        <button type="button" class="ls-btn preview-device-btn" onclick="setPreviewSize('768px', this)" title="جهاز لوحي iPad">
                            📱 لوحي (768px)
                        </button>
                        <button type="button" class="ls-btn preview-device-btn" onclick="setPreviewSize('390px', this)" title="هاتف ذكي Mobile">
                            📲 جوال (390px)
                        </button>
                        <button type="button" class="ls-btn" onclick="reloadPreviewFrame()" title="إعادة تحميل المعاينة">
                            🔄
                        </button>
                    </div>
                </div>

                {{-- Iframe Container --}}
                <div id="preview-wrapper" style="flex: 1; background: #020408; display: flex; justify-content: center; align-items: stretch; overflow: auto; transition: all 0.3s ease;">
                    <iframe id="preview-frame" 
                            src="{{ $previewUrl }}" 
                            style="width: 100%; height: 100%; border: none; transition: width 0.3s ease;"
                            title="معاينة الصفحة الحية"></iframe>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
// Live update preview frame on input
function handleFieldLiveUpdate(key, value) {
    const status = document.getElementById('save-status-indicator');
    if (status) {
        status.textContent = 'تعديلات معلقة...';
        status.className = 'nw-badge nw-badge-gold';
    }

    try {
        const frame = document.getElementById('preview-frame');
        if (frame && frame.contentWindow) {
            frame.contentWindow.postMessage({
                type: 'NAWADER_LIVE_CONTENT_UPDATE',
                key: key,
                value: value
            }, '*');
        }
    } catch (e) {
        // Cross-origin fallback
    }
}

// Restore single field default
function restoreFieldDefault(key, defaultValue) {
    const input = document.getElementById('field-' + key);
    if (input) {
        input.value = defaultValue;
        handleFieldLiveUpdate(key, defaultValue);
    }
}

// Save content blocks via AJAX
function savePageContent() {
    const btn = document.getElementById('save-content-btn');
    const status = document.getElementById('save-status-indicator');
    const page = document.getElementById('editor-page-name').value;
    
    const form = document.getElementById('editor-form');
    const formData = new FormData(form);
    
    btn.disabled = true;
    btn.innerHTML = '⏳ جاري الحفظ والتثبيت...';

    fetch('{{ route("dashboard.editor.save") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            page: page,
            fields: Object.fromEntries(
                Array.from(formData.entries())
                    .filter(([k]) => k.startsWith('fields['))
                    .map(([k, v]) => [k.replace('fields[', '').replace(']', ''), v])
            )
        })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '💾 حفظ التغييرات السيادية';
        if (data.status === 'success') {
            status.textContent = 'تم الحفظ والاعتماد ✓';
            status.className = 'nw-badge nw-badge-teal';
            reloadPreviewFrame();
        } else {
            alert(data.message || 'حدث خطأ أثناء الحفظ.');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '💾 حفظ التغييرات السيادية';
        alert('تعذر الاتصال بالخادم.');
    });
}

// Reset page back to default
function resetCurrentPage() {
    if (!confirm('هل أنت متأكد من استعادة المحتوى الافتراضي لهذه الصفحة؟ سيتم إلغاء التعديلات المخصصة.')) {
        return;
    }
    const page = document.getElementById('editor-page-name').value;

    fetch('{{ route("dashboard.editor.reset") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ page: page })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.reload();
        }
    });
}

// Reload preview frame
function reloadPreviewFrame() {
    const frame = document.getElementById('preview-frame');
    if (frame) {
        frame.src = frame.src.split('#')[0] + '?t=' + new Date().getTime();
    }
}

// Responsive device switcher
function setPreviewSize(width, btn) {
    document.querySelectorAll('.preview-device-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    const frame = document.getElementById('preview-frame');
    if (frame) {
        frame.style.width = width;
    }
}

// Import JSON configuration
function importContentJson(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const formData = new FormData();
    formData.append('file', file);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("dashboard.editor.import") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message || 'فشل الاستيراد.');
        }
    })
    .catch(() => alert('حدث خطأ أثناء رفع الملف.'));
}
</script>
@endsection
