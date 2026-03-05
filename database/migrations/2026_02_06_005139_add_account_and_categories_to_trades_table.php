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
        Schema::table('trades', function (Blueprint $table) {
            $table->foreignId('trading_account_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('emotion_id')->nullable()->constrained();
            $table->foreignId('pattern_id')->nullable()->constrained();
            $table->foreignId('pair_id')->nullable()->constrained();
            $table->string('timeframe')->nullable(); // M1, M5, H1, etc.
            $table->decimal('risk_percentage', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            $table->dropForeign(['trading_account_id']);
            $table->dropForeign(['emotion_id']);
            $table->dropForeign(['pattern_id']);
            $table->dropForeign(['pair_id']);
            $table->dropColumn(['trading_account_id', 'emotion_id', 'pattern_id', 'pair_id', 'timeframe', 'risk_percentage']);
        });
    }
};
