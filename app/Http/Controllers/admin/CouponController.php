<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class CouponController extends Controller
{
    public function index(Request $request) {
        $coupons = DB::table('coupons')->orderByDesc('id');

        if (!empty($request->get('search'))) {
            $coupons = $coupons->where('code', 'like', '%' . $request->get('search') . '%');
            $coupons = $coupons->orWhere('discount', 'like', '%' . $request->get('search') . '%');
        }

        $coupons = $coupons->paginate(perPage: 7);
        // dd($coupons);

        return view('admin.coupon.index', compact('coupons'));
    }

    public function create() {
        return view('admin.coupon.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            "code" => "required|unique:coupons",
            "description" => "nullable|string",
            "max_uses" => "nullable|integer",
            "max_uses_per_user" => "nullable|integer",
            "type" => "required|in:fixed,percent",
            "discount" => "required|numeric",
            "min_cart_amount" => "required|numeric",
            "starts_at" => "required|date_format:Y-m-d|after_or_equal:today|before_or_equal:expires_at",
            "expires_at" => "required|date_format:Y-m-d|after_or_equal:starts_at",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('coupons')->insert([
                'code' => $request->code,
                'description' => $request->description,
                'max_uses' => $request->max_uses,
                'max_uses_per_user' => $request->max_uses_per_user,
                'type' => $request->type,
                'discount' => $request->discount,
                'min_cart_amount' => $request->min_cart_amount,
                'starts_at' => $request->starts_at,
                'expires_at' => $request->expires_at,
                'status' => $request->status,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            return redirect()->route('admin_coupons_index')->with('success', "Coupon created successfully.");
        } else {
            return redirect()->route('admin_coupon_create_page')->withErrors($validator)->withInput();
        }
    }

    public function edit($coupon_code_id) {
        $coupon = DB::table('coupons')->where('id', $coupon_code_id)->first();

        if (empty($coupon)) {
            return redirect()->route('admin_coupons_index')->with("error", "Coupon not found.");
        }

        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $coupon_code_id) {
        $coupon = DB::table('coupons')->where('id', $coupon_code_id)->first();
        // dd($request->all());

        if (empty($coupon)) {
            return redirect()->route('admin_coupons_index')->with("error", "Coupon not found.");
        }

        $validator = Validator::make($request->all(), [
            "code" => "required|unique:coupons,code," . $coupon->id . ",id",
            "description" => "nullable|string",
            "max_uses" => "nullable|integer",
            "max_uses_per_user" => "nullable|integer",
            "type" => "required|in:fixed,percent",
            "discount" => "required|numeric",
            "min_cart_amount" => "required|numeric",
            "starts_at" => "required|date_format:Y-m-d|before_or_equal:expires_at",
            "expires_at" => "required|date_format:Y-m-d|after_or_equal:starts_at",
            "status" => "required|in:1,0",
        ]);

        if ($validator->passes()) {
            DB::table('coupons')
                ->where('id', $coupon_code_id)
                ->update([
                    'code' => $request->code,
                    'description' => $request->description,
                    'max_uses' => $request->max_uses,
                    'max_uses_per_user' => $request->max_uses_per_user,
                    'type' => $request->type,
                    'discount' => $request->discount,
                    'min_cart_amount' => $request->min_cart_amount,
                    'starts_at' => $request->starts_at,
                    'expires_at' => $request->expires_at,
                    'status' => $request->status,
                    'updated_at' => Carbon::now(),
                ]);

            return redirect()->route('admin_coupons_index')->with('success', "Coupon updated successfully.");
        } else {
            return redirect()->route('admin_coupon_edit_page', $coupon->id)->withErrors($validator)->withInput();
        }
    }

    public function destroy($coupon_code_id) {
        $coupon = DB::table('coupons')->where('id', $coupon_code_id)->first();

        if (empty($coupon)) {
            session()->flash("error", "Coupon not found.");

            return response()->json([
                'status' => false,
                'msg' => 'Coupon not found.',
            ]);
        }

        DB::table('coupons')->where('id', $coupon_code_id)->delete();

        session()->flash("success", "Coupon deleted successfully.");

        return response()->json([
            'status' => true,
            'msg' => 'Coupon deleted successfully.',
        ]);
    }
}
