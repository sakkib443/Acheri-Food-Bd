<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'order_number',
    'customer_name',
    'phone',
    'email',
    'address',
    'city',
    'note',
    'payment_method',
    'coupon_code',
    'subtotal',
    'discount',
    'delivery_charge',
    'total',
    'status',
])]
class Order extends Model
{
    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'discount' => 'integer',
            'delivery_charge' => 'integer',
            'total' => 'integer',
        ];
    }

    /**
     * Use the order number for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'order_number';
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
