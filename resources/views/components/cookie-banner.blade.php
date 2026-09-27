{{-- Sovereign Privacy & CookieYes / PDPL Consent Banner --}}
<div id="nw-cookie-banner" style="display:none;position:fixed;bottom:24px;left:24px;max-width:440px;width:calc(100vw - 48px);background:rgba(15,23,40,0.95);backdrop-filter:blur(30px);border:1px solid rgba(0,212,200,0.3);border-radius:22px;padding:1.5rem;z-index:99998;box-shadow:0 25px 60px rgba(0,0,0,0.7);font-family:var(--font-arabic);">
  <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1rem;">
    <div style="width:40px;height:40px;border-radius:12px;background:rgba(0,212,200,0.12);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">
      🍪
    </div>
    <div>
      <div style="font-weight:800;color:#fff;font-size:0.95rem;margin-bottom:0.25rem;">ميثاق حماية البيانات وملفات الارتباط</div>
      <p style="font-size:0.78rem;color:var(--text-secondary);margin:0;line-height:1.5;">
        نستخدم ملفات تعريف الارتباط لتحسين تجربتك وضمان أمان المعاملات وتوطين البيانات وفق نظام حماية البيانات الشخصية السعودي (PDPL) واللوائح الدولية (GDPR).
      </p>
    </div>
  </div>

  <div style="display:flex;align-items:center;justify-content:space-between;gap:0.75rem;">
    <a href="{{ route('privacy') }}" style="font-size:0.76rem;color:var(--nawader-gold);text-decoration:none;">
      قراءة سياسة الخصوصية
    </a>
    <div style="display:flex;gap:0.5rem;">
      <button onclick="dismissCookies('necessary')" class="nw-btn nw-btn-ghost" style="padding:0.4rem 0.8rem;font-size:0.78rem;">
        الضرورية فقط
      </button>
      <button onclick="dismissCookies('all')" class="nw-btn nw-btn-primary" style="padding:0.4rem 1.1rem;font-size:0.78rem;">
        قبول الكل
      </button>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (!localStorage.getItem('nw_cookies_accepted')) {
    setTimeout(() => {
      const banner = document.getElementById('nw-cookie-banner');
      if (banner) banner.style.display = 'block';
    }, 1500);
  }
});

function dismissCookies(choice) {
  localStorage.setItem('nw_cookies_accepted', choice);
  const banner = document.getElementById('nw-cookie-banner');
  if (banner) banner.style.display = 'none';
}
</script>
