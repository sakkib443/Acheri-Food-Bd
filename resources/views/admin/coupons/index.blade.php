@extends('admin.layouts.app', ['title' => __('Coupons')])

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $coupons->total() }} {{ __('coupons') }}</p>
        <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            {{ __('Add Coupon') }}
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        @if ($coupons->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('Code') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Discount') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Min Order') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Usage') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Expiry') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                            <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($coupons as $coupon)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3"><span class="rounded bg-[#0c3a2e]/5 px-2 py-1 font-mono text-xs font-semibold text-[#0c3a2e]">{{ $coupon->code }}</span></td>
                                <td class="px-5 py-3 font-semibold text-[#f47b20]">{{ $coupon->type === 'percent' ? $coupon->value.'%' : '৳'.number_format($coupon->value) }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $coupon->min_order_amount ? '৳'.number_format($coupon->min_order_amount) : '—' }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $coupon->used_count }}{{ $coupon->usage_limit ? ' / '.$coupon->usage_limit : '' }}</td>
                                <td class="px-5 py-3 text-gray-600">
                                    @if ($coupon->expires_at)
                                        <span class="{{ $coupon->expires_at->endOfDay()->isPast() ? 'text-red-500' : '' }}">{{ $coupon->expires_at->format('d M Y') }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    @if ($coupon->is_active)
                                        <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">{{ __('Active') }}</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500">{{ __('Inactive') }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('Edit') }}</a>
                                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('{{ __('Delete this coupon?') }}');">
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
            @if ($coupons->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">{{ $coupons->onEachSide(1)->links() }}</div>
            @endif
        @else
            <div class="px-5 py-16 text-center">
                <p class="text-sm text-gray-500">{{ __('No coupons yet.') }}</p>
                <a href="{{ route('admin.coupons.create') }}" class="mt-4 inline-block rounded-md bg-[#f47b20] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Create your first coupon') }}</a>
            </div>
        @endif
    </div>
@endsection
