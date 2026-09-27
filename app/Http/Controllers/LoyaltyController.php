<?php

namespace App\Http\Controllers;

use App\Services\Loyalty\LoyaltyEngine;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    public function __construct(protected LoyaltyEngine $engine) {}

    public function index(Request $request)
    {
        $account = $this->engine->getAccount($request->user());
        $rewards = config('loyalty.rewards', []);

        return view('pages.dashboard.loyalty', compact('account', 'rewards'));
    }

    public function redeem(Request $request)
    {
        return back()->with('error', 'لا توجد مكافآت مفعّلة للاستبدال حالياً.');
    }
}
