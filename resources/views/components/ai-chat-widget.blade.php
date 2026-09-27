{{-- Sovereign Floating 24/7 AI Multi-Domain Expert Assistant & Multi-Voice Sovereign Agent --}}
<div id="nw-ai-widget-container" style="position:fixed;bottom:24px;right:24px;z-index:99999;font-family:var(--font-arabic);">
  
  {{-- Trigger Button --}}
  <button id="nw-ai-toggle-btn" onclick="toggleAIChat()" aria-label="مستشار نوادر الذكي" style="width:64px;height:64px;border-radius:22px;background:var(--grad-gold);color:var(--nawader-navy);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.8rem;box-shadow:0 12px 35px rgba(212,168,67,0.45), 0 0 25px rgba(212,168,67,0.25);transition:all 0.3s cubic-bezier(0.16,1,0.3,1);position:relative;">
    <span id="nw-ai-icon-open">🤖</span>
    <span id="nw-ai-icon-close" style="display:none;font-size:1.4rem;font-weight:900;">✕</span>
    <span style="position:absolute;top:-4px;right:-4px;width:14px;height:14px;border-radius:50%;background:var(--nawader-teal);border:2px solid var(--nawader-navy);box-shadow:0 0 8px var(--nawader-teal);"></span>
  </button>

  {{-- Spatial Chat & Voice Window --}}
  <div id="nw-ai-chat-window" style="display:none;position:absolute;bottom:78px;right:0;width:440px;height:660px;max-width:calc(100vw - 32px);background:rgba(12,18,34,0.96);backdrop-filter:blur(40px);border:1px solid rgba(212,168,67,0.35);border-radius:26px;box-shadow:0 35px 90px rgba(0,0,0,0.85), 0 0 45px rgba(0,212,200,0.15);flex-direction:column;overflow:hidden;">
    
    {{-- Header --}}
    <div style="padding:0.9rem 1.25rem;background:rgba(255,255,255,0.03);border-bottom:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:0.75rem;">
        <div style="width:38px;height:38px;border-radius:12px;background:var(--grad-gold);color:var(--nawader-navy);display:flex;align-items:center;justify-content:center;font-size:1.15rem;font-weight:900;box-shadow:0 4px 12px rgba(212,168,67,0.3);">
          ن
        </div>
        <div>
          <div id="ai-active-title" style="font-weight:800;color:#fff;font-size:0.92rem;">المستشار السيادي (د. سلمان)</div>
          <div style="font-size:0.72rem;color:var(--nawader-teal);display:flex;align-items:center;gap:0.35rem;">
            <span style="width:6px;height:6px;border-radius:50%;background:var(--nawader-teal);display:inline-block;animation:pulse 2s infinite;"></span>
            <span id="ai-active-model-name">علّام السيادي + وكيل صوتي متعدد النبرات</span>
          </div>
        </div>
      </div>
      <button onclick="toggleAIChat()" style="background:none;border:none;color:var(--text-muted);font-size:1.1rem;cursor:pointer;padding:4px;">✕</button>
    </div>

    {{-- Tri-Domain Expert Persona Switcher --}}
    <div style="display:flex;padding:0.35rem 0.6rem;background:rgba(0,0,0,0.35);border-bottom:1px solid rgba(255,255,255,0.06);gap:0.3rem;">
      <button type="button" class="ai-persona-tab active" onclick="switchPersona('legal', this)">
        <span>⚖️</span>
        <span>قانوني سيادي</span>
      </button>
      <button type="button" class="ai-persona-tab" onclick="switchPersona('hr', this)">
        <span>👥</span>
        <span>موارد بشرية</span>
      </button>
      <button type="button" class="ai-persona-tab" onclick="switchPersona('projects', this)">
        <span>🏗️</span>
        <span>مشاريع كبرى</span>
      </button>
    </div>

    {{-- Multi-Voice Selection & Voice Agent Settings Bar --}}
    <div style="padding:0.4rem 0.75rem;background:rgba(0,212,200,0.04);border-bottom:1px solid rgba(0,212,200,0.12);display:flex;align-items:center;justify-content:space-between;gap:0.4rem;overflow-x:auto;">
      <div style="display:flex;align-items:center;gap:0.35rem;">
        <span style="font-size:0.7rem;color:var(--nawader-gold);font-weight:800;white-space:nowrap;">🎙️ الوكيل الصوتي:</span>
        <button type="button" class="ai-voice-chip active" data-voice="salman" onclick="setVoicePersona('salman', this)" title="صوت رسمي وقور رصين">د. سلمان</button>
        <button type="button" class="ai-voice-chip" data-voice="razan" onclick="setVoicePersona('razan', this)" title="صوت استشاري أنثوي هادئ">رزان</button>
        <button type="button" class="ai-voice-chip" data-voice="nayef" onclick="setVoicePersona('nayef', this)" title="صوت شبابي ريادي واثق">نايف</button>
        <button type="button" class="ai-voice-chip" data-voice="global" onclick="setVoicePersona('global', this)" title="Executive Global English Voice">Global EN</button>
      </div>
      <div style="display:flex;align-items:center;gap:0.4rem;">
        <button type="button" onclick="previewSelectedVoice()" class="nw-voice-preview-btn" title="تجربة نبرة الصوت">
          🔊 نبرة
        </button>
        <label style="display:flex;align-items:center;gap:0.25rem;cursor:pointer;font-size:0.68rem;color:var(--text-muted);white-space:nowrap;" title="قراءة الردود تلقائياً">
          <input type="checkbox" id="ai-auto-speak" style="cursor:pointer;accent-color:var(--nawader-teal);">
          تحدث آلياً
        </label>
      </div>
    </div>

    {{-- Model Engine Pill Bar --}}
    <div style="display:flex;gap:0.3rem;padding:0.35rem 0.75rem;background:rgba(255,255,255,0.02);border-bottom:1px solid rgba(255,255,255,0.04);overflow-x:auto;">
      <button type="button" class="ai-model-pill active" onclick="selectAIModel('allam', this)">🇸🇦 علّام (ALLaM)</button>
      <button type="button" class="ai-model-pill" onclick="selectAIModel('openai', this)">GPT-4o</button>
      <button type="button" class="ai-model-pill" onclick="selectAIModel('claude', this)">Claude 3.5</button>
      <button type="button" class="ai-model-pill" onclick="selectAIModel('deepseek', this)">DeepSeek</button>
      <button type="button" class="ai-model-pill" onclick="selectAIModel('ollama', this)">محلي 🔒</button>
    </div>

    {{-- Audio Visualizer Banner (Shown while recording/speaking) --}}
    <div id="ai-audio-wave-bar" style="display:none;padding:0.45rem 1rem;background:rgba(0,212,200,0.12);border-bottom:1px solid rgba(0,212,200,0.3);align-items:center;justify-content:space-between;">
      <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.75rem;color:var(--nawader-teal);">
        <canvas id="ai-visualizer-canvas" width="60" height="16" style="vertical-align:middle;"></canvas>
        <span id="ai-audio-status-text">جاري الاستماع لصوتك باللغة العربية...</span>
      </div>
      <button type="button" onclick="stopAudioProcessing()" style="background:none;border:none;color:#ff5555;font-size:0.72rem;cursor:pointer;font-weight:700;">إلغاء ⏹</button>
    </div>

    {{-- Messages Feed --}}
    <div id="nw-ai-messages" style="flex:1;padding:1.1rem;overflow-y:auto;display:flex;flex-direction:column;gap:0.85rem;font-size:0.84rem;line-height:1.65;">
      <div style="align-self:flex-start;max-width:88%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:16px 16px 16px 3px;padding:0.9rem 1.1rem;color:#fff;">
        <div style="margin-bottom:0.4rem;font-size:0.7rem;color:var(--nawader-gold);font-weight:700;">⚖️ المستشار القانوني السيادي (د. سلمان):</div>
        مرحباً بك! أنا مستشارك السيادي على مدار الساعة. يسعدني إفادتك في صياغة وتوثيق العقود التجارية، تأسيس شركات ديلاوير والسعودية، الامتثال للأنظمة الحكومية، والتحكيم التجاري المعتمد لدى SCCA. يمكنك التحدث إليّ صوتياً واختيار نبرة الصوت المفضلة لك من الشريط بالأعلى.
      </div>
    </div>

    {{-- Quick Starters (Dynamic per persona) --}}
    <div id="ai-quick-starters" style="padding:0.4rem 0.8rem;display:flex;gap:0.4rem;overflow-x:auto;white-space:nowrap;border-top:1px solid rgba(255,255,255,0.05);">
      <button onclick="sendQuickPrompt('كيف أؤسس شركة ديلاوير LLC؟')" class="ai-quick-chip">تأسيس ديلاوير LLC</button>
      <button onclick="sendQuickPrompt('صياغة بند التحكيم التجاري SCCA')" class="ai-quick-chip">شرط التحكيم SCCA</button>
      <button onclick="sendQuickPrompt('متطلبات رخصة الاستثمار MISA')" class="ai-quick-chip">ترخيص MISA</button>
      <button onclick="sendQuickPrompt('متطلبات الفوترة الإلكترونية زاتكا مرحلة 2')" class="ai-quick-chip">فوترة ZATCA 2</button>
    </div>

    {{-- Input & Voice Recording Controls --}}
    <form id="nw-ai-form" onsubmit="submitAIChat(event)" style="padding:0.75rem 1rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;gap:0.5rem;align-items:center;background:rgba(8,12,24,0.85);">
      
      {{-- Voice Record Button --}}
      <button type="button" id="nw-ai-mic-btn" onclick="toggleVoiceRecording()" title="تحدث صوتياً الآن" style="width:38px;height:38px;border-radius:11px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:1.1rem;transition:all 0.2s;">
        🎙️
      </button>

      {{-- Text Input --}}
      <input type="text" id="nw-ai-input" placeholder="اكتب سؤالك أو تحدث صوتياً بالضغط على المايك..." style="flex:1;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:0.6rem 0.9rem;color:#fff;font-size:0.83rem;font-family:var(--font-arabic);outline:none;">
      
      {{-- Send Button --}}
      <button type="submit" id="nw-ai-send-btn" style="width:38px;height:38px;border-radius:11px;background:var(--grad-gold);border:none;color:var(--nawader-navy);cursor:pointer;font-weight:900;display:flex;align-items:center;justify-content:center;transition:transform 0.2s;">
        ←
      </button>
    </form>

  </div>
