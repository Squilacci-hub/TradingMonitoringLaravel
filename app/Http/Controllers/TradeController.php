<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\TradingAccount;
use App\Models\Pattern;
use App\Models\Emotion;
use App\Models\Pair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        $user = Auth::user();
        $activeAccountId = session('active_account_id') ?? $user->tradingAccounts()->first()?->id;

        if (!$activeAccountId) {
            return redirect()->route('trades.create')->with('error', 'Aucun compte de trading actif trouvé.');
        }

        try {
            $file = $request->file('excel_file');
            $filePath = $file->getRealPath();
            $extension = $file->getClientOriginalExtension();

            if ($extension === 'csv') {
                // Traitement CSV optimisé avec INSERT IGNORE
                $result = $this->importCsvOptimized($filePath, $user->id, $activeAccountId);
                
                $message = "Importation terminée : {$result['imported']} trades importés avec succès";
                if ($result['skipped'] > 0) {
                    $message .= ", {$result['skipped']} doublons ignorés";
                }
                
                return redirect()->route('trades.create')->with('success', $message);
            } else {
                return redirect()->route('trades.create')->with('error', 'Format Excel non supporté. Utilisez un fichier CSV.');
            }

        } catch (\Exception $e) {
            return redirect()->route('trades.create')->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    private function importCsvOptimized($filePath, $userId, $accountId)
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception('Impossible de lire le fichier CSV');
        }

        // Sauter l'en-tête
        $header = fgetcsv($handle);
        
        $tradesData = [];
        $now = now();
        
        // Préparer toutes les données
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 16) continue; // Skip lignes invalides
            
            $ticket = $row[0] ?? null;
            $openTime = $row[1] ?? null;
            $closeTime = $row[2] ?? null;
            $type = strtoupper($row[3] ?? '');
            $volume = floatval($row[4] ?? 0);
            $symbol = $row[6] ?? '';
            $openPrice = floatval($row[7] ?? 0);
            $closePrice = floatval($row[8] ?? 0);
            $commission = floatval($row[11] ?? 0);
            $swap = floatval($row[12] ?? 0);
            $profit = floatval($row[13] ?? 0);
            $closeReason = $row[15] ?? '';

            // Validation de base
            if (!$ticket || !$symbol || !$type || !in_array($type, ['BUY', 'SELL'])) {
                continue;
            }

            // Trouver ou créer la paire
            $pair = Pair::firstOrCreate(['name' => $symbol]);
            
            $tradesData[] = [
                'user_id' => $userId,
                'trading_account_id' => $accountId,
                'ticket' => $ticket,
                'pair_id' => $pair->id,
                'symbol' => $symbol,
                'type' => $type,
                'volume' => $volume,
                'open_price' => $openPrice,
                'close_price' => $closePrice,
                'open_time' => $openTime ? date('Y-m-d H:i:s', strtotime($openTime)) : $now,
                'close_time' => $closeTime ? date('Y-m-d H:i:s', strtotime($closeTime)) : null,
                'profit' => $profit,
                'commission' => $commission,
                'swap' => $swap,
                'status' => 'CLOSED',
                'timeframe' => 'H1',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        fclose($handle);

        if (empty($tradesData)) {
            return ['imported' => 0, 'skipped' => 0];
        }

        // Insertion optimisée avec INSERT IGNORE
        $insertedCount = $this->insertTradesWithIgnore($tradesData);
        $totalCount = count($tradesData);
        $skippedCount = $totalCount - $insertedCount;

        return [
            'imported' => $insertedCount,
            'skipped' => $skippedCount
        ];
    }

    private function insertTradesWithIgnore($tradesData)
    {
        $insertedCount = 0;
        $now = now();
        
        foreach ($tradesData as $trade) {
            try {
                // Insertion individuelle avec gestion des doublons
                DB::table('trades')->insert($trade);
                $insertedCount++;
            } catch (\Illuminate\Database\QueryException $e) {
                // Vérifier si c'est une erreur de doublon PostgreSQL
                $errorMessage = strtolower($e->getMessage());
                if (str_contains($errorMessage, 'duplicate key') || 
                    str_contains($errorMessage, 'unique constraint') ||
                    str_contains($errorMessage, 'unique violation')) {
                    // Doublon détecté, on ignore silencieusement
                    continue;
                }
                // Autre erreur, on propage pour debugging
                throw $e;
            }
        }
        
        return $insertedCount;
    }
}
