<?php

namespace App\Http\Controllers\Coupon;

use App\Order;
use App\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->search;
        $coupons = Coupon::all();
        if ($search) {
            $coupons->where(function ($query) use ($search) {
                $query->where('code', 'like', '%' . $search . '%');
            });
        }

        return response()->json($coupons, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type == 'percent') {
            $request->value = null;
        } else {
            $request->percent_off = null;
        }

        $this->validate($request, [
            'code' => 'unique:coupons'
        ]);
        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'percent_off' => $request->percent_off,
            'max_usage' => $request->max_usage,
            'expires_at' => $request->expires_at
        ]);

        return response()->json($coupon, 200);
    }

    public function validateCoupon($code)
    {
        $coupon = Coupon::findByCode(Str::upper($code));
        if ($coupon) {
            if ($coupon->expires_at->lt(Carbon::now())) {
                return response()->json([
                    'message' => 'Coupon Expired',
                ], 400);
            }
            if ($coupon->usage == $coupon->max_usage) {
                return response()->json([
                    'message' => 'Coupon is not active',
                ], 400);
            }

            return response()->json($coupon, 200);
        }

        return response()->json([
            'message' => 'Invalid Coupon',
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateReport()
    {
        // return Coupon::all();
        $orders = Order::where('billing_discount', '!=', 0)->where('payment_status', '=', 'success')
            ->get(['billing_email', 'invoice_code', 'billing_discount_code'])->groupBy(
                function ($item) {
                    return strtolower($item['billing_discount_code']); //$item->created_at->format($delimiter);
                }
            );
        // 'billing_discount_code');
        return $orders;
    }
}
