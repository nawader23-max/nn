@extends('layouts.app')

@section('title', 'غرفة قيادة التكاملات ومفاتيح الربط البرمجي — نوادر')
@section('page_title', 'غرفة قيادة التكاملات والمفاتيح')

@push('head')
<style>
.nw-integ-page { padding: 120px 0 90px; position: relative; }
.integ-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(95px); }

.integ-group-nav {
  display: flex; gap: 0.6rem; overflow-x: auto; padding-bottom: 0.5rem; margin-bottom: 2.5rem;
}
.integ-nav-btn {
  padding: 0.65rem 1.25rem; border-radius: 12px; background: rgba(15,23,40,0.8);
  border: 1px solid rgba(255,255,255,0.08); color: var(--text-secondary); font-size: 0.84rem;
  font-weight: 700; cursor: pointer; transition: all 0.25s; white-space: nowrap; font-family: var(--font-arabic);
}
.integ-nav-btn.active, .integ-nav-btn:hover {
  background: rgba(212,168,67,0.15); border-color: var(--nawader-gold); color: var(--nawader-gold);
}
.provider-box {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 2rem;
  margin-bottom: 1.75rem; transition: all 0.3s;
}
.provider-box:hover {
  border-color: rgba(0,212,200,0.3);
}
.status-pill-connected {
  background: rgba(0,212,200,0.12); color: var(--nawader-teal); border: 1px solid rgba(0,212,200,0.3);
  padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;
}
.status-pill-ready {
  background: rgba(212,168,67,0.12); color: var(--nawader-gold); border: 1px solid rgba(212,168,67,0.3);
  padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700;
}
</style>
@endpush

@section('content')
<div class="nw-integ-page">
  <div class="integ-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(0,212,200,0.12) 0%,transparent 70%);"></div>
  <div class="integ-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(212,168,67,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="nw-section-eyebrow" style="margin-bottom:0.4rem;">منظومة الربط الشاملة</div>
        <h1 style="font-size:1.85rem;font-weight:900;color:#fff;">غرفة قيادة التكاملات ومفاتيح الربط (API Key Vault)</h1>
        <p style="font-size:0.86rem;color:var(--text-muted);margin-top:0.3rem;">
          تُعرض هنا حالة إعداد كل تكامل بناءً على المفاتيح المحفوظة فعلياً. لا نعتبر التكامل متصلاً قبل نجاح فحصه من مزود الخدمة.
        </p>
      </div>
      <div>
        <span style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);padding:0.6rem 1.25rem;border-radius:14px;font-size:0.82rem;color:var(--text-secondary);">
          🔒 المفاتيح محمية ومخفاة داخل إعدادات التطبيق
        </span>
      </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.4);border-radius:14px;padding:1rem 1.5rem;margin-bottom:2rem;color:var(--nawader-teal);display:flex;align-items:center;gap:0.75rem;">
      <span>✓</span>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Group Navigation Tabs -->
    <div class="integ-group-nav">
      @foreach($groups as $grpKey => $grp)
      <button class="integ-nav-btn {{ $loop->first ? 'active' : '' }}" onclick="switchGroup('{{ $grpKey }}', this)">
        <span>{{ $grp['icon'] }}</span>
        <span>{{ $grp['title'] }}</span>
      </button>
      @endforeach
    </div>

    <!-- Integration Groups Panels -->
    @foreach($groups as $grpKey => $grp)
    <div id="group-panel-{{ $grpKey }}" class="integ-panel" style="{{ $loop->first ? 'display:block;' : 'display:none;' }}">
      
      <div style="display:grid;grid-template-columns:1fr;gap:1.5rem;">
        @foreach($grp['providers'] as $provKey => $prov)
        <div class="provider-box">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
            <div>
              <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.3rem;">
                <h3 style="font-size:1.2rem;font-weight:800;color:#fff;margin:0;">{{ $prov['name'] }}</h3>
                <span class="{{ $prov['status'] === 'connected' ? 'status-pill-connected' : 'status-pill-ready' }}">
                  {{ $prov['status'] === 'connected' ? 'مهيأ — يحتاج تحققاً خارجياً' : 'غير مهيأ' }}
                </span>
                <span style="font-size:0.75rem;color:var(--nawader-gold);">{{ $prov['badge'] }}</span>
              </div>
              <p style="font-size:0.84rem;color:var(--text-muted);margin:0;">{{ $prov['desc'] }}</p>
            </div>

            <div>
              <button type="button" class="nw-btn nw-btn-ghost" style="padding:0.4rem 0.9rem;font-size:0.78rem;" onclick="testEngine('{{ $provKey }}')">
                ⚡ فحص الاتصال بالمحرك
              </button>
            </div>
          </div>

          <!-- Key Configuration Form -->
          <form method="POST" action="{{ route('dashboard.integrations.key') }}">
            @csrf
            <input type="hidden" name="provider" value="{{ $provKey }}">
            <input type="hidden" name="group" value="{{ $grpKey }}">

            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:1rem;margin-bottom:1.25rem;">
              @foreach($prov['keys'] as $k => $label)
              <div>
                <label class="nw-label" style="font-size:0.78rem;">{{ $label }}</label>
                <input type="password" name="value" class="nw-input" placeholder="أدخل قيمة المفتاح هنا..." value="{{ \App\Services\Integrations\SovereignIntegrationsManager::getKey($provKey, $k) ? '••••••••••••••••••••••••' : '' }}">
                <input type="hidden" name="key" value="{{ $k }}">
              </div>
              @endforeach
            </div>

            <div style="display:flex;justify-content:flex-end;">
              <button type="submit" class="nw-btn nw-btn-primary" style="padding:0.5rem 1.25rem;font-size:0.82rem;">
                💾 حفظ وتفعيل المحرك
              </button>
            </div>
          </form>
        </div>
        @endforeach
      </div>

    </div>
    @endforeach

  </div>
</div>

<script>
function switchGroup(groupKey, btn) {
  document.querySelectorAll('.integ-nav-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('.integ-panel').forEach(p => p.style.display = 'none');
  const target = document.getElementById('group-panel-' + groupKey);
  if (target) target.style.display = 'block';
}

function testEngine(provider) {
  fetch("{{ route('dashboard.integrations.test') }}?provider=" + provider)
    .then(r => r.json())
    .then(data => {
      alert("نتيجة فحص المحرك:\n" + data.message);
    })
    .catch(() => {
      alert("تعذر الوصول إلى فحص المحرك حالياً. راجع إعدادات الشبكة والمفاتيح ثم أعد المحاولة.");
    });
}
</script>
@endsection
