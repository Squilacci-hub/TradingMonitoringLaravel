<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer tous les trades paginés (20 par page)
        // Triés par date d'ouverture déscendante
        $trades = $user->trades()->orderBy('open_time', 'desc')->paginate(20);

        return view('journal', [
            'trades' => $trades
        ]);
    }
}
