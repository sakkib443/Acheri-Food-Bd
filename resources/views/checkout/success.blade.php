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
                    @if ($order->discount > 0)
                        <div class="flex justify-between"><span class="text-[#5a8a2c]">{{ __('Discount') }}{{ $order->coupon_code ? ' ('.$order->coupon_code.')' : '' }}</span><span class="text-[#5a8a2c]">−৳{{ number_format($order->discount) }}</span></div>
                    @endif
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

            {{-- Send order to WhatsApp --}}
            <div class="mt-6 rounded-2xl border border-[#25D366]/30 bg-[#25D366]/5 p-6 text-center">
                <p class="text-sm text-gray-600">{{ __('Please confirm your order by sending the details to us on WhatsApp.') }}</p>
                <a href="{{ $order->whatsappUrl() }}" target="_blank" rel="noopener" id="waOrder"
                   class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-md bg-[#25D366] px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1da851] sm:w-auto">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Zm4.66 11.43c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.56.13-.16.25-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43l-.48-.01c-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.29Z" />
                    </svg>
                    {{ __('Confirm order on WhatsApp') }}
                </a>
            </div>

            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('products.index') }}" class="rounded-md bg-[#f47b20] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Continue Shopping') }}</a>
                <a href="{{ url('/') }}" class="rounded-md border border-gray-200 px-6 py-3 text-sm font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('Back to Home') }}</a>
            </div>
        </div>
    </section>

    {{-- Auto-open WhatsApp with the order details (best-effort; button stays for manual tap) --}}
    <script>
        window.addEventListener('load', function () {
            var btn = document.getElementById('waOrder');
            if (btn) { window.open(btn.href, '_blank'); }
        });
    </script>
@endsection
