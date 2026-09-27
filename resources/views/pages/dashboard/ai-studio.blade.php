@extends('layouts.app')

@section('title', 'أستديو نوادر للذكاء الاصطناعي التوليدي — صياغة العقود والبروموتات والفيديو')
@section('page_title', 'أستديو الذكاء الاصطناعي السيادي')

@push('head')
<style>
.nw-studio-page { padding: 120px 0 80px; position: relative; }
.studio-orb { position: absolute; border-radius: 50%; pointer-events: none; filter: blur(100px); }

.studio-card {
  background: rgba(15,23,40,0.85); backdrop-filter: blur(30px);
  border: 1px solid rgba(255,255,255,0.08); border-radius: 22px; padding: 2rem;
  transition: all 0.3s;
}

.studio-tab-btn {
  display: flex; align-items: center; gap: 0.6rem;
  background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px; padding: 0.85rem 1.25rem; color: var(--text-muted);
  font-family: var(--font-arabic); font-size: 0.88rem; cursor: pointer; transition: all 0.25s;
}
.studio-tab-btn.active {
  background: rgba(212,168,67,0.15); border-color: var(--nawader-gold);
  color: #fff; font-weight: 700; box-shadow: 0 0 15px rgba(212,168,67,0.2);
}

.studio-output-box {
  background: rgba(8,12,24,0.92); border: 1px solid rgba(212,168,67,0.3);
  border-radius: 16px; padding: 1.5rem; color: #fff; line-height: 1.8;
  font-size: 0.88rem; white-space: pre-wrap; word-break: break-word; min-height: 250px;
}
</style>
@endpush

