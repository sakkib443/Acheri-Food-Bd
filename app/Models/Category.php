<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'name_bn',
    'slug',
    'emoji',
    'image',
    'sort_order',
    'is_active',
])]
class Category extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Use the slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Localized display name — Bangla when the app is in Bengali (falls back to
     * the static translation or the English name when no Bangla name is set).
     */
    public function getDisplayNameAttribute(): string
    {
        if (app()->getLocale() === 'bn') {
            return $this->name_bn ?: __($this->name);
        }

        return $this->name;
    }

    /**
     * Products that belong to this category (matched by the category name string).
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category', 'name');
    }

    /**
     * Scope to active categories only.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by the display sort order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
