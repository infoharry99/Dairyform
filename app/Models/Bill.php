<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'dairy_id',
        'customer_id',
        'bill_number',
        'month_year',
        'total_litres',
        'milk_rate',
        'subtotal',
        'additional_products_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'pending_amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'total_litres' => 'decimal:2',
        'milk_rate' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'additional_products_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'pending_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function dairy(): BelongsTo
    {
        return $this->belongsTo(Dairy::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
