<?php

use App\Http\Controllers\admin\AddonProductController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\DeliveryMethodController;
use App\Http\Controllers\admin\DeliveryTimeslotController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\ContactMessageController;
use App\Http\Controllers\admin\HomepageSliderController;
use App\Http\Controllers\admin\AdminpanelUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Routes for main website */
// For homepage and common pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('userend_search');

// For authentication related
Auth::routes();

// For shoppage
Route::get('/shop/{category_slug?}', [ShopController::class, 'index'])->name('shop');

// For product details page
Route::group(['prefix' => 'product'], function() {
    Route::get('/{product_slug}', [ProductDetailsController::class, 'index'])->name('product_details');
    Route::post('/get-timeslots', [ProductDetailsController::class, 'get_timeslots'])->name('get_timeslots');
    Route::post('/add-to-cart', [CartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::post('/add-to-wishlist', [ProductDetailsController::class, 'add_to_wishlist'])->name('add_to_wishlist');
    Route::delete('/remove-from-wishlist', [ProductDetailsController::class, 'remove_from_wishlist'])->name('remove_from_wishlist');
    Route::post('/submit_rating/{product_slug}', [ProductDetailsController::class, 'submit_rating'])->name('submit_rating');
});

// For cartpage
Route::group(['prefix' => 'cart'], function() {
    Route::get('/', [CartController::class, 'index'])->name('cartpage');
    Route::put('/update-cart-item-qty', [CartController::class, 'update_cart_item_qty'])->name('update_cart_item_qty');
    Route::delete('/delete-cart-item', [CartController::class, 'delete_cart_item'])->name('delete_cart_item');
    Route::put('/update-addon-cart-item-qty', [CartController::class, 'update_addon_cart_item_qty'])->name('update_addon_cart_item_qty');
    Route::delete('/delete-addon-cart-item', [CartController::class, 'delete_addon_cart_item'])->name('delete_addon_cart_item');
    Route::post('/apply-coupon', [CartController::class, 'apply_coupon'])->name('apply_coupon');
    Route::post('/deactivate-coupon', [CartController::class, 'deactivate_coupon'])->name('deactivate_coupon');
});

// For checkout related
Route::group(['middleware' => 'checkout_check'], function() {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process_checkout'])->name('process_checkout');
});
Route::get('/thank-you', [CheckoutController::class, 'thank_you'])->name('thank_you')->middleware('auth');

// For static pages
Route::get('/about-us', [StaticPagesController::class, 'about_us'])->name('about_us');
Route::get('/affiliates', [StaticPagesController::class, 'affiliates'])->name('affiliates');
Route::get('/contact-us', [StaticPagesController::class, 'contact_us'])->name('contact_us');
Route::post('/contact-us', [StaticPagesController::class, 'process_contact_us'])->name('send_contact_us_form');
Route::get('/legal-and-privacy', [StaticPagesController::class, 'legal_and_privacy'])->name('legal_and_privacy');
Route::get('/privacy-policy', [StaticPagesController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms-and-conditions', [StaticPagesController::class, 'terms_and_conditions'])->name('terms_and_conditions');

// For wishlist page
Route::get('/wishlist', [UserController::class, 'wishlist'])->name('wishlist');


/* Routes for user account */
Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('user_dashboard');
        Route::get('/orders', [UserController::class, 'orders'])->name('user_orders');
        Route::get('/orders/{unique_oid}', [UserController::class, 'order'])->name('user_order');
        Route::put('/orders/cancel', [UserController::class, 'cancel_order'])->name('cancel_order');
        Route::get('/account-details', [UserController::class, 'account_details'])->name('account_details');
        Route::put('/account-details', [UserController::class, 'update_account_details'])->name('update_account_details');
        Route::put('/change-password', [UserController::class, 'change_password'])->name('change_password');
        Route::get('/addresses', [UserController::class, 'addresses'])->name('addresses');
        Route::get('/addresses/create', [UserController::class, 'create_address'])->name('create_address');
        Route::post('/addresses/store', [UserController::class, 'store_address'])->name('store_address');
        Route::post('/addresses/make-default', [UserController::class, 'make_default_address'])->name('make_default_address');
        Route::get('/addresses/edit/{address_id}', [UserController::class, 'edit_address'])->name('edit_address');
        Route::put('/addresses/update/{address_id}', [UserController::class, 'update_address'])->name('update_address');
    });
});



