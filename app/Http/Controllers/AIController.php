<?php

namespace App\Http\Controllers;

use App\Services\AI\SovereignAIEngine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function __construct(protected SovereignAIEngine $aiEngine) {}

    public function chat(Request $request): JsonResponse
    {
        $prompt = $request->input('message') ?? $request->input('prompt') ?? '';
        if (empty(trim($prompt))) {
            return response()->json(['error' => 'الرسالة مطلوبة'], 422);
        }

        $model = $request->input('model');
        $history = $request->input('history', []);
        $persona = $request->input('persona', 'legal');

        $result = $this->aiEngine->chat($prompt, $model, $history, $persona);

        return response()->json($result);
    }

    public function autoFill(Request $request): JsonResponse
    {
        $formData = $request->input('form_data', []);
        $docText = $request->input('document_text');

        $result = $this->aiEngine->analyzeAndFillForm($formData, $docText);

        return response()->json($result);
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q') ?? $request->input('query') ?? '';
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = $this->aiEngine->searchServices($query);

        return response()->json(['results' => $results]);
    }
}