@section('content')
<div class="nw-studio-page">
  <div class="studio-orb" style="width:600px;height:600px;top:0;right:5%;background:radial-gradient(circle,rgba(212,168,67,0.12) 0%,transparent 70%);"></div>
  <div class="studio-orb" style="width:500px;height:500px;bottom:10%;left:5%;background:radial-gradient(circle,rgba(0,212,200,0.1) 0%,transparent 70%);"></div>

  <div class="nw-container" style="position:relative;z-index:2;">
    
    <!-- Header -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
      <div>
        <div class="nw-section-eyebrow" style="margin-bottom:0.4rem;">مختبر الإبداع السيادي المتقدم</div>
        <h1 style="font-size:1.85rem;font-weight:900;color:#fff;">أستديو نوادر لتوليد النصوص، البروموتات، الفيديوهات وفحص الوثائق</h1>
      </div>
      <div style="display:flex;align-items:center;gap:0.5rem;background:rgba(0,212,200,0.1);padding:6px 14px;border-radius:12px;border:1px solid rgba(0,212,200,0.25);">
        <span style="width:8px;height:8px;border-radius:50%;background:var(--nawader-teal);display:inline-block;"></span>
        <span style="font-size:0.75rem;color:var(--nawader-teal);font-weight:700;">النماذج السيادية: علام + Claude 3.5 + DeepSeek نشطة</span>
      </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(0,212,200,0.12);border:1px solid rgba(0,212,200,0.4);border-radius:14px;padding:1rem 1.5rem;margin-bottom:2rem;color:var(--nawader-teal);display:flex;align-items:center;gap:0.75rem;">
      <span>✓</span>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Studio Mode Tabs -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:0.75rem;margin-bottom:2rem;">
      <button type="button" class="studio-tab-btn active" onclick="switchStudioTab('legal_draft', this)">
        <span style="font-size:1.3rem;">📜</span>
        <div>
          <div style="font-weight:700;">الصياغة القانونية والعقود</div>
          <div style="font-size:0.7rem;color:var(--text-muted);">عقود سيادية ومذكرات تحكيم SCCA</div>
        </div>
      </button>

      <button type="button" class="studio-tab-btn" onclick="switchStudioTab('prompt_generator', this)">
        <span style="font-size:1.3rem;">🌌</span>
        <div>
          <div style="font-weight:700;">مهندس البروموتات 8K</div>
          <div style="font-size:0.7rem;color:var(--text-muted);">توليد أوامر Midjourney و Unreal 5</div>
        </div>
      </button>

      <button type="button" class="studio-tab-btn" onclick="switchStudioTab('video_script', this)">
        <span style="font-size:1.3rem;">🎬</span>
        <div>
          <div style="font-weight:700;">سيناريوهات الفيديو السينمائي</div>
          <div style="font-size:0.7rem;color:var(--text-muted);">مشاهد، مؤثرات وتعليق صوتي</div>
        </div>
      </button>

      <button type="button" class="studio-tab-btn" onclick="switchStudioTab('document_ocr', this)">
        <span style="font-size:1.3rem;">🔍</span>
        <div>
          <div style="font-weight:700;">تدقيق الوثائق والـ OCR</div>
          <div style="font-size:0.7rem;color:var(--text-muted);">فحص السجلات والتراخيص مع واثق</div>
        </div>
      </button>
    </div>

    <!-- Active Studio Form Workbench -->
    <div class="studio-card" style="margin-bottom:2.5rem;">
      <form id="studio-form" method="POST" action="{{ route('dashboard.ai-studio.generate') }}">
        @csrf
        <input type="hidden" name="type" id="studio-type-input" value="legal_draft">

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
          <h2 id="studio-form-title" style="font-size:1.25rem;font-weight:800;color:#fff;">صياغة عقد أو وثيقة قانونية سيادية</h2>
          <div style="display:flex;gap:0.5rem;align-items:center;">
            <label style="font-size:0.78rem;color:var(--text-muted);">النموذج المفضل:</label>
            <select name="preferred_model" style="background:rgba(8,12,24,0.8);border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:4px 10px;color:var(--nawader-gold);font-size:0.75rem;font-family:var(--font-arabic);outline:none;">
              <option value="allam">علّام السيادي (ALLaM-SDAIA)</option>
              <option value="claude">Anthropic Claude 3.5 Sonnet</option>
              <option value="deepseek">DeepSeek V3</option>
              <option value="openai">OpenAI GPT-4o Enterprise</option>
            </select>
          </div>
        </div>

        <div style="margin-bottom:1.25rem;">
          <label style="display:block;font-size:0.82rem;color:var(--text-secondary);margin-bottom:0.5rem;">الموضوع أو الموجه الأساسي (Prompt)</label>
          <textarea name="prompt" id="studio-prompt-input" rows="4" required placeholder="اكتب موضوع العقد أو الاتفاقية المراد صياغتها، مثل: عقد شراكة هندسية لمشروع مدينة أوكساجون مع شرط التحكيم التجاري..." style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.12);border-radius:14px;padding:0.9rem 1.1rem;color:#fff;font-family:var(--font-arabic);font-size:0.88rem;outline:none;line-height:1.6;"></textarea>
        </div>

        <!-- Dynamic Fields Container -->
        <div id="studio-dynamic-fields" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));gap:1rem;margin-bottom:1.5rem;">
          <div>
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الطرف الأول</label>
            <input type="text" name="party_a" value="مجموعة نوادر للخدمات السيادية والاستشارية" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          </div>
          <div>
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الطرف الثاني</label>
            <input type="text" name="party_b" value="{{ $user->company_name ?? 'شركة التحالف الاستثماري' }}" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          </div>
          <div>
            <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الاختصاص القضائي</label>
            <input type="text" name="jurisdiction" value="المملكة العربية السعودية - المركز السعودي للتحكيم (SCCA)" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          </div>
        </div>

        <div style="display:flex;justify-content:flex-end;">
          <button type="submit" class="nw-btn nw-btn-primary" style="padding:0.8rem 2rem;">
            <span>✨</span>
            <span>بدء التوليد الذكي الفوري</span>
          </button>
        </div>
      </form>
    </div>

    <!-- Section: Archive of Recent Generations -->
    <div class="studio-card">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <h2 style="font-size:1.25rem;font-weight:800;color:#fff;">سجل الوثائق والمخرجات الذكية المولدة</h2>
        <span style="font-size:0.78rem;color:var(--text-muted);">محفوظة ومشفرة في الخزينة السحابية</span>
      </div>

      <div style="display:flex;flex-direction:column;gap:1.5rem;">
        @forelse($generations as $gen)
        <div style="background:rgba(0,0,0,0.3);border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:1.5rem;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.8rem;flex-wrap:wrap;gap:0.75rem;">
            <div style="display:flex;align-items:center;gap:0.6rem;">
              @if($gen->type === 'legal_draft')
                <span style="background:rgba(212,168,67,0.15);color:var(--nawader-gold);padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">📜 صياغة قانونية</span>
              @elseif($gen->type === 'prompt_generator')
                <span style="background:rgba(0,212,200,0.15);color:var(--nawader-teal);padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">🌌 برومبت 8K</span>
              @elseif($gen->type === 'video_script')
                <span style="background:rgba(168,85,247,0.15);color:#c084fc;padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">🎬 سيناريو سينمائي</span>
              @else
                <span style="background:rgba(34,197,94,0.15);color:#4ade80;padding:3px 10px;border-radius:8px;font-size:0.75rem;font-weight:700;">🔍 تدقيق وثيقة</span>
              @endif
              <strong style="color:#fff;font-size:0.95rem;">{{ $gen->title }}</strong>
            </div>
            <div style="font-size:0.75rem;color:var(--text-muted);display:flex;align-items:center;gap:0.5rem;">
              <span>النموذج: <strong style="color:var(--nawader-teal);">{{ $gen->model_used }}</strong></span>
              <span>•</span>
              <span>{{ $gen->created_at ? $gen->created_at->diffForHumans() : 'مؤخراً' }}</span>
              <button type="button" onclick="navigator.clipboard.writeText(this.getAttribute('data-content'));alert('تم نسخ المحتوى المولّد بنجاح!');" data-content="{{ $gen->generated_content }}" class="nw-btn nw-btn-sm nw-btn-ghost" style="padding:2px 8px;font-size:0.7rem;">نسخ 📋</button>
            </div>
          </div>

          <div class="studio-output-box" style="min-height:auto;max-height:260px;overflow-y:auto;">
{{ $gen->generated_content }}
          </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem 1rem;color:var(--text-muted);">
          لا توجد مخرجات مسجلة بعد. استخدم الأستديو أعلاه لبدء التوليد الفوري!
        </div>
        @endforelse
      </div>
    </div>

  </div>
