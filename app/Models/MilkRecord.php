<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilkRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'dairy_id',
        'customer_id',
        'date',
        'shift',
        'quantity',
        'milk_type',
        'rate',
        'amount',
        'status',
        'recorded_by',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function dairy(): BelongsTo
    {
        return $this->belongsTo(Dairy::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
