<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function index()
    {
        if (Cart::isEmpty()) {
            return redirect()->route('products.index')->with('success', __('Your cart is empty.'));
        }

        $subtotal = Cart::subtotal();
        $coupon = Coupon::resolve(Cart::couponCode(), $subtotal);

        return view('checkout.index', [
            'items' => Cart::items(),
            'subtotal' => $subtotal,
            'coupon' => $coupon,
            'discount' => $coupon?->discountFor($subtotal) ?? 0,
            'deliveryCharge' => (int) config('site.delivery_charge'),
        ]);
    }

    /**
     * Place the order.
     */
    public function store(Request $request)
    {
        if (Cart::isEmpty()) {
            return redirect()->route('products.index')->with('success', __('Your cart is empty.'));
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:120'],
            'note' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod'],
        ]);

        $subtotal = Cart::subtotal();
        $delivery = (int) config('site.delivery_charge');
        $coupon = Coupon::resolve(Cart::couponCode(), $subtotal);
        $discount = $coupon?->discountFor($subtotal) ?? 0;

        $order = DB::transaction(function () use ($data, $subtotal, $delivery, $discount, $coupon) {
            $order = Order::create([
                ...$data,
                'order_number' => $this->generateOrderNumber(),
                'coupon_code' => $coupon?->code,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_charge' => $delivery,
                'total' => max(0, $subtotal - $discount) + $delivery,
                'status' => 'pending',
            ]);

            foreach (Cart::items() as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'line_total' => $item['price'] * $item['qty'],
                ]);
            }

            if ($coupon) {
                $coupon->increment('used_count');
            }

            return $order;
        });

        Cart::clear();

        return redirect()->route('order.success', $order);
    }

    /**
     * Order confirmation page.
     */
    public function success(Order $order)
    {
        $order->load('items');

        return view('checkout.success', compact('order'));
    }

    /**
     * Generate a unique human-friendly order number.
     */
    private function generateOrderNumber(): string
    {
        do {
            $number = 'ACH-'.now()->format('ymd').'-'.Str::upper(Str::random(4));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
