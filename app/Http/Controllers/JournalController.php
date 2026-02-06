<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $accountId = session('active_account_id') ?? $user->tradingAccounts()->first()?->id;
        $account = $accountId ? $user->tradingAccounts()->find($accountId) : null;

        if (!$account) {
            return redirect()->route('dashboard');
        }

        // Récupérer les trades du compte actif paginés
        $trades = $account->trades()->orderBy('open_time', 'desc')->paginate(20);

        return view('journal', [
            'trades' => $trades
        ]);
    }
}
