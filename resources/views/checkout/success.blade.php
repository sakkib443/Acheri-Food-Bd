@extends('layouts.app')

@section('content')
    <section class="py-12 lg:py-16">
        <div class="mx-auto max-w-2xl px-4 lg:px-8">
            <div class="rounded-2xl border border-gray-100 bg-white p-8 text-center shadow-sm">
                <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[#7cb342]/15 text-[#5a8a2c]">
                    <svg class="h-9 w-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
                <h1 class="mt-5 font-display text-3xl font-bold tracking-wide text-[#0c3a2e]">{{ __('Thank you for your order!') }}</h1>
                <p class="mt-2 text-gray-600">{{ __('Your order has been placed successfully. We will contact you shortly to confirm.') }}</p>

                <div class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#FBF9F5] px-4 py-2 text-sm">
                    <span class="text-gray-500">{{ __('Order Number') }}:</span>
                    <span class="font-bold text-[#0c3a2e]">{{ $order->order_number }}</span>
                </div>
            </div>

            {{-- Order details --}}
            <div class="mt-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h2 class="font-semibold text-[#0c3a2e]">{{ __('Order Details') }}</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        <div class="flex items-center justify-between px-6 py-3 text-sm">
                            <span class="text-gray-700">{{ $item->name }} <span class="text-gray-400">× {{ $item->quantity }}</span></span>
                            <span class="font-semibold text-[#0c3a2e]">৳{{ number_format($item->line_total) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="space-y-2 border-t border-gray-100 px-6 py-4 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">{{ __('Subtotal') }}</span><span class="text-[#0c3a2e]">৳{{ number_format($order->subtotal) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">{{ __('Delivery Charge') }}</span><span class="text-[#0c3a2e]">৳{{ number_format($order->delivery_charge) }}</span></div>
                    <div class="flex justify-between border-t border-gray-100 pt-2 text-base font-bold"><span class="text-[#0c3a2e]">{{ __('Total') }}</span><span class="text-[#f47b20]">৳{{ number_format($order->total) }}</span></div>
                </div>
                <div class="grid gap-1 border-t border-gray-100 px-6 py-4 text-sm text-gray-600">
                    <p><span class="font-medium text-[#0c3a2e]">{{ __('Name') }}:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-medium text-[#0c3a2e]">{{ __('Phone') }}:</span> {{ $order->phone }}</p>
                    <p><span class="font-medium text-[#0c3a2e]">{{ __('Address') }}:</span> {{ $order->address }}{{ $order->city ? ', '.$order->city : '' }}</p>
                    <p><span class="font-medium text-[#0c3a2e]">{{ __('Payment') }}:</span> {{ __('Cash on Delivery') }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('products.index') }}" class="rounded-md bg-[#f47b20] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Continue Shopping') }}</a>
                <a href="{{ url('/') }}" class="rounded-md border border-gray-200 px-6 py-3 text-sm font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('Back to Home') }}</a>
            </div>
        </div>
    </section>
@endsection
