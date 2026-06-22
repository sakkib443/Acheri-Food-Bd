@extends('admin.layouts.app', ['title' => __('Customers')])

@section('content')
    <div class="mb-5">
        <p class="text-sm text-gray-500">{{ $customers->count() }} {{ __('customers') }}</p>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm">
        @if ($customers->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-medium">{{ __('Customer') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Phone') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Orders') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Total Spent') }}</th>
                            <th class="px-5 py-3 font-medium">{{ __('Last Order') }}</th>
                            <th class="px-5 py-3 text-right font-medium">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($customers as $customer)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0c3a2e]/10 text-sm font-semibold text-[#0c3a2e]">{{ \Illuminate\Support\Str::of($customer->customer_name)->substr(0, 1)->upper() }}</span>
                                        <div>
                                            <span class="block font-medium text-[#0c3a2e]">{{ $customer->customer_name }}</span>
                                            @if ($customer->email)<span class="block text-xs text-gray-500">{{ $customer->email }}</span>@endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $customer->phone }}</td>
                                <td class="px-5 py-3 text-gray-600">{{ $customer->orders_count }}</td>
                                <td class="px-5 py-3 font-semibold text-[#f47b20]">৳{{ number_format($customer->total_spent) }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ \Illuminate\Support\Carbon::parse($customer->last_order)->format('d M Y') }}</td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.customers.show', $customer->phone) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-[#0c3a2e] transition hover:bg-gray-50">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="px-5 py-16 text-center text-sm text-gray-500">{{ __('No customers yet.') }}</p>
        @endif
    </div>
@endsection
