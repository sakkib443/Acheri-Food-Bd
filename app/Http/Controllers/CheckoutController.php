<?php

namespace App\Http\Controllers;

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

        return view('checkout.index', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
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

        $order = DB::transaction(function () use ($data, $subtotal, $delivery) {
            $order = Order::create([
                ...$data,
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $subtotal,
                'delivery_charge' => $delivery,
                'total' => $subtotal + $delivery,
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
