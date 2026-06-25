<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Acheri Food Bd') }}</title>

    <link rel="icon" href="{{ asset(config('site.favicon')) }}">
    <link rel="shortcut icon" href="{{ asset(config('site.favicon')) }}">
    <link rel="apple-touch-icon" href="{{ asset(config('site.favicon')) }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Load Google Fonts without blocking the first paint (text shows instantly, swaps when ready). --}}
    <link rel="preload" as="style"
          href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
          media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap">
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FBF9F5] text-[#1b1b18] antialiased">
    <x-site-header />

    @if (session('success'))
        <div class="border-b border-green-200 bg-green-50">
            <div class="mx-auto flex max-w-[1500px] items-center gap-2 px-4 py-2.5 text-sm font-medium text-green-800 lg:px-8">
                <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <x-site-footer />
</body>
</html>
