@extends('admin.layouts.app', ['title' => $customer->customer_name])

@php
    $statusColors = [
        'pending' => '#f59e0b', 'processing' => '#3b82f6', 'completed' => '#22c55e', 'cancelled' => '#ef4444',
    ];
@endphp

@section('content')
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-[#0c3a2e]">
        &larr; {{ __('Back to customers') }}
    </a>

    {{-- Customer summary --}}
    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm sm:col-span-1">
            <div class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[#0c3a2e]/10 text-lg font-semibold text-[#0c3a2e]">{{ \Illuminate\Support\Str::of($customer->customer_name)->substr(0, 1)->upper() }}</span>
                <div>
                    <p class="font-semibold text-[#0c3a2e]">{{ $customer->customer_name }}</p>
                    <p class="text-sm text-gray-500">{{ $phone }}</p>
                </div>
            </div>
            @if ($customer->email)<p class="mt-3 text-sm text-gray-500">{{ $customer->email }}</p>@endif
            <p class="mt-1 text-sm text-gray-500">{{ $customer->address }}{{ $customer->city ? ', '.$customer->city : '' }}</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">{{ __('Total Orders') }}</p>
            <p class="mt-2 text-3xl font-bold text-[#0c3a2e]">{{ $orders->count() }}</p>
        </div>
        <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">{{ __('Total Spent') }}</p>
            <p class="mt-2 text-3xl font-bold text-[#f47b20]">৳{{ number_format($totalSpent) }}</p>
        </div>
    </div>

    {{-- Order history --}}
    <div class="mt-6 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-4">
            <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Order History') }}</h2>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-5 py-3 font-medium">{{ __('Order') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('Date') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('Total') }}</th>
                    <th class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                    <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-medium text-[#0c3a2e]">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 font-semibold text-[#f47b20]">৳{{ number_format($order->total) }}</td>
                        <td class="px-5 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize text-white" style="background-color: {{ $statusColors[$order->status] ?? '#6b7280' }}">{{ $order->status }}</span></td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-semibold text-[#f47b20] hover:text-[#dd6c14]">{{ __('View') }} →</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
