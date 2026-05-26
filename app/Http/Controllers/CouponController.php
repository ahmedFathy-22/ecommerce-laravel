<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $coupon = Coupon::where(
            'code',
            $request->code
        )->first();

        if (!$coupon) {

            return back()->with(
                'error',
                'Invalid coupon ❌'
            );
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount,
            'type' => $coupon->type
        ]);

        return back()->with(
            'success',
            'Coupon applied ✅'
        );
    }
    public function remove()
    {
        session()->forget('coupon');

        return back()->with(
            'success',
            'Coupon removed ✅'
        );
    }
}