/* Routes for admin panel */
Route::group(['prefix' => 'admin'], function () {
    // // Unauthenticated routes for anyone
    // Route::group(['middleware' => 'guest'], function () {
    // });

    // Authenticated routes for admin
    Route::group(['middleware' => 'admin.auth'], function () {
        // For dashboard and common pages
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');
        Route::get('/account-details', [AdminController::class, 'account_details'])->name('admin_account_details');
        Route::put('/account-details', [AdminController::class, 'update_account_details'])->name('admin_update_account_details');
        Route::put('/change-password', [AdminController::class, 'change_password'])->name('admin_change_password');
        Route::get('/search', [AdminController::class, 'search'])->name('admin_search');

        // For temporary images
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp_image_create');
        Route::post('/upload-temp-images', [TempImagesController::class, 'images_create'])->name('temp_images_create');
        Route::post('/delete-temp-image', [TempImagesController::class, 'delete'])->name('temp_image_delete');

        // For brands
        Route::get('/brands', [BrandController::class, 'index'])->name('admin_brands_index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('admin_brand_create_page');
        Route::post('/brands/create', [BrandController::class, 'store'])->name('admin_brand_create');
        Route::get('/brands/edit/{brand_slug}', [BrandController::class, 'edit'])->name('admin_brand_edit_page');
        Route::put('/brands/update/{brand_slug}', [BrandController::class, 'update'])->name('admin_brand_edit');
        Route::delete('/brands/destroy/{brand_slug}', [BrandController::class, 'destroy'])->name('admin_brand_destroy');
        Route::post('/brands/delete-brand-image/{brand_slug}', [BrandController::class, 'delete_brand_image'])->name('brand_image_delete');

        // For categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin_categories_index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin_category_create_page');
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('admin_category_create');
        Route::get('/categories/edit/{category_slug}', [CategoryController::class, 'edit'])->name('admin_category_edit_page');
        Route::put('/categories/update/{category_slug}', [CategoryController::class, 'update'])->name('admin_category_edit');
        Route::delete('/categories/destroy/{category_slug}', [CategoryController::class, 'destroy'])->name('admin_category_destroy');
        Route::post('/categories/delete-category-image/{category_slug}', [CategoryController::class, 'delete_category_image'])->name('category_image_delete');

        // For delivery methods
        Route::get('/delivery-methods', [DeliveryMethodController::class, 'index'])->name('admin_delivery_methods_index');
        Route::get('/delivery-methods/create', [DeliveryMethodController::class, 'create'])->name('admin_delivery_method_create_page');
        Route::post('/delivery-methods/create', [DeliveryMethodController::class, 'store'])->name('admin_delivery_method_create');
        Route::get('/delivery-methods/edit/{delivery_method_slug}', [DeliveryMethodController::class, 'edit'])->name('admin_delivery_method_edit_page');
        Route::put('/delivery-methods/update/{delivery_method_slug}', [DeliveryMethodController::class, 'update'])->name('admin_delivery_method_edit');
        Route::delete('/delivery-methods/destroy/{delivery_method_slug}', [DeliveryMethodController::class, 'destroy'])->name('admin_delivery_method_destroy');

        // For coupons
        Route::get('/coupons', [CouponController::class, 'index'])->name('admin_coupons_index');
        Route::get('/coupons/create', [CouponController::class, 'create'])->name('admin_coupon_create_page');
        Route::post('/coupons/create', [CouponController::class, 'store'])->name('admin_coupon_create');
        Route::get('/coupons/edit/{coupon_id}', [CouponController::class, 'edit'])->name('admin_coupon_edit_page');
        Route::put('/coupons/update/{coupon_id}', [CouponController::class, 'update'])->name('admin_coupon_edit');
        Route::delete('/coupons/destroy/{coupon_id}', [CouponController::class, 'destroy'])->name('admin_coupon_destroy');

        // For delivery timeslots
        Route::get('/delivery-timeslots', [DeliveryTimeslotController::class, 'index'])->name('admin_delivery_timeslots_index');
        Route::get('/delivery-timeslots/create', [DeliveryTimeslotController::class, 'create'])->name('admin_delivery_timeslot_create_page');
        Route::post('/delivery-timeslots/create', [DeliveryTimeslotController::class, 'store'])->name('admin_delivery_timeslot_create');
        Route::get('/delivery-timeslots/edit/{delivery_timeslot_slug}', [DeliveryTimeslotController::class, 'edit'])->name('admin_delivery_timeslot_edit_page');
        Route::put('/delivery-timeslots/update/{delivery_timeslot_slug}', [DeliveryTimeslotController::class, 'update'])->name('admin_delivery_timeslot_edit');
        Route::delete('/delivery-timeslots/destroy/{delivery_timeslot_slug}', [DeliveryTimeslotController::class, 'destroy'])->name('admin_delivery_timeslot_destroy');

        // For products
        Route::get('/products', [ProductController::class, 'index'])->name('admin_products_index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('admin_product_create_page');
        Route::post('/products/create', [ProductController::class, 'store'])->name('admin_product_create');
        Route::get('/products/view/{product_slug}', [ProductController::class, 'view'])->name('admin_product_view_page');
        Route::get('/products/edit/{product_slug}', [ProductController::class, 'edit'])->name('admin_product_edit_page');
        Route::put('/products/update/{product_slug}', [ProductController::class, 'update'])->name('admin_product_edit');
        Route::delete('/products/destroy/{product_slug}', [ProductController::class, 'destroy'])->name('admin_product_destroy');
        Route::post('/products/delete-product-image/{product_slug}', [ProductController::class, 'delete_product_image'])->name('product_image_delete');
        Route::post('/products/delete-product-gallery-image/{product_gal_img_id}', [ProductController::class, 'delete_product_gallery_image'])->name('product_gallery_image_delete');

        // For addon products
        Route::get('/addon-products', [AddonProductController::class, 'index'])->name('admin_addon_products_index');
        Route::get('/addon-products/create', [AddonProductController::class, 'create'])->name('admin_addon_product_create_page');
        Route::post('/addon-products/create', [AddonProductController::class, 'store'])->name('admin_addon_product_create');
        Route::get('/addon-products/view/{addon_product_slug}', [AddonProductController::class, 'view'])->name('admin_addon_product_view_page');
        Route::get('/addon-products/edit/{addon_product_slug}', [AddonProductController::class, 'edit'])->name('admin_addon_product_edit_page');
        Route::put('/addon-products/update/{addon_product_slug}', [AddonProductController::class, 'update'])->name('admin_addon_product_edit');
        Route::delete('/addon-products/destroy/{addon_product_slug}', [AddonProductController::class, 'destroy'])->name('admin_addon_product_destroy');
        Route::post('/addon-products/delete-addon-product-image/{addon_product_slug}', [AddonProductController::class, 'delete_addon_product_image'])->name('addon_product_image_delete');

        // For orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin_orders_index');
        Route::get('/orders/view/{id}', [OrderController::class, 'view'])->name('admin_order_view_page');
        Route::put('/orders/update-delivered-date', [OrderController::class, 'update_delivered_date'])->name('admin_update_delivered_date');

        // For contact messages
        Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('admin_contact_messages_index');
        Route::get('/contact-messages/details/{id}', [ContactMessageController::class, 'details'])->name('admin_contact_messages_details_page');
        Route::post('/contact-messages/reply/{id}', [ContactMessageController::class, 'reply'])->name('admin_reply_contact_message');

        // For homepage slides
        Route::get('/slides', [HomepageSliderController::class, 'index'])->name('admin_slides_index');
        Route::get('/slides/create', [HomepageSliderController::class, 'create'])->name('admin_slide_create_page');
        Route::post('/slides/create', [HomepageSliderController::class, 'store'])->name('admin_slide_create');
        Route::get('/slides/edit/{slide_id}', [HomepageSliderController::class, 'edit'])->name('admin_slide_edit_page');
        Route::put('/slides/update/{slide_id}', [HomepageSliderController::class, 'update'])->name('admin_slide_edit');
        Route::delete('/slides/destroy/{slide_id}', [HomepageSliderController::class, 'destroy'])->name('admin_slide_destroy');
        Route::post('/slides/delete-slide-image/{slide_id}', [HomepageSliderController::class, 'delete_slide_image'])->name('slide_image_delete');

        // For users
        Route::get('/users', [AdminpanelUserController::class, 'index'])->name('admin_users_index');
        Route::put('/users/block/{user_id}', [AdminpanelUserController::class, 'block'])->name('admin_user_block');
        Route::put('/users/unblock/{user_id}', [AdminpanelUserController::class, 'unblock'])->name('admin_user_unblock');
    });
});
