<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Show the storefront home page.
     */
    public function index()
    {
        $topProducts = Product::topSelling()->take(4)->get();
        $products = Product::orderBy('sort_order')->take(8)->get();

        return view('home', compact('topProducts', 'products'));
    }
}
