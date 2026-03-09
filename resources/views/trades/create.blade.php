@extends('layouts.app')

@section('title', 'Nouveau Trade')

@section('content')
    <!-- Messages flash -->
    @if(session('success'))
        <div style="max-width: 1100px; margin: 0 auto 20px auto;">
            <div style="background: rgba(0, 189, 157, 0.1); border: 1px solid var(--accent-emerald); color: var(--accent-emerald); padding: 12px 15px; border-radius: 4px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div style="max-width: 1100px; margin: 0 auto 20px auto;">
            <div style="background: rgba(242, 54, 69, 0.1); border: 1px solid var(--accent-crimson); color: var(--accent-crimson); padding: 12px 15px; border-radius: 4px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div style="max-width: 1100px; margin: 0 auto;">
        <div class="panel">
            <div class="panel-header" style="padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                <span>Enregistrer un nouveau trade manuel</span>
                <form action="{{ route('trades.import') }}" method="POST" enctype="multipart/form-data" style="display: inline;">
                    @csrf
                    <input type="file" name="excel_file" id="excel_file" accept=".csv,.xlsx,.xls" style="display: none;" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('excel_file').click()" 
                            style="background: var(--accent-emerald); color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-file-excel"></i>
                        Importer Excel
                    </button>
                </form>
            </div>
            <div class="panel-body" style="padding: 15px;">
                <form action="{{ url('/trades') }}" method="POST"
                    style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    @csrf
                
                    @php
                        $activeAccountId = session('active_account_id') ?? Auth::user()->tradingAccounts()->first()?->id;
                        $activeAccount = Auth::user()->tradingAccounts()->find($activeAccountId);
                    @endphp

                    <!-- Info Compte (Pleine largeur) -->
                    <!-- <div style="grid-column: span 3; background: rgba(0, 189, 157, 0.05); padding: 8px 12px; border-radius: 4px; border: 1px solid rgba(0, 189, 157, 0.2); margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-size: 11px; color: var(--text-secondary);">Enregistrement sur le compte : </span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--accent-emerald);">{{ $activeAccount->name }}</span>
                        </div>
                        <input type="hidden" name="trading_account_id" value="{{ $activeAccount->id }}">
                        <span style="font-size: 10px; color: var(--text-secondary); opacity: 0.7;">SESSION_ID: {{ session()->getId() }}</span>
                    </div> -->

                    <!-- LIGNE 1 : Symbole, Action, Timeframe -->
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Paire / Symbole</label>
                        <select name="pair_id" id="pair_select"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;"
                            onchange="document.getElementById('symbol_hidden').value = this.options[this.selectedIndex].text">
                            @foreach($pairs as $pair)
                                <option value="{{ $pair->id }}">{{ $pair->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="symbol" id="symbol_hidden" value="{{ $pairs->first()->name ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Action (BUY/SELL)</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="radio" name="type" value="BUY" id="buy" checked style="display: none;">
                            <label for="buy" onclick="updateType('BUY')" id="label-buy"
                                style="flex: 1; text-align: center; padding: 7px; background: rgba(0, 189, 157, 0.1); border: 1px solid var(--accent-emerald); border-radius: 4px; color: var(--accent-emerald); cursor: pointer; font-weight: 600; font-size: 12px;">ACHETER</label>

                            <input type="radio" name="type" value="SELL" id="sell" style="display: none;">
                            <label for="sell" onclick="updateType('SELL')" id="label-sell"
                                style="flex: 1; text-align: center; padding: 7px; background: #131722; border: 1px solid #2a2e39; border-radius: 4px; color: var(--text-secondary); cursor: pointer; font-weight: 600; font-size: 12px;">VENDRE</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Timeframe</label>
                        <select name="timeframe"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;">
                            <option value="M1">M1</option>
                            <option value="M5">M5</option>
                            <option value="M15">M15</option>
                            <option value="M30">M30</option>
                            <option value="H1" selected>H1</option>
                            <option value="H4">H4</option>
                            <option value="D1">D1</option>
                            <option value="W1">W1</option>
                        </select>
                    </div>

                    <!-- LIGNE 2 : Volume, Risque, Prix Entry -->
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Lots / Volume</label>
                        <input type="number" name="volume" step="0.01" value="0.10"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Risque (%)</label>
                        <input type="number" name="risk_percentage" step="0.1" value="1.0"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Prix d'entrée</label>
                        <input type="number" name="open_price" step="0.00001"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;"
                            placeholder="e.g. 1.08500">
                    </div>

                    <!-- LIGNE 3 : Profit, Pattern, Emotion -->
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Profit ($)</label>
                        <input type="number" name="profit" step="0.01"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;"
                            placeholder="e.g. 45.50">
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Pattern</label>
                        <select name="pattern_id"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;">
                            <option value="">Aucun</option>
                            @foreach($patterns as $pattern)
                                <option value="{{ $pattern->id }}">{{ $pattern->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Émotion</label>
                        <select name="emotion_id"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; font-size: 13px;">
                            <option value="">Neutre</option>
                            @foreach($emotions as $emotion)
                                <option value="{{ $emotion->id }}">{{ $emotion->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- LIGNE 4 : Notes -->
                    <div class="form-group" style="grid-column: span 3;">
                        <label style="display: block; margin-bottom: 5px; font-size: 12px; color: var(--text-secondary);">Notes</label>
                        <textarea name="notes" rows="2"
                            style="width: 100%; background: #131722; border: 1px solid #2a2e39; color: white; padding: 8px; border-radius: 4px; outline: none; resize: vertical; font-size: 13px;"></textarea>
                    </div>

                    <div style="grid-column: span 3; margin-top: 5px; display: flex; gap: 15px;">
                        <button type="submit"
                            style="flex: 3; background: var(--accent-blue); color: white; border: none; padding: 12px; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 14px; letter-spacing: 0.5px;">
                            ENREGISTRER LE TRADE
                        </button>
                        <a href="{{ route('journal') }}" style="flex: 1; text-align: center; padding: 12px; background: rgba(255,255,255,0.05); color: var(--text-secondary); border: 1px solid #2a2e39; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500;">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateType(type) {
            document.getElementById('buy').checked = (type === 'BUY');
            document.getElementById('sell').checked = (type === 'SELL');

            const labelBuy = document.getElementById('label-buy');
            const labelSell = document.getElementById('label-sell');

            if (type === 'BUY') {
                labelBuy.style.background = 'rgba(0, 189, 157, 0.1)';
                labelBuy.style.border = '1px solid var(--accent-emerald)';
                labelBuy.style.color = 'var(--accent-emerald)';

                labelSell.style.background = '#131722';
                labelSell.style.border = '1px solid #2a2e39';
                labelSell.style.color = 'var(--text-secondary)';
            } else {
                labelSell.style.background = 'rgba(242, 54, 69, 0.1)';
                labelSell.style.border = '1px solid var(--accent-crimson)';
                labelSell.style.color = 'var(--accent-crimson)';

                labelBuy.style.background = '#131722';
                labelBuy.style.border = '1px solid #2a2e39';
                labelBuy.style.color = 'var(--text-secondary)';
            }
        }
    </script>
@endsection