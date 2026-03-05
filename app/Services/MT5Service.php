<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class MT5Service
{
    /**
     * Exécute le script Python bridge pour interagir avec MetaTrader 5.
     *
     * @param string $mode 'verify' ou 'fetch'
     * @param string $login
     * @param string $password
     * @param string $server
     * @return array
     */
    public function runBridge(string $mode, string $login, string $password, string $server): array
    {
        $scriptPath = base_path('mt5_bridge.py');

        // Sur Windows, 'python' ou 'py' est utilisé. L'utilisateur utilise 'py'.
        $pythonPath = 'py';

        $process = new Process([$pythonPath, $scriptPath, $mode, $login, $password, $server]);
        $process->setTimeout(60); // Connexion MT5 peut prendre du temps

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("MT5 Bridge Error: " . $process->getErrorOutput());
                return [
                    'success' => false,
                    'error' => "Erreur lors de l'exécution du bridge: " . $process->getErrorOutput()
                ];
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE || !isset($result['success'])) {
                Log::error("MT5 Bridge Result Error: " . $output);
                return [
                    'success' => false,
                    'error' => "Réponse invalide du bridge Python ou succès non spécifié. Sortie: " . substr($output, 0, 100)
                ];
            }

            return $result;
        } catch (\Exception $e) {
            Log::error("MT5 Service Exception: " . $e->getMessage());
            return [
                'success' => false,
                'error' => "Exception: " . $e->getMessage()
            ];
        }
    }

    public function verifyAccount($login, $password, $server)
    {
        return $this->runBridge('verify', $login, $password, $server);
    }

    public function fetchTrades($login, $password, $server)
    {
        return $this->runBridge('fetch', $login, $password, $server);
    }
}
