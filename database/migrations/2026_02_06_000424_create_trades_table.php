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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Le trade appartient à un User

            // Infos de base
            $table->string('symbol'); // e.g. EURUSD, BTCUSD
            $table->enum('type', ['BUY', 'SELL']);
            $table->decimal('volume', 8, 2); // e.g. 1.50 Lots

            // Prix et Temps
            $table->decimal('open_price', 14, 5);
            $table->decimal('close_price', 14, 5)->nullable(); // Nullable car le trade peut être en cours
            $table->timestamp('open_time');
            $table->timestamp('close_time')->nullable();

            // Resultats
            $table->decimal('profit', 10, 2)->nullable();
            $table->decimal('commission', 8, 2)->default(0);
            $table->decimal('swap', 8, 2)->default(0);

            // Metadonnées
            $table->string('status')->default('OPEN'); // OPEN, CLOSED, PENDING
            $table->text('notes')->nullable();
            $table->string('screenshot')->nullable(); // Référence future

            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