</div>

<style>
.ai-persona-tab {
  flex: 1; display: flex; align-items: center; justify-content: center; gap: 0.35rem;
  background: transparent; border: 1px solid rgba(255,255,255,0.07); color: var(--text-muted);
  border-radius: 10px; padding: 5px 8px; font-size: 0.72rem; cursor: pointer; font-family: var(--font-arabic);
  transition: all 0.2s; white-space: nowrap;
}
.ai-persona-tab.active {
  background: rgba(212,168,67,0.15); border-color: var(--nawader-gold); color: #fff; font-weight: 700;
  box-shadow: 0 0 10px rgba(212,168,67,0.2);
}
.ai-voice-chip {
  background: transparent; border: 1px solid rgba(255,255,255,0.08); color: var(--text-muted);
  border-radius: 6px; padding: 2px 7px; font-size: 0.67rem; cursor: pointer; font-family: var(--font-arabic);
  transition: all 0.2s; white-space: nowrap;
}
.ai-voice-chip.active {
  background: rgba(212,168,67,0.2); border-color: var(--nawader-gold); color: var(--nawader-gold); font-weight: 800;
}
.nw-voice-preview-btn {
  background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 6px;
  color: var(--nawader-teal); font-size: 0.65rem; padding: 2px 6px; cursor: pointer; font-family: var(--font-arabic);
  transition: all 0.2s;
}
.nw-voice-preview-btn:hover {
  background: rgba(0,212,200,0.15);
}
.ai-model-pill {
  background: transparent; border: 1px solid rgba(255,255,255,0.07); color: var(--text-muted);
  border-radius: 8px; padding: 2px 8px; font-size: 0.68rem; cursor: pointer; font-family: var(--font-arabic); transition: all 0.2s; white-space: nowrap;
}
.ai-model-pill.active {
  background: rgba(0,212,200,0.15); border-color: var(--nawader-teal); color: var(--nawader-teal); font-weight: 700;
}
.ai-quick-chip {
  font-size: 0.72rem; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 20px; padding: 3px 10px; color: var(--text-secondary); cursor: pointer;
  font-family: var(--font-arabic); transition: all 0.2s;
}
.ai-quick-chip:hover {
  background: rgba(212,168,67,0.1); border-color: var(--nawader-gold); color: #fff;
}
.mic-recording {
  background: rgba(239, 68, 68, 0.25) !important;
  border-color: #ef4444 !important;
  color: #ef4444 !important;
  animation: pulse 0.8s infinite alternate !important;
}
</style>

