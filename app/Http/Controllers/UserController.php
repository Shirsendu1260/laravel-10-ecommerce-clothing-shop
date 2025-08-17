<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.account.dashboard');
    }

    public function wishlist(Request $request) {
        $products = DB::table('wishlists')
                            ->join('products', 'wishlists.product_id', '=', 'products.id')
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->join('brands', 'brands.id', '=', 'products.brand_id')
                            ->select(
                                'wishlists.id as wishlist_id',
                                'products.id',
                                'products.name',
                                'products.sku',
                                'products.slug',
                                'products.price',
                                'products.actual_price',
                                'categories.name as category',
                                'categories.slug as category_slug',
                                'brands.name as brand',
                                'brands.slug as brand_slug',
                                'products.is_featured',
                                'products.is_in_stock',
                                'products.qty',
                                'products.status',
                                'products.created_at',
                                'products.updated_at',
                            )
                            ->where('user_id', Auth::user()->id);

        $products = $products->paginate(perPage: 6);

        // For AJAX request of loading more wishlisted products (pagination) on infinite scroll
        if($request->ajax()) {
            $wishlisted_products_html = view('user.main.wishlisted-products-con', compact('products'))->render();

            return response()->json([
                'status' => true,
                'wishlisted_products_html' => $wishlisted_products_html,
                'wishlisted_products_has_more_pages' => $products->hasMorePages(),
            ]);
        }

        return view('user.account.wishlist', compact('products'));
    }

    public function orders() {
        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5);

        return view('user.account.orders', compact('orders'));
    }

    public function order($unique_oid) {
        $order = DB::table('orders')->where('unique_oid', $unique_oid)->first();

        if(empty($order)) {
            abort(404);
        }

        $order_items = DB::table('order_items')
                            ->join('cart', 'cart.id', '=', 'order_items.cart_id')
                            ->join('products', 'products.id', '=', 'order_items.product_id')
                            ->join('brands', 'brands.id', '=', 'products.brand_id')
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->where('order_items.order_id', $order->id)
                            ->select('order_items.cart_id', 'order_items.delivered_date', 'products.id as product_id', 'products.slug', 'products.name', 'products.image', 'products.price', 'products.sku', 'cart.qty', 'brands.name as brand', 'categories.name as category')
                            ->paginate(3);

        $transaction_details = DB::table('transactions')->where('order_id', $order->id)->first();

        return view('user.account.order', compact('order', 'order_items', 'transaction_details'));
    }

    public function cancel_order(Request $request) {
        $order = DB::table('orders')->where('unique_oid', $request->unique_oid)->first();

        if(empty($order)) {
            Session::flash('error', 'Order data not found.');
            return response()->json(['status' => false]);
        }

        $update_row = DB::table('orders')->where('unique_oid', $request->unique_oid)->update([
            'status' => 'CANC',
            'cancelled_date' => Carbon::now(),
        ]);

        // If payment method is COD, then cancel the transaction
        $payment_method = DB::table('transactions')->where('order_id', $order->id)->value('mode');
        if($payment_method == 'COD') {
            DB::table('transactions')->where('order_id', $order->id)->update(['status' => 'DEC']);
        }

        if($update_row) {
            Session::flash('success', 'You have successfully cancelled the order.');
            return response()->json(['status' => true]);
        }
        else {
            Session::flash('error', 'Unable to cancel the order, please try again later.');
            return response()->json(['status' => false]);
        }
    }

    public function addresses() {
        $addresses = DB::table('addresses')->where('user_id', Auth::user()->id)->get();

        return view('user.account.addresses', compact('addresses'));
    }

    public function make_default_address(Request $request) {
        $address = DB::table('addresses')->where('id', $request->address_id)->first();

        if(empty($address)) {
            Session::flash('error', 'Address not found.');

            return response()->json([
                'status' => false,
                'msg' => 'Address not found.'
            ]);
        }

        // Make this address default
        DB::table('addresses')->where('id', $address->id)->update(['is_default' => '1']);

        // Make all other addresses non-default
        DB::table('addresses')->where('id', '<>', $address->id)->update(['is_default' => '0']);

        Session::flash('success', 'Default address is chosen successfully.');

        return response()->json([
            'status' => true,
        ]);
    }

    public function create_address() {
        $countries = DB::table('countries')->get();

        return view('user.account.create_address', compact('countries'));
    }

    public function store_address(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'mobile' => 'required|numeric|digits:10',
            'address' => 'required',
            'landmark' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric|digits:6',
            'country' => 'required',
            'is_default' => 'sometimes|integer|in:1'
        ]);

        if($validator->passes()) {
            $address_id = DB::table('addresses')->insertGetId([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'locality' => $request->locality,
                'address' => $request->address,
                'landmark' => $request->landmark,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip' => $request->zip,
                'is_default' => !empty($request->is_default) ? $request->is_default : '0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // If the address is set to default, set other addresses to non-default
            if(!empty($request->is_default)) {
                DB::table('addresses')->where('id', '<>', $address_id)->update(['is_default' => '0']);
            }

            return redirect()->route('addresses')->with('success', 'Address created successfully.');
        }
        else {
            return redirect()->route('create_address')->withErrors($validator)->withInput();
        }
    }

    public function edit_address($address_id) {
        $countries = DB::table('countries')->get();
        $address = DB::table('addresses')->where('id', $address_id)->first();

        if(empty($address)) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        return view('user.account.edit_address', compact('countries', 'address'));
    }

    public function update_address(Request $request, $address_id) {
        $address = DB::table('addresses')->where('id', $address_id)->first();

        if(empty($address)) {
            return redirect()->route('addresses')->with('error', 'Address not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'mobile' => 'required|numeric|digits:10',
            'address' => 'required',
            'landmark' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric|digits:6',
            'country' => 'required',
            'is_default' => 'sometimes|integer|in:1'
        ]);

        if($validator->passes()) {
            DB::table('addresses')
                    ->where('id', $address->id)
                    ->update([
                        'user_id' => Auth::user()->id,
                        'name' => $request->name,
                        'mobile' => $request->mobile,
                        'locality' => $request->locality,
                        'address' => $request->address,
                        'landmark' => $request->landmark,
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'is_default' => !empty($request->is_default) ? $request->is_default : '0',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

            // If the address is set to default, set other addresses to non-default
            if(!empty($request->is_default)) {
                DB::table('addresses')->where('id', '<>', $address_id)->update(['is_default' => '0']);
            }

            return redirect()->route('addresses')->with('success', 'Address updated successfully.');
        }
        else {
            return redirect()->route('create_address')->withErrors($validator)->withInput();
        }
    }

    public function account_details() {
        $user = Auth::user();
        $countries = DB::table('countries')->get();

        return view('user.account.account-details', compact('user', 'countries'));
    }

    public function update_account_details(Request $request) {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id . ',id',
            'gender' => 'required|in:M,F,O',
            'phonecode' => 'required',
            'mobile' => 'required|digits:10|numeric',
        ]);

        if($validator->passes()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phonecode = $request->phonecode;
            $user->mobile = $request->mobile;
            $user->save();

            return redirect()->route('account_details')->with('success', 'Your account details are updated successfully.');
        }
        else {
            return redirect()->route('account_details')->withErrors($validator);
        }
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->passes()) {
            $user = Auth::user();

            // If entered old password is incorrect with the actual old password stored in the database
            if (!Hash::check($request->old_password, $user->password)) {
                session()->flash('error', 'This does not match your old password, please try again.');

                return response()->json([
                    'status' => true,
                ]);
            }
            // If entered old password is correct with the actual old password stored in the database
            else {
                if ($request->old_password == $request->new_password) {
                    return response()->json([
                        'status' => false,
                        'msg' => [
                            'new_password' => 'The new password cannot be same as the old password.',
                        ],
                    ]);
                } else {
                    $user->password = Hash::make($request->new_password);
                    $user->save();

                    session()->flash('success', 'Password changed successfully.');

                    return response()->json([
                        'status' => true,
                        'msg' => 'Password changed successfully.',
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors(),
            ]);
        }
    }
}
