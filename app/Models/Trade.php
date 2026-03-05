<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trading_account_id',
        'ticket',
        'emotion_id',
        'pattern_id',
        'pair_id',
        'symbol',
        'type',
        'volume',
        'open_price',
        'close_price',
        'open_time',
        'close_time',
        'profit',
        'commission',
        'swap',
        'status',
        'timeframe',
        'risk_percentage',
        'notes',
        'screenshot'
    ];

    /**
     * Les attributs qui doivent être convertis.
     */
    protected $casts = [
        'open_time' => 'datetime',
        'close_time' => 'datetime',
        'volume' => 'decimal:2',
        'profit' => 'decimal:2',
        'risk_percentage' => 'decimal:2',
    ];

    /**
     * Relation : Un trade appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tradingAccount()
    {
        return $this->belongsTo(TradingAccount::class);
    }

    public function emotion()
    {
        return $this->belongsTo(Emotion::class);
    }

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    public function pair()
    {
        return $this->belongsTo(Pair::class);
    }
}
