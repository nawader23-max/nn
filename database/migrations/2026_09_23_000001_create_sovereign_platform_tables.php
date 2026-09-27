<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Integration Settings & Key Vault
        Schema::create('integration_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // openai, allam, moyasar, stripe, tamara, tabby, nafath, etc.
            $table->string('key');      // api_key, secret_key, webhook_secret, merchant_id, etc.
            $table->text('value')->nullable();
            $table->string('group');    // ai, payment, gov, comms, analytics, compliance, storage
            $table->boolean('is_active')->default(true);
            $table->boolean('is_secret')->default(true);
            $table->string('environment')->default('live'); // live, sandbox
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['provider', 'key', 'environment']);
        });

        // 2. Digital Contracts
        Schema::create('digital_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('entity_name');
            $table->string('contract_type'); // bilateral_jv, nda, misa_advisory, commercial_rep, escrow_agreement
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 4)->default('SAR');
            $table->string('status')->default('active'); // draft, pending_signature, active, completed, terminated
            $table->string('pdf_path')->nullable();
            $table->string('signature_hash', 64)->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('parties')->nullable();
            $table->json('terms_meta')->nullable();
            $table->timestamps();
        });

        // 3. Sovereign Loyalty & Rewards
        Schema::create('loyalty_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tier')->default('silver'); // silver, gold, platinum, diamond
            $table->integer('points_balance')->default(1500);
            $table->integer('lifetime_points')->default(3200);
            $table->decimal('cashback_balance', 10, 2)->default(250.00);
            $table->decimal('discount_rate', 5, 2)->default(5.00); // 5% discount
            $table->timestamps();
        });

        // 4. Wallet Transactions (Ledger)
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_number')->unique();
            $table->string('type'); // deposit, withdrawal, gov_fee, advisory_fee, escrow_hold, escrow_release, cashback
            $table->decimal('amount', 14, 2);
            $table->string('currency', 4)->default('SAR');
            $table->string('status')->default('completed'); // pending, completed, failed, refunded
            $table->string('payment_method')->default('mada'); // mada, visa, apple_pay, stripe, moyasar, tamara, tabby, wire
            $table->string('reference_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('loyalty_accounts');
        Schema::dropIfExists('digital_contracts');
        Schema::dropIfExists('integration_settings');
    }
};
