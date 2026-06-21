@extends('layouts.app')

@section('content')
    {{-- ===== Page header / breadcrumb ===== --}}
    <section class="relative overflow-hidden border-b border-gray-100 bg-white">
        <div class="animate-blob-float pointer-events-none absolute -right-20 -top-16 h-64 w-64 rounded-full bg-[#f47b20]/10 blur-3xl"></div>
        <div class="animate-blob-float-slow pointer-events-none absolute -left-16 bottom-0 h-56 w-56 rounded-full bg-[#7cb342]/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-[1500px] px-4 py-7 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ url('/') }}" class="transition hover:text-[#f47b20]">{{ __('Home') }}</a>
                <span>/</span>
                <span class="font-medium text-[#0c3a2e]">{{ $activeCategory ?: __('Shop') }}</span>
            </nav>
            <h1 class="mt-2 font-display text-3xl font-bold tracking-wide text-[#0c3a2e] lg:text-4xl">
                {{ $activeCategory ?: __('All Products') }}
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                {{ $products->total() }} {{ trans_choice('product found|products found', $products->total()) }}
                @if ($search)
                    — “<span class="font-medium text-[#0c3a2e]">{{ $search }}</span>”
                @endif
            </p>
        </div>
    </section>

    <section class="py-8 lg:py-10">
        <div class="mx-auto max-w-[1500px] px-4 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-[260px_1fr]">

                {{-- ===== Sidebar filters ===== --}}
                <aside class="space-y-6">
                    {{-- Search --}}
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        @if ($sort && $sort !== 'default')
                            <input type="hidden" name="sort" value="{{ $sort }}">
                        @endif
                        <input type="text" name="q" value="{{ $search }}" placeholder="{{ __('Search products...') }}"
                               class="w-full rounded-md border border-gray-200 bg-white py-2.5 pl-4 pr-10 text-sm text-gray-700 placeholder-gray-400 focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                        <button type="submit" aria-label="Search"
                                class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-md p-1.5 text-gray-500 transition hover:text-[#0c3a2e]">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                            </svg>
                        </button>
                    </form>

                    {{-- Categories --}}
                    <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-[#0c3a2e]">{{ __('Categories') }}</h3>
                        <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                        <ul class="mt-4 space-y-1">
                            <li>
                                <a href="{{ route('products.index', array_filter(['sort' => $sort !== 'default' ? $sort : null])) }}"
                                   class="flex items-center justify-between rounded-md px-3 py-2 text-sm transition {{ ! $activeCategory ? 'bg-[#0c3a2e] font-medium text-white' : 'text-gray-600 hover:bg-[#FBF9F5] hover:text-[#0c3a2e]' }}">
                                    {{ __('All Products') }}
                                </a>
                            </li>
                            @foreach ($navCategories as $cat)
                                <li>
                                    <a href="{{ route('products.index', array_filter(['category' => $cat->name, 'sort' => $sort !== 'default' ? $sort : null])) }}"
                                       class="flex items-center gap-2 rounded-md px-3 py-2 text-sm transition {{ $activeCategory === $cat->name ? 'bg-[#0c3a2e] font-medium text-white' : 'text-gray-600 hover:bg-[#FBF9F5] hover:text-[#0c3a2e]' }}">
                                        @if ($cat->emoji)<span aria-hidden="true">{{ $cat->emoji }}</span>@endif
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Help card --}}
                    <div class="rounded-xl bg-[#0c3a2e] p-5 text-white shadow-sm">
                        <h3 class="text-sm font-semibold">{{ __('Need help ordering?') }}</h3>
                        <p class="mt-1 text-xs text-gray-300">{{ __('Talk to us on WhatsApp, we are here to help.') }}</p>
                        <a href="{{ config('site.social.whatsapp') }}" target="_blank" rel="noopener"
                           class="mt-3 inline-flex items-center gap-1.5 rounded-md bg-[#25D366] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#1da851]">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Z" />
                            </svg>
                            {{ __('Chat now') }}
                        </a>
                    </div>
                </aside>

                {{-- ===== Product grid ===== --}}
                <div>
                    {{-- Toolbar --}}
                    <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-100 bg-white px-4 py-3 shadow-sm">
                        <p class="text-sm text-gray-500">
                            {{ __('Showing') }} <span class="font-medium text-[#0c3a2e]">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                            {{ __('of') }} <span class="font-medium text-[#0c3a2e]">{{ $products->total() }}</span>
                        </p>
                        <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                            @if ($search)
                                <input type="hidden" name="q" value="{{ $search }}">
                            @endif
                            @if ($activeCategory)
                                <input type="hidden" name="category" value="{{ $activeCategory }}">
                            @endif
                            <label for="sort" class="text-sm text-gray-500">{{ __('Sort by') }}</label>
                            <select name="sort" id="sort" onchange="this.form.submit()"
                                    class="rounded-md border border-gray-200 bg-white py-1.5 pl-3 pr-8 text-sm text-gray-700 focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                                <option value="default" @selected($sort === 'default')>{{ __('Featured') }}</option>
                                <option value="price_low" @selected($sort === 'price_low')>{{ __('Price: Low to High') }}</option>
                                <option value="price_high" @selected($sort === 'price_high')>{{ __('Price: High to Low') }}</option>
                                <option value="name" @selected($sort === 'name')>{{ __('Name: A to Z') }}</option>
                                <option value="newest" @selected($sort === 'newest')>{{ __('Newest') }}</option>
                            </select>
                        </form>
                    </div>

                    @if ($products->count())
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
                            @foreach ($products as $product)
                                @include('products.partials.card', ['product' => $product])
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $products->onEachSide(1)->links() }}
                        </div>
                    @else
                        {{-- Empty state --}}
                        <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-200 bg-white py-20 text-center">
                            <svg class="h-14 w-14 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272" />
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-[#0c3a2e]">{{ __('No products found') }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Try a different search or category.') }}</p>
                            <a href="{{ route('products.index') }}"
                               class="mt-5 inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                                {{ __('View all products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
