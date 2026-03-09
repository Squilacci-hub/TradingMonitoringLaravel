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
            // Ajouter un index unique sur user_id + ticket pour éviter les doublons (PostgreSQL)
            $table->unique(['user_id', 'ticket'], 'trades_user_id_ticket_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trades', function (Blueprint $table) {
            // Supprimer l'index unique en cas de rollback
            $table->dropUnique('trades_user_id_ticket_unique');
        });
    }
};
