<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OllamaService
{
    protected string $baseUrl;
    protected string $catalogModel;
    protected string $docsModel;
    protected string $contentModel;

    public function __construct()
    {
        $this->baseUrl = config('services.ollama.host', env('OLLAMA_HOST', 'http://127.0.0.1:11434'));
        $this->catalogModel = env('OLLAMA_MODEL_CATALOG', 'qwen2.5-coder:7b');
        $this->docsModel = env('OLLAMA_MODEL_DOCS', 'llama3.2:3b');
        $this->contentModel = env('OLLAMA_MODEL_CONTENT', 'qwen2.5:3b');
    }

    /**
     * 1. نموذج الكتالوج والبيانات (عند الحاجة - يفرغ الرام بعد دقيقة)
     */
    public function generateCatalogStructure(string $prompt): ?array
    {
        return $this->callModel($this->catalogModel, $prompt, true, '1m');
    }

    /**
     * 2. نموذج فحص المستندات (عند الحاجة - يفرغ الرام بعد دقيقة)
     */
    public function analyzeDocument(string $text): ?string
    {
        $response = $this->callModel($this->docsModel, "لخص واستخرج النقاط الرئيسية من هذا المستند:\n\n" . $text, false, '1m');
        return $response['response'] ?? null;
    }

    /**
     * 3. النموذج المميز الدائم: المحتوى والردود السريعة (دائم البقاء في الرام للسرعة القصوى)
     */
    public function generateMarketingContent(string $prompt): ?string
    {
        $response = $this->callModel($this->contentModel, $prompt, false, -1);
        return $response['response'] ?? null;
    }

    /**
     * تنفيذ الاتصال مع محرك Ollama مع إدارة استهلاك الذاكرة
     */
    protected function callModel(string $model, string $prompt, bool $isJson = false, $keepAlive = '1m'): ?array
    {
        try {
            $payload = [
                'model'      => $model,
                'prompt'     => $prompt,
                'stream'     => false,
                'keep_alive' => $keepAlive,
            ];

            if ($isJson) {
                $payload['format'] = 'json';
            }

            $response = Http::timeout(120)->post("{$this->baseUrl}/api/generate", $payload);

            if ($response->successful()) {
                if ($isJson) {
                    return json_decode($response->json('response'), true);
                }
                return $response->json();
            }

            Log::error("Ollama API Error [{$model}]: " . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error("Ollama Connection Exception [{$model}]: " . $e->getMessage());
            return null;
        }
    }
}
