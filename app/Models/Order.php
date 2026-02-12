<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'phone',
        'address',
        'city',
        'quantity',
        'status',
        'color',
        'size',
    ];

    const STATUS_PENDING = 'قيد المعالجة';
    const STATUS_CONFIRMED = 'تم التأكيد';
    const STATUS_DELIVERED = 'تم التوصيل';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_CONFIRMED,
            self::STATUS_DELIVERED,
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_CONFIRMED => 'blue',
            self::STATUS_DELIVERED => 'green',
            default => 'gray',
        };
    }
}
