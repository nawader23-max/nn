<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Users Table for Strict RBAC & Sovereign Security
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('corporate_client')->after('email'); // super_admin, sovereign_advisor, corporate_client, investor, developer
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('role');
            }
            if (! Schema::hasColumn('users', 'national_id')) {
                $table->string('national_id')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable()->after('national_id');
            }
            if (! Schema::hasColumn('users', 'kyc_tier')) {
                $table->integer('kyc_tier')->default(3)->after('company_name'); // Tier 1-4
            }
            if (! Schema::hasColumn('users', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(true)->after('kyc_tier');
            }
            if (! Schema::hasColumn('users', 'referral_code')) {
                $table->string('referral_code', 32)->nullable()->unique()->after('two_factor_enabled');
            }
        });

        // 2. Affiliate Referrals & Tracking
        Schema::create('affiliate_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // The referrer
            $table->foreignId('referred_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('referral_code', 32);
            $table->decimal('commission_rate', 5, 2)->default(15.00); // 15%
            $table->decimal('total_earnings', 12, 2)->default(0.00);
            $table->decimal('pending_payout', 12, 2)->default(0.00);
            $table->integer('clicks_count')->default(0);
            $table->integer('conversions_count')->default(0);
            $table->string('status')->default('active'); // active, paused
            $table->timestamps();
        });

        // 3. Affiliate Commission Transactions
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliate_referral_id')->constrained('affiliate_referrals')->cascadeOnDelete();
            $table->string('order_reference');
            $table->decimal('order_amount', 12, 2);
            $table->decimal('commission_amount', 12, 2);
            $table->string('currency', 4)->default('SAR');
            $table->string('status')->default('approved'); // pending, approved, paid
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 4. Developer API Tokens (B2B Platform Connect)
        Schema::create('developer_api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('token_prefix', 16);
            $table->string('token_hash', 64)->unique();
            $table->json('abilities')->nullable(); // ["services:read", "requests:create", "contracts:read"]
            $table->string('environment')->default('live'); // live, sandbox
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Webhook Endpoints
        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('secret', 64);
            $table->json('events')->nullable(); // ["request.created", "request.completed", "invoice.paid"]
            $table->boolean('is_active')->default(true);
            $table->integer('failure_count')->default(0);
            $table->timestamp('last_dispatched_at')->nullable();
            $table->timestamps();
        });

        // 6. AI Studio Generations (Texts, Prompts, Video Scripts, OCR Audits)
        Schema::create('ai_studio_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // prompt_generator, legal_draft, video_script, document_ocr
            $table->string('title');
            $table->text('input_prompt');
            $table->longText('generated_content');
            $table->string('model_used')->default('allam-sovereign');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_studio_generations');
        Schema::dropIfExists('webhook_endpoints');
        Schema::dropIfExists('developer_api_tokens');
        Schema::dropIfExists('affiliate_commissions');
        Schema::dropIfExists('affiliate_referrals');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'national_id', 'company_name', 'kyc_tier', 'two_factor_enabled', 'referral_code',
            ]);
        });
    }
};
