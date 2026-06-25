<header class="w-full bg-white shadow-sm">
    {{-- ===== Top bar ===== --}}
    <div class="mx-auto flex max-w-[1500px] items-center gap-4 px-4 py-3 lg:px-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex shrink-0 items-center">
            <img src="{{ asset(config('site.logo')) }}" alt="{{ config('app.name') }}" fetchpriority="high" decoding="async" class="h-12 w-auto object-contain lg:h-14">
        </a>

        {{-- Spacer --}}
        <div class="flex-1"></div>

        {{-- Search --}}
        <form action="{{ route('products.index') }}" method="GET" class="relative hidden w-[520px] md:block">
            <input type="text" name="q" placeholder="{{ __('Search in...') }}"
                   class="w-full rounded-md bg-[#f2f2f2] py-3 pl-4 pr-10 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/25" />
            <button type="submit" aria-label="Search"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-md p-2 text-gray-600 transition hover:text-[#0c3a2e]">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                </svg>
            </button>
        </form>

        {{-- Right actions --}}
        <div class="flex items-center gap-5 sm:gap-6">

            {{-- Language Switcher (dropdown) --}}
            <details class="group relative [&_summary::-webkit-details-marker]:hidden">
                <summary class="flex cursor-pointer list-none flex-col items-center gap-1 text-[#0c3a2e] transition hover:text-[#f47b20]">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253M3.157 7.582A8.959 8.959 0 0 0 3 12c0 .778.099 1.533.284 2.253" />
                    </svg>
                    <span class="flex items-center gap-0.5 text-[11px] font-medium">
                        {{ app()->getLocale() === 'bn' ? 'বাংলা' : 'English' }}
                        <svg class="h-3 w-3 transition group-open:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </summary>
                <div class="absolute right-0 top-full z-20 mt-2 w-32 overflow-hidden rounded-lg border border-gray-100 bg-white py-1 shadow-lg">
                    <a href="{{ route('language.switch', 'en') }}"
                       class="block px-4 py-2 text-sm transition hover:bg-gray-50 {{ app()->getLocale() === 'en' ? 'font-semibold text-[#f47b20]' : 'text-[#0c3a2e]' }}">
                        English
                    </a>
                    <a href="{{ route('language.switch', 'bn') }}"
                       class="block px-4 py-2 text-sm transition hover:bg-gray-50 {{ app()->getLocale() === 'bn' ? 'font-semibold text-[#f47b20]' : 'text-[#0c3a2e]' }}">
                        বাংলা
                    </a>
                </div>
            </details>

            {{-- Sign In (admin login) --}}
            <a href="{{ route('admin.login') }}" class="flex flex-col items-center gap-1 text-[#0c3a2e] transition hover:text-[#f47b20]">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span class="text-[11px] font-medium">{{ __('Sign In') }}</span>
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-1 text-[#0c3a2e] transition hover:text-[#f47b20]">
                <span class="relative">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-1.5 2.143-3.107 3.054-4.806l1.206-2.799a.75.75 0 0 0-.59-1.04l-12.36-1.236M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    @if (\App\Support\Cart::count() > 0)
                        <span class="absolute -right-2.5 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#f47b20] px-1 text-[10px] font-bold leading-none text-white">{{ \App\Support\Cart::count() }}</span>
                    @endif
                </span>
                <span class="text-[11px] font-medium">{{ __('Cart') }}</span>
            </a>

            {{-- More --}}
            <button type="button" class="flex flex-col items-center gap-1 text-[#0c3a2e] transition hover:text-[#f47b20]">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <span class="text-[11px] font-medium">{{ __('More') }}</span>
            </button>
        </div>
    </div>

    {{-- ===== Category nav ===== --}}
    <nav class="bg-[#0c3a2e] text-white">
        <ul class="mx-auto flex max-w-[1500px] items-center gap-x-7 overflow-x-auto px-4 py-3 text-sm font-medium lg:justify-end lg:px-8">
            <li>
                <a href="{{ route('products.index') }}" class="flex items-center gap-1 whitespace-nowrap transition hover:text-[#f4a93c]">
                    {{ __('Combos') }}
                </a>
            </li>
            <li>
                <a href="{{ route('products.index') }}" class="flex items-center gap-1 whitespace-nowrap transition hover:text-[#f4a93c]">
                    {{ __('Offer Zone') }}
                </a>
            </li>
            @foreach ($navCategories as $cat)
                <li>
                    <a href="{{ route('products.index', ['category' => $cat->name]) }}" class="flex items-center gap-1 whitespace-nowrap transition hover:text-[#f4a93c]">
                        {{ $cat->display_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</header>
