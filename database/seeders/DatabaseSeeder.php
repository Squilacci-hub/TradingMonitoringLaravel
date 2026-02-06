<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Trade;
use App\Models\Pattern;
use App\Models\Emotion;
use App\Models\Pair;
use App\Models\TradingAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Patterns (Requested by user)
        $patterns = [
            'Triangle Asymétrique',
            'Tête et Épaules',
            'Imbalance',
            'Order Block',
            'Fibonacci',
            'Breakout',
            'Range Bound'
        ];
        foreach ($patterns as $p) {
            Pattern::firstOrCreate(['name' => $p]);
        }

        // 2. Emotions (Recommended for trading)
        $emotions = ['Confiant', 'Stressé', 'Peur (FOMO)', 'Neutre', 'Euphorique', 'Frustré'];
        foreach ($emotions as $e) {
            Emotion::firstOrCreate(['name' => $e]);
        }

        // 3. Pairs
        $pairs = ['EURUSD', 'GBPUSD', 'USDJPY', 'XAUUSD', 'BTCUSD', 'ETHUSD'];
        foreach ($pairs as $p) {
            Pair::firstOrCreate(['name' => $p]);
        }

        // 4. Utilisateur et Compte Principal
        $user = User::firstOrCreate(
            ['email' => 'squilaccilaurieanjara@gmail.com'],
            [
                'name' => 'Laurie Trader',
                'password' => Hash::make('password'),
            ]
        );

        $account = TradingAccount::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Compte Principal']
        );

        // 5. Mettre à jour les trades orphelins (si existants)
        Trade::where('user_id', $user->id)
            ->whereNull('trading_account_id')
            ->update(['trading_account_id' => $account->id]);

        // 6. Générer quelques trades frais connectés au compte
        Trade::factory()
            ->count(20)
            ->create([
                'user_id' => $user->id,
                'trading_account_id' => $account->id,
                'pair_id' => Pair::inRandomOrder()->first()->id,
                'emotion_id' => Emotion::inRandomOrder()->first()->id,
                'pattern_id' => Pattern::inRandomOrder()->first()->id,
            ]);

        $this->command->info("Seeding terminé avec succès pour {$user->email} !");
    }
}
