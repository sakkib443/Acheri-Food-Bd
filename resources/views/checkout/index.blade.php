@extends('layouts.app')

@section('content')
    <section class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-[1500px] px-4 py-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ url('/') }}" class="transition hover:text-[#f47b20]">{{ __('Home') }}</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}" class="transition hover:text-[#f47b20]">{{ __('Cart') }}</a>
                <span>/</span>
                <span class="font-medium text-[#0c3a2e]">{{ __('Checkout') }}</span>
            </nav>
            <h1 class="mt-2 font-display text-3xl font-bold tracking-wide text-[#0c3a2e] lg:text-4xl">{{ __('Checkout') }}</h1>
        </div>
    </section>

    <section class="py-8 lg:py-10">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            <form action="{{ route('checkout.store') }}" method="POST" class="grid gap-8 lg:grid-cols-[1fr_380px]">
                @csrf

                {{-- Billing details --}}
                <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-lg font-semibold text-[#0c3a2e]">{{ __('Delivery Information') }}</h2>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" required
                                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                            @error('customer_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Phone') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required placeholder="01XXXXXXXXX"
                                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                            @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="address" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Full Address') }} <span class="text-red-500">*</span></label>
                            <textarea name="address" id="address" rows="3" required
                                      class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">{{ old('address') }}</textarea>
                            @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="city" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('City / District') }}</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}"
                                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                            @error('city') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="note" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Order Note') }}</label>
                            <textarea name="note" id="note" rows="2" placeholder="{{ __('Any special instruction (optional)') }}"
                                      class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <h2 class="mt-8 text-lg font-semibold text-[#0c3a2e]">{{ __('Payment Method') }}</h2>
                    <label class="mt-4 flex items-start gap-3 rounded-lg border border-[#f47b20] bg-[#fff7ee] p-4">
                        <input type="radio" name="payment_method" value="cod" checked class="mt-0.5 h-4 w-4 text-[#f47b20] focus:ring-[#f47b20]/30">
                        <span>
                            <span class="block text-sm font-semibold text-[#0c3a2e]">{{ __('Cash on Delivery') }}</span>
                            <span class="block text-xs text-gray-500">{{ __('Pay with cash when your order arrives.') }}</span>
                        </span>
                    </label>
                    @error('payment_method') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                {{-- Order summary --}}
                <div class="h-fit rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-[#0c3a2e]">{{ __('Your Order') }}</h2>
                    <div class="mt-4 divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <div class="flex items-center gap-3 py-3">
                                <div class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-[#fff7ee] to-[#eef7e6]">
                                    <img src="{{ asset($item['image']) }}" alt="" class="max-h-[80%] max-w-[80%] object-contain">
                                    <span class="absolute -right-2 -top-2 flex h-5 min-w-5 items-center justify-center rounded-full bg-[#0c3a2e] px-1 text-[10px] font-bold text-white">{{ $item['qty'] }}</span>
                                </div>
                                <p class="min-w-0 flex-1 truncate text-sm text-gray-700">{{ $item['name'] }}</p>
                                <p class="text-sm font-semibold text-[#0c3a2e]">৳{{ number_format($item['price'] * $item['qty']) }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 space-y-3 border-t border-gray-100 pt-4 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">{{ __('Subtotal') }}</span><span class="font-medium text-[#0c3a2e]">৳{{ number_format($subtotal) }}</span></div>
                        @if ($discount > 0)
                            <div class="flex justify-between"><span class="text-[#5a8a2c]">{{ __('Discount') }}{{ $coupon ? ' ('.$coupon->code.')' : '' }}</span><span class="font-medium text-[#5a8a2c]">−৳{{ number_format($discount) }}</span></div>
                        @endif
                        <div class="flex justify-between"><span class="text-gray-500">{{ __('Delivery Charge') }}</span><span class="font-medium text-[#0c3a2e]">৳{{ number_format($deliveryCharge) }}</span></div>
                        <div class="flex justify-between border-t border-gray-100 pt-3 text-base"><span class="font-semibold text-[#0c3a2e]">{{ __('Total') }}</span><span class="font-bold text-[#f47b20]">৳{{ number_format(max(0, $subtotal - $discount) + $deliveryCharge) }}</span></div>
                    </div>
                    <button type="submit" class="mt-6 w-full rounded-md bg-[#f47b20] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                        {{ __('Place Order') }}
                    </button>
                    <p class="mt-3 text-center text-xs text-gray-400">{{ __('By placing the order you agree to our terms.') }}</p>
                </div>
            </form>
        </div>
    </section>
@endsection
