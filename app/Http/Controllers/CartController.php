<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    public function index() {
        // Get cart items for the current session
        $cart_items = DB::table('cart')
                        ->join('products', 'products.id', '=', 'cart.product_id')
                        ->join('categories', 'categories.id', '=', 'products.category_id')
                        ->join('brands', 'brands.id', '=', 'products.brand_id')
                        ->join('delivery_methods', 'delivery_methods.id', '=', 'cart.delivery_method_id')
                        ->where('cart_session_id', Session::get('cart_session_id'))
                        ->select(
                            'cart.id',
                            'products.slug',
                            'products.image',
                            'products.name',
                            'products.price',
                            'cart.size',
                            'cart.qty',
                            'cart.order_date',
                            'cart.coupon_id',
                            'delivery_methods.price as shipping_charge',
                            'brands.name as brand',
                            'categories.name as category',
                        )
                        ->orderBy('cart.id', 'ASC')
                        ->get();

        $coupon = null;
        if(Session::has('cart.coupon_id')) {
            $coupon = DB::table('coupons')->where('id', Session::get('cart.coupon_id'))->where('status', 1)->first();

            // Check if authenticated user has exceeds his/her coupon usage limit
            if(!empty($coupon) && ($coupon->max_uses_per_user != null) && Auth::check()) {
                $user_coupon_used = DB::table('orders')->where([['coupon_id', $coupon->id], ['user_id', Auth::user()->id]])->count();

                if($user_coupon_used >= $coupon->max_uses_per_user) {
                    DB::table('cart')->where([['cart_session_id', Session::get('cart_session_id')], ['coupon_id', $coupon->id]])->update(['coupon_id' => null]);
                    Session::forget('cart.coupon_id');
                    Session::put('cart.discount', 0.0);

                    $total = round(Session::get('cart.subtotal') + Session::get('cart.shipping'));
                    Session::put('cart.total', $total);

                    return redirect()->route('cartpage')->with('error', 'Maximum limit reached. You cannot use the coupon anymore.');
                }
            }
        }

        return view('user.checkout.cart', compact('cart_items'));
    }

    public function add_to_cart(Request $request) {
        $product = DB::table('products')->where('slug', $request->product_slug)->select('id', 'name')->first();
        $qty = $request->product_qty;
        $size = $request->product_size;
        $order_date = $request->selected_date;
        $delivery_method = DB::table('delivery_methods')->where('slug', $request->selected_method)->first();
        $delivery_timeslot = DB::table('delivery_timeslots')->where('slug', $request->selected_timeslot)->first();
        $status = null;
        $msg = '';
        $cart_id = null;
        // dd($request->all());

        if(empty($product)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'msg' => 'Product not found.'
            ]);
        }

        if(empty($size)) {
            return response()->json([
                'status' => false,
                'msg' => 'The product size was not selected, please select it to proceed.',
            ]);
        }

        if(empty($order_date)) {
            return response()->json([
                'status' => false,
                'msg' => 'The order date was not selected, please select it to proceed.',
            ]);
        }

        if(empty($delivery_method)) {
            return response()->json([
                'status' => false,
                'msg' => 'The delivery method was not selected, please select it to proceed.',
            ]);
        }

        if(empty($delivery_timeslot)) {
            return response()->json([
                'status' => false,
                'msg' => 'The delivery timeslot was not selected, please select it to proceed.',
            ]);
        }

        // Create session id for the current session for 'Add to Cart' process of the product
        $cart_session_id = '';
        if (empty(Session::get('cart_session_id'))) {
            $cart_session_id = md5(uniqid(rand(), true));
            Session::put('cart_session_id', $cart_session_id);
        } else {
            $cart_session_id = Session::get('cart_session_id');
        }

        // Get cart items for the current session
        $cart_items = DB::table('cart')->where('cart_session_id', $cart_session_id)->get();

        // If coupon was already applied to any of the previously added cart items, get it
        $applied_coupon_id = null;
        $applied_coupon_cart_row = DB::table('cart')->where([['cart_session_id', $cart_session_id], ['coupon_id', '<>', null]])->first();
        if(!empty($applied_coupon_cart_row)) {
            $applied_coupon_id = $applied_coupon_cart_row->coupon_id;
        }
        // dd($applied_coupon_cart_row);

        // If the cart has some items
        if($cart_items->isNotEmpty()) {
            $product_already_in_cart = false;

            foreach($cart_items as $item) {
                // If the product already exists in cart
                if($item->product_id == $product->id) {
                    $product_already_in_cart = true;
                }
            }

            // If the product does not exist in the cart, then add the product to cart
            if($product_already_in_cart == false) {
                // Insert product to cart
                $cart_id = DB::table('cart')->insertGetId([
                    'cart_session_id' => $cart_session_id,
                    'product_id' => $product->id,
                    'size' => $size,
                    'qty' => $qty,
                    'coupon_id' => $applied_coupon_id,
                    'order_date' => $order_date,
                    'delivery_method_id' => $delivery_method->id,
                    'delivery_timeslot_id' => $delivery_timeslot->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Insert addon products (if available) to addon's cart
                if($request->addon_products != []) {
                    foreach($request->addon_products as $addon_product) {
                        $addon_product_data = DB::table('addon_products')->where('slug', $addon_product['addonSlug'])->select('id')->first();

                        DB::table('addon_cart')->insert([
                            'addon_product_id' => $addon_product_data->id,
                            'qty' => $addon_product['addonQty'],
                            'cart_id' => $cart_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }

                $status = true;
                $msg = "'" . $product->name . "' is successfully added to cart.";

                Session::flash('success', $msg);
            }
            // If the product exists in the cart
            else {
                $status = false;
                $msg = "'" . $product->name . "' was already there in cart.";
            }
        }
        // If cart is empty
        else {
            // Insert product to cart
            $cart_id = DB::table('cart')->insertGetId([
                'cart_session_id' => $cart_session_id,
                'product_id' => $product->id,
                'size' => $size,
                'qty' => $qty,
                'coupon_id' => $applied_coupon_id,
                'order_date' => $order_date,
                'delivery_method_id' => $delivery_method->id,
                'delivery_timeslot_id' => $delivery_timeslot->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insert addon products (if available) to addon's cart
            if($request->addon_products != []) {
                foreach($request->addon_products as $addon_product) {
                    $addon_product_data = DB::table('addon_products')->where('slug', $addon_product['addonSlug'])->select('id')->first();

                    DB::table('addon_cart')->insert([
                        'addon_product_id' => $addon_product_data->id,
                        'qty' => $addon_product['addonQty'],
                        'cart_id' => $cart_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            $status = true;
            $msg = "'" . $product->name . "' is successfully added to cart.";

            Session::flash('success', $msg);
        }

        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    public function update_cart_item_qty(Request $request) {
        $product = DB::table('cart')
                        ->join('products', 'cart.product_id', '=', 'products.id')
                        ->where('cart.id', $request->cart_id)
                        ->select('products.qty')
                        ->first();

        // Check if the requested quantity is available for the product
        if($request->qty <= $product->qty) {
            $qty_update = DB::table('cart')->where('id', $request->cart_id)->update(['qty' => $request->qty]);

            if($qty_update) {
                Session::flash('success', 'The item\'s quantity is updated successfully.');

                return response()->json([
                    'status' => true,
                    'msg' => 'The item\'s quantity is updated successfully.',
                ]);
            }
            else {
                return response()->json([[
                    'status' => false,
                    'msg' => 'Unable to update the item\'s quantity.',
                ]]);
            }
        }
        else {
            Session::flash('error', 'Requested quantity (' . $request->qty . ') is unavailable at this moment.');

            return response()->json([
                'status' => false,
                'msg' => 'Requested quantity (' . $request->qty . ') is unavailable at this moment.',
            ]);
        }
    }

    public function update_addon_cart_item_qty(Request $request) {
        $addon_product = DB::table('addon_cart')
                        ->join('addon_products', 'addon_cart.addon_product_id', '=', 'addon_products.id')
                        ->where('addon_cart.id', $request->addon_cart_id)
                        ->select('addon_products.qty')
                        ->first();

        // Check if the requested quantity is available for the product
        if($request->qty <= $addon_product->qty) {
            $qty_update = DB::table('addon_cart')->where('id', $request->addon_cart_id)->update(['qty' => $request->qty]);

            // dd($qty_update);

            if($qty_update) {
                Session::flash('success', 'The addon item\'s quantity is updated successfully.');

                return response()->json([
                    'status' => true,
                    'msg' => 'The addon item\'s quantity is updated successfully.',
                ]);
            }
            else {
                return response()->json([[
                    'status' => false,
                    'msg' => 'Unable to update the addon item\'s quantity.',
                ]]);
            }
        }
        else {
            Session::flash('error', 'Requested quantity (' . $request->qty . ') is unavailable at this moment.');

            return response()->json([
                'status' => false,
                'msg' => 'Requested quantity (' . $request->qty . ') is unavailable at this moment.',
            ]);
        }
    }

    public function delete_cart_item(Request $request) {
        $is_deleted = DB::table('cart')->where('id', $request->cart_id)->delete();

        if($is_deleted) {
            Session::flash('success', 'The item is successfully deleted from cart.');

            return response()->json([
                'status' => true,
                'msg' => 'The item is successfully deleted from cart.',
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'msg' => 'Unable to delete the item from cart.',
            ]);
        }
    }

    public function delete_addon_cart_item(Request $request) {
        $is_deleted = DB::table('addon_cart')->where('id', $request->addon_cart_id)->delete();

        if($is_deleted) {
            Session::flash('success', 'The addon item is successfully deleted from cart.');

            return response()->json([
                'status' => true,
                'msg' => 'The addon item is successfully deleted from cart.',
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'msg' => 'Unable to delete the addon item from cart.',
            ]);
        }
    }

    public function apply_coupon(Request $request) {
        $coupon = DB::table('coupons')->where('code', $request->coupon_code)->where('status', 1)->first();

        if(empty($coupon)) {
            return redirect()->route('cartpage')->with('error', 'This coupon code does not exist.');
        }

        $subtotal = get_subtotal();
        $now = Carbon::now();

        // Check if the coupon's start date is valid or not
        if($coupon->starts_at != '') {
            $starts_at = Carbon::createFromFormat('Y-m-d', $coupon->starts_at);

            if($now->lt($starts_at)) {
                return redirect()->route('cartpage')->with('error', 'Invalid coupon (Invalid starting date).');
            }
        }

        // Check if the coupon's expiry date is valid or not
        if($coupon->expires_at != '') {
            $expires_at = Carbon::createFromFormat('Y-m-d', $coupon->expires_at);

            if($now->gt($expires_at)) {
                return redirect()->route('cartpage')->with('error', 'Invalid coupon (Coupon expired).');
            }
        }

        // Check how many times this coupon is used
        if($coupon->max_uses != null) {
            $coupon_used = DB::table('orders')->where('coupon_id', $coupon->id)->count();

            if($coupon_used >= $coupon->max_uses) {
                return redirect()->route('cartpage')->with('error', 'Invalid coupon (Maximum limit reached).');
            }
        }

        // Check if authenticated user has exceeds his/her coupon usage limit
        if(($coupon->max_uses_per_user != null) && Auth::check()) {
            $user_coupon_used = DB::table('orders')->where([['coupon_id', $coupon->id], ['user_id', Auth::user()->id]])->count();

            if($user_coupon_used >= $coupon->max_uses_per_user) {
                DB::table('cart')->where([['cart_session_id', Session::get('cart_session_id')], ['coupon_id', $coupon->id]])->update(['coupon_id' => null]);

                return redirect()->route('cartpage')->with('error', 'Maximum limit reached. You cannot use the coupon anymore.');
            }
        }

        // Minimum amount condition
        if($coupon->min_cart_amount != null) {
            if ($subtotal < $coupon->min_cart_amount) {
                return redirect()->route('cartpage')->with('error', 'Sorry! This coupon can be applied only when the subtotal is above ' . round($coupon->min_cart_amount) . ' Rs.');
            }
        }

        // Apply discount
        DB::table('cart')->where('cart_session_id', Session::get('cart_session_id'))->update(['coupon_id' => $coupon->id]);

        // Save in session
        Session::put('cart.coupon_id', $coupon->id);

        return redirect()->route('cartpage')->with('success', 'Coupon applied successfully.');
    }

    public function deactivate_coupon(Request $request) {
        $coupon = DB::table('coupons')->where('code', $request->coupon_code)->where('status', 1)->first();

        if(empty($coupon)) {
            Session::flash('error', 'Error occurred, coupon not found.');

            return response()->json([
                'status' => false,
            ]);
        }

        $coupon_deactivated = DB::table('cart')
                                        ->where([
                                            ['cart_session_id', Session::get('cart_session_id')],
                                            ['coupon_id', $coupon->id]
                                        ])
                                        ->update(['coupon_id' => null]);

        // Destroy from session
        Session::forget('cart.coupon_id');

        if($coupon_deactivated) {
            Session::flash('success', 'Coupon deactivated successfully.');

            return response()->json([
                'status' => true,
            ]);
        }
        else {
            Session::flash('error', 'Unable to deactivate the coupon as the coupon was not applied before.');

            return response()->json([
                'status' => false,
            ]);
        }
    }
}
