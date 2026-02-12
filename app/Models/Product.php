<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
        'colors',
        'sizes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'colors' => 'array',
        'sizes' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return 'https://placehold.co/600x800/d4a574/ffffff?text=' . urlencode($this->name);
    }

    public function inStock(): bool
    {
        return $this->stock > 0;
    }
}
