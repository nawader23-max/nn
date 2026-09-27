@extends('layouts.app')

@section('title', 'الأسعار والخطط — نوادر')
@section('page_title', 'خطط الأسعار')
@section('description', 'أسعار شفافة وخطط مرنة لجميع احتياجاتك من الخدمات الحكومية والاستشارية. ابدأ مجاناً أو اختر الخطة التي تناسب مؤسستك.')

@push('head')
<style>
.nw-pricing-hero { padding: 120px 0 60px; text-align: center; position: relative; overflow: hidden; }
.nw-pricing-hero-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(80px); }
.nw-plans-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 6rem; }
.nw-plan-card {
  background: rgba(15,23,40,0.7); backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.07); border-radius: 24px;
  padding: 2.5rem; display: flex; flex-direction: column;
  transition: all 0.4s var(--ease-smooth); position: relative; overflow: hidden;
}
.nw-plan-card.popular {
  border-color: rgba(212,168,67,0.3);
  background: linear-gradient(135deg, rgba(212,168,67,0.06) 0%, rgba(15,23,40,0.8) 50%);
  box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(212,168,67,0.15);
  transform: translateY(-8px);
}
.nw-plan-card:hover { transform: translateY(-6px); }
.nw-plan-card.popular:hover { transform: translateY(-14px); }
.nw-popular-badge {
  position: absolute; top: 0; left: 50%; transform: translateX(-50%);
  background: var(--grad-gold); color: var(--nawader-navy);
  font-size: 0.7rem; font-weight: 800; padding: 0.3rem 1.5rem;
  border-radius: 0 0 12px 12px; white-space: nowrap;
}
.nw-plan-name { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-muted); margin-bottom: 1rem; }
.nw-plan-price { display: flex; align-items: flex-end; gap: 0.25rem; margin-bottom: 0.5rem; }
.nw-plan-price-num { font-size: 3rem; font-weight: 900; line-height: 1; }
.nw-plan-price-currency { font-size: 1.1rem; font-weight: 700; color: var(--text-muted); padding-bottom: 0.4rem; }
.nw-plan-price-period { font-size: 0.8rem; color: var(--text-muted); padding-bottom: 0.5rem; }
.nw-plan-desc { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 2rem; }
.nw-plan-features { flex: 1; display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem; }
.nw-plan-feature { display: flex; align-items: center; gap: 0.75rem; font-size: 0.85rem; color: var(--text-secondary); }
.nw-plan-feature .check { color: var(--nawader-teal); font-size: 0.9rem; flex-shrink: 0; }

