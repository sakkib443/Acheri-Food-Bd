<div class="space-y-5">
    <div>
        <label for="name" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Category Name') }} <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="emoji" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Emoji / Icon') }}</label>
            <input type="text" name="emoji" id="emoji" value="{{ old('emoji', $category->emoji) }}" maxlength="16" placeholder="🥭"
                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-lg focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
            @error('emoji') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="sort_order" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Sort Order') }}</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0"
                   class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
            @error('sort_order') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <label class="flex items-center gap-2.5 text-sm text-gray-700">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))
               class="h-4 w-4 rounded border-gray-300 text-[#0c3a2e] focus:ring-[#0c3a2e]/30">
        {{ __('Active (show on the website)') }}
    </label>
</div>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
        {{ $submitLabel ?? __('Save') }}
    </button>
    <a href="{{ route('admin.categories.index') }}" class="rounded-md border border-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
        {{ __('Cancel') }}
    </a>
</div>
