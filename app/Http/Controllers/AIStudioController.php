<?php

namespace App\Http\Controllers;

use App\Models\AiStudioGeneration;
use App\Services\AI\SovereignAIEngine;
use Illuminate\Http\Request;

class AIStudioController extends Controller
{
    public function __construct(protected SovereignAIEngine $aiEngine) {}

    /**
     * AI Studio Main Workbench
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $activeTab = $request->query('tab', 'legal');
        $generations = AiStudioGeneration::where('user_id', $user->id)
            ->latest()
            ->take(20)
            ->get();

        return view('pages.dashboard.ai-studio', compact('user', 'generations', 'activeTab'));
    }

    /**
     * Dispatch Studio Generation Request
     */
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:legal_draft,prompt_generator,video_script,document_ocr',
            'prompt' => 'required|string|min:5',
        ]);

        $user = $request->user();
        $type = $request->input('type');
        $prompt = $request->input('prompt');

        $result = match ($type) {
            'legal_draft' => $this->aiEngine->generateStudioLegalDraft(
                $prompt,
                $request->input('party_a', $user->company_name ?: 'الطرف الأول'),
                $request->input('party_b', $user->company_name ?? 'الطرف الشريك'),
                $request->input('jurisdiction', 'المملكة العربية السعودية')
            ),
            'prompt_generator' => $this->aiEngine->generateStudioPrompt(
                $prompt,
                $request->input('engine', 'midjourney'),
                $request->input('style', 'cinematic_cyber_saudi')
            ),
            'video_script' => $this->aiEngine->generateStudioVideoScript(
                $prompt,
                $request->input('tone', 'inspiring_sovereign'),
                (int) $request->input('duration', 60)
            ),
            'document_ocr' => $this->aiEngine->analyzeDocumentOcr(
                $prompt,
                $request->input('doc_type', 'commercial_registration')
            ),
        };

        // Persist to database
        $record = AiStudioGeneration::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $result['title'] ?? 'عملية توليد ذكاء اصطناعي سيادي',
            'input_prompt' => $prompt,
            'generated_content' => $result['content'],
            'model_used' => $result['model'] ?? 'allam-sovereign',
            'metadata' => $result['metadata'] ?? [],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        }

        return redirect()->route('dashboard.ai-studio', ['tab' => $type])
            ->with('success', "تم إنجاز التوليد الذكي بنجاح عبر {$record->model_used} وتمت أرشفة الوثيقة في سجلك.");
    }
}
