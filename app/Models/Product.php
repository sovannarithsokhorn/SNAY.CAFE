<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_km',
        'description_en',
        'description_km',
        'category_id',
        'price',
        'old_price',
        'stock',
        'image_url',
        'is_bestseller',
        'is_organic',
        'is_new',
    ];

    /**
     * Get the category that owns the Product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // You might also want to define other relationships here, e.g., for OrderItem
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }
}

