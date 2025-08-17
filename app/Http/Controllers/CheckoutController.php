<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CheckoutController extends Controller
{
    public function index() {
        if(!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => route('checkout')]); // Save the checkout page's url in session
            }

            return redirect()->to('/login');
        }

        $cart_items = DB::table('cart')
                            ->join('products', 'cart.product_id', '=', 'products.id')
                            ->where('cart.cart_session_id', session()->get('cart_session_id'))
                            ->select('cart.*', 'products.name', 'products.price')
                            ->get();
        $countries = DB::table('countries')->get();
        $addresses = DB::table('addresses')->where([['user_id', Auth::user()->id]])->get();

        return view('user.checkout.checkout', compact('addresses', 'cart_items', 'countries'));
    }

    public function process_checkout(Request $request) {
        $user = Auth::user();
        $cart_items = DB::table('cart')->where('cart_session_id', Session::get('cart_session_id'))->get();
        // dd($request->all());

        $initial_validator = Validator::make($request->all(), [
            'delivery_address_option' => 'required',
        ]);

        if($initial_validator->passes()) {
            // Check if authenticated user has exceeds his/her coupon usage limit
            $coupon = DB::table('coupons')->where('id', Session::get('cart.coupon_id'))->where('status', 1)->first();
            if(!empty($coupon) && ($coupon->max_uses_per_user != null) && Auth::check()) {
                $user_coupon_used = DB::table('orders')->where([['coupon_id', $coupon->id], ['user_id', $user->id]])->count();

                if($user_coupon_used >= $coupon->max_uses_per_user) {
                    DB::table('cart')->where([['cart_session_id', Session::get('cart_session_id')], ['coupon_id', $coupon->id]])->update(['coupon_id' => null]);
                    Session::forget('cart.coupon_id');
                    Session::put('cart.discount', 0.0);

                    $total = round(Session::get('cart.subtotal') + Session::get('cart.shipping'));
                    Session::put('cart.total', $total);

                    return redirect()->route('checkout')->with('error', "We're sorry, but the coupon you applied has been deactivated. It looks like you've already used this coupon the maximum number of times allowed for your account.");
                }
            }

            if($request->delivery_address_option == 'new') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:3',
                    'mobile' => 'required|numeric|digits:10',
                    'address' => 'required',
                    'landmark' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'zip' => 'required|numeric|digits:6',
                    'country' => 'required',
                ]);

                if($validator->passes()) {
                    // Save delivery address
                    $addess_id = DB::table('addresses')->insertGetId([
                        'user_id' => $user->id,
                        'name' => $request->name,
                        'mobile' => $request->mobile,
                        'locality' => $request->locality,
                        'address' => $request->address,
                        'landmark' => $request->landmark,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'is_default' => '0',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    // Save order
                    $order_id = DB::table('orders')->insertGetId([
                        'unique_oid' => 'LE-XXXX',
                        'user_id' => $user->id,
                        'subtotal' => Session::get('cart.subtotal'),
                        'shipping' => Session::get('cart.shipping'),
                        'discount' => Session::get('cart.discount'),
                        'coupon_id' => Session::has('cart.coupon_id') ? Session::get('cart.coupon_id') : null,
                        'total' => Session::get('cart.total'),
                        'name' => $request->name,
                        'mobile' => $request->mobile,
                        'locality' => $request->locality,
                        'address' => $request->address,
                        'landmark' => $request->landmark,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'status' => 'ORD',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    DB::table('orders')->where('id', $order_id)->update(['unique_oid' => 'LE-' . rand(10000, 99999) . '-' . $order_id . '-' . rand(0, 99)]);

                    // Save order items
                    foreach($cart_items as $cart_item) {
                        DB::table('order_items')->insert([
                            'product_id' => $cart_item->product_id,
                            'order_id' => $order_id,
                            'cart_id' => $cart_item->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }

                    // Save transaction
                    $transaction_id = null;
                    if($request->checkout_payment_method == 'COD') {
                        DB::table('transactions')->insert([
                            'user_id' => $user->id,
                            'order_id' => $order_id,
                            'mode' => $request->checkout_payment_method,
                            'status' => 'PEND', // Initially pending
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    else {

                    }

                    // Destroy cart/checkout related data from session
                    Session::forget('cart');

                    $order_id = Crypt::encryptString($order_id);
                    return redirect()->route('thank_you', compact('order_id'));
                }
                else {
                    // dd($validator->errors());
                    return redirect()->route('checkout')->withErrors($validator)->withInput();
                }
            }
            else {
                $selected_address = DB::table('addresses')->where('id', $request->delivery_address_option)->first();

                // Save order
                $order_id = DB::table('orders')->insertGetId([
                    'unique_oid' => 'LE-XXXX',
                    'user_id' => $user->id,
                    'subtotal' => Session::get('cart.subtotal'),
                    'shipping' => Session::get('cart.shipping'),
                    'discount' => Session::get('cart.discount'),
                    'coupon_id' => Session::has('cart.coupon_id') ? Session::get('cart.coupon_id') : null,
                    'total' => Session::get('cart.total'),
                    'name' => $selected_address->name,
                    'mobile' => $selected_address->mobile,
                    'locality' => $selected_address->locality,
                    'address' => $selected_address->address,
                    'landmark' => $selected_address->landmark,
                    'city' => $selected_address->city,
                    'state' => $selected_address->state,
                    'country' => $selected_address->country,
                    'zip' => $selected_address->zip,
                    'status' => 'ORD',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                DB::table('orders')->where('id', $order_id)->update(['unique_oid' => 'LE-' . rand(10000, 99999) . '-' . $order_id . '-' . rand(0, 99)]);

                // Save order items
                foreach($cart_items as $cart_item) {
                    DB::table('order_items')->insert([
                        'product_id' => $cart_item->product_id,
                        'order_id' => $order_id,
                        'cart_id' => $cart_item->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }

                // Save transaction
                $transaction_id = null;
                if($request->checkout_payment_method == 'COD') {
                    DB::table('transactions')->insert([
                        'user_id' => $user->id,
                        'order_id' => $order_id,
                        'mode' => $request->checkout_payment_method,
                        'status' => 'PEND', // Initially pending
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
                else {

                }

                // Destroy cart/checkout related data from session
                Session::forget('cart');

                $order_id = Crypt::encryptString($order_id);
                return redirect()->route('thank_you', compact('order_id'));
            }
        }
        else {
            // dd($validator->errors());
            return redirect()->route('checkout')->withErrors($initial_validator);
        }
    }

    public function thank_you(Request $request) {
        $this_order_id = null;

        try {
            $this_order_id = Crypt::decryptString($request->order_id);
        }
        catch (DecryptException $e) {
            return redirect()->route('checkout')->with('error', 'Invalid order link: ' . $e->getMessage());
        }

        $order = DB::table('orders')->where('id', $this_order_id)->first();
        $transaction_details = DB::table('transactions')->where('order_id', $order->id)->first();
        $order_items = DB::table('order_items')
                            ->join('products', 'order_items.product_id', '=', 'products.id')
                            ->join('cart', 'order_items.cart_id', '=', 'cart.id')
                            ->where('order_items.order_id', $order->id)
                            ->select('products.id', 'products.slug', 'products.name', 'products.price', 'cart.qty', 'cart.id as cart_id')
                            ->get();

        // dd($order_items);

        return view('user.checkout.thank-you', compact('this_order_id', 'order', 'transaction_details', 'order_items'));
    }
}
