<?php

namespace App\Services\AI;

use App\Services\Integrations\IntegrationCredentials;
use Illuminate\Support\Facades\Http;
use Throwable;

/** Unified AI Engine — fallback chain allam/openai/anthropic/gemini/deepseek/ollama. Keys from vault then env; local advisor stub when none. */
class UnifiedAIEngine
{
    public function __construct(private readonly IntegrationCredentials $credentials) {}

    /** @return array{provider: string, text: string, model: string|null} */
    public function generate(string $prompt, int $maxTokens = 800): array
    {
        foreach ($this->orderedProviders() as $provider) {
            try {
                $text = match ($provider) {
                    'allam' => $this->viaAllam($prompt, $maxTokens),
                    'openai' => $this->viaChat('https://api.openai.com/v1', $this->credentials->get('openai', 'api_key'), $this->model($provider, 'gpt-4o-mini'), $prompt, $maxTokens),
                    'anthropic' => $this->viaAnthropic($prompt, $maxTokens),
                    'gemini' => $this->viaGemini($prompt, $maxTokens),
                    'deepseek' => $this->viaChat('https://api.deepseek.com/v1', $this->credentials->get('deepseek', 'api_key'), $this->model($provider, 'deepseek-chat'), $prompt, $maxTokens),
                    'ollama' => $this->viaOllama($prompt, $maxTokens),
                    default => null,
                };
                if (is_string($text) && trim($text) !== '') {
                    return ['provider' => $provider, 'text' => $text, 'model' => $this->model($provider, null)];
                }
            } catch (Throwable) {
                continue;
            }
        }

        return ['provider' => 'local', 'text' => $this->localStub($prompt), 'model' => null];
    }

    public function status(): array
    {
        $rows = [];
        foreach ($this->orderedProviders() as $provider) {
            $needles = $provider === 'ollama' ? ['endpoint'] : ['api_key'];
            $ok = $this->credentials->has($provider, $needles);
            $rows[] = ['provider' => $provider, 'status' => $ok ? 'configured' : 'missing',
                'source' => $ok ? $this->credentials->source($provider, $needles[0]) : null,
                'detail' => $ok ? 'ready' : 'paste key in integrations later'];
        }

        return $rows;
    }

    /** @return array<int, string> */
    private function orderedProviders(): array
    {
        return ['allam', 'openai', 'anthropic', 'gemini', 'deepseek', 'ollama'];
    }

    private function model(string $provider, ?string $fallback): ?string
    {
        return $this->credentials->get($provider, 'model', $fallback) ?? $fallback;
    }

    private function viaAllam(string $prompt, int $maxTokens): ?string
    {
        $key = $this->credentials->get('allam', 'api_key');
        $ep = $this->credentials->get('allam', 'endpoint', 'https://api.allam.sdaia.gov.sa/v1/chat');
        if (! $key || ! $ep) {
            return null;
        }
        $r = Http::timeout(25)->withToken($key)->post($ep, ['messages' => [['role' => 'user', 'content' => $prompt]], 'max_tokens' => $maxTokens]);
        if (! $r->successful()) {
            return null;
        }

        return $r->json('choices.0.message.content') ?? $r->json('text');
    }

    private function viaChat(string $base, ?string $key, ?string $model, string $prompt, int $maxTokens): ?string
    {
        if (! $key) {
            return null;
        }
        $r = Http::timeout(25)->withToken($key)->post(rtrim($base, '/').'/chat/completions',
            ['model' => $model, 'messages' => [['role' => 'user', 'content' => $prompt]], 'max_tokens' => $maxTokens, 'temperature' => 0.7]);

        return $r->successful() ? $r->json('choices.0.message.content') : null;
    }

    private function viaAnthropic(string $prompt, int $maxTokens): ?string
    {
        $key = $this->credentials->get('anthropic', 'api_key');
        if (! $key) {
            return null;
        }
        $r = Http::timeout(25)->withHeaders(['x-api-key' => $key, 'anthropic-version' => '2023-06-01'])
            ->post('https://api.anthropic.com/v1/messages', ['model' => 'claude-3-5-sonnet-latest',
                'max_tokens' => $maxTokens, 'messages' => [['role' => 'user', 'content' => $prompt]]]);

        return $r->successful() ? $r->json('content.0.text') : null;
    }

    private function viaGemini(string $prompt, int $maxTokens): ?string
    {
        $key = $this->credentials->get('gemini', 'api_key');
        if (! $key) {
            return null;
        }
        $r = Http::timeout(25)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key='.$key,
            ['contents' => [['parts' => [['text' => $prompt]]]], 'generationConfig' => ['maxOutputTokens' => $maxTokens]]);

        return $r->successful() ? $r->json('candidates.0.content.parts.0.text') : null;
    }

    private function viaOllama(string $prompt, int $maxTokens): ?string
    {
        $ep = $this->credentials->get('ollama', 'endpoint');
        if (! $ep) {
            return null;
        }
        $r = Http::timeout(60)->post(rtrim($ep, '/').'/api/generate',
            ['model' => $this->model('ollama', 'llama3'), 'prompt' => $prompt, 'stream' => false]);

        return $r->successful() ? $r->json('response') : null;
    }

    private function localStub(string $prompt): string
    {
        $excerpt = mb_substr(trim(preg_replace('/\s+/u', ' ', $prompt) ?? ''), 0, 160);

        return '— مسودة محلية سيادية (لا يوجد مفتاح AI بعد) — الموضوع: '.$excerpt;
    }
}
