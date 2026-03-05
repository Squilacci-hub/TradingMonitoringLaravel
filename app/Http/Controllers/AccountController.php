<?php

namespace App\Http\Controllers;

use App\Models\TradingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $mt5;

    public function __construct(\App\Services\MT5Service $mt5)
    {
        $this->mt5 = $mt5;
    }

    public function select($id)
    {
        $account = Auth::user()->tradingAccounts()->findOrFail($id);

        session(['active_account_id' => $account->id]);

        return back()->with('success', "Compte {$account->name} sélectionné.");
    }

    public function create()
    {
        return view('accounts.create');
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

    public function link()
    {
        return view('accounts.link');
    }

    public function linkStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'broker_server' => 'required|string',
            'broker_login' => 'required|string',
            'broker_password' => 'required|string',
        ]);

        // Vérifier la connexion via le bridge
        $result = $this->mt5->verifyAccount(
            $validated['broker_login'],
            $validated['broker_password'],
            $validated['broker_server']
        );

        if (!$result['success']) {
            return back()->withErrors(['broker_login' => $result['error']])->withInput();
        }

        // Sauvegarder
        $account = Auth::user()->tradingAccounts()->create([
            'name' => $validated['name'],
            'broker_server' => $validated['broker_server'],
            'broker_login' => $validated['broker_login'],
            'broker_password' => encrypt($validated['broker_password']),
            'platform' => 'mt5'
        ]);

        session(['active_account_id' => $account->id]);

        return redirect()->route('dashboard')->with('success', 'Compte Exness/MT5 associé avec succès.');
    }

    public function sync($id)
    {
        $account = Auth::user()->tradingAccounts()->findOrFail($id);

        if (!$account->broker_login || !$account->broker_password) {
            return back()->with('error', "Ce compte n'est pas lié à MT5.");
        }

        try {
            $password = decrypt($account->broker_password);
        } catch (\Exception $e) {
            return back()->with('error', "Erreur de déchiffrement du mot de passe.");
        }

        $result = $this->mt5->fetchTrades($account->broker_login, $password, $account->broker_server);

        if (!$result['success']) {
            return back()->with('error', "Erreur de synchronisation : " . $result['error']);
        }

        $count = 0;
        // Pour simplifier, on traite chaque deal comme un trade ou on les groupe par position_id
        // Ici on va faire simple : chaque deal 'OUT' représente la fermeture d'un trade
        foreach ($result['closed_deals'] as $deal) {
            if ($deal['entry'] == 1) { // DEAL_ENTRY_OUT
                \App\Models\Trade::updateOrCreate(
                    ['ticket' => $deal['ticket'], 'trading_account_id' => $account->id],
                    [
                        'user_id' => $account->user_id,
                        'symbol' => $deal['symbol'],
                        'type' => $deal['type'],
                        'volume' => $deal['volume'],
                        'open_price' => $deal['price'], // Price at exit (simplified)
                        'close_price' => $deal['price'],
                        'open_time' => \Carbon\Carbon::createFromTimestamp($deal['time']),
                        'close_time' => \Carbon\Carbon::createFromTimestamp($deal['time']),
                        'profit' => $deal['profit'],
                        'commission' => $deal['commission'],
                        'swap' => $deal['swap'],
                        'status' => 'closed',
                        'notes' => $deal['comment']
                    ]
                );
                $count++;
            }
        }

        return back()->with('success', "$count trades synchronisés.");
    }

}
