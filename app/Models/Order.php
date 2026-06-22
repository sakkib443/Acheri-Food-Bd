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

    /**
     * Build a WhatsApp-ready order summary (with full product details) for the shop owner.
     */
    public function whatsappMessage(): string
    {
        $lines = [];
        $lines[] = '🛒 *New Order — Acheri Food Bd*';
        $lines[] = 'Order No: '.$this->order_number;
        $lines[] = '';
        $lines[] = '*Products:*';

        foreach ($this->items as $item) {
            $lines[] = '• '.$item->name.' × '.$item->quantity.' = ৳'.number_format($item->line_total);
        }

        $lines[] = '';
        $lines[] = 'Subtotal: ৳'.number_format($this->subtotal);

        if ($this->discount > 0) {
            $lines[] = 'Discount'.($this->coupon_code ? ' ('.$this->coupon_code.')' : '').': -৳'.number_format($this->discount);
        }

        $lines[] = 'Delivery: ৳'.number_format($this->delivery_charge);
        $lines[] = '*Total: ৳'.number_format($this->total).'*';
        $lines[] = '';
        $lines[] = '*Customer:*';
        $lines[] = 'Name: '.$this->customer_name;
        $lines[] = 'Phone: '.$this->phone;
        $lines[] = 'Address: '.$this->address.($this->city ? ', '.$this->city : '');

        if ($this->note) {
            $lines[] = 'Note: '.$this->note;
        }

        $lines[] = 'Payment: Cash on Delivery';

        return implode("\n", $lines);
    }

    /**
     * wa.me link that opens WhatsApp with the order summary pre-filled.
     */
    public function whatsappUrl(): string
    {
        return 'https://wa.me/'.config('site.whatsapp').'?text='.rawurlencode($this->whatsappMessage());
    }
}
