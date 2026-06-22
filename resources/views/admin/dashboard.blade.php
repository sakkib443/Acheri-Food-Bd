@extends('admin.layouts.app', ['title' => __('Dashboard')])

@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? __('Good morning') : ($hour < 17 ? __('Good afternoon') : __('Good evening'));

    $statusMeta = [
        'pending'    => ['label' => __('Pending'),    'color' => '#f59e0b'],
        'processing' => ['label' => __('Processing'), 'color' => '#3b82f6'],
        'completed'  => ['label' => __('Completed'),  'color' => '#22c55e'],
        'cancelled'  => ['label' => __('Cancelled'),  'color' => '#ef4444'],
    ];

    $kpis = [
        [
            'label' => __('Total Revenue'), 'value' => '৳'.number_format($revenue['total']),
            'sub' => '৳'.number_format($revenue['month']).' '.__('this month'), 'color' => '#f47b20',
            'icon' => 'M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
        ],
        [
            'label' => __('Total Orders'), 'value' => $orderStats['total'],
            'sub' => $orderStats['pending'].' '.__('pending'), 'color' => '#0c3a2e',
            'icon' => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z',
        ],
        [
            'label' => __('Products'), 'value' => $productStats['total'],
            'sub' => $productStats['outOfStock'].' '.__('out of stock'), 'color' => '#7cb342',
            'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9',
        ],
        [
            'label' => __('Categories'), 'value' => $productStats['categories'],
            'sub' => __('All active'), 'color' => '#8b5cf6',
            'icon' => 'M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122',
        ],
    ];

    $chartMax = max($chart->max('value'), 1);
@endphp

