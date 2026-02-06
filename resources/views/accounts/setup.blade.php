@extends('layouts.app')

@section('title', 'Configuration Automatique')

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="panel" style="border: 1px solid var(--accent-emerald);">
            <div class="panel-header"
                style="background: rgba(16, 185, 129, 0.1); border-bottom: 1px solid var(--accent-emerald);">
                <span style="color: var(--accent-emerald);"><i class="fa-solid fa-circle-check"></i> Compte Associé avec
                    Succès !</span>
            </div>
            <div class="panel-body" style="padding: 30px; text-align: center;">
                <h2 style="margin-top: 0; color: white;">Votre Clé de Synchronisation</h2>
                <p style="color: var(--text-secondary); font-size: 14px; margin-bottom: 25px;">
                    Copiez cette clé dans les paramètres de votre EA (Expert Advisor) sur MetaTrader pour activer le suivi
                    en direct.
                </p>

                <div
                    style="background: #131722; border: 1px solid #2a2e39; padding: 20px; border-radius: 8px; display: inline-flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                    <code
                        style="font-size: 18px; color: var(--accent-emerald); font-family: 'Courier New', monospace; letter-spacing: 1px;">{{ $account->api_key }}</code>
                    <button onclick="navigator.clipboard.writeText('{{ $account->api_key }}')"
                        style="background: var(--accent-blue); border: none; color: white; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 12px;">
                        <i class="fa-solid fa-copy"></i> Copier
                    </button>
                </div>

                <hr style="border: 0; border-top: 1px solid #2a2e39; margin: 30px 0;">

                <div style="text-align: left;">
                    <h4 style="color: white; margin-bottom: 15px;">Prochaines étapes :</h4>
                    <ol style="color: var(--text-secondary); font-size: 13px; line-height: 1.8;">
                        <li>Téléchargez notre script <strong>TradingApp-Sync.ex4</strong> (ou .ex5).</li>
                        <li>Installez-le dans le dossier <code>MQL4/Experts</code> de votre MetaTrader.</li>
                        <li>Dans les paramètres de l'EA, collez votre <strong>Clé API</strong> ci-dessus.</li>
                        <li>Autorisez les requêtes Web (WebRequests) vers : <code>{{ url('/') }}</code></li>
                    </ol>
                </div>

                <div style="margin-top: 40px; display: flex; gap: 15px; justify-content: center;">
                    <button onclick="testSync()" id="test-btn" class="btn-primary"
                        style="background: var(--accent-emerald); border: none; padding: 12px 30px; cursor: pointer; font-weight: 600; border-radius: 4px;">
                        <i class="fa-solid fa-vial"></i> Tester la Synchro Maintenant
                    </button>
                    <a href="{{ route('dashboard') }}"
                        style="text-decoration: none; padding: 12px 30px; display: inline-block; color: var(--text-secondary); border: 1px solid #2a2e39; border-radius: 4px;">
                        Aller au Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testSync() {
            const btn = document.getElementById('test-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Simulation en cours...';
            btn.disabled = true;

            fetch('/api/trades/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-API-KEY': '{{ $account->api_key }}'
                },
                body: JSON.stringify({
                    ticket: 'TEST_' + Math.floor(Math.random() * 100000),
                    symbol: 'XAUUSD',
                    type: 'BUY',
                    volume: 0.1,
                    open_price: 2030.00,
                    profit: (Math.random() * 100).toFixed(2),
                    status: 'CLOSED'
                })
            })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));
                    if (response.ok && data.success) {
                        btn.style.background = '#10b981';
                        btn.innerHTML = '<i class="fa-solid fa-check"></i> Succès ! Trade synchronisé.';
                        setTimeout(() => {
                            alert('Félicitations ! Un trade de test a été envoyé. Vous le verrez sur votre Dashboard.');
                            window.location.href = "{{ route('dashboard') }}";
                        }, 1000);
                    } else {
                        throw new Error(data.error || 'Erreur ' + response.status);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur détectée : ' + error.message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        }
    </script>
    </div>
@endsection