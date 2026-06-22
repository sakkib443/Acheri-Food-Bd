@extends('admin.layouts.app', ['title' => __('Logo & Name')])

@section('content')
    <div class="max-w-3xl">
        <form action="{{ route('admin.site-content.branding.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Logo & Site Name') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Shown in the header, footer and admin panel.') }}</p>

                <div class="mt-6 space-y-6">
                    <div>
                        <label for="site_name" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Site Name') }}</label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', config('app.name')) }}"
                               class="w-full rounded-md border border-gray-200 px-3 py-2.5 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                        @error('site_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="logo" class="mb-1.5 block text-sm font-medium text-[#0c3a2e]">{{ __('Logo') }}</label>
                        <div class="flex items-center gap-4">
                            <span class="inline-flex shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-[#0c3a2e] p-2">
                                <img src="{{ asset(config('site.logo')) }}" alt="{{ config('app.name') }}" class="h-12 w-auto object-contain">
                            </span>
                            <input type="file" name="logo" id="logo" accept="image/*"
                                   class="block w-full text-sm text-gray-600 file:mr-3 file:rounded-md file:border-0 file:bg-[#0c3a2e] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-[#0a2f25]">
                        </div>
                        <p class="mt-1 text-xs text-gray-400">{{ __('PNG or JPG, up to 2MB. Transparent background recommended. Leave empty to keep current.') }}</p>
                        @error('logo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                {{ __('Save Changes') }}
            </button>
        </form>
    </div>
@endsection
