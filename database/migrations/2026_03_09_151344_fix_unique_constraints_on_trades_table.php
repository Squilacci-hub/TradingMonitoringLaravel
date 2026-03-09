<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte unique sur ticket seul si elle existe
            $table->dropUnique('trades_ticket_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            // Recréer l'ancienne contrainte si besoin
            $table->unique('ticket', 'trades_ticket_unique');
        });
    }
};
