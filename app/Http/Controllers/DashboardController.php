<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Gérer le compte actif
        $accountId = session('active_account_id') ?? $user->tradingAccounts()->first()?->id;
        $account = $accountId ? $user->tradingAccounts()->find($accountId) : null;

        if (!$account) {
            // Créer un compte par défaut si aucun n'existe
            $account = $user->tradingAccounts()->create(['name' => 'Compte Principal']);
            session(['active_account_id' => $account->id]);
        }

        // Récupérer les trades du compte actif uniquement pour les stats
        $closedTrades = $account->trades()->where('status', 'CLOSED')->get();

        // 1. Calcul Balance (Supposons dépôt initial fictif)
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

        // 4. Derniers trades (pour la liste) du compte actif
        $recentTrades = $account->trades()->latest('open_time')->take(5)->get();

        return view('dashboard', [
            'account_name' => $account->name,
            'balance' => $currentBalance,
            'net_pl' => $totalProfit,
            'win_rate' => $winRate,
            'profit_factor' => $profitFactor,
            'recent_trades' => $recentTrades
        ]);
    }
}
