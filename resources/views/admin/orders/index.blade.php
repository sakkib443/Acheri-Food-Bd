@extends('admin.layouts.app', ['title' => __('Orders')])

@php
    $statusClasses = [
        'pending'    => 'bg-amber-100 text-amber-700',
        'processing' => 'bg-blue-100 text-blue-700',
        'completed'  => 'bg-green-100 text-green-700',
        'cancelled'  => 'bg-red-100 text-red-600',
    ];
@endphp

@section('content')
    <div class="mb-5">
        <p class="text-sm text-gray-500">{{ $orders->total() }} {{ __('orders') }}</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        @if ($orders->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('Order') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Customer') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Items') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Total') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Date') }}</th>
                            <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-medium text-[#0c3a2e]">{{ $order->order_number }}</td>
                                <td class="px-5 py-3">
                                    <span class="block text-[#0c3a2e]">{{ $order->customer_name }}</span>
                                    <span class="block text-xs text-gray-500">{{ $order->phone }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $order->items_count }}</td>
                                <td class="px-5 py-3 font-semibold text-[#f47b20]">৳{{ number_format($order->total) }}</td>
                                <td class="px-5 py-3">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">{{ $order->status }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">{{ $orders->onEachSide(1)->links() }}</div>
            @endif
        @else
            <p class="px-5 py-16 text-center text-sm text-gray-500">{{ __('No orders yet.') }}</p>
        @endif
    </div>
@endsection
