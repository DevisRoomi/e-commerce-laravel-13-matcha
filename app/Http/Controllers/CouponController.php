<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function coupons()
    {
        $coupons = Coupon::orderBy('expiry_date', 'desc')->paginate(12);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
            'status' => 'nullable|boolean',
        ]);

        $coupon = new Coupon();
        $coupon->code = strtoupper(trim($request->code));
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->status = $request->has('status') ? 1 : 0;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Kupon baru berhasil ditambahkan!');
    }

    public function coupon_edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function coupon_update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'cart_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
            'status' => 'nullable|boolean',
        ]);

        $coupon->code = strtoupper(trim($request->code));
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->status = $request->has('status') ? 1 : 0;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Kupon berhasil diperbarui!');
    }

    public function coupon_delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons')->with('status', 'Kupon berhasil dihapus!');
    }
}
