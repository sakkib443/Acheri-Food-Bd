<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show the cart page.
     */
    public function index()
    {
        $subtotal = Cart::subtotal();
        $coupon = Coupon::resolve(Cart::couponCode(), $subtotal);

        return view('cart.index', [
            'items' => Cart::items(),
            'subtotal' => $subtotal,
            'coupon' => $coupon,
            'discount' => $coupon?->discountFor($subtotal) ?? 0,
            'deliveryCharge' => (int) config('site.delivery_charge'),
        ]);
    }

    /**
     * Apply a coupon code to the cart.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => ['required', 'string', 'max:50']]);

        $coupon = Coupon::resolve($request->input('code'), Cart::subtotal());

        if (! $coupon) {
            return back()->withErrors(['code' => __('Invalid, expired, or inapplicable coupon.')]);
        }

        Cart::setCoupon($coupon->code);

        return back()->with('success', __('Coupon ":code" applied.', ['code' => $coupon->code]));
    }

    /**
     * Remove the applied coupon.
     */
    public function removeCoupon()
    {
        Cart::forgetCoupon();

        return back()->with('success', __('Coupon removed.'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $qty = max(1, (int) $request->input('quantity', 1));
        Cart::add($product, $qty);

        if ($request->boolean('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', __(':name added to your cart.', ['name' => $product->name]));
    }

    /**
     * Update the quantity of a cart line.
     */
    public function update(Request $request, Product $product)
    {
        Cart::update($product->id, (int) $request->input('quantity', 1));

        return back()->with('success', __('Cart updated.'));
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product)
    {
        Cart::remove($product->id);

        return back()->with('success', __('Item removed from cart.'));
    }

    /**
     * Empty the cart.
     */
    public function clear()
    {
        Cart::clear();

        return back()->with('success', __('Cart cleared.'));
    }
}
