@extends('admin.layouts.app', ['title' => __('Products')])

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $products->total() }} {{ __('products') }}</p>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            {{ __('Add Product') }}
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        @if ($products->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('Product') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Category') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Price') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Stock') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Flags') }}</th>
                            <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset($product->image) }}" alt="" class="h-10 w-10 shrink-0 rounded-md border border-gray-100 object-contain">
                                        <span class="font-medium text-[#0c3a2e]">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($product->category)
                                        <span class="rounded-full bg-[#7cb342]/15 px-2.5 py-0.5 text-xs font-medium text-[#5a8a2c]">{{ $product->category }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-semibold text-[#f47b20]">৳{{ number_format($product->price) }}</span>
                                    @if ($product->old_price)
                                        <span class="ml-1 text-xs text-gray-400 line-through">৳{{ number_format($product->old_price) }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    @if ($product->stock > 0)
                                        <span class="text-gray-600">{{ $product->stock }}</span>
                                    @else
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-600">{{ __('Out') }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if ($product->is_top_selling)<span class="rounded bg-blue-100 px-1.5 py-0.5 text-[10px] font-semibold text-blue-700">{{ __('Top') }}</span>@endif
                                        @if ($product->is_best_selling)<span class="rounded bg-red-100 px-1.5 py-0.5 text-[10px] font-semibold text-red-700">{{ __('Best') }}</span>@endif
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('products.show', $product) }}" target="_blank" rel="noopener" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-500 transition hover:bg-gray-50" title="{{ __('View') }}">{{ __('View') }}</a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('Edit') }}</a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('{{ __('Delete this product?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        @else
            <div class="px-5 py-16 text-center">
                <p class="text-sm text-gray-500">{{ __('No products yet.') }}</p>
                <a href="{{ route('admin.products.create') }}" class="mt-4 inline-block rounded-md bg-[#f47b20] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Add your first product') }}</a>
            </div>
        @endif
    </div>
@endsection
