<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('server_purchases', function (Blueprint $table) {
            $table->string('os')->default('ubuntu-22.04')->after('server_name');
            $table->string('preset_software')->nullable()->after('os');
            $table->string('power_state')->default('running')->after('status');
            $table->timestamp('last_reinstalled_at')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('server_purchases', function (Blueprint $table) {
            $table->dropColumn(['os', 'preset_software', 'power_state', 'last_reinstalled_at']);
        });
    }
};
