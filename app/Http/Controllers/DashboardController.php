<?php

namespace App\Http\Controllers;

use App\Models\DigitalContract;
use App\Models\ServiceRequest;
use App\Models\UserNotification;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $operations = ServiceRequest::query()->where('user_id', $user->id);
        $wallet = $this->walletSummary($user->id);

        $summary = [
            'requests_total' => (clone $operations)->count(),
            'requests_active' => (clone $operations)->whereNotIn('status', ['completed', 'cancelled'])->count(),
            'requests_completed' => (clone $operations)->where('status', 'completed')->count(),
            'contracts_active' => DigitalContract::where('user_id', $user->id)->where('status', 'active')->count(),
            'wallet_balance' => $wallet['balance'],
            'notifications_unread' => UserNotification::where('user_id', $user->id)->whereNull('read_at')->count(),
        ];

        return view('pages.dashboard.index', [
            'user' => $user,
            'summary' => $summary,
            'recentRequests' => $operations->latest('submitted_at')->latest()->limit(4)->get(),
            'notifications' => UserNotification::where('user_id', $user->id)->latest()->limit(4)->get(),
        ]);
    }

    public function profile(Request $request)
    {
        return view('pages.dashboard.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        $request->user()->update($data);

        return back()->with('success', 'تم حفظ بيانات الملف الشخصي.');
    }

    public function settings(Request $request)
    {
        return view('pages.dashboard.settings', ['user' => $request->user()]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate(['two_factor_enabled' => ['nullable', 'boolean']]);
        $request->user()->update(['two_factor_enabled' => (bool) ($data['two_factor_enabled'] ?? false)]);

        return back()->with('success', 'تم تحديث تفضيلات الأمان.');
    }

    public function notifications(Request $request)
    {
        return view('pages.dashboard.notifications', [
            'items' => UserNotification::where('user_id', $request->user()->id)->latest()->paginate(20),
        ]);
    }

    public function markNotificationsRead(Request $request)
    {
        UserNotification::where('user_id', $request->user()->id)->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'تم تحديد الإشعارات الحالية كمقروءة.');
    }

    public function payments(Request $request)
    {
        $transactions = WalletTransaction::where('user_id', $request->user()->id)->latest()->paginate(20);
        $wallet = $this->walletSummary($request->user()->id);
        $paid = WalletTransaction::where('user_id', $request->user()->id)->whereIn('status', ['completed', 'paid', 'settled'])->sum('amount');
        $due = WalletTransaction::where('user_id', $request->user()->id)->whereIn('status', ['pending', 'due'])->sum('amount');

        return view('pages.dashboard.payments', compact('transactions', 'wallet', 'paid', 'due'));
    }

    public function documents()
    {
        $user = request()->user();
        $contracts = DigitalContract::where('user_id', $user->id)->whereNotNull('pdf_path')->latest()->get();
        $requestDocuments = ServiceRequest::where('user_id', $user->id)
            ->whereNotNull('documents')
            ->latest('submitted_at')
            ->get(['request_number', 'service_name', 'documents']);

        return view('pages.dashboard.documents', compact('contracts', 'requestDocuments'));
    }

    public function messages(Request $request)
    {
        return view('pages.dashboard.messages', [
            'requests' => ServiceRequest::where('user_id', $request->user()->id)->latest('submitted_at')->paginate(10),
            'notifications' => UserNotification::where('user_id', $request->user()->id)->latest()->limit(20)->get(),
        ]);
    }

    public function wallet(Request $request)
    {
        $transactions = WalletTransaction::where('user_id', $request->user()->id)->latest()->paginate(20);

        return view('pages.dashboard.wallet', [
            'transactions' => $transactions,
            'wallet' => $this->walletSummary($request->user()->id),
        ]);
    }

    public function invoice(Request $request, $id)
    {
        $transaction = WalletTransaction::where('user_id', $request->user()->id)->find($id);

        return view('pages.dashboard.invoice', compact('transaction'));
    }

    public function sendMessage(Request $r, $requestId)
    {
        abort(422, 'قناة المحادثات المباشرة غير مفعّلة لهذا الحساب حالياً. استخدم نموذج طلب خدمة لإرسال متابعة موثقة.');
    }

    private function walletSummary(int $userId): array
    {
        $transactions = WalletTransaction::where('user_id', $userId)->get();
        $creditTypes = ['deposit', 'cashback', 'escrow_release', 'refund'];
        $balance = $transactions->sum(fn (WalletTransaction $transaction) => in_array($transaction->type, $creditTypes, true)
            ? (float) $transaction->amount
            : -(float) $transaction->amount);

        return [
            'balance' => $balance,
            'held' => (float) $transactions->where('type', 'escrow_hold')->where('status', 'completed')->sum('amount'),
            'transactions_count' => $transactions->count(),
        ];
    }
}
