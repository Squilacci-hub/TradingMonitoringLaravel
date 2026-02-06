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
            'platform' => 'nullable|string|in:MT4,MT5',
            'broker_login' => 'nullable|string|max:255',
            'broker_server' => 'nullable|string|max:255',
            'broker_password' => 'nullable|string|max:255',
        ]);

        $account = Auth::user()->tradingAccounts()->create($validated);

        if ($request->has('is_sync')) {
            $account->api_key = 'TA_' . bin2hex(random_bytes(16));
            $account->save();
        }

        session(['active_account_id' => $account->id]);

        if ($request->has('is_sync')) {
            return view('accounts.setup', compact('account'));
        }

        return redirect()->route('dashboard')->with('success', 'Nouveau compte créé.');
    }
}
