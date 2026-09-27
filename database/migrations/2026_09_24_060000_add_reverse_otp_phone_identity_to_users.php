<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_e164', 16)->nullable()->unique()->after('phone');
            $table->timestamp('phone_verified_at')->nullable()->after('phone_e164');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['phone_e164']);
            $table->dropColumn(['phone_e164', 'phone_verified_at']);
        });
    }
};
