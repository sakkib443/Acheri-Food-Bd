<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the shop / product listing page with search, category and sort filters.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        // Accept category as a single value (header links) or an array (sidebar checkboxes).
        $activeCategories = array_values(array_filter((array) $request->query('category', [])));
        $sort = $request->query('sort', 'default');

        $products = Product::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($activeCategories, fn ($query) => $query->whereIn('category', $activeCategories))
            ->when(true, function ($query) use ($sort) {
                match ($sort) {
                    'price_low' => $query->orderBy('price'),
                    'price_high' => $query->orderByDesc('price'),
                    'newest' => $query->orderByDesc('created_at'),
                    'name' => $query->orderBy('name'),
                    default => $query->orderBy('sort_order'),
                };
            })
            ->paginate(12)
            ->withQueryString();

        // Single value kept for the breadcrumb / page title.
        $activeCategory = count($activeCategories) === 1 ? $activeCategories[0] : null;

        return view('products.index', compact('products', 'activeCategory', 'activeCategories', 'search', 'sort'));
    }

    /**
     * Show a single product detail page with related products.
     */
    public function show(Product $product)
    {
        $related = Product::query()
            ->where('category', $product->category)
            ->whereKeyNot($product->getKey())
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
