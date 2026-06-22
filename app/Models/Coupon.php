<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'code',
    'type',
    'value',
    'min_order_amount',
    'usage_limit',
    'used_count',
    'expires_at',
    'is_active',
])]
class Coupon extends Model
{
    protected function casts(): array
    {
        return [
            'value' => 'integer',
            'min_order_amount' => 'integer',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'is_active' => 'boolean',
            'expires_at' => 'date',
        ];
    }

    /**
     * Whether the coupon can be applied to the given subtotal right now.
     */
    public function isValidFor(int $subtotal): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->endOfDay()->isPast()) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return $subtotal >= $this->min_order_amount;
    }

    /**
     * Discount amount (in taka) for the given subtotal.
     */
    public function discountFor(int $subtotal): int
    {
        if (! $this->isValidFor($subtotal)) {
            return 0;
        }

        $discount = $this->type === 'percent'
            ? (int) round($subtotal * $this->value / 100)
            : $this->value;

        return min($discount, $subtotal);
    }

    /**
     * Resolve a usable coupon by code for the given subtotal, or null.
     */
    public static function resolve(?string $code, int $subtotal): ?self
    {
        if (! $code) {
            return null;
        }

        $coupon = static::whereRaw('UPPER(code) = ?', [strtoupper($code)])->first();

        return $coupon && $coupon->isValidFor($subtotal) ? $coupon : null;
    }
}
