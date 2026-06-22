<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="code" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Coupon Code') }} <span class="text-red-500">*</span></label>
        <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" required placeholder="SAVE20"
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm uppercase focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="type" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Discount Type') }} <span class="text-red-500">*</span></label>
        <select name="type" id="type"
                class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
            <option value="fixed" @selected(old('type', $coupon->type) === 'fixed')>{{ __('Fixed amount (৳)') }}</option>
            <option value="percent" @selected(old('type', $coupon->type) === 'percent')>{{ __('Percentage (%)') }}</option>
        </select>
        @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="value" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Discount Value') }} <span class="text-red-500">*</span></label>
        <input type="number" name="value" id="value" value="{{ old('value', $coupon->value) }}" min="1" required
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        <p class="mt-1 text-xs text-gray-400">{{ __('e.g. 20 = ৳20 off or 20% off depending on type') }}</p>
        @error('value') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="min_order_amount" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Minimum Order (৳)') }}</label>
        <input type="number" name="min_order_amount" id="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? 0) }}" min="0"
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        @error('min_order_amount') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="usage_limit" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Usage Limit') }}</label>
        <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1" placeholder="{{ __('Unlimited') }}"
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        @error('usage_limit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="expires_at" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Expiry Date') }}</label>
        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}"
               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
        @error('expires_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
</div>

<label class="mt-5 flex items-center gap-2.5 text-sm text-gray-700">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $coupon->is_active ?? true))
           class="h-4 w-4 rounded border-gray-300 text-[#0c3a2e] focus:ring-[#0c3a2e]/30">
    {{ __('Active') }}
</label>

<div class="mt-7 flex items-center gap-3">
    <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
        {{ $submitLabel ?? __('Save') }}
    </button>
    <a href="{{ route('admin.coupons.index') }}" class="rounded-md border border-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
        {{ __('Cancel') }}
    </a>
</div>
