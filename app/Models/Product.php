<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'slug',
    'category',
    'description',
    'image',
    'price',
    'old_price',
    'stock',
    'is_best_selling',
    'is_top_selling',
    'sort_order',
])]
class Product extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'old_price' => 'integer',
            'stock' => 'integer',
            'is_best_selling' => 'boolean',
            'is_top_selling' => 'boolean',
        ];
    }

    /**
     * Amount saved versus the old price (0 when not discounted).
     */
    public function getSaveAmountAttribute(): int
    {
        return $this->old_price ? max(0, $this->old_price - $this->price) : 0;
    }

    /**
     * Whether the product is currently discounted.
     */
    public function getOnSaleAttribute(): bool
    {
        return $this->save_amount > 0;
    }

    /**
     * Discount percentage versus the old price (0 when not discounted).
     */
    public function getSavePercentAttribute(): int
    {
        return $this->old_price ? (int) round($this->save_amount / $this->old_price * 100) : 0;
    }

    /**
     * Scope to the products featured in the "Top Selling" home section.
     */
    public function scopeTopSelling(Builder $query): Builder
    {
        return $query->where('is_top_selling', true)->orderBy('sort_order');
    }
}
