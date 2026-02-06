<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les trades fermés pour les stats
        $closedTrades = $user->trades()->where('status', 'CLOSED')->get();

        // 1. Calcul Balance (Supposons dépôt initial fictif ou calculé)
        // Pour l'exemple, on part de 100,000 et on ajoute les profits
        $initialBalance = 100000;
        $totalProfit = $closedTrades->sum('profit');
        $currentBalance = $initialBalance + $totalProfit;

        // 2. Win Rate
        $winningTrades = $closedTrades->where('profit', '>', 0)->count();
        $totalClosed = $closedTrades->count();
        $winRate = $totalClosed > 0 ? ($winningTrades / $totalClosed) * 100 : 0;

        // 3. Profit Factor
        $grossProfit = $closedTrades->where('profit', '>', 0)->sum('profit');
        $grossLoss = abs($closedTrades->where('profit', '<', 0)->sum('profit'));
        $profitFactor = $grossLoss > 0 ? $grossProfit / $grossLoss : 0;

        // 4. Derniers trades (pour la liste)
        $recentTrades = $user->trades()->latest('open_time')->take(5)->get();

        return view('dashboard', [
            'balance' => $currentBalance,
            'net_pl' => $totalProfit,
            'win_rate' => $winRate,
            'profit_factor' => $profitFactor,
            'recent_trades' => $recentTrades
        ]);
    }
}
