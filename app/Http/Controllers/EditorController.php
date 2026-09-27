<?php

namespace App\Http\Controllers;

use App\Services\ContentBlockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EditorController extends Controller
{
    /**
     * Show the Live Visual Page & Content Editor.
     */
    public function index(Request $request): View
    {
        $schema = ContentBlockService::getSchema();
        $pages = array_keys($schema);
        $currentPage = $request->query('page', 'home');

        if (! in_array($currentPage, $pages)) {
            $currentPage = 'home';
        }

        $currentSchema = $schema[$currentPage];
        $savedBlocks = ContentBlockService::getPageBlocks($currentPage);

        // Merge defaults with saved values
        $mergedFields = [];
        foreach ($currentSchema['sections'] as $fieldKey => $fieldConfig) {
            $mergedFields[$fieldKey] = [
                'label' => $fieldConfig['label'],
                'type' => $fieldConfig['type'],
                'default' => $fieldConfig['default'],
                'value' => $savedBlocks[$fieldKey] ?? $fieldConfig['default'],
            ];
        }

        // Target URL for live preview iframe
        $previewUrlMap = [
            'home' => route('home'),
            'about' => route('about'),
            'pricing' => route('pricing'),
            'studio' => route('studio'),
            'app_builder' => route('app-builder'),
        ];
        $previewUrl = $previewUrlMap[$currentPage] ?? route('home');

        return view('pages.dashboard.editor', compact(
            'schema',
            'pages',
            'currentPage',
            'currentSchema',
            'mergedFields',
            'previewUrl'
        ));
    }

    /**
     * Save updated page blocks via AJAX.
     */
    public function save(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'required|string',
            'fields' => 'required|array',
        ]);

        $schema = ContentBlockService::getSchema();
        if (! isset($schema[$validated['page']])) {
            return response()->json([
                'status' => 'error',
                'message' => 'الصفحة المحددة غير مدعومة في محرر المحتوى السيادي.',
            ], 422);
        }

        $saved = ContentBlockService::savePageBlocks($validated['page'], $validated['fields']);

        return response()->json([
            'status' => 'success',
            'message' => 'تم حفظ التحديثات وتطبيق التغييرات اللحظية بنجاح.',
            'page' => $validated['page'],
            'blocks' => $saved,
        ]);
    }

    /**
     * Reset page blocks to system defaults.
     */
    public function reset(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => 'required|string',
        ]);

        ContentBlockService::resetPage($validated['page']);

        return response()->json([
            'status' => 'success',
            'message' => 'تمت استعادة المحتوى الافتراضي السيادي للصفحة بنجاح.',
            'page' => $validated['page'],
        ]);
    }

    /**
     * Export all page configurations as JSON.
     */
    public function export(): StreamedResponse
    {
        $all = ContentBlockService::getAll();
        $json = json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, 'nawader_sovereign_content_blocks_'.date('Y_m_d_His').'.json', [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Import JSON configuration file.
     */
    public function import(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:json,txt|max:2048',
        ]);

        $content = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($content, true);

        if (! is_array($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'الملف المرفوع لا يحتوي على بنية JSON صالحة.',
            ], 422);
        }

        $schema = ContentBlockService::getSchema();
        foreach ($data as $page => $fields) {
            if (isset($schema[$page]) && is_array($fields)) {
                ContentBlockService::savePageBlocks($page, $fields);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'تم استيراد قوالب المحتوى وتحديث المنظومة بنجاح.',
        ]);
    }
}
