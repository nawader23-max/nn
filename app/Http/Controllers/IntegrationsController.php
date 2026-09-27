<?php

namespace App\Http\Controllers;

use App\Services\Integrations\SovereignIntegrationsManager;
use Illuminate\Http\Request;

class IntegrationsController extends Controller
{
    public function index()
    {
        $groups = SovereignIntegrationsManager::getAllIntegrations();

        return view('pages.dashboard.integrations', compact('groups'));
    }

    public function saveKey(Request $request)
    {
        $provider = $request->input('provider');
        $key = $request->input('key');
        $value = $request->input('value');
        $group = $request->input('group', 'general');

        if ($provider && $key && ! preg_match('/^•+$/u', (string) $value)) {
            SovereignIntegrationsManager::setKey($provider, $key, $value, $group);
        }

        return back()->with('success', "تم حفظ إعدادات التكامل ({$provider}). لا يُعتبر الاتصال خارجياً ناجحاً إلا بعد فحصه.");
    }

    public function testConnection(Request $request)
    {
        $provider = $request->input('provider');

        $configured = false;
        foreach (SovereignIntegrationsManager::getAllIntegrations() as $group) {
            if (! isset($group['providers'][$provider])) {
                continue;
            }

            $configured = collect(array_keys($group['providers'][$provider]['keys']))
                ->every(fn (string $key) => SovereignIntegrationsManager::hasKey($provider, $key));
            break;
        }

        return response()->json([
            'success' => $configured,
            'provider' => $provider,
            'message' => $configured
                ? 'الإعدادات الأساسية مكتملة. يلزم اختبار الاتصال الفعلي قبل اعتبار الخدمة متصلة.'
                : 'لم تكتمل مفاتيح هذا التكامل بعد؛ لا توجد نتيجة اتصال فعلية يمكن تأكيدها.',
        ]);
    }
}
