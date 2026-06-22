<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create', ['coupon' => new Coupon(['type' => 'fixed', 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        Coupon::create($this->validateData($request));

        return redirect()->route('admin.coupons.index')->with('success', __('Coupon created successfully.'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->validateData($request, $coupon->id));

        return redirect()->route('admin.coupons.index')->with('success', __('Coupon updated successfully.'));
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->with('success', __('Coupon deleted.'));
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($ignoreId)],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'integer', 'min:1'],
            'min_order_amount' => ['nullable', 'integer', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
