@extends('layouts.app')

@section('title', 'بوابة المطورين والربط التقني للمنصات الخارجية — نوادر')
@section('page_title', 'مركز تكامل المنصات الخارجية ومفاتيح الـ API')

@push('head')
<style>
.nw-dev-page { padding: 120px 0 80px; position: relative; }
.dev-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(100px); }

.dev-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 2rem;
  margin-bottom: 2rem; transition: all 0.3s;
}
.dev-card:hover {
  border-color: rgba(0,212,200,0.3);
  box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

.code-snippet-box {
  background: rgba(8,12,24,0.9); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px; padding: 1.25rem; font-family: monospace; font-size: 0.82rem;
  color: #a5b4fc; direction: ltr; text-align: left; overflow-x: auto;
}
.token-badge-live { background: rgba(34,197,94,0.12); color: #22c55e; border: 1px solid rgba(34,197,94,0.3); padding: 3px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; }
.token-badge-sandbox { background: rgba(234,179,8,0.12); color: #eab308; border: 1px solid rgba(234,179,8,0.3); padding: 3px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="nw-dev-page">
  <div class="dev-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>
  <div class="dev-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(212,168,67,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="nw-section-eyebrow" style="margin-bottom:0.4rem;">منظومة الربط البرمجي (B2B API & Webhooks)</div>
        <h1 style="font-size:1.85rem;font-weight:900;color:#fff;">بوابة المطورين والربط التقني للمنصات الخارجية</h1>
      </div>
      <div style="display:flex;gap:0.75rem;">
        <button onclick="document.getElementById('token-form-container').scrollIntoView({behavior:'smooth'})" class="nw-btn nw-btn-primary">
          <span>⚡</span>
          <span>إصدار مفتاح ربط جديد</span>
        </button>
      </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.4);border-radius:14px;padding:1rem 1.5rem;margin-bottom:2rem;color:var(--nawader-teal);display:flex;align-items:center;gap:0.75rem;">
      <span>✓</span>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('new_token'))
    <div style="background:rgba(212,168,67,0.15);border:1px solid var(--nawader-gold);border-radius:16px;padding:1.5rem;margin-bottom:2rem;">
      <div style="color:var(--nawader-gold);font-weight:800;margin-bottom:0.5rem;font-size:1rem;">⚠️ تم إنشاء مفتاح الربط السيادي بنجاح:</div>
      <div style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:0.75rem;">احفظ هذا المفتاح في مكان آمن الآن، فلن تتمكن من رؤيته مرة أخرى:</div>
      <div style="background:rgba(0,0,0,0.6);border:1px dashed rgba(212,168,67,0.5);border-radius:10px;padding:0.85rem 1rem;font-family:monospace;font-size:0.95rem;color:#fff;direction:ltr;text-align:left;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <span id="revealed-new-token">{{ session('new_token') }}</span>
        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('revealed-new-token').innerText);alert('تم نسخ المفتاح إلى الحافظة!');" class="nw-btn nw-btn-sm nw-btn-primary">نسخ</button>
      </div>
    </div>
    @endif

    <!-- Section 1: Active API Tokens -->
    <div class="dev-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;">مفاتيح الربط السيادي (API Tokens)</h2>
          <div style="font-size:0.78rem;color:var(--text-muted);">مفاتيح مصادقة مشفرة تتيح لمنصتك استدعاء واجهات نوادر آلياً</div>
        </div>
      </div>

      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.85rem;text-align:right;">
          <thead>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.08);color:var(--text-muted);font-size:0.78rem;">
              <th style="padding:0.75rem 1rem;">اسم التطبيق / المفتاح</th>
              <th style="padding:0.75rem 1rem;">بادئة المفتاح</th>
              <th style="padding:0.75rem 1rem;">البيئة</th>
              <th style="padding:0.75rem 1rem;">الصلاحيات</th>
              <th style="padding:0.75rem 1rem;">آخر استدعاء</th>
              <th style="padding:0.75rem 1rem;text-align:center;">إجراء</th>
            </tr>
          </thead>
          <tbody>
            @forelse($tokens as $token)
            <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
              <td style="padding:1rem;font-weight:700;color:#fff;">{{ $token->name }}</td>
              <td style="padding:1rem;color:var(--nawader-teal);font-family:monospace;direction:ltr;text-align:right;">
                {{ $token->token_prefix }}••••••••
              </td>
              <td style="padding:1rem;">
                <span class="{{ $token->environment === 'live' ? 'token-badge-live' : 'token-badge-sandbox' }}">
                  {{ strtoupper($token->environment) }}
                </span>
              </td>
              <td style="padding:1rem;color:var(--text-muted);font-size:0.75rem;">
                {{ implode(', ', $token->abilities ?? ['all']) }}
              </td>
              <td style="padding:1rem;color:var(--text-muted);font-size:0.78rem;">
                {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'لم يُستخدم بعد' }}
              </td>
              <td style="padding:1rem;text-align:center;">
                <form method="POST" action="{{ route('dashboard.developer.revoke-token', $token->id) }}" onsubmit="return confirm('هل أنت متأكد من رغبتك في إبطال هذا المفتاح نهائياً؟');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="background:none;border:none;color:#ef4444;font-size:0.75rem;cursor:pointer;">إلغاء المفتاح ✕</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="padding:2rem;text-align:center;color:var(--text-muted);">
                لا توجد مفاتيح مسجلة. أنشئ مفتاحك الأول أدناه لربط نظامك الخارجي.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Create Token Form -->
      <div id="token-form-container" style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,0.08);">
        <h3 style="font-size:1rem;font-weight:700;color:var(--nawader-gold);margin-bottom:1rem;">توليد مفتاح ربط جديد</h3>
        <form method="POST" action="{{ route('dashboard.developer.create-token') }}" style="display:flex;gap:1rem;flex-wrap:wrap;align-items:flex-end;">
          @csrf
          <div style="flex:2;min-width:250px;">
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">اسم المنصة أو التطبيق المتصل</label>
            <input type="text" name="name" required placeholder="مثال: نظام إدارة العملاء أو تطبيق الشركاء" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:0.65rem 1rem;color:#fff;font-family:var(--font-arabic);outline:none;">
          </div>
          <div style="flex:1;min-width:160px;">
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">البيئة التشغيلية</label>
            <select name="environment" style="width:100%;background:rgba(15,23,40,0.9);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:0.65rem 1rem;color:#fff;font-family:var(--font-arabic);outline:none;">
              <option value="live">الإنتاج المباشر (Live)</option>
              <option value="sandbox">بيئة الاختبار والتجربة (Sandbox)</option>
            </select>
          </div>
          <button type="submit" class="nw-btn nw-btn-primary">
            <span>توليد المفتاح</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Section 2: Webhooks Management -->
    <div class="dev-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#fff;">أحداث الويب هوك اللحظية (Webhooks)</h2>
          <div style="font-size:0.78rem;color:var(--text-muted);">إشعارات برمجية فورية مشفرة بختم HMAC-SHA256 ترسل إلى خادمك عند توقيع العقود أو سداد الفواتير</div>
        </div>
      </div>

      <div style="margin-bottom:2rem;">
        @forelse($webhooks as $wh)
        <div style="background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:1.25rem;margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
          <div style="flex:1;min-width:280px;">
            <div style="font-family:monospace;color:var(--nawader-teal);font-size:0.9rem;direction:ltr;text-align:right;margin-bottom:0.4rem;">
              {{ $wh->url }}
            </div>
            <div style="display:flex;gap:0.4rem;flex-wrap:wrap;">
              @foreach($wh->events ?? [] as $ev)
                <span style="background:rgba(212,168,67,0.12);color:var(--nawader-gold);font-size:0.7rem;padding:2px 8px;border-radius:4px;font-family:monospace;">{{ $ev }}</span>
              @endforeach
            </div>
            <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.4rem;">
              السر المشفر: <span style="font-family:monospace;">{{ substr($wh->secret, 0, 10) }}••••••••</span> | 
              آخر إرسال: {{ $wh->last_dispatched_at ? $wh->last_dispatched_at->diffForHumans() : 'لم يُرسل بعد' }}
            </div>
          </div>
          <div>
            <form method="POST" action="{{ route('dashboard.developer.test-webhook', $wh->id) }}">
              @csrf
              <button type="submit" class="nw-btn nw-btn-sm nw-btn-ghost">
                <span>⚡ طلب اختبار التسليم</span>
              </button>
            </form>
          </div>
        </div>
        @empty
        <div style="padding:1.5rem;text-align:center;color:var(--text-muted);background:rgba(0,0,0,0.2);border-radius:12px;">
          لا توجد نقاط ويب هوك مسجلة بعد.
        </div>
        @endforelse
      </div>

      <!-- Register Webhook Form -->
      <div style="padding-top:1.5rem;border-top:1px solid rgba(255,255,255,0.08);">
        <h3 style="font-size:1rem;font-weight:700;color:var(--nawader-teal);margin-bottom:1rem;">إضافة نقطة استماع ويب هوك جديدة</h3>
        <form method="POST" action="{{ route('dashboard.developer.create-webhook') }}">
          @csrf
          <div style="margin-bottom:1rem;">
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">رابط الاستقبال على خادمك (Payload URL - HTTPS مطلوب)</label>
            <input type="url" name="url" required placeholder="https://api.yourcompany.com/nawader-webhooks" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:0.65rem 1rem;color:#fff;direction:ltr;font-family:monospace;outline:none;">
          </div>
          <div style="margin-bottom:1.25rem;">
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.5rem;">الأحداث التي ترغب بالاشتراك فيها</label>
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:0.75rem;">
              @foreach($availableEvents as $eKey => $eDesc)
              <label style="display:flex;align-items:center;gap:0.6rem;background:rgba(255,255,255,0.02);padding:0.6rem 0.8rem;border-radius:8px;border:1px solid rgba(255,255,255,0.05);cursor:pointer;font-size:0.8rem;">
                <input type="checkbox" name="events[]" value="{{ $eKey }}" checked>
                <div>
                  <div style="font-weight:700;color:#fff;font-family:monospace;">{{ $eKey }}</div>
                  <div style="font-size:0.72rem;color:var(--text-muted);">{{ $eDesc }}</div>
                </div>
              </label>
              @endforeach
            </div>
          </div>
          <button type="submit" class="nw-btn nw-btn-primary">
            <span>تسجيل الويب هوك</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Section 3: Interactive SDK Integration Guide -->
    <div class="dev-card">
      <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">نماذج الأكواد للربط البرمجي السريع (Integration SDKs)</h2>
      <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1.5rem;">
        يمكن لمهندسي البرمجيات في مؤسستك استدعاء واجهات نوادر بلغات متعددة. يتم توثيق كافة الطلبات بترويسة الأمان السيادية.
      </p>

      <div style="display:flex;gap:0.5rem;margin-bottom:1rem;">
        <button type="button" class="nw-btn nw-btn-sm nw-btn-primary" onclick="showSdkCode('curl')">cURL</button>
        <button type="button" class="nw-btn nw-btn-sm nw-btn-ghost" onclick="showSdkCode('python')">Python</button>
        <button type="button" class="nw-btn nw-btn-sm nw-btn-ghost" onclick="showSdkCode('php')">PHP (Laravel)</button>
        <button type="button" class="nw-btn nw-btn-sm nw-btn-ghost" onclick="showSdkCode('node')">Node.js</button>
      </div>

      <div id="code-curl" class="code-snippet-box">
