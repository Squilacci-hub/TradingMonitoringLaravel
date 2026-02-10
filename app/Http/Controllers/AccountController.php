<?php

namespace App\Http\Controllers;

use App\Models\TradingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function select($id)
    {
        $account = Auth::user()->tradingAccounts()->findOrFail($id);

        session(['active_account_id' => $account->id]);

        return back()->with('success', "Compte {$account->name} sélectionné.");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $account = Auth::user()->tradingAccounts()->create($validated);

        session(['active_account_id' => $account->id]);

        return redirect()->route('dashboard')->with('success', 'Nouveau compte créé.');
    }
}