<script>
let currentPersona = 'legal';
let currentAIModel = 'allam';
let currentVoicePersona = 'salman';
let isRecording = false;
let speechRecognizer = null;
let visualizerAnimFrame = null;

// Voice profiles configuration
const voiceProfiles = {
  salman: {
    name: 'د. سلمان الفهد',
    lang: 'ar-SA',
    pitch: 0.86,
    rate: 0.92,
    gender: 'male',
    previewText: 'أهلاً بك، أنا المستشار سلمان، يسعدني تقديم المشورة السيادية المعتمدة.'
  },
  razan: {
    name: 'المستشارة رزان',
    lang: 'ar-SA',
    pitch: 1.22,
    rate: 1.0,
    gender: 'female',
    previewText: 'مرحباً، أنا رزان، مستشارتك الاستراتيجية لنمو الأعمال وحوكمة المنشآت.'
  },
  nayef: {
    name: 'المهندس نايف',
    lang: 'ar-SA',
    pitch: 1.04,
    rate: 1.06,
    gender: 'male',
    previewText: 'أهلاً يا صديقي، أنا نايف، خبيرك التقني للأنظمة الذكية والحلول الرقمية.'
  },
  global: {
    name: 'Global Advisor',
    lang: 'en-US',
    pitch: 1.0,
    rate: 1.0,
    gender: 'male',
    previewText: 'Welcome to Nawader Sovereign Platform. I am ready to assist with your international setup.'
  }
};

