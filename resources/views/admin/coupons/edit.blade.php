@extends('admin.layouts.app', ['title' => __('Edit Coupon')])

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.coupons.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-[#0c3a2e]">
            &larr; {{ __('Back to coupons') }}
        </a>
        <div class="mt-4 rounded-xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.coupons._form', ['submitLabel' => __('Update Coupon')])
            </form>
        </div>
    </div>
@endsection
