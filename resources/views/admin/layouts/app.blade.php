<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Acheri Food Bd</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f3f4f6] text-[#1b1b18] antialiased">
@php
    $nav = [
        ['label' => 'Dashboard',  'route' => 'admin.dashboard',       'active' => 'admin.dashboard',  'icon' => 'M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25A2.25 2.25 0 0 1 13.5 8.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z'],
        ['label' => 'Categories', 'route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z M6 6h.008v.008H6V6Z'],
        ['label' => 'Products',   'route' => 'admin.products.index',   'active' => 'admin.products.*',   'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
        ['label' => 'Orders',     'route' => 'admin.orders.index',     'active' => 'admin.orders.*',     'icon' => 'M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z'],
    ];
@endphp

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="hidden w-64 shrink-0 flex-col bg-[#0c3a2e] text-white lg:flex">
        <div class="flex h-16 items-center gap-2 border-b border-white/10 px-6">
            <span class="inline-flex rounded-md bg-white p-1">
                <img src="{{ asset('images/logo.png') }}" alt="Acheri Food Bd" class="h-8 w-auto object-contain">
            </span>
            <span class="font-display text-lg font-bold tracking-wide">Admin Panel</span>
        </div>
        <nav class="flex-1 space-y-1 px-3 py-5">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($item['active']) ? 'bg-white/15 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="space-y-1 border-t border-white/10 px-3 py-4">
            <a href="{{ url('/') }}" target="_blank" rel="noopener"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-white/10 hover:text-white">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                {{ __('View Site') }}
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-white/10 hover:text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    {{ __('Logout') }}
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-10 border-b border-gray-200 bg-white">
            <div class="flex h-16 items-center justify-between gap-4 px-4 lg:px-8">
                <h1 class="font-display text-xl font-bold tracking-wide text-[#0c3a2e] lg:text-2xl">{{ $title ?? 'Dashboard' }}</h1>
                <div class="flex items-center gap-3">
                    <span class="hidden text-sm text-gray-500 sm:inline">{{ auth()->user()?->name }}</span>
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0c3a2e]/10 text-sm font-semibold text-[#0c3a2e]">
                        {{ Str::of(auth()->user()?->name ?? 'A')->substr(0, 1)->upper() }}
                    </span>
                </div>
            </div>
            {{-- Mobile nav --}}
            <nav class="flex gap-1 overflow-x-auto border-t border-gray-100 px-4 py-2 lg:hidden">
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}"
                       class="whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium transition {{ request()->routeIs($item['active']) ? 'bg-[#0c3a2e] text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <form action="{{ route('admin.logout') }}" method="POST" class="ml-auto">
                    @csrf
                    <button type="submit" class="whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium text-[#e74c3c] hover:bg-red-50">{{ __('Logout') }}</button>
                </form>
            </nav>
        </header>

        <main class="flex-1 p-4 lg:p-8">
            @if (session('success'))
                <div class="mb-5 flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                    <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
