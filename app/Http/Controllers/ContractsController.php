<?php

namespace App\Http\Controllers;

use App\Models\DigitalContract;
use App\Services\Contracts\ContractsEngine;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function __construct(protected ContractsEngine $engine) {}

    public function index(Request $request)
    {
        $contracts = DigitalContract::where('user_id', $request->user()->id)->latest()->get();

        return view('pages.dashboard.contracts', compact('contracts'));
    }

    public function sign(Request $request, int $id)
    {
        $contract = DigitalContract::where('user_id', $request->user()->id)->findOrFail($id);
        abort_unless($contract->status === 'pending_signature', 422, 'هذا العقد لا يحتاج إلى توقيع جديد.');

        $this->engine->signContract($contract, $request->user()->name, $request->ip());

        return back()->with('success', 'تم تسجيل التوقيع الإلكتروني وحفظ بصمة العقد.');
    }
}
