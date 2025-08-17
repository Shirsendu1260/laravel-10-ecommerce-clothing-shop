@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>
            {{-- {{ dd(Session::all()) }} --}}
            @if ($cart_items->isNotEmpty())
                @include('layouts.userend-alerts')
                <div class="checkout-steps pt-3">
                    <a href="{{ route('cartpage') }}" class="checkout-steps__item active">
                        <span class="checkout-steps__item-number">01</span>
                        <span class="checkout-steps__item-title">
                            <span>Shopping Bag</span>
                            <em>Manage Your Items List</em>
                        </span>
                    </a>
                    <a href="javascript:void(0)" class="checkout-steps__item">
                        <span class="checkout-steps__item-number">02</span>
                        <span class="checkout-steps__item-title">
                            <span>Shipping and Checkout</span>
                            <em>Checkout Your Items List</em>
                        </span>
                    </a>
                    <a href="javascript:void(0)" class="checkout-steps__item">
                        <span class="checkout-steps__item-number">03</span>
                        <span class="checkout-steps__item-title">
                            <span>Confirmation</span>
                            <em>Review And Submit Your Order</em>
                        </span>
                    </a>
                </div>
                <div class="shopping-cart">
                    <div class="cart-table__wrapper">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Delivery Date</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $subtotal = 0;
                                    $total_shipping_charge = 0;
                                    $discount = 0;
                                    $coupon_applied = false;
                                    $coupon_code = null;
                                    $coupon_id = null;
                                @endphp
                                @foreach ($cart_items as $cart_item)
                                    @php
                                        if(!empty($cart_item->coupon_id)) {
                                            $coupon_applied = true;
                                            $coupon_code = DB::table('coupons')->where('id', $cart_item->coupon_id)->where('status', 1)->value('code');
                                            $coupon_id = $cart_item->coupon_id;
                                        }
                                        else {
                                            $coupon_applied = false;
                                            $coupon_code = null;
                                            $coupon_id = null;
                                        }
                                    @endphp
                                    {{-- {{ dd($coupon_applied . ' ' . $coupon_code) }} --}}
                                    <tr>
                                        <td>
                                            <div class="shopping-cart__product-item">
                                                @if (!empty($cart_item->image))
                                                    <img data-lazy="{{ asset('uploads/product/thumbnails/' . $cart_item->image) }}" width="120" height="120" alt="{!! $cart_item->name !!}" class="lazy-img">
                                                @else
                                                    <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="120" height="120" alt="{!! $cart_item->name !!}" class="lazy-img">
                                                @endif
                                            </div>
                                        </td>
                                        <td style="max-width: 100px" class="pe-2">
                                            <div class="shopping-cart__product-item__detail">
                                                <h4><a href="{{ route('product_details', $cart_item->slug) }}"  class="btn-link">{!! $cart_item->name !!}</a></h4>
                                                <ul class="shopping-cart__product-item__options">
                                                    <li>Category: {{ $cart_item->category }}</li>
                                                    <li>Brand: {{ $cart_item->brand }}</li>
                                                    <li>Size: {{ strtoupper($cart_item->size) }}</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="pe-2">
                                            <span class="shopping-cart__product-price">₹{{ round($cart_item->price) }}</span>
                                        </td>
                                        <td class="pe-2">
                                            <div class="qty-control position-relative">
                                                <input type="number" name="quantity" value="{{ $cart_item->qty }}" data-cart-id="{{ $cart_item->id }}" min="1" class="qty-control__number text-center" readonly disabled>
                                                <div class="qty-control__reduce" data-cart-id="{{ $cart_item->id }}">-</div>
                                                <div class="qty-control__increase" data-cart-id="{{ $cart_item->id }}">+</div>
                                            </div>
                                        </td>
                                        <td class="pe-2">
                                            <span class="shopping-cart__product-price">{{ date('d M, Y', strtotime($cart_item->order_date)) }}</span>
                                        </td>
                                        <td class="pe-2">
                                            <span class="shopping-cart__subtotal">
                                                @php
                                                    $row_total = $cart_item->price * $cart_item->qty;
                                                    $subtotal = $subtotal + $row_total;
                                                    $total_shipping_charge = $total_shipping_charge + $cart_item->shipping_charge;
                                                    // dd($row_total);
                                                @endphp
                                                ₹{{ $row_total }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="delete-cart d-flex align-items-center" data-cart-id="{{ $cart_item->id }}">
                                                <svg width="12" height="12" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                    <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $addon_products = get_addon_products_for_cart($cart_item->id);
                                    @endphp
                                    @if ($addon_products->isNotEmpty())
                                        @foreach ($addon_products as $addon_cart_item)
                                            <tr class="border">
                                                <td>
                                                    <span class="badge bg-dark text-uppercase rounded-0 mx-2" style="font-size: 9px">Addon</span>
                                                    @if (!empty($addon_cart_item->image))
                                                        <img data-lazy="{{ asset('uploads/addon-product/thumbnails/' . $addon_cart_item->image) }}" width="70" height="70" alt="{!! $addon_cart_item->name !!}" class="lazy-img">
                                                    @else
                                                        <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="70" height="70" alt="{!! $addon_cart_item->name !!}" class="lazy-img">
                                                    @endif
                                                </td>
                                                <td style="max-width: 100px" class="pe-2">
                                                    <div class="shopping-cart__product-item__detail">
                                                        <h4><div class="btn-link" style="font-size: 14.5px">{!! $addon_cart_item->name !!}</div></h4>
                                                        <ul class="shopping-cart__product-item__options">
                                                            <li style="font-size: 12.5px">Brand: {{ $addon_cart_item->brand }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="pe-2">
                                                    <span class="shopping-cart__product-price">₹{{ round($addon_cart_item->price) }}</span>
                                                </td>
                                                <td class="pe-2">
                                                    <div class="qty-control position-relative">
                                                        <input type="number" name="quantity" value="{{ $addon_cart_item->qty }}" data-addon-cart-id="{{ $addon_cart_item->id }}" min="1" class="addon-qty-input text-center" readonly disabled>
                                                        <div class="addon-qty-minus" data-addon-cart-id="{{ $addon_cart_item->id }}">-</div>
                                                        <div class="addon-qty-plus" data-addon-cart-id="{{ $addon_cart_item->id }}">+</div>
                                                    </div>
                                                </td>
                                                <td class="pe-2"></td>
                                                <td class="pe-2">
                                                    <span class="shopping-cart__subtotal">
                                                        @php
                                                            $row_total = $addon_cart_item->price * $addon_cart_item->qty;
                                                            $subtotal = $subtotal + $row_total;
                                                            // dd($row_total);
                                                        @endphp
                                                        ₹{{ $row_total }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0)" class="delete-addon-cart d-flex align-items-center" data-addon-cart-id="{{ $addon_cart_item->id }}">
                                                        <svg width="12" height="12" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                            <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="cart-table-footer">
                            <form action="{{ route('apply_coupon') }}" class="position-relative bg-body" method="post">
                                @csrf
                                <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code" value="{{ !empty($coupon_code) ? $coupon_code : '' }}">
                                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="APPLY COUPON">
                            </form>
                        </div>
                        @if($coupon_applied == true)
                            <div class="mt-2">
                                To deactivate this coupon, click <a href="javascript::void(0)" id="deactivate-coupon" data-coupon-code="{{ $coupon_code }}" class="menu-link menu-link_us-s fw-bold text-uppercase">here</a>.
                            </div>
                        @endif
                    </div>
                    <div class="shopping-cart__totals-wrapper">
                        <div class="sticky-content">
                            <div class="shopping-cart__totals">
                                <h3>Cart Totals</h3>
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td>₹{{ $subtotal }}</td>
                                            @php
                                                Session::put('cart.subtotal', $subtotal);
                                            @endphp
                                        </tr>
                                        <tr>
                                            <th>Shipping</th>
                                            <td></td>
                                            @php
                                                Session::put('cart.shipping', $total_shipping_charge);
                                            @endphp
                                        </tr>
                                        @foreach ($cart_items as $item)
                                            <tr>
                                                <th class="fw-light text-wrap" style="font-size: 13px; padding: 5px 0;">{!! $item->name !!}</th>
                                                <td style="font-size: 13px; padding: 5px 0;">₹{{ round($item->shipping_charge) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr id="discount-div">
                                            <th>Discount</th>
                                            @php
                                                if($coupon_applied == true) {
                                                    $discount = get_discount_amount($coupon_id);
                                                }
                                                else {
                                                    $discount = 0;
                                                }

                                                Session::put('cart.discount', $discount);
                                            @endphp
                                            <td style="color: rgb(197, 81, 81)">₹<span id="discount-value">{{ round($discount) }}</span></td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #e4e4e4;"></tr>
                                        <tr>
                                            <th>Total <br><span style="font-size: 12px" class="fw-normal text-capitalize">(Tax incl.)</span></th>
                                            @php
                                                $total = round($subtotal + $total_shipping_charge - $discount);
                                                Session::put('cart.total', $total);
                                            @endphp
                                            <td>₹{{ $total }}</td>
                                        </tr>
                                        {{-- {{ dd(Session::all()) }} --}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="mobile_fixed-btn_wrapper">
                                <div class="button-wrapper container">
                                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                                </div>
                                <div class="button-wrapper container mt-3">
                                    <a href="{{ route('shop') }}" class="btn btn-checkout text-white" style="background-color: #606060">CONTINUE SHOPPING</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php
                    Session::forget('cart');
                @endphp
                <div class="d-flex justify-content-center align-items-center flex-column pb-5">
                    <img data-lazy="{{ asset('assets/user/images/404.png') }}" width="600" class="lazy-img">
                    <h4 class="mt-3 text-uppercase">Your cart is empty. Click <a href="{{ route('shop') }}" class="btn-link default-underline fw-medium">here</a> to continue Shopping.</h4>
                </div>
            @endif
        </section>
    </main>
@endsection

@push('scripts')
<script>
    function updateCartItemQty(cartId, qty) {
        if(qty >= 1) {
            $.ajax({
                url: "{{ route('update_cart_item_qty') }}",
                method: "put",
                dataType: "json",
                data: {
                    cart_id: cartId,
                    qty: qty,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.status == true) {
                        window.location.reload();
                    }
                    else {
                        Swal.fire({
                            title: "Error!",
                            text: response.msg,
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error while updating the item's quantity, please try again later.",
                        icon: "error"
                    });
                },
            });
        }
        else {
            return;
        }
    }

    function updateAddonCartItemQty(addonCartId, qty) {
        if(qty >= 1) {
            $.ajax({
                url: "{{ route('update_addon_cart_item_qty') }}",
                method: "put",
                dataType: "json",
                data: {
                    addon_cart_id: addonCartId,
                    qty: qty,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.status == true) {
                        window.location.reload();
                    }
                    else {
                        Swal.fire({
                            title: "Error!",
                            text: response.msg,
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Error while updating the addon item's quantity, please try again later.",
                        icon: "error"
                    });
                },
            });
        }
        else {
            return;
        }
    }
</script>

<script>
    $(document).ready(function() {
        // Quantity increase
        $(".qty-control__increase").click(function() {
            let cartId = $(this).data("cart-id");
            let qty = parseInt($(this).parent().children().first().val());
            // console.log(qty + " " + cartId);

            qty++;
            $(this).parent().children().first().val(qty);

            updateCartItemQty(cartId, qty);
        });

        // Quantity reduce
        $(".qty-control__reduce").click(function() {
            let cartId = $(this).data("cart-id");
            let qty = parseInt($(this).parent().children().first().val());
            // console.log(qty + " " + cartId);

            if(qty > 1) {
                qty--;
                $(this).parent().children().first().val(qty);
                updateCartItemQty(cartId, qty);
            }
            else {
                $(this).parent().children().first().val(1);
            }
        });

        // Addon quantity increase
        $(".addon-qty-plus").click(function() {
            let addonCartId = $(this).data("addon-cart-id");
            let qty = parseInt($(this).parent().children().first().val());
            // console.log(addonCartId + " " + qty);

            qty++;
            $(this).parent().children().first().val(qty);

            updateAddonCartItemQty(addonCartId, qty);
        });

        // Addon quantity reduce
        $(".addon-qty-minus").click(function() {
            let addonCartId = $(this).data("addon-cart-id");
            let qty = parseInt($(this).parent().children().first().val());
            // console.log(addonCartId + " " + qty);

            if(qty > 1) {
                qty--;
                $(this).parent().children().first().val(qty);
                updateAddonCartItemQty(addonCartId, qty);
            }
            else {
                $(this).parent().children().first().val(1);
            }
        });

        // Item deletion
        $(".delete-cart").click(function() {
            Swal.fire({
                title: "Do you really want to delete this item from cart?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                showCancelButton: true, // Show "Cancel" button
                confirmButtonColor: '#dc3545', // Red color for the "Yes, delete it!" button
                cancelButtonColor: '#1d1d1d', // Black shade
                confirmButtonText: 'Yes, delete it!', // Custom text for confirm button
            })
            .then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_cart_item') }}",
                        type: "delete",
                        dataType: "json",
                        data: {
                            cart_id: $(this).data("cart-id"),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == true) {
                                window.location.reload();
                            }
                            else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.msg,
                                    icon: "error"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Error while deleting the item from cart.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        // Addon item deletion
        $(".delete-addon-cart").click(function() {
            Swal.fire({
                title: "Do you really want to delete this addon item from cart?",
                text: "Once deleted, you will not be able to recover this addon item!",
                icon: "warning",
                showCancelButton: true, // Show "Cancel" button
                confirmButtonColor: '#dc3545', // Red color for the "Yes, delete it!" button
                cancelButtonColor: '#1d1d1d', // Black shade
                confirmButtonText: 'Yes, delete it!', // Custom text for confirm button
            })
            .then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete_addon_cart_item') }}",
                        type: "delete",
                        dataType: "json",
                        data: {
                            addon_cart_id: $(this).data("addon-cart-id"),
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == true) {
                                window.location.reload();
                            }
                            else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.msg,
                                    icon: "error"
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Error while deleting the addon item from cart.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });

        // Deactivate coupon AJAX
        $("#deactivate-coupon").click(function() {
            const couponCode = $(this).data("coupon-code");
            // console.log(couponCode);

            Swal.fire({
                title: "Do you really want to deactivate this coupon from cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#1d1d1d',
                confirmButtonText: 'Yes, deactivate it!'
            })
            .then(function(result) {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deactivate_coupon') }}",
                        type: "post",
                        dataType: "json",
                        data: {coupon_code: couponCode},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function() {
                            alert("Unable to deactivate the coupon.");
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
