<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with KPIs, charts and activity.
     */
    public function index()
    {
        $today = now();
        $earned = fn () => Order::where('status', '!=', 'cancelled');

        $orderStats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $revenue = [
            'total' => (int) $earned()->sum('total'),
            'month' => (int) $earned()->whereMonth('created_at', $today->month)->whereYear('created_at', $today->year)->sum('total'),
            'today' => (int) $earned()->whereDate('created_at', $today->toDateString())->sum('total'),
        ];

        $productStats = [
            'total' => Product::count(),
            'categories' => Category::count(),
            'outOfStock' => Product::where('stock', 0)->count(),
            'lowStock' => Product::where('stock', '>', 0)->where('stock', '<', 10)->count(),
        ];

        // Revenue for each of the last 7 days (oldest first).
        $chart = collect(range(6, 0))->map(function (int $daysAgo) use ($today) {
            $date = $today->copy()->subDays($daysAgo);

            return [
                'label' => $date->format('D'),
                'date' => $date->format('d M'),
                'value' => (int) Order::where('status', '!=', 'cancelled')
                    ->whereDate('created_at', $date->toDateString())
                    ->sum('total'),
            ];
        })->values();

        $recentOrders = Order::latest()->take(6)->get();
        $lowStockProducts = Product::where('stock', '<', 10)->orderBy('stock')->take(5)->get();

        return view('admin.dashboard', compact(
            'orderStats',
            'revenue',
            'productStats',
            'chart',
            'recentOrders',
            'lowStockProducts',
        ));
    }
}