@section('content')
    {{-- Greeting --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-[#0c3a2e]">{{ $greeting }}, {{ auth()->user()->name }} 👋</h2>
            <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p>
        </div>
        <a href="{{ url('/') }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 rounded-md border border-[#0c3a2e]/20 px-4 py-2 text-sm font-semibold text-[#0c3a2e] transition hover:bg-[#0c3a2e] hover:text-white">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            {{ __('View Store') }}
        </a>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($kpis as $kpi)
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500">{{ $kpi['label'] }}</p>
                        <p class="mt-2 text-2xl font-bold text-[#0c3a2e]">{{ $kpi['value'] }}</p>
                    </div>
                    <span class="flex h-11 w-11 items-center justify-center rounded-lg" style="background-color: {{ $kpi['color'] }}1a; color: {{ $kpi['color'] }};">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}" /></svg>
                    </span>
                </div>
                <p class="mt-3 text-xs font-medium text-gray-400">{{ $kpi['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        {{-- Left column --}}
        <div class="space-y-6 lg:col-span-2">
            {{-- Revenue chart --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Revenue — last 7 days') }}</h2>
                    <div class="flex gap-4 text-sm">
                        <span class="text-gray-500">{{ __('Today') }}: <span class="font-semibold text-[#f47b20]">৳{{ number_format($revenue['today']) }}</span></span>
                        <span class="text-gray-500">{{ __('Month') }}: <span class="font-semibold text-[#0c3a2e]">৳{{ number_format($revenue['month']) }}</span></span>
                    </div>
                </div>
                <div class="mt-6 flex h-44 items-end gap-2 sm:gap-4">
                    @foreach ($chart as $day)
                        <div class="group flex flex-1 flex-col items-center gap-2">
                            <div class="relative flex w-full flex-1 items-end">
                                <div class="w-full rounded-t bg-gradient-to-t from-[#f47b20] to-[#ffb066] transition-all duration-300 group-hover:from-[#dd6c14]"
                                     style="height: {{ $day['value'] > 0 ? max(4, round($day['value'] / $chartMax * 100)) : 2 }}%">
                                </div>
                                <span class="pointer-events-none absolute -top-6 left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-[#0c3a2e] px-1.5 py-0.5 text-[10px] font-medium text-white opacity-0 transition group-hover:opacity-100">৳{{ number_format($day['value']) }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Recent orders --}}
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                    <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Recent Orders') }}</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-[#f47b20] hover:text-[#dd6c14]">{{ __('View all') }} →</a>
                </div>
                @if ($recentOrders->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-5 py-3 font-medium">{{ __('Order') }}</th>
                                    <th class="px-5 py-3 font-medium">{{ __('Customer') }}</th>
                                    <th class="px-5 py-3 font-medium">{{ __('Total') }}</th>
                                    <th class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($recentOrders as $order)
                                    <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                                        <td class="px-5 py-3 font-medium text-[#0c3a2e]">{{ $order->order_number }}</td>
                                        <td class="px-5 py-3 text-gray-600">{{ $order->customer_name }}</td>
                                        <td class="px-5 py-3 font-semibold text-[#f47b20]">৳{{ number_format($order->total) }}</td>
                                        <td class="px-5 py-3">
                                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize text-white" style="background-color: {{ $statusMeta[$order->status]['color'] ?? '#6b7280' }}">{{ $order->status }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="px-5 py-10 text-center text-sm text-gray-500">{{ __('No orders yet.') }}</p>
                @endif
            </div>
        </div>

        {{-- Right column --}}
        <div class="space-y-6">
            {{-- Order status breakdown --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Order Status') }}</h2>
                <div class="mt-4 flex h-3 w-full overflow-hidden rounded-full bg-gray-100">
                    @foreach (['pending', 'processing', 'completed', 'cancelled'] as $s)
                        @if ($orderStats[$s] > 0)
                            <div title="{{ $statusMeta[$s]['label'] }}" style="width: {{ round($orderStats[$s] / max($orderStats['total'], 1) * 100) }}%; background-color: {{ $statusMeta[$s]['color'] }}"></div>
                        @endif
                    @endforeach
                </div>
                <ul class="mt-5 space-y-3">
                    @foreach (['pending', 'processing', 'completed', 'cancelled'] as $s)
                        <li class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-gray-600">
                                <span class="h-2.5 w-2.5 rounded-full" style="background-color: {{ $statusMeta[$s]['color'] }}"></span>
                                {{ $statusMeta[$s]['label'] }}
                            </span>
                            <span class="font-semibold text-[#0c3a2e]">{{ $orderStats[$s] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Low stock alert --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Low Stock Alert') }}</h2>
                    @if ($productStats['lowStock'] + $productStats['outOfStock'] > 0)
                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-600">{{ $productStats['lowStock'] + $productStats['outOfStock'] }}</span>
                    @endif
                </div>
                @if ($lowStockProducts->count())
                    <ul class="mt-4 space-y-3">
                        @foreach ($lowStockProducts as $product)
                            <li class="flex items-center gap-3">
                                <img src="{{ asset($product->image) }}" alt="" class="h-9 w-9 shrink-0 rounded-md border border-gray-100 object-contain">
                                <a href="{{ route('admin.products.edit', $product) }}" class="min-w-0 flex-1 truncate text-sm font-medium text-[#0c3a2e] hover:text-[#f47b20]">{{ $product->name }}</a>
                                <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-semibold {{ $product->stock == 0 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $product->stock == 0 ? __('Out') : $product->stock.' '.__('left') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 text-sm text-gray-500">{{ __('All products are well stocked.') }}</p>
                @endif
            </div>

            {{-- Quick actions --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Quick Actions') }}</h2>
                <div class="mt-4 grid grid-cols-1 gap-2.5">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        {{ __('Add Product') }}
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 rounded-md border border-gray-200 px-4 py-2.5 text-sm font-semibold text-[#0c3a2e] transition hover:bg-gray-50">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        {{ __('Add Category') }}
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 rounded-md border border-gray-200 px-4 py-2.5 text-sm font-semibold text-[#0c3a2e] transition hover:bg-gray-50">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" /></svg>
                        {{ __('Manage Orders') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
