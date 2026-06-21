@extends('layouts.app')

@section('content')
    @php
        $trust = [
            ['title' => '100% Natural',     'desc' => 'No preservatives', 'icon' => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
            ['title' => 'Fast Delivery',    'desc' => 'All 64 districts',  'icon' => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
            ['title' => 'Cash on Delivery', 'desc' => 'Pay at your door',  'icon' => 'M21 12a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3'],
        ];
    @endphp

    {{-- ===== Breadcrumb ===== --}}
    <section class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-[1500px] px-4 py-5 lg:px-8">
            <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                <a href="{{ url('/') }}" class="transition hover:text-[#f47b20]">{{ __('Home') }}</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="transition hover:text-[#f47b20]">{{ __('Shop') }}</a>
                @if ($product->category)
                    <span>/</span>
                    <a href="{{ route('products.index', ['category' => $product->category]) }}" class="transition hover:text-[#f47b20]">{{ $product->category }}</a>
                @endif
                <span>/</span>
                <span class="font-medium text-[#0c3a2e]">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    {{-- ===== Product detail ===== --}}
    <section class="py-8 lg:py-12">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-2 lg:gap-12">

                {{-- Image --}}
                <div class="relative flex items-center justify-center overflow-hidden rounded-2xl border border-gray-100 bg-gradient-to-br from-[#fff7ee] to-[#eef7e6] p-10 shadow-sm">
                    @if ($product->on_sale)
                        <span class="absolute left-4 top-4 rounded-md bg-[#7cb342] px-2.5 py-1 text-xs font-semibold text-white">
                            -{{ $product->save_percent }}%
                        </span>
                    @endif
                    @if ($product->is_best_selling)
                        <span class="absolute right-4 top-4 flex items-center gap-1 rounded-full bg-gradient-to-r from-[#e74c3c] to-[#f47b20] px-3 py-1 text-xs font-semibold text-white shadow-sm">
                            <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2c.4 2.4-1 4-2.4 5.2C8 8.6 6.5 10 6.5 12.5a5.5 5.5 0 0 0 11 0c0-1.6-.7-3-1.6-4.2.3 1-.2 2-1 2.6 0-2.3-1.3-4.2-2.9-5.6C10.6 4.2 12.2 3 12 2Z" />
                            </svg>
                            {{ __('Best Selling') }}
                        </span>
                    @endif
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                         class="max-h-[360px] w-auto max-w-full object-contain drop-shadow-sm">
                </div>

                {{-- Info --}}
                <div class="flex flex-col">
                    @if ($product->category)
                        <a href="{{ route('products.index', ['category' => $product->category]) }}"
                           class="inline-flex w-fit items-center gap-1.5 rounded-full bg-[#7cb342]/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#5a8a2c] transition hover:bg-[#7cb342]/25">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#7cb342]"></span>
                            {{ $product->category }}
                        </a>
                    @endif

                    <h1 class="mt-3 font-display text-3xl font-bold leading-tight tracking-wide text-[#0c3a2e] lg:text-4xl">
                        {{ $product->name }}
                    </h1>

                    {{-- Price --}}
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="text-3xl font-bold text-[#f47b20]">৳{{ number_format($product->price) }}</span>
                        @if ($product->on_sale)
                            <span class="text-lg text-gray-400 line-through">৳{{ number_format($product->old_price) }}</span>
                            <span class="rounded-md bg-[#7cb342] px-2 py-0.5 text-xs font-semibold text-white">
                                {{ __('Save') }} ৳{{ number_format($product->save_amount) }}
                            </span>
                        @endif
                    </div>

                    {{-- Stock --}}
                    <div class="mt-3">
                        @if ($product->stock > 0)
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#5a8a2c]">
                                <span class="h-2 w-2 rounded-full bg-[#7cb342]"></span>
                                {{ __('In Stock') }} ({{ $product->stock }} {{ __('available') }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-sm font-medium text-[#e74c3c]">
                                <span class="h-2 w-2 rounded-full bg-[#e74c3c]"></span>
                                {{ __('Out of Stock') }}
                            </span>
                        @endif
                    </div>

                    @if ($product->description)
                        <p class="mt-5 leading-relaxed text-gray-600">{{ $product->description }}</p>
                    @endif

                    {{-- Quantity + actions --}}
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-7 flex flex-wrap items-center gap-3">
                        @csrf
                        <div class="flex items-center rounded-md border border-gray-200">
                            <button type="button" data-qty="dec" aria-label="Decrease"
                                    class="flex h-11 w-11 items-center justify-center text-lg text-gray-600 transition hover:text-[#f47b20]">−</button>
                            <input type="text" name="quantity" id="qty" value="1" readonly
                                   class="h-11 w-12 border-x border-gray-200 text-center text-sm font-semibold text-[#0c3a2e] focus:outline-none">
                            <button type="button" data-qty="inc" aria-label="Increase"
                                    class="flex h-11 w-11 items-center justify-center text-lg text-gray-600 transition hover:text-[#f47b20]">+</button>
                        </div>

                        <button type="submit" @disabled($product->stock < 1)
                                class="flex items-center gap-1.5 rounded-md border border-[#f47b20] px-5 py-3 text-sm font-semibold text-[#f47b20] transition hover:bg-[#f47b20] hover:text-white disabled:cursor-not-allowed disabled:opacity-50">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            {{ __('Add To Cart') }}
                        </button>

                        <button type="submit" name="buy_now" value="1" @disabled($product->stock < 1)
                                class="flex items-center gap-1.5 rounded-md bg-[#f47b20] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#dd6c14] disabled:cursor-not-allowed disabled:opacity-50">
                            {{ __('Buy Now') }}
                        </button>
                    </form>

                    {{-- WhatsApp order --}}
                    <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode(__('I want to order:') . ' ' . $product->name) }}"
                       target="_blank" rel="noopener"
                       class="mt-4 inline-flex w-fit items-center gap-2 rounded-md bg-[#25D366] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#1da851]">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Zm4.66 11.43c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.56.13-.16.25-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43l-.48-.01c-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.29Z" />
                        </svg>
                        {{ __('Order on WhatsApp') }}
                    </a>

                    {{-- Trust badges --}}
                    <div class="mt-8 grid grid-cols-3 gap-3 border-t border-gray-100 pt-6">
                        @foreach ($trust as $t)
                            <div class="flex flex-col items-center gap-2 text-center">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#0c3a2e]/5 text-[#0c3a2e]">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold text-[#0c3a2e]">{{ __($t['title']) }}</p>
                                    <p class="text-[11px] text-gray-500">{{ __($t['desc']) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ===== Related products ===== --}}
            @if ($related->count())
                <div class="mt-16 lg:mt-20">
                    <div class="flex items-center justify-between">
                        <h2 class="font-display text-2xl font-bold tracking-wide text-[#0c3a2e] lg:text-3xl">{{ __('Related Products') }}</h2>
                        <a href="{{ route('products.index', ['category' => $product->category]) }}"
                           class="text-sm font-semibold text-[#f47b20] transition hover:text-[#dd6c14]">{{ __('View all') }} →</a>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($related as $item)
                            @include('products.partials.card', ['product' => $item])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Quantity stepper --}}
    <script>
        (function () {
            const input = document.getElementById('qty');
            if (!input) return;
            const max = {{ max($product->stock, 1) }};
            document.querySelectorAll('[data-qty]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let v = parseInt(input.value, 10) || 1;
                    v += btn.dataset.qty === 'inc' ? 1 : -1;
                    v = Math.min(max, Math.max(1, v));
                    input.value = v;
                });
            });
        })();
    </script>
@endsection
