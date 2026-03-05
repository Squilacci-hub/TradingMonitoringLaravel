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
                @forelse($trades as $trade)
                <tr>
                    <td class="font-mono" style="color: var(--text-secondary);">#{{ $trade->id }}</td>
                    <td class="font-mono">{{ $trade->open_time->format('Y-m-d H:i') }}</td>
                    <td class="font-mono">{{ $trade->close_time ? $trade->close_time->format('Y-m-d H:i') : '-' }}</td>
                    <td style="font-weight: 500;">{{ $trade->symbol }}</td>
                    <td class="{{ $trade->type === 'BUY' ? 'text-emerald' : 'text-crimson' }}" style="font-weight: 600;">{{ $trade->type }}</td>
                    <td><span style="font-size: 11px; background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 2px;">Standard</span></td>
                    <td class="font-mono">{{ number_format($trade->open_price, 5) }}</td>
                    <td class="font-mono">{{ $trade->close_price ? number_format($trade->close_price, 5) : '-' }}</td>
                    <td class="font-mono">{{ number_format($trade->volume, 2) }}</td>
                    <td class="font-mono {{ $trade->profit >= 0 ? 'text-emerald' : 'text-crimson' }}" style="text-align: right;">
                        {{ $trade->profit ? (($trade->profit >= 0 ? '+' : '') . '$' . number_format($trade->profit, 2)) : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="text-align: center; color: var(--text-secondary);">Aucun trade trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination Links -->
        <div style="margin-top: 20px;">
            {{ $trades->links() }}
        </div>
    </div>
@endsection
