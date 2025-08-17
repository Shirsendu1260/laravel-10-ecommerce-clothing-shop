<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class ProductDetailsController extends Controller
{
    public function index($product_slug) {
        $product = DB::table('products')
                        ->join('categories', 'products.category_id', '=', 'categories.id')
                        ->join('brands', 'products.brand_id', '=', 'brands.id')
                        ->where([
                            ['products.status', 1],
                            ['products.slug', $product_slug]
                        ])
                        ->select(
                            'products.id',
                            'products.name',
                            'products.image',
                            'products.slug',
                            'products.sku',
                            'products.short_description',
                            'products.description',
                            'products.price',
                            'products.actual_price',
                            'products.qty as product_db_qty',
                            'products.available_sizes',
                            'brands.name as brand',
                            'brands.slug as brand_slug',
                            'brands.image as brand_image',
                            'categories.name as category',
                            'categories.slug as category_slug',
                        )->first();

        if (empty($product)) {
            abort(404);
        }

        $product_images = DB::table('product_gallery_images')->where('product_id', $product->id)->get();

        $user_bought_product = false;
        $user_rated_product = false;
        if (Auth::check()) {
            $user_bought_product = DB::table('products')
                                        ->join('order_items', 'order_items.product_id', '=', 'products.id')
                                        ->join('orders', 'orders.id', '=', 'order_items.order_id')
                                        ->where('orders.user_id', Auth::user()->id)
                                        ->where('products.slug', $product_slug)
                                        ->where('orders.status', 'DEL')
                                        ->exists();
            $user_rated_product = DB::table('product_ratings')->where([['product_id', $product->id], ['user_id', Auth::user()->id]])->exists();
            // dd($user_bought_product);
        }

        $product_ratings = DB::table('product_ratings')
                                    ->join('users', 'users.id', '=', 'product_ratings.user_id')
                                    ->where('product_ratings.product_id', $product->id)
                                    ->where('product_ratings.status', '1')
                                    ->select('product_ratings.*', 'users.name', 'users.gender')
                                    ->get();

        $product_ratings_count = count($product_ratings);

        $previous_product = DB::table('products')
                                        ->where([
                                            ['status', 1],
                                            ['id', '<', $product->id]
                                        ])
                                        ->orderByDesc('id')
                                        ->select('slug')
                                        ->first();

        $next_product = DB::table('products')
                                        ->where([
                                            ['status', 1],
                                            ['id', '>', $product->id]
                                        ])
                                        ->orderBy('id', 'ASC')
                                        ->select('slug')
                                        ->first();

        $related_products = DB::table('products')
                                        ->join('categories', 'categories.id', '=', 'products.category_id')
                                        ->join('brands', 'brands.id', '=', 'products.brand_id')
                                        ->where([
                                            ['products.status', 1],
                                            ['products.slug', '<>', $product_slug],
                                            ['categories.slug', $product->category_slug],
                                            ['products.is_in_stock', 1],
                                            ['products.qty', '<>', 0]
                                        ])
                                        ->limit(10)
                                        ->select(
                                            'products.id',
                                            'products.name',
                                            'products.slug',
                                            'products.price',
                                            'products.actual_price',
                                            'categories.name as category',
                                            'categories.slug as category_slug',
                                            'brands.name as brand',
                                            'brands.slug as brand_slug',
                                            'products.is_in_stock',
                                            'products.qty',
                                            'products.status',
                                            'products.created_at',
                                            'products.updated_at',
                                        )->get();

        $addon_products = DB::table('addon_products')
                                        ->join('categories', 'categories.id', '=', 'addon_products.category_id')
                                        ->join('brands', 'brands.id', '=', 'addon_products.brand_id')
                                        ->where([
                                            ['addon_products.status', 1],
                                            ['categories.slug', $product->category_slug],
                                            ['addon_products.is_in_stock', 1]
                                        ])
                                        ->select(
                                            'addon_products.id',
                                            'addon_products.name',
                                            'addon_products.image',
                                            'addon_products.slug',
                                            'addon_products.price',
                                            'categories.name as category',
                                            'categories.slug as category_slug',
                                            'brands.name as brand',
                                            'brands.slug as brand_slug',
                                            'addon_products.is_in_stock',
                                            'addon_products.qty',
                                            'addon_products.status',
                                            'addon_products.created_at',
                                            'addon_products.updated_at',
                                        )->get();

        $delivery_methods = DB::table('delivery_methods')->where('status', 1)->get();

        // dd($product->product_db_qty);
        $product_available_status = $product->product_db_qty > 0 ? true : false;
        // dd($product_available_status);

        return view('user.main.product', compact('product', 'product_images', 'user_bought_product', 'user_rated_product', 'product_ratings', 'product_ratings_count', 'previous_product', 'next_product', 'related_products', 'addon_products', 'delivery_methods', 'product_available_status'));
    }

    public function get_timeslots(Request $request) {
        $now_time = date("H:i");
        $now_date = date("Y-m-d");
        $timeslots = DB::table('delivery_timeslots')
                            ->join('delivery_methods', 'delivery_methods.id', '=', 'delivery_timeslots.delivery_method_id')
                            ->where('delivery_methods.slug', $request->method_slug)
                            ->select('delivery_timeslots.*', 'delivery_methods.name as method_name', 'delivery_methods.slug as method_slug', 'delivery_methods.price as method_cost');

        if($now_date == $request->selected_date) {
            $timeslots = $timeslots->where('delivery_timeslots.start', '>=', $now_time)->get();
            // dd(1);
        }
        else {
            $timeslots = $timeslots->orderBy('delivery_timeslots.start', 'ASC')->get();
            // dd(2);
        }

        return response()->json([
            'status' => true,
            'timeslots' => $timeslots,
        ]);
    }

    public function add_to_wishlist(Request $request) {
        $product = DB::table('products')->where('slug', $request->slug)->first();

        if(empty($product)) {
            return response()->json([
                'status' => false,
                'msg' => 'Product not found.'
            ]);
        }

        if(!Auth::check()) {
            return response()->json([
                'status' => false,
                'msg' => 'You cannot wishlist the product without logging in.'
            ]);
        }

        $is_wishlisted_already = DB::table('wishlists')->where([['product_id', $product->id], ['user_id', Auth::user()->id]])->count();

        if($is_wishlisted_already == 1) {
            return response()->json([
                'status' => false,
                'msg' => 'The product was already wishlisted.'
            ]);
        }
        else {
            $wishlist_now = DB::table('wishlists')
                                            ->insert([
                                                'product_id' => $product->id,
                                                'user_id' => Auth::user()->id,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ]);

            if($wishlist_now) {
                return response()->json([
                    'status' => true,
                    'msg' => 'The product is wishlisted successfully.'
                ]);
            }
            else {
                return response()->json([
                    'status' => false,
                    'msg' => 'Unable to add the product to wishlist.'
                ]);
            }
        }
    }

    public function remove_from_wishlist(Request $request) {
        $wishlist_data = DB::table('wishlists')->where('id', $request->id)->first();
        // dd($request->all());

        if(empty($wishlist_data)) {
            return response()->json([
                'status' => false,
                'msg' => 'Wishlist data not found.'
            ]);
        }

        $is_deleted = DB::table('wishlists')->where('id', $wishlist_data->id)->delete();

        if($is_deleted) {
            Session::flash('success', 'The product is successfully removed from wishlist.');

            return response()->json([
                'status' => true,
                'msg' => 'The product is successfully removed from wishlist.'
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'msg' => 'Failed to remove the product from wishlist, please try again later.'
            ]);
        }
    }

    public function submit_rating(Request $request, $product_slug) {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer',
            'comment' => 'nullable|min:2'
        ]);

        if($validator->passes()) {
            $rating_exists = DB::table('product_ratings')
                                    ->join('products', 'products.id', '=', 'product_ratings.product_id')
                                    ->where('products.slug', $product_slug)
                                    ->where('product_ratings.user_id', Auth::user()->id)
                                    ->exists();

            if($rating_exists) {
                return redirect()->route('product_details', $product_slug)->with('warning', "You have already rated this product before.");
            }
            else {
                $product_id = DB::table('products')->where('slug', $product_slug)->value('id');

                // Insert rating data
                DB::table('product_ratings')->insert([
                    'product_id' => $product_id,
                    'user_id' => Auth::user()->id,
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                    'status' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                return redirect()->route('product_details', $product_slug)->with('success', "Thanks! Your review has been submitted.");
            }
        }
        else {
            return redirect()->route('product_details', $product_slug)->withErrors($validator);
        }
    }
}
