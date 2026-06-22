<?php

namespace App\Support;

use App\Models\Product;

/**
 * Simple session-backed shopping cart.
 */
class Cart
{
    protected const KEY = 'cart';

    /**
     * @return array<int, array{id:int,name:string,slug:string,price:int,image:?string,qty:int}>
     */
    public static function items(): array
    {
        return session(self::KEY, []);
    }

    public static function add(Product $product, int $qty = 1): void
    {
        $qty = max(1, $qty);
        $items = self::items();
        $id = $product->id;

        if (isset($items[$id])) {
            $items[$id]['qty'] += $qty;
        } else {
            $items[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (int) $product->price,
                'image' => $product->image,
                'qty' => $qty,
            ];
        }

        session([self::KEY => $items]);
    }

    public static function update(int $id, int $qty): void
    {
        $items = self::items();

        if (! isset($items[$id])) {
            return;
        }

        if ($qty <= 0) {
            unset($items[$id]);
        } else {
            $items[$id]['qty'] = $qty;
        }

        session([self::KEY => $items]);
    }

    public static function remove(int $id): void
    {
        $items = self::items();
        unset($items[$id]);
        session([self::KEY => $items]);
    }

    public static function clear(): void
    {
        session()->forget([self::KEY, 'coupon_code']);
    }

    public static function couponCode(): ?string
    {
        return session('coupon_code');
    }

    public static function setCoupon(string $code): void
    {
        session(['coupon_code' => $code]);
    }

    public static function forgetCoupon(): void
    {
        session()->forget('coupon_code');
    }

    public static function count(): int
    {
        return array_sum(array_map(fn ($i) => $i['qty'], self::items()));
    }

    public static function subtotal(): int
    {
        return array_sum(array_map(fn ($i) => $i['price'] * $i['qty'], self::items()));
    }

    public static function isEmpty(): bool
    {
        return self::count() === 0;
    }
}
