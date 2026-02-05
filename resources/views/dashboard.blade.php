@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- KPI Row -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <span class="kpi-label">Net P&L</span>
            <span class="kpi-value text-emerald">+$12,450.00</span>
        </div>
        <div class="kpi-card">
            <span class="kpi-label">Win Rate</span>
            <span class="kpi-value">68.5%</span>
        </div>
        <div class="kpi-card">
            <span class="kpi-label">Profit Factor</span>
            <span class="kpi-value">2.45</span>
        </div>
        <div class="kpi-card">
            <span class="kpi-label">Account Balance</span>
            <span class="kpi-value">$112,450.00</span>
        </div>
    </div>

    <!-- Charts Section (Dense Grid) -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
        
        <!-- Main: Equity Curve -->
        <div class="panel">
            <div class="panel-header">
                <span>Equity Curve</span>
                <div style="display: flex; gap: 8px;">
                    <button class="badge" style="background: var(--bg-app); color: var(--text-secondary); border: none;">1M</button>
                    <button class="badge" style="background: var(--accent-blue); color: white; border: none;">YTD</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="chart-container" style="height: 320px;">
                    <canvas id="equityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Sidebar Charts Column -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            
            <!-- Win/Loss Ratio -->
            <div class="panel" style="flex: 1;">
                <div class="panel-header">
                    <span>Win / Loss Ratio</span>
                </div>
                <div class="panel-body" style="display: flex; align-items: center; justify-content: center; position: relative;">
                    <div class="chart-container" style="height: 140px; width: 140px;">
                        <canvas id="winLossChart"></canvas>
                    </div>
                    <!-- Center stats overlay -->
                    <div style="position: absolute; text-align: center;">
                        <span style="font-size: 10px; color: var(--text-secondary); display: block;">High</span>
                        <span class="font-mono" style="font-weight: 700; color: var(--text-primary);">68%</span>
                    </div>
                </div>
            </div>

            <!-- Asset Allocation -->
            <div class="panel" style="flex: 1;">
                <div class="panel-header">
                    <span>Volume Distribution</span>
                </div>
                <div class="panel-body">
                    <div class="chart-container" style="height: 140px;">
                        <canvas id="volumeChart"></canvas>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Recent Trades -->
    <div class="panel">
        <div class="panel-header">
            <span>Recent Activity</span>
            <span style="font-size: 11px; color: var(--text-secondary); cursor: pointer;">VIEW ALL</span>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Symbol</th>
                    <th>Side</th>
                    <th>Entry</th>
                    <th>Exit</th>
                    <th>Result</th>
                    <th style="text-align: right;">PnL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">Oct 24 14:30</td>
                    <td style="font-weight: 500;">EUR/USD</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td class="font-mono">1.05420</td>
                    <td class="font-mono">1.05850</td>
                    <td><span class="badge badge-win">WIN</span></td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$430.00</td>
                </tr>
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">Oct 23 09:15</td>
                    <td style="font-weight: 500;">GBP/JPY</td>
                    <td class="text-crimson" style="font-weight: 600;">SHORT</td>
                    <td class="font-mono">182.500</td>
                    <td class="font-mono">182.800</td>
                    <td><span class="badge badge-loss">LOSS</span></td>
                    <td class="font-mono text-crimson" style="text-align: right;">-$150.00</td>
                </tr>
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">Oct 22 16:45</td>
                    <td style="font-weight: 500;">XAU/USD</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td class="font-mono">1980.50</td>
                    <td class="font-mono">1995.00</td>
                    <td><span class="badge badge-win">WIN</span></td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$1,450.00</td>
                </tr>
                 <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">Oct 21 10:20</td>
                    <td style="font-weight: 500;">NAS100</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td class="font-mono">14250.0</td>
                    <td class="font-mono">14350.0</td>
                    <td><span class="badge badge-win">WIN</span></td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$2,100.00</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    // Common Config
    Chart.defaults.font.family = 'Inter';
    Chart.defaults.color = '#787b86';
    Chart.defaults.borderColor = '#2a2e39';

    // 1. Equity Chart
    const ctxEquity = document.getElementById('equityChart').getContext('2d');
    const gradient = ctxEquity.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 189, 157, 0.2)');
    gradient.addColorStop(1, 'rgba(0, 189, 157, 0)');

    new Chart(ctxEquity, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            datasets: [{
                label: 'Equity',
                data: [10000, 10800, 10500, 11200, 11900, 12500, 12300, 13100, 13800, 14250],
                borderColor: '#00bd9d',
                backgroundColor: gradient,
                borderWidth: 2,
                pointRadius: 0,
                pointHoverRadius: 4,
                fill: true,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { maxTicksLimit: 6 } },
                y: { grid: { color: '#2a2e39' } }
            }
        }
    });

    // 2. Win/Loss Doughnut
    const ctxWinLoss = document.getElementById('winLossChart').getContext('2d');
    new Chart(ctxWinLoss, {
        type: 'doughnut',
        data: {
            labels: ['Wins', 'Losses'],
            datasets: [{
                data: [68, 32],
                backgroundColor: ['#00bd9d', '#f23645'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });

    // 3. Volume Distribution (Bar)
    const ctxVolume = document.getElementById('volumeChart').getContext('2d');
    new Chart(ctxVolume, {
        type: 'bar',
        data: {
            labels: ['EUR', 'GBP', 'XAU', 'NAS', 'BTC'],
            datasets: [{
                label: 'Volume',
                data: [45, 30, 60, 25, 15],
                backgroundColor: '#2962ff',
                borderRadius: 2,
                barThickness: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { display: false }
            }
        }
    });
</script>
@endsection
