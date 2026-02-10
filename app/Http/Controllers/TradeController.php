<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\TradingAccount;
use App\Models\Pattern;
use App\Models\Emotion;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $patterns = Pattern::all();
        $emotions = Emotion::all();
        $pairs = Pair::all();

        return view('trades.create', compact('patterns', 'emotions', 'pairs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $activeAccountId = session('active_account_id') ?? $user->tradingAccounts()->first()?->id;

        $validated = $request->validate([
            'trading_account_id' => 'required|exists:trading_accounts,id',
            'symbol' => 'required|string',
            'pair_id' => 'required|exists:pairs,id',
            'type' => 'required|in:BUY,SELL',
            'volume' => 'required|numeric|min:0.01',
            'open_price' => 'required|numeric',
            'close_price' => 'nullable|numeric',
            'profit' => 'required|numeric',
            'risk_percentage' => 'nullable|numeric|min:0|max:100',
            'timeframe' => 'required|string',
            'pattern_id' => 'nullable|exists:patterns,id',
            'emotion_id' => 'nullable|exists:emotions,id',
            'notes' => 'nullable|string',
        ]);

        // Sécurité : Vérifier que le compte appartient bien à l'utilisateur
        if (!$user->tradingAccounts()->where('id', $validated['trading_account_id'])->exists()) {
            abort(403);
        }

        $trade = new Trade($validated);
        $trade->user_id = $user->id;
        $trade->open_time = now();

        // Pour une insertion manuelle avec profit, on considère le trade comme TERMINE (CLOSED)
        $trade->status = 'CLOSED';
        $trade->close_time = now();

        $trade->save();

        return redirect()->route('trades.create')->with('success', 'Trade ajouté avec succès !');
    }
}
