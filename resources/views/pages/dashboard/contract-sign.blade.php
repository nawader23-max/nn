@extends('layouts.app')
@section('title', 'غرفة التوقيع الرقمي — نوادر')
@section('page_title', 'غرفة التوقيع الرقمي الآمنة')
@push('head')
<style>
.nw-sign-page{max-width:860px;margin:auto;padding:120px 24px 80px}
.nw-sign-card{border-radius:24px;padding:clamp(1.3rem,3.5vw,2.2rem);margin-bottom:1.1rem}
.nw-terms-box{max-height:210px;overflow-y:auto;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.09);border-radius:14px;padding:1rem 1.2rem;font-size:.83rem;line-height:1.9;color:var(--text-secondary);margin:1rem 0}
.nw-terms-box::-webkit-scrollbar{width:6px}.nw-terms-box::-webkit-scrollbar-thumb{background:rgba(212,168,67,.4);border-radius:3px}
.nw-sig-wrap{position:relative;background:#f5efe2;border-radius:16px;padding:.5rem;margin:.8rem 0}
#sigPad{display:block;width:100%;height:190px;touch-action:none;cursor:crosshair;border-radius:12px}
.nw-sig-line{position:absolute;right:8%;left:8%;bottom:38px;border-bottom:1.5px dashed #9c7c2c;pointer-events:none}
.nw-pill{display:inline-flex;align-items:center;gap:.4rem;padding:.35rem 1rem;border-radius:999px;font-size:.8rem;font-weight:700}
.nw-pill-wait{background:rgba(212,168,67,.12);color:var(--nawader-gold-light);border:1px solid rgba(212,168,67,.4)}
.nw-pill-ok{background:rgba(0,212,200,.13);color:var(--nawader-teal);border:1px solid rgba(0,212,200,.45)}
.nw-otp-token{font:800 1.5rem 'Courier New',monospace;letter-spacing:.35rem;color:var(--nawader-gold-light);background:rgba(212,168,67,.08);border:1px dashed rgba(212,168,67,.5);border-radius:12px;padding:.6rem 1.2rem;display:inline-block;margin:.6rem 0}
.nw-terms-check{display:flex;gap:.6rem;align-items:flex-start;font-size:.85rem;line-height:1.7;margin:.7rem 0;cursor:pointer}
.nw-terms-check input{margin-top:.35rem;accent-color:var(--nawader-teal)}
.nw-hash-mono{font-family:'Courier New',monospace;font-size:.72rem;color:var(--nawader-teal);word-break:break-all}
</style>
@endpush
@section('content')
<main class="nw-sign-page">
  <a href="{{ route('dashboard.contracts') }}" style="display:inline-block;color:var(--nawader-gold);margin-bottom:1rem">← العودة إلى العقود</a>

  <section class="nw-sign-card nw-cinematic-panel">
    <div class="nw-section-eyebrow">{{ $contract->contract_number }}</div>
    <h1 class="nw-h1" style="margin:.5rem 0">{{ $contract->title }}</h1>
    @php $tm = $contract->terms_meta ?? []; @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:.7rem;margin-top:1rem">
      <div style="padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem"><small style="display:block;color:var(--text-muted)">أجر الخدمات</small>{{ number_format((float) ($tm['base_fee'] ?? 0), 2) }} ر.س</div>
      <div style="padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem"><small style="display:block;color:var(--text-muted)">رسوم الاستعجال</small>{{ number_format((float) ($tm['speed_fee'] ?? 0), 2) }} ر.س</div>
      <div style="padding:.8rem;border-radius:12px;background:rgba(255,255,255,.035);font-size:.82rem"><small style="display:block;color:var(--text-muted)">ضريبة القيمة المضافة</small>{{ number_format((float) ($tm['vat'] ?? 0), 2) }} ر.س</div>
      <div style="padding:.8rem;border-radius:12px;background:rgba(212,168,67,.09);font-size:.82rem;border:1px solid rgba(212,168,67,.3)"><small style="display:block;color:var(--nawader-gold-light)">الإجمالي شامل الضريبة</small><strong style="font-size:1.05rem">{{ number_format((float) $contract->amount, 2) }} {{ $contract->currency }}</strong></div>
    </div>
    <p style="color:var(--text-muted);font-size:.78rem;margin-top:.8rem">مدى التنفيذ: {{ $tm['speed'] ?? 'قياسي' }} — المدة المتوقعة: {{ $tm['sla'] ?? '—' }}</p>
  </section>

  @if($contract->status !== 'pending_signature')
    <section class="nw-sign-card nw-cinematic-panel" style="text-align:center">
      <div style="font-size:2.4rem">🛡️</div>
      <h2 class="nw-h3" style="margin:.4rem 0">العقد موقّع ومختوم رقمياااً</h2>
      <p style="color:var(--text-secondary);font-size:.85rem">نُفّذ التوقيع {{ $contract->signed_at?->format('Y/m/d H:i') }} (+03:00) بعد تحقق واتساب عكسي.</p>
      @if($contract->document_sha256)<p style="margin:.6rem 0"><span class="nw-hash-mono">بصمة الوثيقة: {{ $contract->document_sha256 }}</span></p>@endif
      <div style="display:flex;justify-content:center;gap:.8rem;flex-wrap:wrap;margin-top:1rem">
        @if($contract->pdf_path && \Storage::exists($contract->pdf_path))
          <a class="nw-btn nw-btn-primary nw-btn-sm" href="{{ route('dashboard.contracts.download', $contract->id) }}">⬇ تحميل نسخة PDF الممهورة</a>
        @endif
        @if($verificationUrl)
          <a class="nw-btn nw-btn-ghost nw-btn-sm" href="{{ $verificationUrl }}" target="_blank">🔍 عرض سجل التوثيق العام</a>
        @endif
      </div>
    </section>
  @else
  <section id="otpGate" class="nw-sign-card nw-cinematic-panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap">
      <div><h2 class="nw-h3">الخطوة الأولى — التحقق السيادي من هويتك</h2>
      <p style="color:var(--text-secondary);font-size:.84rem;margin-top:.35rem">سيُرسل رمز تحقق لمرة واحدة إلى واتساب الموثوق <strong dir="ltr" style="color:var(--nawader-gold-light)">{{ $phone ?: 'غير مُضاف' }}</strong>. لن يُفتح حقل التوقيع إلا بعد تأكيد الرمز.</p></div>
      <span id="otpPill" class="nw-pill nw-pill-wait">⏳ بانتظار التحقق</span>
    </div>
    <div id="otpInfo" style="display:none;margin-top:1rem">
      <p style="font-size:.84rem;color:var(--text-secondary)">افتحت لك نوادر محادثة واتساب بالرمز — أرسله كما هو (أو انسخه):</p>
      <div class="nw-otp-token" id="otpToken">—</div>
      <div><a id="otpWaLink" href="#" target="_blank" class="nw-btn nw-btn-ghost nw-btn-sm">إعادة فتح محادثة واتساب</a></div>
      <p id="otpCount" style="color:var(--text-muted);font-size:.76rem;margin-top:.6rem"></p>
    </div>
    <div id="otpNoPhone" @if($phone) style="display:none" @endif>
      <p style="color:#ff7d92;font-size:.84rem">لم يُسجّل رقم جوال في حسابك — أكمل التحقق من الهاتف أولاً عبر <a href="{{ route('dashboard.security.phone') }}" style="color:var(--nawader-gold-light)">إعدادات الأمان</a>.</p>
    </div>
    <button id="otpBtn" class="nw-btn nw-btn-primary nw-btn-sm" style="margin-top:1rem" @if(!$phone) disabled @endif>🔐 إرسال رمز واتساب الآن</button>
  </section>

  <section id="signBox" class="nw-sign-card nw-cinematic-panel" @if(!($contract->otp_verified_at && $contract->otp_verified_at->gt(now()->subMinutes(15)))) style="display:none" @endif>
    <span id="signPill" class="nw-pill nw-pill-ok">✔ تم التحقق من الهوية</span>
    <h2 class="nw-h3" style="margin:.7rem 0 .2rem">الخطوة الثانية — اقرأ واختم توقيعك</h2>
    <div class="nw-terms-box">
      <strong style="color:var(--nawader-gold-light)">شروط العقد السيادي (نسخة ملزمة):</strong><br>
      1. تلتزم نوادر بتنفيذ الخدمات المتفق عليها ببذل عناية مهني، ويلتزم العميل بصحة بياناته ومستنداته المقدمة.<br>
      2. تُحفظ القيمة كاملة في الضمان السيادي (Escrow) ولا يُصرف للمنفذ إلا عند إنجاز الخدمة واعتماد العميل — سياسة حماية العملاء.<br>
      3. تُصدر فاتورة ضريبية نهائية متوافقة مع ZATCA (المرحلة الثانية) عند الإغلاق، وتُمنح نقاط ولاء على القيمة المدفوعة.<br>
      4. بياناتك الشخصية تُعالج وفق لائحة حماية البيانات الشخصية (PDPL) وفق إشعار الموافقة المسجل ببصمتك الرقمية.<br>
      5. هذا التوقيع الإلكتروني سند تنفيذي ملزم بموجب نظام التعاملات الإلكتروني السعودي وقانون E-SIGN، ويرتبط ببصمة SHA-256 عامة قابلة للتحقق.
    </div>
    <form method="POST" action="{{ route('dashboard.contracts.sign', $contract->id) }}" id="signForm">
      @csrf
      <input type="hidden" name="signature_png" id="sigData">
      <label class="nw-terms-check"><input type="checkbox" name="consent_signed" id="agreeChk" value="1">
        قرأتُ الشروط أعلاه وأوافق عليها وأمنح موافقتي الصريحة على المعالجة، وأريد التوقيع الإلكتروني الملزم.</label>
      <div class="nw-sig-wrap"><canvas id="sigPad" aria-label="لوحة التوقيع"></canvas><span class="nw-sig-line"></span></div>
      <div style="display:flex;justify-content:space-between;gap:.8rem;flex-wrap:wrap">
        <button type="button" id="clearSig" class="nw-btn nw-btn-ghost nw-btn-sm">مسح التوقيع</button>
        <button type="submit" id="sealBtn" class="nw-btn nw-btn-primary nw-btn-sm" disabled>🖋 ختم العقد وتوقيعه رقمياً</button>
      </div>
    </form>
  </section>
  @endif
</main>
@endsection
@push('scripts')
<script>
(function(){
  const OTP_URL='{{ route("dashboard.contracts.otp",$contract->id) }}';
  const STATUS_URL='{{ route("dashboard.contracts.otp-status",$contract->id) }}';
  const CSRF='{{ csrf_token() }}';
  let verified={{ ($contract->status==='pending_signature' && $contract->otp_verified_at && $contract->otp_verified_at->gt(now()->subMinutes(15))) ? 'true':'false' }};
  const $=id=>document.getElementById(id);
  function refresh(){const f=$('signForm');if(!f)return;const agree=$('agreeChk');const ready=verified&&agree&&agree.checked&&ink;$('sealBtn').disabled=!ready;}
  if(verified&&$('otpGate')){$('otpGate').style.display='none';const p=$('otpPill');if(p){p.className='nw-pill nw-pill-ok';p.textContent='✔ تم التحقق';}}
  let poll=null,otpTok=null;
  if($('otpBtn')){
    $('otpBtn').addEventListener('click',async()=>{
      const btn=$('otpBtn');btn.disabled=true;btn.textContent='... جارٍ الإنشاء';
      try{
        const res=await fetch(OTP_URL,{method:'POST',headers:{'X-CSRF-TOKEN':CSRF,'Accept':'application/json'},body:'{}'});
        const d=await res.json();
        if(!res.ok){throw new Error(d.message||(d.phone&&d.phone[0])||'تعذر إنشاء الرمز');}
        otpTok=d.token;$('otpToken').textContent=d.token;$('otpInfo').style.display='block';
        $('otpWaLink').href=d.whatsapp_url;window.open(d.whatsapp_url,'_blank');
        btn.textContent='🔄 إعادة إرسال رمز جديد';btn.disabled=false;
        const end=new Date(d.expires_at).getTime();
        clearInterval(poll);
        poll=setInterval(async()=>{
          const left=Math.max(0,Math.floor((end-Date.now())/1000));
          $('otpCount').textContent='صلاحية الرمز: '+Math.floor(left/60)+':'+String(left%60).padStart(2,'0')+' — التحقق تلقائي كل لحظات';
          try{
            const s=await fetch(STATUS_URL+'?token='+encodeURIComponent(otpTok),{headers:{'Accept':'application/json'}});
            const j=await s.json();
            if(j.status==='verified'){clearInterval(poll);verified=true;$('otpGate').style.display='none';$('signBox').style.display='block';$('signPill').style.display='inline-flex';refresh();window.scrollTo({top:$('signBox').offsetTop-90,behavior:'smooth'});}
            else if(left<=0){clearInterval(poll);$('otpCount').textContent='انتهت صلاحية الرمز — أرسل رمزاً جديداً.';}
          }catch(e){}
        },3000);
      }catch(err){alert(err.message);btn.disabled=false;btn.textContent='🔐 إرسال رمز واتساب الآن';}
    });
  }
  const cv=$('sigPad');let ink=false,drawing=false;
  if(cv){
    const W=1000,H=380;cv.width=W;cv.height=H;
    const ctx=cv.getContext('2d');ctx.lineWidth=4.5;ctx.lineCap='round';ctx.lineJoin='round';ctx.strokeStyle='#1a2340';
    const pos=e=>{const r=cv.getBoundingClientRect();return[(e.clientX-r.left)*W/r.width,(e.clientY-r.top)*H/r.height];};
    cv.addEventListener('pointerdown',e=>{drawing=true;const[x,y]=pos(e);ctx.beginPath();ctx.moveTo(x,y);cv.setPointerCapture(e.pointerId);e.preventDefault();});
    cv.addEventListener('pointermove',e=>{if(!drawing)return;const[x,y]=pos(e);ctx.lineTo(x,y);ctx.stroke();if(!ink){ink=true;refresh();}});
    window.addEventListener('pointerup',()=>{drawing=false;});
    $('clearSig').addEventListener('click',()=>{ctx.clearRect(0,0,W,H);ink=false;refresh();});
    $('agreeChk').addEventListener('change',refresh);
    $('signForm').addEventListener('submit',e=>{if(!ink){e.preventDefault();alert('ارسم توقيعك في اللوحة أولاً.');return;}$('sigData').value=cv.toDataURL('image/png');$('sealBtn').disabled=true;$('sealBtn').textContent='... جارٍ الختم';});
  }
})();
</script>
@endpush
