@extends('admin.layouts.app', ['title' => __('Add Category')])

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-[#0c3a2e]">
            &larr; {{ __('Back to categories') }}
        </a>
        <div class="mt-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.categories._form', ['submitLabel' => __('Create Category')])
            </form>
        </div>
    </div>
@endsection
