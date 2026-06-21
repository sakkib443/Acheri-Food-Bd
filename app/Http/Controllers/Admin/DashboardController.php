<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with summary stats.
     */
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'bestSelling' => Product::where('is_best_selling', true)->count(),
            'outOfStock' => Product::where('stock', 0)->count(),
        ];

        $recentProducts = Product::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts'));
    }
}
