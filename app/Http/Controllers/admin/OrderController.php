<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    public function index(Request $request) {
        $orders = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.user_id')
                        ->orderByDesc('orders.id')
                        ->select('orders.*', 'users.name as customer_name');

        if (!empty($request->get('search'))) {
            $orders = $orders->where('orders.unique_oid', 'like', '%' . $request->get('search') . '%');
            $orders = $orders->orWhere('orders.name', 'like', '%' . $request->get('search') . '%');
            $orders = $orders->orWhere('users.name', 'like', '%' . $request->get('search') . '%');
        }

        $orders = $orders->paginate(perPage: 7);
        // dd($orders);

        return view('admin.order.index', compact('orders'));
    }

    public function view($order_id) {
        $order = DB::table('orders')->where('id', $order_id)->first();

        if(empty($order)) {
            abort(404);
        }

        $order_items = DB::table('order_items')
                            ->join('cart', 'cart.id', '=', 'order_items.cart_id')
                            ->join('products', 'products.id', '=', 'order_items.product_id')
                            ->join('brands', 'brands.id', '=', 'products.brand_id')
                            ->join('categories', 'categories.id', '=', 'products.category_id')
                            ->where('order_items.order_id', $order->id)
                            ->select('order_items.id', 'order_items.cart_id', 'order_items.delivered_date', 'cart.order_date', 'products.id as product_id', 'products.slug', 'products.name', 'products.image', 'products.price', 'products.sku', 'cart.qty', 'brands.name as brand', 'categories.name as category')
                            ->paginate(3);

        $transaction_details = DB::table('transactions')->where('order_id', $order->id)->first();

        return view('admin.order.details', compact('order', 'order_items', 'transaction_details'));
    }

    public function update_delivered_date(Request $request) {
        $order_item = DB::table('order_items')
                            ->join('products', 'products.id', '=', 'order_items.product_id')
                            ->where('order_items.id', $request->del_item_id)
                            ->select('order_items.*', 'products.name')
                            ->first();

        if(empty($order_item)) {
            Session::flash('error', 'Order item data not found.');
            return response()->json(['status' => false]);
        }

        $order_id = $order_item->order_id;

        // Update delivery date
        $update_row = DB::table('order_items')->where('id', $request->del_item_id)->update(['delivered_date' => $request->del_datetime]);

        // Code for updating ordered item's stock quantity
        $order_item_qty = DB::table('cart')->where('id', $order_item->cart_id)->value('qty');
        $product_stock_qty = DB::table('products')->where('id', $order_item->product_id)->value('qty');
        $updated_qty = $product_stock_qty - $order_item_qty;
        DB::table('products')->where('id', $order_item->product_id)->update(['qty' => $updated_qty]);

        // Code for updating addon item's stock quantity
        $addon_items = DB::table('addon_cart')->where('cart_id', $order_item->cart_id)->get();
        foreach($addon_items as $addon_item) {
            $addon_item_qty = $addon_item->qty;
            $addon_stock_qty = DB::table('addon_products')->where('id', $addon_item->addon_product_id)->value('qty');
            $updated_addon_qty = $addon_stock_qty - $addon_item_qty;
            DB::table('addon_products')->where('id', $addon_item->addon_product_id)->update(['qty' => $updated_addon_qty]);
        }

        // After updating delivery date, count how many order items are yet to be delivered
        $count = DB::table('order_items')->where([['order_id', $order_id], ['delivered_date', null]])->count();

        // If all items are delivered, change the order status to DEL (Delivered)
        if($count == 0) {
            DB::table('orders')->where('id', $order_id)->update(['status' => 'DEL']);

            // Update the transaction data for successful payment on COD order
            DB::table('transactions')->where([['order_id', $order_id], ['mode', 'COD']])->update(['status' => 'APP']);
        }

        if($update_row) {
            Session::flash('success', "Delivery date has been updated for " . "'" . $order_item->name . "'.");
            return response()->json(['status' => true]);
        }
        else {
            Session::flash('error', 'Unable to update the order date, please try again later.');
            return response()->json(['status' => false]);
        }
    }
}
