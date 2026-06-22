@extends('admin.layouts.app', ['title' => __('Settings')])

@section('content')
    <div class="max-w-3xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Contact --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Contact Information') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Shown in the footer and used for WhatsApp order links.') }}</p>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Phone') }}</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', config('site.phone')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                    <div>
                        <label for="whatsapp" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('WhatsApp Number') }}</label>
                        <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', config('site.whatsapp')) }}" placeholder="8801XXXXXXXXX"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                        <p class="mt-1 text-xs text-gray-400">{{ __('Country code, no + or spaces (e.g. 8801712345678)') }}</p>
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Email') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email', config('site.email')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="address" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Address') }}</label>
                        <input type="text" name="address" id="address" value="{{ old('address', config('site.address')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                </div>
            </div>

            {{-- Delivery --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Delivery') }}</h2>
                <div class="mt-5 max-w-xs">
                    <label for="delivery_charge" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Delivery Charge (৳)') }}</label>
                    <input type="number" name="delivery_charge" id="delivery_charge" value="{{ old('delivery_charge', config('site.delivery_charge')) }}" min="0"
                           class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    @error('delivery_charge') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Social --}}
            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Social Links') }}</h2>
                <div class="mt-5 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="facebook" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Facebook URL') }}</label>
                        <input type="text" name="facebook" id="facebook" value="{{ old('facebook', config('site.social.facebook')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                    <div>
                        <label for="instagram" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Instagram URL') }}</label>
                        <input type="text" name="instagram" id="instagram" value="{{ old('instagram', config('site.social.instagram')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                    <div>
                        <label for="youtube" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('YouTube URL') }}</label>
                        <input type="text" name="youtube" id="youtube" value="{{ old('youtube', config('site.social.youtube')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                    </div>
                </div>
            </div>

            <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                {{ __('Save Settings') }}
            </button>
        </form>
    </div>
@endsection
