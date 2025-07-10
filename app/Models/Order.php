<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import for type hinting
use Illuminate\Database\Eloquent\Relations\HasMany;   // Import for type hinting

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_address', // Added 'shipping_address' as it's used in your modal
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'float', // This line is crucial for numeric casting
    ];

    /**
     * Get the user that owns the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo // Added return type hint
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany // Added return type hint
    {
        return $this->hasMany(OrderItem::class);
    }
}
