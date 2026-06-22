@extends('admin.layouts.app', ['title' => __('Hero Banners')])

@section('content')
    @php $hero = config('site.hero', []); @endphp
    <div class="max-w-3xl">
        <form action="{{ route('admin.site-content.hero.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-gray-100 bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[#0c3a2e]">{{ __('Home Hero Banners') }}</h2>
                <p class="text-sm text-gray-500">{{ __('The two banners shown at the top of the home page.') }}</p>

                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    @foreach ([1, 2] as $i)
                        @php
                            $img = $hero[$i - 1]['image'] ?? null;
                            $link = $hero[$i - 1]['link'] ?? '/products';
                        @endphp
                        <div class="rounded-lg border border-gray-100 bg-gray-50 p-4">
                            <h3 class="text-sm font-semibold text-[#0c3a2e]">{{ __('Banner') }} {{ $i }}</h3>

                            @if ($img)
                                <img src="{{ asset($img) }}" alt="Banner {{ $i }}" class="mt-3 w-full rounded-md border border-gray-200 object-cover">
                            @else
                                <div class="mt-3 flex h-24 items-center justify-center rounded-md border border-dashed border-gray-300 text-xs text-gray-400">{{ __('No image yet') }}</div>
                            @endif

                            <div class="mt-3">
                                <label for="hero_{{ $i }}" class="mb-1 block text-xs font-medium text-gray-600">{{ __('Upload new image') }}</label>
                                <input type="file" name="hero_{{ $i }}" id="hero_{{ $i }}" accept="image/*"
                                       class="block w-full text-xs text-gray-600 file:mr-2 file:rounded file:border-0 file:bg-[#0c3a2e] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                                @error('hero_'.$i) <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="mt-3">
                                <label for="hero_{{ $i }}_link" class="mb-1 block text-xs font-medium text-gray-600">{{ __('Link (when clicked)') }}</label>
                                <input type="text" name="hero_{{ $i }}_link" id="hero_{{ $i }}_link" value="{{ old('hero_'.$i.'_link', $link) }}" placeholder="/products"
                                       class="w-full rounded-md border border-gray-200 px-3 py-2 text-sm focus:border-[#0c3a2e]/30 focus:outline-none focus:ring-2 focus:ring-[#0c3a2e]/15">
                            </div>
                        </div>
                    @endforeach
                </div>

                <p class="mt-4 text-xs text-gray-400">{{ __('Tip: Banner 1 is wider (left), Banner 2 is smaller (right). Use similar ratios to your current banners for the best look.') }}</p>
            </div>

            <button type="submit" class="rounded-md bg-[#f47b20] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
                {{ __('Save Changes') }}
            </button>
        </form>
    </div>
@endsection
