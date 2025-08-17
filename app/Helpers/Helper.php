<?php

use Illuminate\Support\Facades\DB;

function count_products_by_brand($brand_id) {
    $count = DB::table('products')->where('brand_id', $brand_id)->count();
    return $count;
}

function count_products_by_category($category_id) {
    $count = DB::table('products')->where('category_id', $category_id)->count();
    return $count;
}

function get_product_gallery_images($product_slug) {
    return DB::table('product_gallery_images')
        ->join('products', 'products.id', '=', 'product_gallery_images.product_id')
        ->where('products.slug', $product_slug)
        ->select('product_gallery_images.id', 'product_gallery_images.name')
        ->get();
}

function get_addon_products_for_cart($cart_id) {
    return DB::table('addon_cart')
                ->join('addon_products', 'addon_cart.addon_product_id', '=', 'addon_products.id')
                ->join('brands', 'brands.id', '=', 'addon_products.brand_id')
                ->where('addon_cart.cart_id', $cart_id)
                ->select('addon_products.image', 'addon_products.name', 'addon_products.slug', 'addon_products.price', 'addon_cart.qty', 'brands.name as brand', 'addon_cart.id')
                ->get();
}

function get_subtotal() {
    $cart_subtotal = DB::table('cart')
                            ->join('products', 'products.id', '=', 'cart.product_id')
                            ->where('cart.cart_session_id', Session::get('cart_session_id'))
                            ->sum(DB::raw('products.price * cart.qty'));

    $addon_cart_subtotal = DB::table('addon_cart')
                                ->join('cart', 'cart.id', '=', 'addon_cart.cart_id')
                                ->join('addon_products', 'addon_products.id', '=', 'addon_cart.addon_product_id')
                                ->where('cart.cart_session_id', Session::get('cart_session_id'))
                                ->sum(DB::raw('addon_products.price * addon_cart.qty'));

    $subtotal = $cart_subtotal + $addon_cart_subtotal;
    // dd($subtotal);

    return $subtotal;
}

function get_discount_amount($coupon_id) {
    $coupon = DB::table('coupons')->where('id', $coupon_id)->where('status', 1)->first();
    $discount = 0;
    $subtotal = get_subtotal();

    if(empty($coupon)) {
        $discount = 0;
    }

    if($coupon->type == 'fixed') {
        $discount = $coupon->discount;
    }
    else {
        $discount = $subtotal * ($coupon->discount / 100);
    }

    return round($discount);
}

function get_addon_cart_items($cart_id) {
    return DB::table('addon_cart')
                ->join('addon_products', 'addon_cart.addon_product_id', '=', 'addon_products.id')
                ->where('addon_cart.cart_id', $cart_id)
                ->select('addon_cart.qty', 'addon_products.price', 'addon_products.name')
                ->get();
}

function total_orders_count() {
    return DB::table('orders')->count();
}

function total_orders_amount() {
    return round(DB::table('orders')->sum('total'));
}

function total_pending_orders_count() {
    return DB::table('orders')->where('status', 'ORD')->count();
}

function total_pending_orders_amount() {
    return round(DB::table('orders')->where('status', 'ORD')->sum('total'));
}

function total_delivered_orders_count() {
    return DB::table('orders')->where('status', 'DEL')->count();
}

function total_delivered_orders_amount() {
    return round(DB::table('orders')->where('status', 'DEL')->sum('total'));
}

function total_cancelled_orders_count() {
    return DB::table('orders')->where('status', 'CANC')->count();
}

function total_cancelled_orders_amount() {
    return round(DB::table('orders')->where('status', 'CANC')->sum('total'));
}

function total_order_items_count($order_id) {
    $items_count = DB::table('order_items')->where('order_id', $order_id)->count();
    $addon_items_count = DB::table('addon_cart')
                                ->join('cart', 'cart.id', '=', 'addon_cart.cart_id')
                                ->join('order_items', 'order_items.cart_id', '=', 'cart.id')
                                ->where('order_items.order_id', $order_id)
                                ->count();

    return $items_count + $addon_items_count;
}

function non_replied_contact_msgs_count() {
    return DB::table('contact_us')->where('is_replied', '0')->count();
}

function get_product_avg_rating($product_id) {
    return DB::table('product_ratings')->where('product_id', $product_id)->avg('rating');
}

function product_review_count($product_id) {
    return DB::table('product_ratings')->where('product_id', $product_id)->count();
}

?>