curl -X POST https://nawadersrv.com/api/v1/contracts/create \
  -H "Authorization: Bearer nwdr_live_xxxxxxxxxxxxxxxxxxxxxxxx" \
  -H "Content-Type: application/json" \
  -H "X-Sovereign-Platform: Aramco-ERP-v2" \
  -d '{
    "title": "عقد توريدات هندسية سيادية لمنطقة أوكساجون",
    "amount": 1850000.00,
    "currency": "SAR",
    "second_party_national_id": "1073829105"
  }'
      </div>

      <div id="code-python" class="code-snippet-box" style="display:none;">
import requests

url = "https://nawadersrv.com/api/v1/contracts/create"
headers = {
    "Authorization": "Bearer nwdr_live_xxxxxxxxxxxxxxxxxxxxxxxx",
    "Content-Type": "application/json"
}
payload = {
    "title": "عقد توريدات هندسية سيادية لمنطقة أوكساجون",
    "amount": 1850000.00,
    "currency": "SAR"
}

response = requests.post(url, json=payload, headers=headers)
print("Contract Verified:", response.json()["contract_number"])
      </div>

      <div id="code-php" class="code-snippet-box" style="display:none;">
use Illuminate\Support\Facades\Http;

$response = Http::withToken('nwdr_live_xxxxxxxxxxxxxxxxxxxxxxxx')
    ->withHeaders(['X-Sovereign-Client' => 'Enterprise-HQ'])
    ->post('https://nawadersrv.com/api/v1/contracts/create', [
        'title' => 'عقد توريدات هندسية سيادية لمنطقة أوكساجون',
        'amount' => 1850000.00,
        'currency' => 'SAR',
    ]);

$contract = $response->json();
      </div>

      <div id="code-node" class="code-snippet-box" style="display:none;">
const axios = require('axios');

async function createSovereignContract() {
  const { data } = await axios.post('https://nawadersrv.com/api/v1/contracts/create', {
    title: 'عقد توريدات هندسية سيادية لمنطقة أوكساجون',
    amount: 1850000.00,
    currency: 'SAR'
  }, {
    headers: {
      Authorization: 'Bearer nwdr_live_xxxxxxxxxxxxxxxxxxxxxxxx'
    }
  });

  console.log('Contract Created Hash:', data.signature_hash);
}
      </div>

    </div>

  </div>
</div>

<script>
function showSdkCode(lang) {
  document.querySelectorAll('.code-snippet-box').forEach(el => el.style.display = 'none');
  const target = document.getElementById('code-' + lang);
  if (target) target.style.display = 'block';
}
</script>
@endsection
