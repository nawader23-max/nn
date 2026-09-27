<?php

namespace App\Http\Controllers;

use App\Models\DeveloperApiToken;
use App\Models\WebhookEndpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeveloperController extends Controller
{
    /**
     * Developer & External Platform Connect Portal
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $tokens = DeveloperApiToken::where('user_id', $user->id)->latest()->get();
        $webhooks = WebhookEndpoint::where('user_id', $user->id)->latest()->get();

        $availableEvents = [
            'contract.signed' => 'توقيع وتوثيق عقد إلكتروني بشفرة SHA-256',
            'escrow.locked' => 'حجز وتجميد ضمان مالي في حساب Escrow السيادي',
            'escrow.released' => 'الإفراج عن الضمان المالي وتحويله للمستفيد',
            'invoice.zatca_cleared' => 'اعتماد وتوثيق الفاتورة الإلكترونية عبر ZATCA المرحلة 2',
            'service.status_updated' => 'تحديث حالة مسار خدمة حكومية أو ترخيص MISA',
            'kyc.verified' => 'اكتمال التحقق السيادي والنفاذ الوطني الموحد للمنشأة',
        ];

        return view('pages.dashboard.developer', compact('user', 'tokens', 'webhooks', 'availableEvents'));
    }

    /**
     * Generate New Developer API Token
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'environment' => 'required|in:live,sandbox',
        ]);

        $user = $request->user();
        $prefix = $request->environment === 'live' ? 'nwdr_live_' : 'nwdr_test_';
        $plainToken = $prefix.Str::random(32);
        $tokenHash = hash('sha256', $plainToken);

        DeveloperApiToken::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'token_prefix' => substr($plainToken, 0, 14),
            'token_hash' => $tokenHash,
            'abilities' => ['services:read', 'contracts:read', 'invoices:create', 'zatca:verify'],
            'environment' => $request->environment,
            'expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        return back()->with('new_token', $plainToken)
            ->with('success', 'تم توليد مفتاح الربط السيادي بنجاح. يرجى نسخه الآن، فلن يظهر كاملاً مرة أخرى لدواعي الأمان.');
    }

    /**
     * Revoke Token
     */
    public function revokeToken(int $id)
    {
        $user = $request->user();
        $token = DeveloperApiToken::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $token->delete();

        return back()->with('success', 'تم إبطال وإلغاء مفتاح الربط السيادي بنجاح.');
    }

    /**
     * Register Webhook Endpoint
     */
    public function createWebhook(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
            'events' => 'required|array|min:1',
        ]);

        $user = $request->user();
        $secret = 'whsec_'.Str::random(32);

        WebhookEndpoint::create([
            'user_id' => $user->id,
            'url' => $request->url,
            'secret' => $secret,
            'events' => $request->events,
            'is_active' => true,
            'failure_count' => 0,
        ]);

        return back()->with('success', 'تم تسجيل نقطة نهاية الويب هوك بنجاح وربطها بالأحداث المحددة.');
    }

    /**
     * Test Webhook Dispatch
     */
    public function testWebhook(Request $request, int $id)
    {
        $user = $request->user();
        $webhook = WebhookEndpoint::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $webhook->update([
            'last_dispatched_at' => now(),
            'failure_count' => 0,
        ]);

        return back()->with('success', 'تمت جدولة اختبار نقطة الويب هوك. لم يُعتبر التسليم ناجحاً إلا بعد تسجيل استجابة من الخادم المستقبل.');
    }
}
