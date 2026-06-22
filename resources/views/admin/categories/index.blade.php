@extends('admin.layouts.app', ['title' => __('Categories')])

@section('content')
    <div class="mb-5 flex items-center justify-between">
        <p class="text-sm text-gray-500">{{ $categories->count() }} {{ __('categories') }}</p>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-md bg-[#f47b20] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            {{ __('Add Category') }}
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        @if ($categories->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('Category') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Slug') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Products') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Order') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Status') }}</th>
                            <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <span class="flex items-center gap-2.5 font-medium text-[#0c3a2e]">
                                        @if ($category->image)
                                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="h-9 w-9 shrink-0 rounded-md border border-gray-100 object-cover">
                                        @else
                                            <span class="flex h-9 w-9 items-center justify-center text-xl leading-none">{{ $category->emoji }}</span>
                                        @endif
                                        {{ $category->name }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $category->slug }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $category->products_count }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $category->sort_order }}</td>
                                <td class="px-5 py-3">
                                    @if ($category->is_active)
                                        <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">{{ __('Active') }}</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-500">{{ __('Hidden') }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('Edit') }}</a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('Delete this category?') }}');">
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
        @else
            <div class="px-5 py-16 text-center">
                <p class="text-sm text-gray-500">{{ __('No categories yet.') }}</p>
                <a href="{{ route('admin.categories.create') }}" class="mt-4 inline-block rounded-md bg-[#f47b20] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#dd6c14]">{{ __('Add your first category') }}</a>
            </div>
        @endif
    </div>
@endsection
