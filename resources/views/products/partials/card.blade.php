{{-- Reusable product card. Expects: $product --}}
<div class="group relative flex flex-col rounded-lg border border-gray-100 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    {{-- Save badge --}}
    @if ($product->on_sale)
        <span class="absolute right-2 top-2 z-10 rounded-md bg-[#7cb342] px-2 py-0.5 text-[11px] font-semibold text-white">
            {{ __('Save') }} {{ $product->save_percent }}%
        </span>
    @endif

    {{-- Image --}}
    <a href="{{ route('products.show', $product) }}" class="flex h-44 items-center justify-center overflow-hidden rounded-md bg-gradient-to-br from-[#fff7ee] to-[#eef7e6]">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
             class="h-[85%] w-[85%] object-contain transition duration-300 group-hover:scale-105">
    </a>

    {{-- Details --}}
    <div class="mt-3 flex flex-1 flex-col">
        @if ($product->category)
            <span class="text-[11px] font-medium uppercase tracking-wide text-[#7cb342]">{{ $product->category }}</span>
        @endif

        <h3 class="mt-0.5 line-clamp-2 min-h-[2.5rem] text-sm font-medium text-gray-800">
            <a href="{{ route('products.show', $product) }}" class="transition hover:text-[#f47b20]">{{ $product->name }}</a>
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
            <a href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode(__('I want to order:') . ' ' . $product->name) }}"
               target="_blank" rel="noopener" aria-label="WhatsApp"
               class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-[#25D366] text-white transition hover:bg-[#1da851]">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.04 2a9.9 9.9 0 0 0-8.46 15.05L2 22l5.07-1.33A9.9 9.9 0 1 0 12.04 2Zm0 1.8a8.1 8.1 0 1 1-4.13 15.06l-.3-.18-3 .79.8-2.93-.2-.31A8.1 8.1 0 0 1 12.04 3.8Zm4.66 11.43c-.25-.13-1.47-.72-1.7-.8-.23-.09-.4-.13-.56.13-.16.25-.64.8-.79.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.38-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.16-.25.25-.41.08-.16.04-.31-.02-.43-.06-.13-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43l-.48-.01c-.16 0-.43.06-.66.31-.23.25-.86.85-.86 2.07 0 1.22.89 2.4 1.01 2.56.13.16 1.75 2.67 4.23 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.1-.22-.16-.47-.29Z" />
                </svg>
            </a>
        </div>
    </div>
</div>
