@extends('layouts.app')

@section('title', 'بوابة التسويق بالعمولة والشراكات السيادية — نوادر')
@section('page_title', 'منظومة الشراكة والتسويق بالعمولة')

@push('head')
<style>
.nw-affiliate-page { padding: 120px 0 80px; position: relative; }
.affiliate-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(100px); }

.affiliate-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 2rem;
  transition: all 0.3s;
}
.affiliate-card:hover {
  border-color: rgba(212,168,67,0.35); transform: translateY(-3px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

.copy-box {
  background: rgba(0,0,0,0.4); border: 1px dashed rgba(212,168,67,0.4);
  border-radius: 14px; padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: space-between;
  gap: 1rem; flex-wrap: wrap;
}
</style>
@endpush

@section('content')
<div class="nw-affiliate-page">
  <div class="affiliate-orb" style="width:550px;height:550px;top:0;right:10%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="affiliate-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.08) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="nw-section-eyebrow" style="margin-bottom:0.4rem;">برنامج الشركاء وصناع التأثير</div>
        <h1 style="font-size:1.85rem;font-weight:900;color:#fff;">بوابة التسويق بالعمولة وتنمية العوائد السيادية</h1>
      </div>
      <div style="display:flex;gap:0.75rem;">
        <form method="POST" action="{{ route('dashboard.affiliate.payout') }}">
          @csrf
          <button type="submit" class="nw-btn nw-btn-primary" {{ $stats['pending_payout'] < 500 ? 'disabled' : '' }}>
            <span>💳</span>
            <span>طلب صرف الأرباح المعلقة ({{ number_format($stats['pending_payout'], 2) }} ر.س)</span>
          </button>
        </form>
      </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.4);border-radius:14px;padding:1rem 1.5rem;margin-bottom:2rem;color:var(--nawader-teal);display:flex;align-items:center;gap:0.75rem;">
      <span>✓</span>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.4);border-radius:14px;padding:1rem 1.5rem;margin-bottom:2rem;color:#ef4444;display:flex;align-items:center;gap:0.75rem;">
      <span>⚠️</span>
      <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Metrics Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:1.25rem;margin-bottom:2.5rem;">
      
      <div class="affiliate-card" style="padding:1.5rem;">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">إجمالي العمولات المكتسبة</div>
        <div style="font-size:1.9rem;font-weight:900;color:var(--nawader-gold);font-family:var(--font-latin);">
          {{ number_format($stats['total_earnings'], 2) }} <span style="font-size:1rem;">SAR</span>
        </div>
        <div style="font-size:0.72rem;color:var(--nawader-teal);margin-top:0.2rem;">محصلة من صفقات التعاقد والتأسيس</div>
      </div>

      <div class="affiliate-card" style="padding:1.5rem;">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">الرصيد المعلق للصرف</div>
        <div style="font-size:1.9rem;font-weight:900;color:var(--nawader-teal);font-family:var(--font-latin);">
          {{ number_format($stats['pending_payout'], 2) }} <span style="font-size:1rem;">SAR</span>
        </div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.2rem;">متاح للتحويل البنكي الفوري</div>
      </div>

      <div class="affiliate-card" style="padding:1.5rem;">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">نسبة العمولة الحالية</div>
        <div style="font-size:1.9rem;font-weight:900;color:#fff;font-family:var(--font-latin);">
          {{ $stats['commission_rate'] }}%
        </div>
        <div style="font-size:0.72rem;color:var(--nawader-gold);margin-top:0.2rem;">مستوى الشريك الماسي المتميز</div>
      </div>

      <div class="affiliate-card" style="padding:1.5rem;">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">النقرات المسجلة</div>
        <div style="font-size:1.9rem;font-weight:900;color:#fff;font-family:var(--font-latin);">
          {{ number_format($stats['clicks_count']) }}
        </div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.2rem;">معدل تحويل: {{ $stats['conversion_rate'] }}%</div>
      </div>

      <div class="affiliate-card" style="padding:1.5rem;">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.3rem;">التعاقدات الناجحة</div>
        <div style="font-size:1.9rem;font-weight:900;color:var(--nawader-teal);font-family:var(--font-latin);">
          {{ $stats['conversions_count'] }}
        </div>
        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.2rem;">عقود خدمات واستشارات موثقة</div>
      </div>

    </div>

    <!-- Referral Link & Promotion Center -->
    <div class="affiliate-card" style="margin-bottom:2.5rem;border-color:rgba(212,168,67,0.3);">
      <h2 style="font-size:1.25rem;font-weight:800;color:#fff;margin-bottom:0.5rem;">رابط الإحالة السيادي المخصص لحسابك</h2>
      <p style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:1.5rem;">
        شارك هذا الرابط مع رواد الأعمال، المستثمرين، والشركات الدولية. ستحصل تلقائياً على <strong>{{ $stats['commission_rate'] }}% عمولة مباشرة</strong> على أي خدمة يتم طلبها أو عقد يتم توثيقه.
      </p>

      <div class="copy-box">
        <div style="display:flex;align-items:center;gap:0.75rem;">
          <span style="font-size:1.2rem;">🔗</span>
          <span id="ref-link-text" style="color:var(--nawader-gold);font-weight:700;font-family:var(--font-latin);direction:ltr;">
            {{ $stats['referral_url'] }}
          </span>
        </div>
        <div style="display:flex;gap:0.5rem;">
          <button type="button" onclick="copyRefLink()" class="nw-btn nw-btn-sm nw-btn-primary">
            <span>📋</span>
            <span id="copy-btn-label">نسخ الرابط</span>
          </button>
          <a href="https://api.whatsapp.com/send?text={{ urlencode('انضم إلى منصة نوادر السيادية لأرقى الخدمات الحكومية وتأسيس الشركات: ' . $stats['referral_url']) }}" target="_blank" class="nw-btn nw-btn-sm nw-btn-ghost" style="color:#25D366;border-color:rgba(37,211,102,0.3);">
            واتساب
          </a>
        </div>
      </div>

      <div style="margin-top:1.25rem;display:flex;gap:2rem;flex-wrap:wrap;font-size:0.78rem;color:var(--text-muted);">
        <div>رمز الإحالة المباشر: <strong style="color:#fff;">{{ $stats['referral_code'] }}</strong></div>
        <div>صلاحية ملفات الكوكيز: <strong style="color:#fff;">30 يوماً متواصلة</strong></div>
        <div>دورة الصرف: <strong style="color:var(--nawader-teal);">بعد مراجعة واعتماد الإدارة المالية</strong></div>
      </div>
    </div>

    <!-- Commissions History Table -->
    <div class="affiliate-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <h2 style="font-size:1.2rem;font-weight:800;color:#fff;">سجل العمليات والعمولات المكتسبة</h2>
        <span style="font-size:0.78rem;color:var(--text-muted);">توثيق بنكي مشفر بالكامل</span>
      </div>

      @if($commissions->isEmpty())
      <div style="text-align:center;padding:3rem 1rem;color:var(--text-muted);">
        لا توجد عمولات مسجلة بعد. شارك رابط الإحالة الخاص بك لبدء جني العوائد!
      </div>
      @else
      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:0.85rem;text-align:right;">
          <thead>
            <tr style="border-bottom:1px solid rgba(255,255,255,0.08);color:var(--text-muted);font-size:0.78rem;">
              <th style="padding:0.75rem 1rem;">المرجع التعاقدي</th>
              <th style="padding:0.75rem 1rem;">قيمة العقد</th>
              <th style="padding:0.75rem 1rem;">قيمة العمولة (15%)</th>
              <th style="padding:0.75rem 1rem;">حالة العمولة</th>
              <th style="padding:0.75rem 1rem;">تاريخ الصرف والتسوية</th>
            </tr>
          </thead>
          <tbody>
            @foreach($commissions as $comm)
            <tr style="border-bottom:1px solid rgba(255,255,255,0.04);">
              <td style="padding:1rem;font-weight:700;color:#fff;font-family:var(--font-latin);">
                {{ $comm->order_reference }}
              </td>
              <td style="padding:1rem;color:var(--text-secondary);font-family:var(--font-latin);">
                {{ number_format($comm->order_amount, 2) }} {{ $comm->currency }}
              </td>
              <td style="padding:1rem;font-weight:800;color:var(--nawader-gold);font-family:var(--font-latin);">
                +{{ number_format($comm->commission_amount, 2) }} {{ $comm->currency }}
              </td>
              <td style="padding:1rem;">
                @if($comm->status === 'approved')
                  <span style="background:rgba(0,212,200,0.12);color:var(--nawader-teal);border:1px solid rgba(0,212,200,0.3);padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">معتمدة</span>
                @elseif($comm->status === 'paid')
                  <span style="background:rgba(34,197,94,0.12);color:#22c55e;border:1px solid rgba(34,197,94,0.3);padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">تم الصرف</span>
                @else
                  <span style="background:rgba(212,168,67,0.12);color:var(--nawader-gold);border:1px solid rgba(212,168,67,0.3);padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">قيد المراجعة</span>
                @endif
              </td>
              <td style="padding:1rem;color:var(--text-muted);font-size:0.78rem;">
                {{ $comm->paid_at ? $comm->paid_at->format('Y-m-d H:i') : 'في انتظار أمر الصرف' }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>

  </div>
</div>

<script>
function copyRefLink() {
  const linkText = document.getElementById('ref-link-text').innerText.trim();
  navigator.clipboard.writeText(linkText).then(() => {
    const btn = document.getElementById('copy-btn-label');
    btn.textContent = 'تم النسخ بنجاح!';
    setTimeout(() => { btn.textContent = 'نسخ الرابط'; }, 2500);
  });
}
</script>
@endsection
