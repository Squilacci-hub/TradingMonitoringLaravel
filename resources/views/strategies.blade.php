@extends('layouts.app')

@section('title', 'Strategy Performance')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
        
        <!-- Strategy 1 -->
        <div class="panel">
            <div class="panel-header" style="justify-content: flex-start; gap: 12px;">
                <div style="width: 8px; height: 8px; background: var(--accent-emerald); border-radius: 50%;"></div>
                <span>Trend Following H4</span>
            </div>
            <div class="panel-body">
                <div style="display: flex; gap: 32px; margin-bottom: 24px;">
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Win Rate</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--text-primary);">62%</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Profit Factor</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--accent-emerald);">2.10</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Trades</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--text-primary);">84</div>
                    </div>
                </div>
                <div class="chart-container" style="height: 200px;">
                    <canvas id="strat1Chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Strategy 2 -->
        <div class="panel">
            <div class="panel-header" style="justify-content: flex-start; gap: 12px;">
                 <div style="width: 8px; height: 8px; background: var(--accent-blue); border-radius: 50%;"></div>
                <span>London Session Breakout</span>
            </div>
            <div class="panel-body">
                 <div style="display: flex; gap: 32px; margin-bottom: 24px;">
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Win Rate</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--text-primary);">45%</div>
                    </div>
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Profit Factor</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--accent-emerald);">1.85</div>
                    </div>
                     <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Trades</div>
                        <div class="font-mono" style="font-size: 24px; color: var(--text-primary);">120</div>
                    </div>
                </div>
                <div class="chart-container" style="height: 200px;">
                    <canvas id="strat2Chart"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
    // Mock Chart for Strategy 1
    const ctx1 = document.getElementById('strat1Chart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['M1', 'M2', 'M3', 'M4', 'M5', 'M6'],
            datasets: [{
                label: 'PnL',
                data: [1200, 1500, -400, 2100, 800, 1900],
                backgroundColor: '#00bd9d',
                borderRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#2a2e39' } }
            }
        }
    });

    // Mock Chart for Strategy 2
    const ctx2 = document.getElementById('strat2Chart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['M1', 'M2', 'M3', 'M4', 'M5', 'M6'],
            datasets: [{
                label: 'PnL',
                data: [500, 300, 900, -200, 100, 450],
                backgroundColor: '#2962ff',
                borderRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { grid: { color: '#2a2e39' } }
            }
        }
    });
</script>
@endsection
