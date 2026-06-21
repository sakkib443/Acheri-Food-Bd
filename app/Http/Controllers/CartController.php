<?php

namespace App\Http\Controllers;

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
        return view('cart.index', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
            'deliveryCharge' => (int) config('site.delivery_charge'),
        ]);
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
