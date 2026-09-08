<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'dairy_id',
        'plan_id',
        'billing_cycle',
        'amount',
        'starts_at',
        'expires_at',
        'status',
        'auto_renew',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'expires_at' => 'date',
        'auto_renew' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function dairy(): BelongsTo
    {
        return $this->belongsTo(Dairy::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id');
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' || ($this->expires_at && $this->expires_at->isPast());
    }

    public function daysRemaining(): int
    {
        return $this->expires_at ? max(0, (int) now()->diffInDays($this->expires_at, false)) : 0;
    }
}
