<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consent_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('purpose', 64)->index();
            $table->string('policy_version', 10);
            $table->char('fingerprint', 64);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamp('accepted_at');
            $table->timestamps();
            $table->unique(['user_id', 'purpose', 'policy_version']);
        });

        Schema::create('request_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained()->cascadeOnDelete();
            $table->string('status', 40);
            $table->string('note', 500)->nullable();
            $table->string('actor', 16)->default('system');
            $table->timestamps();
            $table->index(['service_request_id', 'created_at']);
        });

        Schema::table('digital_contracts', function (Blueprint $table) {
            $table->foreignId('service_request_id')->nullable()->after('user_id')
                ->constrained('service_requests')->nullOnDelete();
            $table->string('verification_token', 64)->nullable()->unique()->after('status');
            $table->string('signature_path', 255)->nullable()->after('pdf_path');
            $table->char('document_sha256', 64)->nullable()->after('signature_path');
            $table->timestamp('otp_verified_at')->nullable()->after('signed_at');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('price_base', 12, 2)->nullable()->after('progress');
            $table->decimal('price_speed_fee', 12, 2)->nullable()->after('price_base');
            $table->decimal('price_vat', 12, 2)->nullable()->after('price_speed_fee');
            $table->decimal('price_total', 12, 2)->nullable()->after('price_vat');
            $table->string('escrow_reference', 60)->nullable()->after('price_total');
            $table->foreignId('contract_id')->nullable()->after('escrow_reference')
                ->constrained('digital_contracts')->nullOnDelete();
            $table->string('invoice_number', 40)->nullable()->after('contract_id');
            $table->char('invoice_hash', 64)->nullable()->after('invoice_number');
            $table->timestamp('invoice_issued_at')->nullable()->after('invoice_hash');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('contract_id');
            $table->dropColumn(['price_base', 'price_speed_fee', 'price_vat', 'price_total', 'escrow_reference', 'invoice_number', 'invoice_hash', 'invoice_issued_at']);
        });
        Schema::table('digital_contracts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_request_id');
            $table->dropColumn(['verification_token', 'signature_path', 'document_sha256', 'otp_verified_at']);
        });
        Schema::dropIfExists('request_events');
        Schema::dropIfExists('consent_records');
    }
};
