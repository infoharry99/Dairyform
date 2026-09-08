<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dairy_id',
        'user_id',
        'customer_code',
        'name',
        'phone',
        'email',
        'address',
        'area',
        'daily_quantity',
        'milk_type',
        'delivery_time',
        'rate_per_litre',
        'status',
        'start_date',
        'notes',
    ];

    protected $casts = [
        'daily_quantity' => 'decimal:2',
        'rate_per_litre' => 'decimal:2',
        'start_date' => 'date',
    ];

    public function dairy(): BelongsTo
    {
        return $this->belongsTo(Dairy::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function milkRecords(): HasMany
    {
        return $this->hasMany(MilkRecord::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function totalPendingDues(): float
    {
        return (float) $this->bills()->where('status', '!=', 'paid')->sum('pending_amount');
    }
}