const personaDetails = {
  legal: {
    title: 'المستشار القانوني السيادي (د. سلمان)',
    welcome: 'مرحباً بك! أنا مستشارك القانوني والسيادي على مدار الساعة. يسعدني إفادتك في صياغة العقود التجارية، تأسيس شركات ديلاوير والسعودية، الامتثال للأنظمة الحكومية، والتحكيم التجاري المعتمد لدى SCCA. يمكنك أيضاً التحدث إليّ صوتياً بالضغط على أيقونة الميكروفون.',
    starters: [
      { text: 'كيف أؤسس شركة ديلاوير LLC؟', label: 'تأسيس ديلاوير LLC' },
      { text: 'صياغة بند التحكيم التجاري SCCA', label: 'شرط التحكيم SCCA' },
      { text: 'متطلبات رخصة الاستثمار MISA', label: 'ترخيص MISA' },
      { text: 'متطلبات الفوترة الإلكترونية زاتكا مرحلة 2', label: 'فوترة ZATCA 2' }
    ]
  },
  hr: {
    title: 'خبير الموارد البشرية والاستقدام (نوادر HR)',
    welcome: 'أهلاً بك! أنا خبير الموارد البشرية واللوائح التنظيمية في منصة نوادر. أساعدك في حماية الأجور (مدد)، احتساب نسب السعودة في نطاقات وقوى، رخص العمل، استقدام الكفاءات القيادية وتأشيرات العمل الدبلوماسية.',
    starters: [
      { text: 'كيف أحافظ على النطاق البلاتيني في قوى؟', label: 'نطاقات البلاتيني' },
      { text: 'شروط الامتثال لحماية الأجور عبر منصة مدد', label: 'حماية الأجور (مدد)' },
      { text: 'إجراءات استقدام مهندسين استشاريين', label: 'استقدام الكفاءات' },
      { text: 'صياغة عقد عمل قيادي متوافق مع نظام العمل', label: 'عقود العمل الرسمية' }
    ]
  },
  projects: {
    title: 'كبير مستشاري المشاريع العملاقة ورؤية 2030',
    welcome: 'مرحباً بك! أنا مستشار المشاريع العملاقة والمناقصات الحكومية. أرافقك في تأهيل المقاولين لمشاريع نيوم وكافد والبحر الأحمر، وتجهيز الضمانات المالية (Escrow)، وعقود الفيديك الهندسية، والربط مع منصة اعتماد.',
    starters: [
      { text: 'كيف أسجل كمورد معتمد في مشروع نيوم أوكساجون؟', label: 'تأهيل نيوم وأوكساجون' },
      { text: 'متطلبات فتح حساب الضمان المصرفي Escrow', label: 'ضمانات Escrow' },
      { text: 'حوافز نقل المقر الإقليمي RHQ لمركز كافد', label: 'مقرات كافد RHQ' },
      { text: 'إجراءات تصنيف المقاولين لمنصة اعتماد', label: 'مناقصات اعتماد' }
    ]
  }
};

