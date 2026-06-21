<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Admin Login') }} — Acheri Food Bd</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#FBF9F5] text-[#1b1b18] antialiased">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-sm">
            <div class="mb-6 text-center">
                <span class="inline-flex rounded-xl bg-white p-3 shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Acheri Food Bd" class="h-14 w-auto object-contain">
                </span>
                <h1 class="mt-4 font-display text-2xl font-bold tracking-wide text-[#0c3a2e]">{{ __('Admin Panel') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Sign in to manage your store') }}</p>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.attempt') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Password') }}</label>
                        <input type="password" name="password" id="password" required
                               class="w-full rounded-md border border-gray-200 bg-white px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-[#0c3a2e] focus:ring-[#0c3a2e]/30">
                        {{ __('Remember me') }}
                    </label>
                    <button type="submit"
                            class="w-full rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                        {{ __('Sign In') }}
                    </button>
                </form>
            </div>

            <p class="mt-5 text-center text-sm text-gray-500">
                <a href="{{ url('/') }}" class="font-medium text-[#f47b20] hover:underline">&larr; {{ __('Back to website') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
