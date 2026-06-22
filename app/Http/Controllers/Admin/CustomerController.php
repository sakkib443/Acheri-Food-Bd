<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class CustomerController extends Controller
{
    /**
     * List customers derived from placed orders (grouped by phone).
     */
    public function index()
    {
        $customers = Order::query()
            ->selectRaw('phone,
                MAX(customer_name) as customer_name,
                MAX(email) as email,
                COUNT(*) as orders_count,
                SUM(total) as total_spent,
                MAX(created_at) as last_order')
            ->groupBy('phone')
            ->orderByDesc('last_order')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show a single customer's order history.
     */
    public function show(string $phone)
    {
        $orders = Order::where('phone', $phone)->latest()->get();

        abort_if($orders->isEmpty(), 404);

        $customer = $orders->first();
        $totalSpent = $orders->sum('total');

        return view('admin.customers.show', compact('orders', 'customer', 'phone', 'totalSpent'));
    }
}
