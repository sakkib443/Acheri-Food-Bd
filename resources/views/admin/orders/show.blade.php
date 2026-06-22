@extends('admin.layouts.app', ['title' => __('Order').' '.$order->order_number])

@php
    $statuses = ['pending', 'processing', 'completed', 'cancelled'];
@endphp

@section('content')
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-[#0c3a2e]">
        &larr; {{ __('Back to orders') }}
    </a>

    <div class="mt-4 grid gap-6 lg:grid-cols-[1fr_340px]">
        {{-- Items --}}
        <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <h2 class="font-semibold text-[#0c3a2e]">{{ $order->order_number }}</h2>
                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 font-medium">{{ __('Product') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('Price') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('Qty') }}</th>
                        <th class="px-5 py-3 text-right font-medium">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-5 py-3 font-medium text-[#0c3a2e]">{{ $item->name }}</td>
                            <td class="px-5 py-3 text-gray-600">৳{{ number_format($item->price) }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-5 py-3 text-right font-semibold text-[#0c3a2e]">৳{{ number_format($item->line_total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="space-y-2 border-t border-gray-100 px-5 py-4 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">{{ __('Subtotal') }}</span><span class="text-[#0c3a2e]">৳{{ number_format($order->subtotal) }}</span></div>
                @if ($order->discount > 0)
                    <div class="flex justify-between"><span class="text-[#5a8a2c]">{{ __('Discount') }}{{ $order->coupon_code ? ' ('.$order->coupon_code.')' : '' }}</span><span class="text-[#5a8a2c]">−৳{{ number_format($order->discount) }}</span></div>
                @endif
                <div class="flex justify-between"><span class="text-gray-500">{{ __('Delivery Charge') }}</span><span class="text-[#0c3a2e]">৳{{ number_format($order->delivery_charge) }}</span></div>
                <div class="flex justify-between border-t border-gray-100 pt-2 text-base font-bold"><span class="text-[#0c3a2e]">{{ __('Total') }}</span><span class="text-[#f47b20]">৳{{ number_format($order->total) }}</span></div>
            </div>
        </div>

        {{-- Sidebar: customer + status --}}
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-[#0c3a2e]">{{ __('Customer') }}</h3>
                <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                <dl class="mt-4 space-y-2 text-sm">
                    <div><dt class="text-gray-500">{{ __('Name') }}</dt><dd class="font-medium text-[#0c3a2e]">{{ $order->customer_name }}</dd></div>
                    <div><dt class="text-gray-500">{{ __('Phone') }}</dt><dd class="font-medium text-[#0c3a2e]">{{ $order->phone }}</dd></div>
                    @if ($order->email)
                        <div><dt class="text-gray-500">{{ __('Email') }}</dt><dd class="font-medium text-[#0c3a2e]">{{ $order->email }}</dd></div>
                    @endif
                    <div><dt class="text-gray-500">{{ __('Address') }}</dt><dd class="font-medium text-[#0c3a2e]">{{ $order->address }}{{ $order->city ? ', '.$order->city : '' }}</dd></div>
                    @if ($order->note)
                        <div><dt class="text-gray-500">{{ __('Note') }}</dt><dd class="text-gray-700">{{ $order->note }}</dd></div>
                    @endif
                    <div><dt class="text-gray-500">{{ __('Payment') }}</dt><dd class="font-medium text-[#0c3a2e]">{{ __('Cash on Delivery') }}</dd></div>
                </dl>
            </div>

            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-semibold uppercase tracking-wide text-[#0c3a2e]">{{ __('Update Status') }}</h3>
                <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4 space-y-3">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm capitalize focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
