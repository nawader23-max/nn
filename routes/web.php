<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AIStudioController;
use App\Http\Controllers\Api\BridgeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\DocumentIngestionController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntegrationsController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReverseOtpController;
use App\Http\Controllers\ServicesController;
use App\Http\Middleware\VerifyPlatformSignature;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NAWADER — نوادر | Sovereign Web Routes
| Strategic Global Platform — Saudi Arabia & USA
|--------------------------------------------------------------------------
*/

// ── Public Routes ─────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Services Catalog & Custom Software Studio
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::view('/services/app-builder', 'pages.app-builder')->name('app-builder');
Route::get('/services/{category}', [ServicesController::class, 'category'])->name('services.category');
Route::get('/services/{category}/{subcategory}', [ServicesController::class, 'subcategory'])->name('services.subcategory');
Route::get('/services/{category}/{subcategory}/{service}', [ServicesController::class, 'show'])->name('services.show');

// Pricing & Calculator
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::post('/pricing/calculate', [PricingController::class, 'calculate'])->name('pricing.calculate');

// About & Contact
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:contact')->name('contact.send');

// Help Center
Route::get('/help', [HelpController::class, 'index'])->name('help');
Route::get('/help/{slug}', [HelpController::class, 'article'])->name('help.article');
Route::get('/help/search', [HelpController::class, 'search'])->name('help.search');

// AI Public & Client API
Route::post('/api/ai/chat', [AIController::class, 'chat'])->middleware('throttle:public-api')->name('ai.chat');
Route::post('/api/ai/autofill', [AIController::class, 'autoFill'])->middleware('throttle:public-api')->name('ai.autofill');
Route::get('/api/ai/search', [AIController::class, 'search'])->middleware('throttle:public-api')->name('ai.search');

// ── Auth Routes ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.post');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register')->name('register.post');
    Route::get('/register/verify', [AuthController::class, 'verifyForm'])->name('register.verify');
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgot'])->middleware('throttle:password-reset')->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Browser-bound, reverse WhatsApp/SMS verification. The POST route performs
// its own session-CSRF validation because the global API exclusion is broader.
Route::prefix('api/auth/reverse-otp')->name('reverse-otp.')->group(function () {
    Route::post('/generate', [ReverseOtpController::class, 'generate'])
        ->middleware('throttle:reverse-otp-generate')->name('generate');
    Route::get('/check-status', [ReverseOtpController::class, 'checkStatus'])
        ->middleware('throttle:reverse-otp-status')->name('status');
});

// Local listener callback: authenticated with a timestamped HMAC, never CSRF.
Route::post('/api/internal/reverse-otp/whatsapp', [ReverseOtpController::class, 'receiveWhatsApp'])
    ->withoutMiddleware([VerifyCsrfToken::class])->name('reverse-otp.whatsapp');

Route::get('/dashboard/reverse-otp/pairing', [ReverseOtpController::class, 'pairingPage'])
    ->middleware(['auth', 'role:super_admin'])->name('reverse-otp.pairing');
Route::get('/dashboard/reverse-otp/pairing/status', [ReverseOtpController::class, 'pairingStatus'])
    ->middleware(['auth', 'role:super_admin'])->name('reverse-otp.pairing.status');