function toggleAIChat() {
  const win = document.getElementById('nw-ai-chat-window');
  const iconOpen = document.getElementById('nw-ai-icon-open');
  const iconClose = document.getElementById('nw-ai-icon-close');

  if (win.style.display === 'none' || win.style.display === '') {
    win.style.display = 'flex';
    iconOpen.style.display = 'none';
    iconClose.style.display = 'inline';
    document.getElementById('nw-ai-input').focus();
  } else {
    win.style.display = 'none';
    iconOpen.style.display = 'inline';
    iconClose.style.display = 'none';
  }
}

function setVoicePersona(voiceKey, btn) {
  currentVoicePersona = voiceKey;
  document.querySelectorAll('.ai-voice-chip').forEach(b => b.classList.remove('active'));
  if (btn) btn.classList.add('active');
}

function previewSelectedVoice() {
  const profile = voiceProfiles[currentVoicePersona] || voiceProfiles.salman;
  speakResponse(profile.previewText);
}

function switchPersona(persona, btn) {
  document.querySelectorAll('.ai-persona-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  currentPersona = persona;

  const info = personaDetails[persona];
  document.getElementById('ai-active-title').textContent = info.title;

  const feed = document.getElementById('nw-ai-messages');
  const welcomeDiv = document.createElement('div');
  welcomeDiv.style.cssText = "align-self:flex-start;max-width:88%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:16px 16px 16px 3px;padding:0.9rem 1.1rem;color:#fff;";
  welcomeDiv.innerHTML = `<div style="margin-bottom:0.4rem;font-size:0.7rem;color:var(--nawader-gold);font-weight:700;">${info.title}:</div><div>${info.welcome}</div>`;
  feed.appendChild(welcomeDiv);
  feed.scrollTop = feed.scrollHeight;

  const chipsContainer = document.getElementById('ai-quick-starters');
  chipsContainer.innerHTML = '';
  info.starters.forEach(s => {
    const chip = document.createElement('button');
    chip.className = 'ai-quick-chip';
    chip.textContent = s.label;
    chip.onclick = () => sendQuickPrompt(s.text);
    chipsContainer.appendChild(chip);
  });
}

function selectAIModel(model, btn) {
  document.querySelectorAll('.ai-model-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  currentAIModel = model;
}

function sendQuickPrompt(text) {
  document.getElementById('nw-ai-input').value = text;
  submitAIChat(new Event('submit'));
}

// ── Voice Input & Speech-to-Text ───────────────────────────────────────────
function toggleVoiceRecording() {
  const micBtn = document.getElementById('nw-ai-mic-btn');
  const waveBar = document.getElementById('ai-audio-wave-bar');
  const statusText = document.getElementById('ai-audio-status-text');

  if (isRecording) {
    stopAudioProcessing();
    return;
  }

  const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
  if (!SpeechRecognition) {
    alert("عذراً، متصفحك لا يدعم التعرف الصوتي المباشر. يرجى استخدام متصفح حديث مثل Chrome أو Safari أو Edge.");
    return;
  }

  speechRecognizer = new SpeechRecognition();
  speechRecognizer.lang = (currentVoicePersona === 'global') ? 'en-US' : 'ar-SA';
  speechRecognizer.continuous = false;
  speechRecognizer.interimResults = false;

  speechRecognizer.onstart = function() {
    isRecording = true;
    micBtn.classList.add('mic-recording');
    waveBar.style.display = 'flex';
    statusText.textContent = (currentVoicePersona === 'global') ? 'Listening to your voice in English...' : 'جاري الاستماع لصوتك باللغة العربية...';
    startVisualizer();
  };

  speechRecognizer.onresult = function(event) {
    const transcript = event.results[0][0].transcript;
    document.getElementById('nw-ai-input').value = transcript;
    stopAudioProcessing();
    submitAIChat(new Event('submit'));
  };

  speechRecognizer.onerror = function() {
    stopAudioProcessing();
  };

  speechRecognizer.onend = function() {
    stopAudioProcessing();
  };

  try {
    speechRecognizer.start();
  } catch(e) {
    stopAudioProcessing();
  }
}

function stopAudioProcessing() {
  isRecording = false;
  const micBtn = document.getElementById('nw-ai-mic-btn');
  const waveBar = document.getElementById('ai-audio-wave-bar');
  if (micBtn) micBtn.classList.remove('mic-recording');
  if (waveBar) waveBar.style.display = 'none';
  if (speechRecognizer) {
    try { speechRecognizer.stop(); } catch(e) {}
  }
  if (window.speechSynthesis) {
    window.speechSynthesis.cancel();
  }
  stopVisualizer();
}

// ── Realtime Canvas Sound Waves Visualizer ─────────────────────────────────
function startVisualizer() {
  const canvas = document.getElementById('ai-visualizer-canvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let step = 0;

  function render() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    const bars = 6;
    const barWidth = 4;
    const gap = 3;

    for (let i = 0; i < bars; i++) {
      const height = Math.abs(Math.sin(step + i * 0.8)) * 14 + 2;
      const x = i * (barWidth + gap);
      const y = (canvas.height - height) / 2;

      ctx.fillStyle = i % 2 === 0 ? '#00d4c8' : '#d4a843';
      ctx.beginPath();
      ctx.roundRect(x, y, barWidth, height, 2);
      ctx.fill();
    }
    step += 0.15;
    visualizerAnimFrame = requestAnimationFrame(render);
  }
  visualizerAnimFrame = requestAnimationFrame(render);
}

function stopVisualizer() {
  if (visualizerAnimFrame) {
    cancelAnimationFrame(visualizerAnimFrame);
    visualizerAnimFrame = null;
  }
}

// ── Multi-Voice Speech-Synthesis Playback ───────────────────────────────────
function speakResponse(text) {
  if (!('speechSynthesis' in window)) return;
  window.speechSynthesis.cancel();

  const profile = voiceProfiles[currentVoicePersona] || voiceProfiles.salman;
  const cleanText = text.replace(/<[^>]*>?/gm, '').replace(/https?:\/\/\S+/g, '');
  const utterance = new SpeechSynthesisUtterance(cleanText);

  utterance.lang = profile.lang;
  utterance.rate = profile.rate;
  utterance.pitch = profile.pitch;

  // Voice matching
  const voices = window.speechSynthesis.getVoices();
  if (voices && voices.length > 0) {
    let matched = null;
    if (profile.lang === 'ar-SA') {
      matched = voices.find(v => v.lang.startsWith('ar') && (profile.gender === 'female' ? (v.name.includes('Laila') || v.name.includes('Salma') || v.name.includes('Zari') || v.name.includes('Hoda')) : (v.name.includes('Maged') || v.name.includes('Tarik') || v.name.includes('Hamed') || v.name.includes('Shakir'))));
      if (!matched) matched = voices.find(v => v.lang.startsWith('ar'));
    } else {
      matched = voices.find(v => v.lang.startsWith('en'));
    }
    if (matched) utterance.voice = matched;
  }

  const waveBar = document.getElementById('ai-audio-wave-bar');
  const statusText = document.getElementById('ai-audio-status-text');
  waveBar.style.display = 'flex';
  statusText.textContent = `${profile.name} يتحدث الآن...`;
  startVisualizer();

  utterance.onend = function() {
    waveBar.style.display = 'none';
    stopVisualizer();
  };
  utterance.onerror = function() {
    waveBar.style.display = 'none';
    stopVisualizer();
  };

  window.speechSynthesis.speak(utterance);
}

// ── Chat Submission ────────────────────────────────────────────────────────
async function submitAIChat(e) {
  e.preventDefault();
  const input = document.getElementById('nw-ai-input');
  const text = input.value.trim();
  if (!text) return;

  const feed = document.getElementById('nw-ai-messages');
  
  // User bubble
  const userDiv = document.createElement('div');
  userDiv.style.cssText = "align-self:flex-end;max-width:85%;background:rgba(212,168,67,0.18);border:1px solid rgba(212,168,67,0.35);border-radius:16px 16px 2px 16px;padding:0.8rem 1rem;color:#fff;";
  userDiv.textContent = text;
  feed.appendChild(userDiv);
  input.value = '';
  feed.scrollTop = feed.scrollHeight;

  // Typing indicator
  const botDiv = document.createElement('div');
  botDiv.style.cssText = "align-self:flex-start;max-width:88%;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.09);border-radius:16px 16px 16px 3px;padding:0.9rem 1.1rem;color:var(--text-secondary);";
  botDiv.innerHTML = '<span style="color:var(--nawader-teal);display:flex;align-items:center;gap:0.4rem;"><span class="audio-wave-dot"></span> جاري استدعاء المعرفة والتحليل السيادي...</span>';
  feed.appendChild(botDiv);
  feed.scrollTop = feed.scrollHeight;

  try {
    const res = await fetch("{{ route('ai.chat') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
      },
      body: JSON.stringify({ message: text, model: currentAIModel, persona: currentPersona })
    });
    const data = await res.json();
    const replyText = data.response || "أهلاً بك! يمكنك تصفح كافة الخدمات من خلال الكتالوج أو زيارة لوحة التحكم لطلب الخدمة مباشرة.";
    
    botDiv.innerHTML = `
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.4rem;">
        <span style="font-size:0.72rem;color:var(--nawader-gold);font-weight:700;">${data.provider || 'نوادر AI'}:</span>
        <button type="button" onclick="speakResponse(this.getAttribute('data-text'))" data-text="${replyText.replace(/"/g, '&quot;')}" title="استمع صوتياً" style="background:rgba(0,212,200,0.1);border:1px solid rgba(0,212,200,0.25);border-radius:6px;color:var(--nawader-teal);font-size:0.7rem;padding:2px 6px;cursor:pointer;">🔊 استماع</button>
      </div>
      <div style="color:#fff;line-height:1.7;">${replyText}</div>
    `;

    // Auto-read if enabled
    if (document.getElementById('ai-auto-speak')?.checked) {
      speakResponse(replyText);
    }
  } catch (err) {
    botDiv.textContent = "أهلاً بك! يمكنك تصفح كافة الخدمات من خلال الكتالوج أو زيارة لوحة التحكم لطلب الخدمة مباشرة.";
  }
  feed.scrollTop = feed.scrollHeight;
}
</script>
