@php
    $quickLinks = [
        'Home'       => url('/'),
        'Shop'       => route('products.index'),
        'About Us'   => url('/#about'),
        'Offer Zone' => route('products.index'),
        'Blog'       => '#',
        'Contact'    => url('/#about'),
    ];
    $serviceLinks = ['Track Order', 'Return Policy', 'Privacy Policy', 'Terms & Conditions', 'FAQ'];
@endphp

<footer class="bg-[#0c3a2e] text-gray-200">
    <div class="mx-auto max-w-[1500px] px-4 py-12 lg:px-8">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Brand --}}
            <div>
                <span class="inline-flex rounded-lg bg-white p-2">
                    <img src="{{ asset(config('site.logo')) }}" alt="{{ config('app.name') }}" class="h-12 w-auto object-contain">
                </span>
                <p class="mt-4 text-sm leading-relaxed text-gray-300">
                    {{ __('Pure & authentic homemade pickles, delivered fresh across Bangladesh.') }}
                </p>
                <div class="mt-5 flex gap-3">
                    {{-- Facebook --}}
                    <a href="{{ config('site.social.facebook') }}" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition hover:bg-[#f47b20]">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.198 21.5h4v-8.01h3.604l.396-3.98h-4V7.5a1 1 0 0 1 1-1h3v-4h-3a5 5 0 0 0-5 5v2.01h-2l-.396 3.98h2.396v8.01Z" />
                        </svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="{{ config('site.social.instagram') }}" target="_blank" rel="noopener" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition hover:bg-[#f47b20]">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    {{-- YouTube --}}
                    <a href="{{ config('site.social.youtube') }}" target="_blank" rel="noopener" aria-label="YouTube" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition hover:bg-[#f47b20]">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.58 7.19a2.5 2.5 0 0 0-1.76-1.77C18.25 5 12 5 12 5s-6.25 0-7.82.42A2.5 2.5 0 0 0 2.42 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .42 4.81 2.5 2.5 0 0 0 1.76 1.77C5.75 19 12 19 12 19s6.25 0 7.82-.42a2.5 2.5 0 0 0 1.76-1.77A26 26 0 0 0 22 12a26 26 0 0 0-.42-4.81ZM10 15V9l5.2 3-5.2 3Z" />
                        </svg>
                    </a>
                    {{-- WhatsApp --}}
                    <a href="{{ config('site.social.whatsapp') }}" target="_blank" rel="noopener" aria-label="WhatsApp" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition hover:bg-[#f47b20]">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Zm4.66 11.43c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.56.13-.16.25-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43l-.48-.01c-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.29Z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-base font-semibold text-white">{{ __('Quick Links') }}</h3>
                <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach ($quickLinks as $label => $url)
                        <li><a href="{{ $url }}" class="text-gray-300 transition hover:text-[#f47b20]">{{ __($label) }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Customer Service --}}
            <div>
                <h3 class="text-base font-semibold text-white">{{ __('Customer Service') }}</h3>
                <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach ($serviceLinks as $link)
                        <li><a href="#" class="text-gray-300 transition hover:text-[#f47b20]">{{ __($link) }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="text-base font-semibold text-white">{{ __('Contact Us') }}</h3>
                <span class="mt-2 block h-0.5 w-10 rounded bg-[#f47b20]"></span>
                <ul class="mt-4 space-y-3 text-sm text-gray-300">
                    <li class="flex items-start gap-2.5">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-[#f47b20]" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span>{{ config('site.address') }}</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="h-5 w-5 shrink-0 text-[#f47b20]" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <a href="tel:{{ config('site.phone') }}" class="transition hover:text-[#f47b20]">{{ config('site.phone') }}</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <svg class="h-5 w-5 shrink-0 text-[#f47b20]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <a href="mailto:{{ config('site.email') }}" class="transition hover:text-[#f47b20]">{{ config('site.email') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-[1500px] flex-col items-center justify-between gap-2 px-4 py-4 text-xs text-gray-400 sm:flex-row lg:px-8">
            <p>&copy; {{ date('Y') }} Acheri Food Bd. {{ __('All rights reserved.') }}</p>
            <p>{{ __('Developed by') }} <a href="#" class="font-medium text-[#f47b20]">TechLightIT</a></p>
        </div>
    </div>
</footer>
