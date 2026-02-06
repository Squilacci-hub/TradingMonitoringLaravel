<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Trouver ou Créer l'utilisateur spécifique
        $user = User::firstOrCreate(
            ['email' => 'mamisoasheena@gmail.com'],
            [
                'name' => 'Sheena',
                'password' => Hash::make('sheena123'), // Mot de passe par défaut pour le test
                'id' => 2 // On force l'ID 1 si possible (attention si déjà pris)
            ]
        );

        // 2. Générer 50 Trades pour cet utilisateur
        Trade::factory()
            ->count(50)
            ->for($user)
            ->create();

        $this->command->info("50 Trades générés pour {$user->email} !");
    }
}
