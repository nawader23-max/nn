import QRCode from 'qrcode';

document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('reverse-otp');
  if (!root) return;
  const phone = document.getElementById('reverse-otp-phone');
  const start = document.getElementById('reverse-otp-start');
  const panel = document.getElementById('reverse-otp-panel');
  const code = document.getElementById('reverse-otp-code');
  const qr = document.getElementById('reverse-otp-qr');
  const whatsapp = document.getElementById('reverse-otp-whatsapp');
  const sms = document.getElementById('reverse-otp-sms');
  const state = document.getElementById('reverse-otp-state');
  const instructions = document.getElementById('reverse-otp-instructions');
  const csrf = root.dataset.csrf || document.querySelector('#login-form input[name="_token"]')?.value;
  let timer;

  const mobile = window.matchMedia('(max-width: 767px), (pointer: coarse)').matches;
  const setState = (text) => { state.textContent = text; };
  const fail = (text) => { setState(text); start.disabled = false; };

  start.addEventListener('click', async () => {
    window.clearInterval(timer);
    start.disabled = true;
    setState('جارٍ إنشاء جلسة تحقق آمنة…');
    const response = await fetch(root.dataset.generateUrl, {
      method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
      credentials: 'same-origin', body: JSON.stringify({ phone: phone.value, purpose: root.dataset.purpose || 'login' }),
    }).catch(() => null);
    const data = response ? await response.json().catch(() => ({})) : {};
    if (!response?.ok) return fail(data.message || data.errors?.phone?.[0] || 'تعذر بدء التحقق.');

    panel.classList.add('is-active'); code.textContent = data.token;
    whatsapp.href = data.whatsapp_url || '#'; whatsapp.style.display = data.whatsapp_url ? 'inline-flex' : 'none';
    sms.href = data.sms_url || '#'; sms.style.display = data.sms_url ? 'inline-flex' : 'none';
    qr.classList.toggle('is-active', !mobile && Boolean(data.whatsapp_url));
    instructions.textContent = mobile ? 'افتح WhatsApp وأرسل الرمز، ثم انتظر التحقق التلقائي.' : 'امسح QR بكاميرا هاتفك أو WhatsApp لإرسال الرمز تلقائياً.';
    if (!mobile && data.whatsapp_url) await QRCode.toCanvas(qr, data.whatsapp_url, { width: 170, margin: 1, errorCorrectionLevel: 'M' });
    setState('بانتظار رسالة WhatsApp أو SMS المطابقة…');
    timer = window.setInterval(async () => {
      const status = await fetch(`${root.dataset.statusUrl}?token=${encodeURIComponent(data.token)}`, { credentials: 'same-origin', headers: { Accept: 'application/json' } }).then(r => r.json()).catch(() => null);
      if (!status) return;
      if (status.status === 'verified') { window.clearInterval(timer); setState('تم التحقق، جارٍ الدخول…'); window.location.assign(status.redirect); }
      if (['expired', 'invalid'].includes(status.status)) { window.clearInterval(timer); fail('انتهت جلسة التحقق. أنشئ رمزاً جديداً.'); }
    }, 1500);
  });

  document.getElementById('reverse-otp-copy').addEventListener('click', async () => {
    await navigator.clipboard?.writeText(code.textContent || ''); setState('تم نسخ الرمز.');
  });
});
