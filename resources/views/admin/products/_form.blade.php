@php $catNames = $categories->pluck('name'); @endphp

<div class="grid gap-6 lg:grid-cols-3">
    {{-- Left: main fields --}}
    <div class="space-y-5 lg:col-span-2">
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Product Name') }} <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Description') }}</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">{{ old('description', $product->description) }}</textarea>
            @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
            <div>
                <label for="price" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Price') }} (৳) <span class="text-red-500">*</span></label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" required
                       class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="old_price" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Old Price') }} (৳)</label>
                <input type="number" name="old_price" id="old_price" value="{{ old('old_price', $product->old_price) }}" min="0"
                       class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                @error('old_price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="stock" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Stock') }} <span class="text-red-500">*</span></label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}" min="0" required
                       class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                @error('stock') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Right: meta --}}
    <div class="space-y-5">
        <div>
            <label for="category" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Category') }}</label>
            <select name="category" id="category"
                    class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                <option value="">{{ __('— Select category —') }}</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->name }}" @selected(old('category', $product->category) === $cat->name)>{{ $cat->emoji }} {{ $cat->name }}</option>
                @endforeach
                @if ($product->category && ! $catNames->contains($product->category))
                    <option value="{{ $product->category }}" selected>{{ $product->category }} ({{ __('current') }})</option>
                @endif
            </select>
            @error('category') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Image') }}</label>
            @if ($product->image)
                <img src="{{ asset($product->image) }}" alt="" class="mb-2 h-24 w-24 rounded-md border border-gray-200 object-contain p-1">
            @endif
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-[#0c3a2e] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
            <p class="mt-1 text-xs text-gray-400">{{ $product->exists ? __('Leave empty to keep current image.') : __('PNG, JPG or SVG. Max 4MB.') }}</p>
            @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="sort_order" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Sort Order') }}</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0"
                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
            @error('sort_order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2.5 rounded-lg border border-gray-100 bg-gray-50 p-4">
            <label class="flex items-center gap-2.5 text-sm text-gray-700">
                <input type="hidden" name="is_top_selling" value="0">
                <input type="checkbox" name="is_top_selling" value="1" @checked(old('is_top_selling', $product->is_top_selling))
                       class="h-4 w-4 rounded border-gray-300 text-[#0c3a2e] focus:ring-[#0c3a2e]/30">
                {{ __('Top Selling (home section)') }}
            </label>
            <label class="flex items-center gap-2.5 text-sm text-gray-700">
                <input type="hidden" name="is_best_selling" value="0">
                <input type="checkbox" name="is_best_selling" value="1" @checked(old('is_best_selling', $product->is_best_selling))
                       class="h-4 w-4 rounded border-gray-300 text-[#0c3a2e] focus:ring-[#0c3a2e]/30">
                {{ __('Best Selling (badge)') }}
            </label>
        </div>
    </div>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
        {{ $submitLabel ?? __('Save') }}
    </button>
    <a href="{{ route('admin.products.index') }}" class="rounded-md border border-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
        {{ __('Cancel') }}
    </a>
</div>
