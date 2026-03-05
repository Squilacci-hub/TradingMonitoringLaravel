<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trade>
 */
class TradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['BUY', 'SELL']);
        $status = $this->faker->randomElement(['OPEN', 'CLOSED', 'CLOSED', 'CLOSED']); // Plus de closed que d'open

        $openTime = $this->faker->dateTimeBetween('-3 months', 'now');
        $closeTime = ($status === 'CLOSED') ? $this->faker->dateTimeBetween($openTime, 'now') : null;

        // Simulation simple de prix (EURUSD style)
        $openPrice = $this->faker->randomFloat(5, 1.05000, 1.15000);
        $closePrice = ($status === 'CLOSED') ? $this->faker->randomFloat(5, 1.05000, 1.15000) : $this->faker->randomFloat(5, 1.05000, 1.15000);

        // Calcul profit basique (juste pour avoir des chiffres cohérents + ou -)
        $profit = ($status === 'CLOSED') ? $this->faker->randomFloat(2, -500, 1500) : null;

        return [
            'user_id' => User::factory(), // Crée un user si non fourni
            'symbol' => $this->faker->randomElement(['EURUSD', 'GBPUSD', 'BTCUSD', 'ETHUSD', 'XAUUSD']),
            'type' => $type,
            'volume' => $this->faker->randomFloat(2, 0.01, 5.00),
            'open_price' => $openPrice,
            'close_price' => $closePrice,
            'open_time' => $openTime,
            'close_time' => $closeTime,
            'profit' => $profit,
            'commission' => $this->faker->randomFloat(2, -10, -2),
            'swap' => $this->faker->randomFloat(2, -5, 0),
            'status' => $status,
            'notes' => $this->faker->sentence(),
            'screenshot' => null,
        ];
    }
}
