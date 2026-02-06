<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trading_accounts', function (Blueprint $table) {
            $table->string('broker_server')->nullable();
            $table->string('broker_login')->nullable();
            $table->string('broker_password')->nullable(); // À hasher ou crypter en prod réelle
            $table->string('platform')->default('MT4'); // MT4 ou MT5
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trading_accounts', function (Blueprint $table) {
            $table->dropColumn(['broker_server', 'broker_login', 'broker_password', 'platform']);
        });
    }
};
