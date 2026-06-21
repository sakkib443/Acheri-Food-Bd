@extends('admin.layouts.app', ['title' => __('Dashboard')])

@section('content')
    @php
        $cards = [
            ['label' => __('Total Products'),  'value' => $stats['products'],    'color' => '#f47b20', 'icon' => 'm21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
            ['label' => __('Categories'),      'value' => $stats['categories'],  'color' => '#7cb342', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z'],
            ['label' => __('Best Selling'),    'value' => $stats['bestSelling'], 'color' => '#e74c3c', 'icon' => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z'],
            ['label' => __('Out of Stock'),    'value' => $stats['outOfStock'],  'color' => '#6b7280', 'icon' => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'],
        ];
    @endphp

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
        @foreach ($cards as $card)
            <div class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg" style="background-color: {{ $card['color'] }}1a; color: {{ $card['color'] }};">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-bold text-[#0c3a2e]">{{ $card['value'] }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $card['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            {{ __('Add Product') }}
        </a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-md border border-[#0c3a2e]/20 px-5 py-2.5 text-sm font-semibold text-[#0c3a2e] transition hover:bg-[#0c3a2e] hover:text-white">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            {{ __('Add Category') }}
        </a>
    </div>

    {{-- Recent products --}}
    <div class="mt-6 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Recent Products') }}</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm font-semibold text-[#f47b20] hover:text-[#dd6c14]">{{ __('View all') }} →</a>
        </div>
        @if ($recentProducts->count())
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 font-medium">{{ __('Product') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('Category') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('Price') }}</th>
                        <th class="px-5 py-3 font-medium">{{ __('Stock') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($product->image) }}" alt="" class="h-9 w-9 rounded-md object-contain">
                                    <span class="font-medium text-[#0c3a2e]">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $product->category ?: '—' }}</td>
                            <td class="px-5 py-3 font-semibold text-[#f47b20]">৳{{ number_format($product->price) }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $product->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="px-5 py-8 text-center text-sm text-gray-500">{{ __('No products yet.') }}</p>
        @endif
    </div>
@endsection
