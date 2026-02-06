<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradingAccount;
use App\Models\Trade;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    /**
     * Reçoit les données de trade de l'Expert Advisor.
     */
    public function sync(Request $request)
    {
        try {
            Log::info('Sync API Hit', $request->all());

            $apiKey = $request->header('X-API-KEY') ?? $request->api_key;

            if (!$apiKey) {
                return response()->json(['error' => 'No API Key provided'], 401);
            }

            $account = TradingAccount::where('api_key', $apiKey)->first();

            if (!$account) {
                return response()->json(['error' => 'Invalid API Key: ' . $apiKey], 401);
            }

            $validated = $request->validate([
                'ticket' => 'required|string',
                'symbol' => 'required|string',
                'type' => 'required|in:BUY,SELL',
                'volume' => 'required|numeric',
                'open_price' => 'required|numeric',
                'profit' => 'nullable|numeric',
                'status' => 'required|in:OPEN,CLOSED',
            ]);

            $trade = Trade::where('trading_account_id', $account->id)
                ->where('ticket', $validated['ticket'])
                ->first();

            if (!$trade) {
                $trade = new Trade();
                $trade->user_id = $account->user_id;
                $trade->trading_account_id = $account->id;
                $trade->ticket = $validated['ticket'];
            }

            $trade->symbol = $validated['symbol'];
            $trade->type = $validated['type'];
            $trade->volume = $validated['volume'];
            $trade->open_price = $validated['open_price'];
            $trade->profit = $validated['profit'] ?? 0;
            $trade->status = $validated['status'];

            // Correction : Toujours s'assurer d'avoir un open_time (obligatoire en base)
            if (!$trade->open_time) {
                $trade->open_time = now();
            }

            if ($trade->status === 'CLOSED' && !$trade->close_time) {
                $trade->close_time = now();
            }

            $pair = Pair::where('name', $validated['symbol'])->first();
            if ($pair) {
                $trade->pair_id = $pair->id;
            }

            $trade->save();

            return response()->json([
                'success' => true,
                'trade_id' => $trade->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}