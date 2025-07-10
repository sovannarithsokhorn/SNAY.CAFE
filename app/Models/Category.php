<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_en',
        'name_km', // Keep this if you might re-introduce Khmer later or for data consistency
        'image_url', // Added image_url to fillable
    ];

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