/* Calculator */
.nw-calc-wrap { max-width: 700px; margin: 0 auto; }
.nw-calc-card { background: rgba(15,23,40,0.8); backdrop-filter: blur(30px); border: 1px solid rgba(212,168,67,0.15); border-radius: 28px; padding: 3rem; }
.nw-calc-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem; }
.nw-calc-result { background: rgba(212,168,67,0.06); border: 1px solid rgba(212,168,67,0.15); border-radius: 16px; padding: 2rem; }
.nw-calc-row { display: flex; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.88rem; }
.nw-calc-row:last-child { border-bottom: none; font-size: 1.1rem; font-weight: 800; }
.nw-calc-row:last-child .nw-calc-val { background: var(--grad-gold); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

@media(max-width:900px){ .nw-plans-grid { grid-template-columns: 1fr; } .nw-plan-card.popular { transform: none; } .nw-calc-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

<section class="nw-pricing-hero">
  <div class="nw-pricing-hero-orb" style="width:600px;height:600px;top:-200px;right:-100px;background:radial-gradient(circle,rgba(212,168,67,0.1) 0%,transparent 70%);"></div>
  <div class="nw-pricing-hero-orb" style="width:500px;height:500px;bottom:-100px;left:-100px;background:radial-gradient(circle,rgba(0,212,200,0.07) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    <div class="nw-section-eyebrow" data-nw-animate>الأسعار</div>
    <h1 class="nw-h1" style="margin:1rem 0 1.25rem;" data-nw-animate data-delay="100">
      شفافية كاملة — <span class="nw-gradient-text">بلا مفاجآت</span>
    </h1>
    <p class="nw-lead" style="max-width:550px;margin:0 auto 3rem;" data-nw-animate data-delay="200">
      اختر الخطة التي تناسبك. رسوم الخدمات مدرجة بوضوح، وحاسبة الأسعار متاحة فوراً.
    </p>

    {{-- Period Toggle --}}
    <div style="display:inline-flex;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:100px;padding:4px;margin-bottom:3rem;" data-nw-animate data-delay="250">
      <button id="toggle-monthly" onclick="setPeriod('monthly')" class="nw-btn nw-btn-primary nw-btn-sm" style="border-radius:100px;">شهري</button>
      <button id="toggle-annual" onclick="setPeriod('annual')" class="nw-btn nw-btn-ghost nw-btn-sm" style="border-radius:100px;">سنوي — وفر 25%</button>
    </div>
  </div>
</section>

<div class="nw-container" style="position:relative;z-index:2;">
  <div class="nw-plans-grid">
    @foreach($plans as $plan)
    <div class="nw-plan-card {{ $plan['popular'] ? 'popular' : '' }}" data-nw-animate data-delay="{{ $loop->index * 150 }}">
      @if($plan['popular'])
      <div class="nw-popular-badge">الأكثر شعبية ⭐</div>
      @endif

      <div style="margin-top:{{ $plan['popular'] ? '1.5rem' : '0' }};">
        <div class="nw-plan-name">{{ $plan['name'] }}</div>
        <div class="nw-plan-price">
          @if($plan['price'] === 'مجاني')
          <div class="nw-plan-price-num" style="{{ $plan['popular'] ? 'background:var(--grad-gold);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;' : '' }}">مجاني</div>
          @else
          <div class="nw-plan-price-currency">ر.س</div>
          <div class="nw-plan-price-num" id="price-{{ $loop->index }}" style="{{ $plan['popular'] ? 'background:var(--grad-gold);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;' : '' }}">{{ $plan['price'] }}</div>
          <div class="nw-plan-price-period">{{ $plan['period'] }}</div>
          @endif
        </div>

        <div class="nw-plan-features">
          @foreach($plan['features'] as $feature)
          <div class="nw-plan-feature">
            <span class="check">✓</span>
            <span>{{ $feature }}</span>
          </div>
          @endforeach
        </div>

        <a href="{{ $plan['popular'] ? route('register') : route('contact') }}"
           id="plan-cta-{{ $loop->index }}"
           class="nw-btn {{ $plan['popular'] ? 'nw-btn-primary' : 'nw-btn-ghost' }}"
           style="width:100%;justify-content:center;border-radius:12px;">
          {{ $plan['cta'] }}
        </a>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Fee Calculator --}}
  <div class="nw-section-header" data-nw-animate>
    <div class="nw-section-eyebrow">حاسبة الرسوم</div>
    <h2 class="nw-h2">احسب <span class="nw-gradient-text">تكلفة خدمتك</span> فوراً</h2>
    <p class="nw-lead" style="max-width:500px;margin:0 auto;">بلا تسجيل — نتيجة فورية وشفافة</p>
  </div>

  <div class="nw-calc-wrap">
    <div class="nw-calc-card" data-nw-animate>
      <form id="nw-fee-calc">
        <div class="nw-calc-grid">
          <div class="nw-input-group">
            <label class="nw-label">نوع الخدمة</label>
            <select name="service" id="calc-service" class="nw-input">
              <option value="company">تأسيس شركة</option>
              <option value="license">ترخيص تجاري</option>
              <option value="property">تسجيل عقار</option>
              <option value="investment">استثمار أجنبي</option>
              <option value="trademark">علامة تجارية</option>
              <option value="visa">إقامة وتأشيرة</option>
              <option value="consulting">استشارة قانونية</option>
            </select>
          </div>
          <div class="nw-input-group">
            <label class="nw-label">نوع العميل</label>
            <select name="type" id="calc-type" class="nw-input">
              <option value="individual">فرد أو شركة صغيرة</option>
              <option value="enterprise">مؤسسة كبيرة</option>
              <option value="government">جهة حكومية</option>
            </select>
          </div>
          <div class="nw-input-group">
            <label class="nw-label">مستوى الخدمة</label>
            <select name="urgency" id="calc-urgency" class="nw-input">
              <option value="standard">قياسي</option>
              <option value="express">سريع (Express)</option>
              <option value="priority">أولوية قصوى</option>
            </select>
          </div>
        </div>

        <div class="nw-calc-result">
          <div class="nw-calc-row">
            <span style="color:var(--text-muted);">رسوم الخدمة</span>
            <span id="calc-subtotal" style="font-weight:700;">2,500 ر.س</span>
          </div>
          <div class="nw-calc-row">
            <span style="color:var(--text-muted);">ضريبة القيمة المضافة (15%)</span>
            <span id="calc-vat">375 ر.س</span>
          </div>
          <div class="nw-calc-row">
            <span>الإجمالي</span>
            <span class="nw-calc-val" id="calc-total">2,875 ر.س</span>
          </div>
        </div>

        <div style="display:flex;gap:1rem;margin-top:1.5rem;">
          <a href="{{ route('register') }}" id="calc-proceed-btn" class="nw-btn nw-btn-primary" style="flex:1;justify-content:center;">
            قدّم طلبك الآن
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <button type="button" onclick="downloadQuote()" class="nw-btn nw-btn-ghost">📥 تحميل عرض السعر</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- FAQ --}}
<section class="nw-section" style="background:rgba(10,15,30,0.4);margin-top:4rem;">
  <div class="nw-container">
    <div class="nw-section-header" data-nw-animate>
      <div class="nw-section-eyebrow">أسئلة شائعة</div>
      <h2 class="nw-h2">كل ما تريد <span class="nw-gradient-text">معرفته</span></h2>
    </div>
    <div style="max-width:800px;margin:0 auto;display:flex;flex-direction:column;gap:1rem;">
      @foreach([
        ['q'=>'هل هناك رسوم مخفية؟','a'=>'لا إطلاقاً. كل رسوم الخدمة والضريبة مدرجة بشفافية كاملة قبل أي التزام. لا مفاجآت.'],
        ['q'=>'هل يمكنني استرداد المبلغ؟','a'=>'نعم. إذا لم ينجح طلبك لأسباب إدارية خارج عن إرادتك نعيد رسومنا كاملة خلال 7 أيام عمل.'],
        ['q'=>'هل رسوم الحكومة مدرجة في السعر؟','a'=>'رسوم نوادر للخدمة منفصلة عن الرسوم الحكومية المباشرة. نُفصّل كلاهما بوضوح في عرض السعر.'],
        ['q'=>'كيف أدفع؟','a'=>'ندعم بطاقات الائتمان والمدى وآبل باي ومدفوعات مضيفة آمنة. لا نخزّن بيانات بطاقتك أبداً.'],
        ['q'=>'هل الأسعار تختلف بين السعودية وأمريكا؟','a'=>'نعم، تختلف الرسوم الحكومية حسب الدولة. حاسبتنا تعكس ذلك تلقائياً عند اختيار نوع الخدمة.'],
      ] as $faq)
      <div style="background:rgba(15,23,40,0.7);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.06);border-radius:16px;overflow:hidden;" data-nw-animate>
        <details style="cursor:pointer;">
          <summary style="padding:1.25rem 1.5rem;font-weight:700;font-size:0.95rem;list-style:none;display:flex;align-items:center;justify-content:space-between;">
            {{ $faq['q'] }}
            <span style="color:var(--nawader-gold);font-size:1.25rem;transition:transform 0.3s;">+</span>
          </summary>
          <div style="padding:0 1.5rem 1.25rem;font-size:0.85rem;color:var(--text-muted);line-height:1.8;border-top:1px solid rgba(255,255,255,0.04);padding-top:1rem;margin-top:0;">
            {{ $faq['a'] }}
          </div>
        </details>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
const prices = { monthly: [null, 299, 999], annual: [null, 224, 749] };

function setPeriod(period) {
  document.getElementById('toggle-monthly').className = period === 'monthly' ? 'nw-btn nw-btn-primary nw-btn-sm' : 'nw-btn nw-btn-ghost nw-btn-sm';
  document.getElementById('toggle-annual').className  = period === 'annual'  ? 'nw-btn nw-btn-primary nw-btn-sm' : 'nw-btn nw-btn-ghost nw-btn-sm';
  document.getElementById('toggle-monthly').style.borderRadius = '100px';
  document.getElementById('toggle-annual').style.borderRadius  = '100px';

  [1, 2].forEach(i => {
    const el = document.getElementById(`price-${i}`);
    if(el) el.textContent = prices[period][i];
  });
}

function downloadQuote() {
  window.NawaderNotify?.show('جاري تحضير عرض السعر...', 'info');
}

// FAQ smooth toggle
document.querySelectorAll('details').forEach(d => {
  d.addEventListener('toggle', () => {
    const arrow = d.querySelector('summary span');
    if(arrow) arrow.style.transform = d.open ? 'rotate(45deg)' : 'rotate(0)';
  });
});
</script>
@endpush
