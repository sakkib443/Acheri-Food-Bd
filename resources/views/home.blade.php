@extends('layouts.app')

@section('content')
    {{-- ===== Hero banners ===== --}}
    <section class="mx-auto max-w-[1500px] px-4 py-5 lg:px-8">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-[2.08fr_1fr]">
            @foreach (config('site.hero') as $banner)
                <a href="{{ $banner['link'] }}" class="block overflow-hidden rounded-md">
                    <img src="{{ asset($banner['image']) }}" alt="Banner"
                         class="block h-auto w-full transition duration-300 hover:scale-[1.03]">
                </a>
            @endforeach
        </div>
    </section>

    {{-- ===== Featured Categories ===== --}}
    <section class="bg-[#FBF9F5] py-10">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            <h2 class="text-center font-display text-3xl font-bold tracking-wide text-[#0c3a2e]">{{ __('Featured Categories') }}</h2>

            {{-- Continuous auto-scrolling marquee (pauses on hover) --}}
            <div class="marquee-pause mt-8 overflow-hidden">
                <div class="flex w-max animate-marquee">
                    @foreach ($navCategories->concat($navCategories) as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->name]) }}" class="group mr-5 flex w-32 shrink-0 flex-col items-center gap-3">
                            <div class="flex h-28 w-28 items-center justify-center overflow-hidden rounded-2xl border border-gray-200/70 bg-white/40 transition group-hover:-translate-y-1">
                                @if ($cat->image)
                                    <img src="{{ asset($cat->image) }}" alt="{{ $cat->display_name }}" class="h-full w-full object-cover">
                                @else
                                    <span class="text-5xl leading-none">{{ $cat->emoji }}</span>
                                @endif
                            </div>
                            <span class="text-center text-sm font-medium text-gray-700 group-hover:text-[#f47b20]">{{ $cat->display_name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Top Selling Products ===== --}}
    <section class="relative overflow-hidden py-14 lg:py-16">
        {{-- Soft, slowly panning colorful gradient backdrop (light, not dark) --}}
        <div class="animate-gradient-pan pointer-events-none absolute inset-0 bg-gradient-to-br from-[#fff3e6] via-[#fdfaf4] to-[#edf7e3]"></div>

        {{-- Drifting decorative blobs --}}
        <div class="animate-blob-float pointer-events-none absolute -left-20 top-2 h-72 w-72 rounded-full bg-[#f47b20]/15 blur-3xl"></div>
        <div class="animate-blob-float-slow pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-[#7cb342]/15 blur-3xl"></div>
        <div class="animate-blob-float-delay pointer-events-none absolute left-1/2 top-1/3 h-64 w-64 -translate-x-1/2 rounded-full bg-[#ffce85]/25 blur-3xl"></div>

        <div class="relative mx-auto max-w-[1500px] px-4 lg:px-8">
            {{-- Heading with eyebrow + gradient underline --}}
            <div class="flex flex-col items-center text-center">
                <span class="animate-float-y inline-flex items-center gap-1.5 rounded-full bg-white/70 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-[#f47b20] shadow-sm ring-1 ring-[#f47b20]/15 backdrop-blur">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2c.4 2.4-1 4-2.4 5.2C8 8.6 6.5 10 6.5 12.5a5.5 5.5 0 0 0 11 0c0-1.6-.7-3-1.6-4.2.3 1-.2 2-1 2.6 0-2.3-1.3-4.2-2.9-5.6C10.6 4.2 12.2 3 12 2Z" />
                    </svg>
                    {{ __('Customer Favourites') }}
                </span>
                <h2 class="mt-3 font-display text-3xl font-bold tracking-wide text-[#0c3a2e] lg:text-4xl">{{ __('Top Selling Products') }}</h2>
                <span class="mt-3 h-1 w-24 rounded-full bg-gradient-to-r from-[#f47b20] via-[#ffce85] to-[#7cb342]"></span>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
                @foreach ($topProducts as $product)
                    <div class="group relative overflow-hidden rounded-2xl border border-white/70 bg-white/80 p-5 shadow-md shadow-[#0c3a2e]/5 backdrop-blur-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#f47b20]/15 sm:p-6">
                        {{-- Animated top accent bar (grows in on hover) --}}
                        <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#f47b20] to-[#7cb342] transition-transform duration-300 group-hover:scale-x-100"></span>

                        {{-- Best Selling badge --}}
                        @if ($product->is_best_selling)
                            <span class="absolute right-3 top-3 z-10 flex items-center gap-1 rounded-full bg-gradient-to-r from-[#e74c3c] to-[#f47b20] px-2.5 py-1 text-[11px] font-semibold text-white shadow-sm">
                                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2c.4 2.4-1 4-2.4 5.2C8 8.6 6.5 10 6.5 12.5a5.5 5.5 0 0 0 11 0c0-1.6-.7-3-1.6-4.2.3 1-.2 2-1 2.6 0-2.3-1.3-4.2-2.9-5.6C10.6 4.2 12.2 3 12 2Z" />
                                </svg>
                                {{ __('Best Selling') }}
                            </span>
                        @endif

                        <div class="relative flex items-center gap-5 sm:gap-6">
                            {{-- Image (soft gradient tile, zooms on hover) --}}
                            <div class="flex h-36 w-32 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-[#fff7ee] to-[#eef7e6] ring-1 ring-black/[0.03]">
                                <a href="{{ route('products.show', $product) }}" class="flex h-full w-full items-center justify-center">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->display_name }}"
                                         class="max-h-[85%] max-w-[85%] object-contain drop-shadow-sm transition duration-300 group-hover:-rotate-2 group-hover:scale-110">
                                </a>
                            </div>

                            {{-- Details --}}
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-semibold text-[#0c3a2e]">
                                    <a href="{{ route('products.show', $product) }}" class="transition hover:text-[#f47b20]">{{ $product->display_name }}</a>
                                </h3>

                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-base font-bold text-[#f47b20]">৳{{ number_format($product->price) }}</span>
                                    @if ($product->on_sale)
                                        <span class="text-sm text-gray-400 line-through">৳{{ number_format($product->old_price) }}</span>
                                    @endif
                                </div>

                                @if ($product->on_sale)
                                    <span class="mt-2 inline-block rounded bg-[#7cb342] px-2 py-0.5 text-[11px] font-semibold text-white">
                                        {{ __('Save') }} ৳{{ number_format($product->save_amount) }}
                                    </span>
                                @endif

                                {{-- Actions --}}
                                <div class="mt-4 flex flex-wrap items-center gap-3">
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="flex items-center gap-1.5 rounded-md border border-[#f47b20] px-3 py-2 text-xs font-medium text-[#f47b20] transition hover:bg-[#f47b20] hover:text-white">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                            </svg>
                                            {{ __('Add To Cart') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="buy_now" value="1">
                                        <button type="submit"
                                                class="flex items-center gap-1.5 rounded-md bg-[#f47b20] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#dd6c14]">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                            </svg>
                                            {{ __('Buy now') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== Our Products ===== --}}
    <section class="bg-[#FBF9F5] py-12">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-display text-3xl font-bold tracking-wide text-[#0c3a2e]">{{ __('Our Products') }}</h2>
                <a href="{{ route('products.index') }}" class="inline-flex shrink-0 items-center gap-1 text-sm font-semibold text-[#f47b20] transition hover:text-[#dd6c14]">
                    {{ __('View All') }}
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($products as $product)
                    <div class="group relative flex flex-col rounded-lg border border-gray-100 bg-white p-3 shadow-sm transition hover:shadow-md">
                        {{-- Save badge --}}
                        @if ($product->on_sale)
                            <span class="absolute right-2 top-2 z-10 rounded-md bg-[#7cb342] px-2 py-0.5 text-[11px] font-semibold text-white">
                                {{ __('Save') }} {{ $product->save_percent }}%
                            </span>
                        @endif

                        {{-- Image --}}
                        <a href="{{ route('products.show', $product) }}" class="flex h-44 items-center justify-center overflow-hidden rounded-md">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->display_name }}"
                                 class="h-full w-full object-contain transition duration-300 group-hover:scale-105">
                        </a>

                        {{-- Details --}}
                        <div class="mt-3 flex flex-1 flex-col">
                            <h3 class="line-clamp-2 min-h-[2.5rem] text-sm font-medium text-gray-800">
                                <a href="{{ route('products.show', $product) }}" class="transition hover:text-[#f47b20]">{{ $product->display_name }}</a>
                            </h3>

                            <div class="mt-2 flex items-center gap-2">
                                <span class="font-bold text-[#f47b20]">৳{{ number_format($product->price) }}</span>
                                @if ($product->on_sale)
                                    <span class="text-xs text-gray-400 line-through">৳{{ number_format($product->old_price) }}</span>
                                @endif
                            </div>

                            {{-- Buttons --}}
                            <div class="mt-3 flex items-center gap-2">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="flex w-full items-center justify-center gap-1.5 rounded-md border border-[#f47b20] px-2 py-2 text-xs font-semibold text-[#f47b20] transition hover:bg-[#f47b20] hover:text-white">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>
                                        {{ __('Add To Cart') }}
                                    </button>
                                </form>
                                <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode(__('I want to order:') . ' ' . $product->display_name) }}"
                                   target="_blank" rel="noopener" aria-label="WhatsApp"
                                   class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-[#25D366] text-white transition hover:bg-[#1da851]">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Zm4.66 11.43c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.56.13-.16.25-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43l-.48-.01c-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.29Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== About Us ===== --}}
    @php
        $aboutFeatures = [
            [
                'title' => '100% Pure & Organic',
                'desc'  => 'No chemicals, no preservatives — just real food.',
                'icon'  => 'M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Zm6.633-2.405L18 13.5l-.554.001M18 9.75l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 13.5l-1.035.259a3.375 3.375 0 0 0-2.456 2.456L18 17.25l-.259-1.035a3.375 3.375 0 0 0-2.456-2.456L14.25 13.5l1.035-.259a3.375 3.375 0 0 0 2.456-2.456L18 9.75Z',
            ],
            [
                'title' => 'Nationwide Delivery',
                'desc'  => 'Fast home delivery across all 64 districts.',
                'icon'  => 'M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12',
            ],
            [
                'title' => 'Quality Guaranteed',
                'desc'  => 'Every item checked for freshness & purity.',
                'icon'  => 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z',
            ],
            [
                'title' => 'Fair & Honest Price',
                'desc'  => 'Premium quality at affordable prices.',
                'icon'  => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z M6 6h.008v.008H6V6Z',
            ],
        ];
    @endphp

    <section id="about" class="relative overflow-hidden bg-gradient-to-b from-white to-[#FBF9F5] py-16 lg:py-20">
        {{-- Decorative blobs --}}
        <div class="pointer-events-none absolute -left-24 top-10 h-72 w-72 rounded-full bg-[#7cb342]/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-[#f47b20]/10 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-[1500px] items-center gap-14 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">

            {{-- Image side --}}
            <div class="relative mx-auto w-full max-w-md lg:mx-0">
                <div class="absolute inset-0 -rotate-3 rounded-[2rem] bg-[#0c3a2e]/5"></div>
                <div class="relative overflow-hidden rounded-[2rem] border border-gray-100 bg-white p-6 shadow-xl shadow-[#0c3a2e]/5 sm:p-8">
                    <div class="flex aspect-square items-center justify-center rounded-2xl bg-gradient-to-br from-[#faf7f2] to-[#f3ece0]">
                        <img src="{{ asset('images/logo.png') }}" alt="Acheri Food Bd"
                             class="h-32 w-auto object-contain lg:h-40">
                    </div>
                </div>

                {{-- Top floating badge --}}
                <div class="absolute -right-2 top-6 flex items-center gap-2 rounded-full bg-white px-4 py-2 shadow-lg sm:-right-4">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#7cb342]/15 text-[#5a8a2c]">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <span class="text-xs font-semibold text-[#0c3a2e]">{{ __('100% Natural') }}</span>
                </div>

                {{-- Bottom floating stat --}}
                <div class="absolute -bottom-5 left-6 rounded-2xl bg-[#f47b20] px-5 py-3 text-center text-white shadow-lg">
                    <p class="text-2xl font-bold leading-none">10K+</p>
                    <p class="mt-1 text-[11px] font-medium">{{ __('Happy Customers') }}</p>
                </div>
            </div>

            {{-- Text side --}}
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-[#7cb342]/15 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-[#5a8a2c]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#7cb342]"></span>
                    {{ __('About Us') }}
                </span>

                <h2 class="mt-4 font-display text-4xl font-bold leading-tight tracking-wide text-[#0c3a2e]">
                    {{ __('Pure, Natural & Authentic Food from Bangladesh') }}
                </h2>

                <p class="mt-4 leading-relaxed text-gray-600">
                    {{ __('Acheri Food Bd is a trusted online grocery delivering 100% pure, natural and chemical-free food straight from the farms and forests of Bangladesh — from cold-pressed mustard oil and Sundarban honey to handmade pickles, ghee and premium dates, every item is carefully sourced and brought to your doorstep at a fair price.') }}
                </p>

                {{-- Feature cards --}}
                <div class="mt-7 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach ($aboutFeatures as $feature)
                        <div class="flex items-start gap-3 rounded-xl border border-gray-100 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#0c3a2e]/5 text-[#0c3a2e]">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-[#0c3a2e]">{{ __($feature['title']) }}</h3>
                                <p class="mt-0.5 text-xs leading-relaxed text-gray-500">{{ __($feature['desc']) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- CTAs --}}
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="#"
                       class="inline-flex items-center gap-2 rounded-md bg-[#0c3a2e] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#0a2f25]">
                        {{ __('Learn More') }}
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                    <a href="#"
                       class="inline-flex items-center gap-2 rounded-md border border-[#0c3a2e]/20 px-6 py-3 text-sm font-semibold text-[#0c3a2e] transition hover:border-[#0c3a2e] hover:bg-[#0c3a2e] hover:text-white">
                        {{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