// ── Client Dashboard ─────────────────────────────────────────────────
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index')->withoutMiddleware([]); // alias
    Route::get('/overview', [DashboardController::class, 'index'])->name('overview');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/read', [DashboardController::class, 'markNotificationsRead'])->name('notifications.read');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::put('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/security/phone', [ReverseOtpController::class, 'verificationPage'])->name('security.phone');
    Route::get('/wallet', [DashboardController::class, 'wallet'])->name('wallet');

    // Contracts & E-Sign
    Route::get('/contracts', [ContractsController::class, 'index'])->name('contracts');
    Route::post('/contracts/{id}/sign', [ContractsController::class, 'sign'])->name('contracts.sign');

    // Loyalty & Rewards
    Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('loyalty');
    Route::post('/loyalty/redeem', [LoyaltyController::class, 'redeem'])->name('loyalty.redeem');

    // Integrations Command Center & API Keys
    Route::get('/integrations', [IntegrationsController::class, 'index'])->name('integrations');
    Route::post('/integrations/key', [IntegrationsController::class, 'saveKey'])->middleware('role:super_admin')->name('integrations.key');
    Route::get('/integrations/test', [IntegrationsController::class, 'testConnection'])->name('integrations.test');

    // Affiliate Marketing Portal
    Route::get('/affiliate', [AffiliateController::class, 'index'])->name('affiliate');
    Route::post('/affiliate/payout', [AffiliateController::class, 'requestPayout'])->name('affiliate.payout');

    // Developer & External Platform Connect
    Route::get('/developer', [DeveloperController::class, 'index'])->name('developer');
    Route::post('/developer/token', [DeveloperController::class, 'createToken'])->middleware('role:developer')->name('developer.create-token');
    Route::delete('/developer/token/{id}', [DeveloperController::class, 'revokeToken'])->middleware('role:developer')->name('developer.revoke-token');
    Route::post('/developer/webhook', [DeveloperController::class, 'createWebhook'])->middleware('role:developer')->name('developer.create-webhook');
    Route::post('/developer/webhook/{id}/test', [DeveloperController::class, 'testWebhook'])->middleware('role:developer')->name('developer.test-webhook');

    // AI Creative Studio (Drafts, Prompts, Scripts, OCR)
    Route::get('/ai-studio', [AIStudioController::class, 'index'])->name('ai-studio');
    Route::post('/ai-studio/generate', [AIStudioController::class, 'generate'])->name('ai-studio.generate');

    // Live Visual Page & Content Editor (staff-only content operations)
    Route::get('/editor', [EditorController::class, 'index'])->middleware('role:super_admin,sovereign_advisor')->name('editor');
    Route::post('/editor/save', [EditorController::class, 'save'])->middleware('role:super_admin,sovereign_advisor')->name('editor.save');
    Route::post('/editor/reset', [EditorController::class, 'reset'])->middleware('role:super_admin,sovereign_advisor')->name('editor.reset');
    Route::get('/editor/export', [EditorController::class, 'export'])->middleware('role:super_admin,sovereign_advisor')->name('editor.export');
    Route::post('/editor/import', [EditorController::class, 'import'])->middleware('role:super_admin,sovereign_advisor')->name('editor.import');

    // High-Capacity Universal Document Ingestion & Archive Extractor Engine (sovereign admin tooling)
    Route::get('/importer', [DocumentIngestionController::class, 'index'])->middleware('role:super_admin')->name('importer');
    Route::post('/importer/upload', [DocumentIngestionController::class, 'upload'])->middleware('role:super_admin')->name('importer.upload');
    Route::get('/importer/export', [DocumentIngestionController::class, 'export'])->middleware('role:super_admin')->name('importer.export');

    // Requests
    Route::get('/requests', [RequestController::class, 'index'])->name('requests');
    Route::get('/requests/new', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests/new', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}', [RequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{id}/track', [RequestController::class, 'track'])->name('requests.track');
    Route::post('/requests/{id}/documents', [RequestController::class, 'uploadDoc'])->name('requests.upload');

    // Payments
    Route::get('/payments', [DashboardController::class, 'payments'])->name('payments');
    Route::get('/invoices/{id}', [DashboardController::class, 'invoice'])->name('invoices.show');

    // Messages
    Route::get('/messages', [DashboardController::class, 'messages'])->name('messages');
    Route::post('/messages/{requestId}', [DashboardController::class, 'sendMessage'])->name('messages.send');

    // Documents
    Route::get('/documents', [DashboardController::class, 'documents'])->name('documents');
});

// ── Public Studio & Custom App Builder ────────────────────────────────
Route::view('/studio', 'pages.studio')->name('studio');
Route::get('/ref/{code}', [AffiliateController::class, 'trackClick'])->name('affiliate.track');

// Main dashboard alias
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// ── Investor Portal ───────────────────────────────────────────────────
Route::middleware('auth')->prefix('investor')->name('investor.')->group(function () {
    Route::get('/', [InvestorController::class, 'index'])->name('index');
    Route::get('/opportunities', [InvestorController::class, 'opportunities'])->name('opportunities');
    Route::get('/opportunities/{id}', [InvestorController::class, 'opportunity'])->name('opportunity');
    Route::get('/data-room', [InvestorController::class, 'dataRoom'])->name('data-room');
    Route::get('/consultations', [InvestorController::class, 'consultations'])->name('consultations');
    Route::post('/consultations/book', [InvestorController::class, 'book'])->name('consultations.book');
});

// ── Legal & Policies ──────────────────────────────────────────────────
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/refund', 'pages.refund')->name('refund');

/*
|--------------------------------------------------------------------------
| Sovereign Platform Bridge (Nawader ⇄ TravelsStar)
|--------------------------------------------------------------------------
| Signed server-to-server API. Read endpoints are public (marketing copy and
| identity only); mutation endpoints require an HMAC signature and a
| timestamped, single-use nonce — see App\Http\Middleware\VerifyPlatformSignature.
*/
Route::prefix('api/bridge/v1')->name('bridge.')->group(function () {
    Route::get('/ping', [BridgeController::class, 'ping'])
        ->name('ping');
    Route::get('/content/blocks', [BridgeController::class, 'blocks'])
        ->name('content.blocks');

    Route::middleware(VerifyPlatformSignature::class)->group(function () {
        Route::post('/content/sync', [BridgeController::class, 'sync'])
            ->name('content.sync')
            ->withoutMiddleware([VerifyCsrfToken::class]);
        Route::post('/events', [BridgeController::class, 'events'])
            ->name('events')
            ->withoutMiddleware([VerifyCsrfToken::class]);
    });
});
