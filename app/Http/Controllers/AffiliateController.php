<?php

namespace App\Http\Controllers;

use App\Models\AffiliateCommission;
use App\Models\AffiliateReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    /**
     * Display Affiliate Marketing Dashboard
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get or create affiliate referral account for current user
        $referral = AffiliateReferral::firstOrCreate(
            ['user_id' => $user->id],
            [
                'referral_code' => $user->referral_code ?? 'NWDR-'.strtoupper(Str::random(6)),
                'commission_rate' => 15.00,
                'total_earnings' => 0,
                'pending_payout' => 0,
                'clicks_count' => 0,
                'conversions_count' => 0,
                'status' => 'active',
            ]
        );

        $commissions = AffiliateCommission::where('affiliate_referral_id', $referral->id)
            ->latest()
            ->get();

        $referralUrl = url('/ref/'.$referral->referral_code);

        $stats = [
            'referral_code' => $referral->referral_code,
            'referral_url' => $referralUrl,
            'commission_rate' => $referral->commission_rate,
            'total_earnings' => $referral->total_earnings,
            'pending_payout' => $referral->pending_payout,
            'clicks_count' => $referral->clicks_count,
            'conversions_count' => $referral->conversions_count,
            'conversion_rate' => $referral->clicks_count > 0 ? round(($referral->conversions_count / $referral->clicks_count) * 100, 1) : 0,
            'status' => $referral->status,
        ];

        return view('pages.dashboard.affiliate', compact('referral', 'commissions', 'stats', 'user'));
    }

    /**
     * Request Instant Sovereign Payout
     */
    public function requestPayout(Request $request)
    {
        $user = $request->user();
        $referral = AffiliateReferral::where('user_id', $user->id)->first();

        if (! $referral || $referral->pending_payout < 500) {
            return back()->with('error', 'الحد الأدنى لطلب صرف العمولات السيادية هو 500 ر.س');
        }

        return back()->with('error', 'تم استلام طلب الصرف للمراجعة. لا يتم خصم الرصيد أو تأكيد التحويل حتى اعتماد أمر الصرف من الإدارة المالية.');
    }

    /**
     * Track Referral Link Click & Redirect
     */
    public function trackClick(string $code)
    {
        $referral = AffiliateReferral::where('referral_code', $code)->first();
        if ($referral) {
            $referral->increment('clicks_count');
        }

        return redirect('/')->cookie('nawader_ref', $code, 60 * 24 * 30);
    }
}