</div>

<script>
function switchStudioTab(type, btn) {
  document.querySelectorAll('.studio-tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('studio-type-input').value = type;

  const titleEl = document.getElementById('studio-form-title');
  const promptInput = document.getElementById('studio-prompt-input');
  const fieldsContainer = document.getElementById('studio-dynamic-fields');

  if (type === 'legal_draft') {
    titleEl.textContent = 'صياغة عقد أو وثيقة قانونية سيادية';
    promptInput.placeholder = 'اكتب موضوع العقد أو الاتفاقية المراد صياغتها، مثل: عقد توريدات هندسية لمشروع نيوم مع شرط التحكيم لدى SCCA...';
    fieldsContainer.innerHTML = `
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الطرف الأول</label>
        <input type="text" name="party_a" value="مجموعة نوادر للخدمات السيادية والاستشارية" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
      </div>
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الطرف الثاني</label>
        <input type="text" name="party_b" value="{{ $user->company_name ?? 'الطرف الشريك' }}" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
      </div>
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">الاختصاص القضائي</label>
        <input type="text" name="jurisdiction" value="المملكة العربية السعودية - المركز السعودي للتحكيم (SCCA)" style="width:100%;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
      </div>
    `;
  } else if (type === 'prompt_generator') {
    titleEl.textContent = 'توليد برومبت ثلاثي الأبعاد فائق الواقعية 8K (Prompts Studio)';
    promptInput.placeholder = 'صف المشهد المطلوب، مثل: مجمع موانئ أوكساجون العائمة في نيوم عند الغروب مع انعكاسات البحر الأحمر وشبكة الهايبرلوب...';
    fieldsContainer.innerHTML = `
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">محرك التوليد المستهدف</label>
        <select name="engine" style="width:100%;background:rgba(8,12,24,0.9);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          <option value="midjourney">Midjourney v6.1 Photorealistic</option>
          <option value="sora">OpenAI Sora / Runway Gen-3</option>
          <option value="unreal">Unreal Engine 5.5 Octane Render</option>
        </select>
      </div>
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">النمط السينمائي</label>
        <select name="style" style="width:100%;background:rgba(8,12,24,0.9);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          <option value="cinematic_cyber_saudi">رؤية مستقبلية سيادية (Futuristic Saudi 2030)</option>
          <option value="heritage_luxury">فخامة تراثية معمارية (AlUla & Diriyah)</option>
          <option value="corporate_kafd">أبراج مالية عالمية حديثة (KAFD Financial)</option>
        </select>
      </div>
    `;
  } else if (type === 'video_script') {
    titleEl.textContent = 'صياغة سيناريوهات الفيديو السينمائي والإعلاني';
    promptInput.placeholder = 'عنوان أو فكرة الفيديو، مثل: فيلم وثائقي لتدشين المقر الإقليمي لشركة عالمية في مركز كافد المالي بالرياض...';
    fieldsContainer.innerHTML = `
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">نبرة التعليق الصوتي</label>
        <select name="tone" style="width:100%;background:rgba(8,12,24,0.9);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          <option value="inspiring_sovereign">سيادية ملهمة ووقورة (Sovereign Voiceover)</option>
          <option value="energetic_innovative">حماسية وتقنية متقدمة</option>
          <option value="diplomatic_formal">دبلوماسية ورسمية رفيعة</option>
        </select>
      </div>
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">مدة الفيديو المقترحة</label>
        <select name="duration" style="width:100%;background:rgba(8,12,24,0.9);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          <option value="30">30 ثانية (إعلان تشويقي سريع)</option>
          <option value="60" selected>60 ثانية (فيلم رسمي قياسي)</option>
          <option value="120">120 ثانية (وثائقي مؤسسي شامل)</option>
        </select>
      </div>
    `;
  } else if (type === 'document_ocr') {
    titleEl.textContent = 'التدقيق الآلي للوثائق الحكومية واستخلاص الحقول (OCR)';
    promptInput.placeholder = 'الصق نص الوثيقة أو السجل التجاري أو اكتب رقم السجل للاستعلام عنه وتدقيقه آلياً مع منصات وزارة التجارة وهيئة الزكاة...';
    fieldsContainer.innerHTML = `
      <div>
        <label style="display:block;font-size:0.78rem;color:var(--text-secondary);margin-bottom:0.4rem;">نوع الوثيقة الرسمية</label>
        <select name="doc_type" style="width:100%;background:rgba(8,12,24,0.9);border:1px solid rgba(255,255,255,0.1);border-radius:10px;padding:0.6rem 0.9rem;color:#fff;font-size:0.82rem;font-family:var(--font-arabic);outline:none;">
          <option value="commercial_registration">سجل تجاري سعودي (وزارة التجارة / واثق)</option>
          <option value="misa_license">ترخيص استثمار أجنبي MISA</option>
          <option value="zatca_tax_certificate">شهادة التسجيل الضريبي ZATCA</option>
          <option value="delaware_incorporation">شهادة تأسيس شركة ديلاوير الأمريكية</option>
        </select>
      </div>
    `;
  }
}
</script>
@endsection
