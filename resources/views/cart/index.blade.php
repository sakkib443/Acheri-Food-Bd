@extends('layouts.app')

@section('content')
    <section class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-[1500px] px-4 py-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ url('/') }}" class="transition hover:text-[#f47b20]">{{ __('Home') }}</a>
                <span>/</span>
                <span class="font-medium text-[#0c3a2e]">{{ __('Shopping Cart') }}</span>
            </nav>
            <h1 class="mt-2 font-display text-3xl font-bold tracking-wide text-[#0c3a2e] lg:text-4xl">{{ __('Shopping Cart') }}</h1>
        </div>
    </section>

    <section class="py-8 lg:py-10">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            @if (empty($items))
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-200 bg-white py-20 text-center">
                    <svg class="h-16 w-16 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-[#0c3a2e]">{{ __('Your cart is empty') }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Add some products to get started.') }}</p>
                    <a href="{{ route('products.index') }}" class="mt-5 inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Continue Shopping') }}</a>
                </div>
            @else
                <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
                    {{-- Items --}}
                    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
                        <div class="divide-y divide-gray-100">
                            @foreach ($items as $item)
                                <div class="flex items-center gap-4 p-4 sm:gap-5 sm:p-5">
                                    <a href="{{ route('products.show', $item['slug']) }}" class="flex h-20 w-20 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-[#fff7ee] to-[#eef7e6]">
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="max-h-[80%] max-w-[80%] object-contain">
                                    </a>
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('products.show', $item['slug']) }}" class="font-medium text-[#0c3a2e] transition hover:text-[#f47b20]">{{ $item['name'] }}</a>
                                        <p class="mt-1 text-sm text-[#f47b20]">৳{{ number_format($item['price']) }}</p>
                                    </div>

                                    {{-- Quantity --}}
                                    <form action="{{ route('cart.update', $item['slug']) }}" method="POST" class="flex items-center rounded-md border border-gray-200">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="quantity" value="{{ $item['qty'] - 1 }}" class="flex h-9 w-9 items-center justify-center text-gray-600 transition hover:text-[#f47b20]">−</button>
                                        <span class="w-9 border-x border-gray-200 text-center text-sm font-semibold text-[#0c3a2e]">{{ $item['qty'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $item['qty'] + 1 }}" class="flex h-9 w-9 items-center justify-center text-gray-600 transition hover:text-[#f47b20]">+</button>
                                    </form>

                                    {{-- Line total --}}
                                    <div class="hidden w-24 text-right font-semibold text-[#0c3a2e] sm:block">৳{{ number_format($item['price'] * $item['qty']) }}</div>

                                    {{-- Remove --}}
                                    <form action="{{ route('cart.remove', $item['slug']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="{{ __('Remove') }}" class="flex h-9 w-9 items-center justify-center rounded-md text-gray-400 transition hover:bg-red-50 hover:text-red-500">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-100 px-5 py-4">
                            <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#0c3a2e] transition hover:text-[#f47b20]">← {{ __('Continue Shopping') }}</a>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('{{ __('Clear the whole cart?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-500 transition hover:text-red-600">{{ __('Clear Cart') }}</button>
                            </form>
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="h-fit rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-[#0c3a2e]">{{ __('Order Summary') }}</h2>
                        <div class="mt-5 space-y-3 text-sm">
                            <div class="flex justify-between"><span class="text-gray-500">{{ __('Subtotal') }}</span><span class="font-medium text-[#0c3a2e]">৳{{ number_format($subtotal) }}</span></div>
                            <div class="flex justify-between"><span class="text-gray-500">{{ __('Delivery Charge') }}</span><span class="font-medium text-[#0c3a2e]">৳{{ number_format($deliveryCharge) }}</span></div>
                            <div class="flex justify-between border-t border-gray-100 pt-3 text-base"><span class="font-semibold text-[#0c3a2e]">{{ __('Total') }}</span><span class="font-bold text-[#f47b20]">৳{{ number_format($subtotal + $deliveryCharge) }}</span></div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="mt-6 flex items-center justify-center gap-2 rounded-md bg-[#f47b20] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                            {{ __('Proceed to Checkout') }}
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
