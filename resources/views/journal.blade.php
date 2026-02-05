@extends('layouts.app')

@section('title', 'Trading Journal')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>Trade History Log</span>
            <div style="display: flex; gap: 8px;">
                 <input type="text" placeholder="Search symbol..." style="background: #131722; border: 1px solid #2a2e39; color: #d1d4dc; padding: 4px 8px; border-radius: 4px; outline: none; font-family: 'Inter'; font-size: 12px;">
                 <button class="badge" style="background: var(--accent-blue); color: white; border: none; cursor: pointer;">Export CSV</button>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date Open</th>
                    <th>Date Close</th>
                    <th>Pair</th>
                    <th>Dir</th>
                    <th>Type</th>
                    <th>Entry Price</th>
                    <th>Exit Price</th>
                    <th>Lots</th>
                    <th style="text-align: right;">Net PnL</th>
                </tr>
            </thead>
            <tbody>
                <!-- Row 1 -->
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">#1024</td>
                    <td class="font-mono">2023-10-24 14:30</td>
                    <td class="font-mono">2023-10-24 16:45</td>
                    <td style="font-weight: 500;">EUR/USD</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td><span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 2px;">Trend Following</span></td>
                    <td class="font-mono">1.05420</td>
                    <td class="font-mono">1.05850</td>
                    <td class="font-mono">1.00</td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$430.00</td>
                </tr>
                <!-- Row 2 -->
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">#1023</td>
                    <td class="font-mono">2023-10-23 09:15</td>
                    <td class="font-mono">2023-10-23 10:00</td>
                    <td style="font-weight: 500;">GBP/JPY</td>
                    <td class="text-crimson" style="font-weight: 600;">SHORT</td>
                    <td><span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 2px;">Breakout</span></td>
                    <td class="font-mono">182.500</td>
                    <td class="font-mono">182.800</td>
                    <td class="font-mono">0.50</td>
                    <td class="font-mono text-crimson" style="text-align: right;">-$150.00</td>
                </tr>
                <!-- Row 3 -->
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">#1022</td>
                    <td class="font-mono">2023-10-22 12:00</td>
                    <td class="font-mono">2023-10-22 18:30</td>
                    <td style="font-weight: 500;">BTC/USD</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td><span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 2px;">Swing</span></td>
                    <td class="font-mono">34,100</td>
                    <td class="font-mono">35,200</td>
                    <td class="font-mono">0.10</td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$110.00</td>
                </tr>
                 <!-- Row 4 -->
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">#1021</td>
                    <td class="font-mono">2023-10-21 08:20</td>
                    <td class="font-mono">2023-10-21 08:45</td>
                    <td style="font-weight: 500;">XAU/USD</td>
                    <td class="text-emerald" style="font-weight: 600;">LONG</td>
                    <td><span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 2px;">Scalp</span></td>
                    <td class="font-mono">1985.50</td>
                    <td class="font-mono">1988.00</td>
                    <td class="font-mono">2.00</td>
                    <td class="font-mono text-emerald" style="text-align: right;">+$500.00</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
