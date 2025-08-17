@extends('layouts.app')

@section('content')
    @php
        Session::forget('cart');
        Session::forget('cart_session_id');
    @endphp
    {{-- {{ dd(Session::all()) }} --}}
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Order Received</h2>
            <div class="checkout-steps">
                <a href="{{ route('cartpage') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript::void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript::void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z" fill="white" />
                    </svg>
                    <h3>Your order is completed!</h3>
                    <p>Thank you. Your order has been received.</p>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label class="text-center">Order Number</label>
                        <span class="text-center">{{ $order->unique_oid }}</span>
                    </div>
                    <div class="order-info__item">
                        <label class="text-center">Date</label>
                        <span class="text-center">{{ date('d M, Y, h:m a', strtotime($order->created_at)) }}</span>
                    </div>
                    <div class="order-info__item">
                        <label class="text-center">Total</label>
                        <span class="text-center">₹{{ round($order->total) }}</span>
                    </div>
                    <div class="order-info__item">
                        <label class="text-center">Payment Method</label>
                        <span class="text-center">{{ $transaction_details->mode == 'COD' ? 'Cash On Delivery' : 'PhonePe' }}</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        @if ($order_items->isNotEmpty())
                            <h3>Order Details</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th align="right">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_items as $order_item)
                                        <tr>
                                            <td>{!! $order_item->name !!} x {{ $order_item->qty }}</td>
                                            <td align="right">₹{{ $order_item->price * $order_item->qty }}</td>
                                        </tr>
                                        @php
                                            $addon_order_items = get_addon_cart_items($order_item->cart_id);
                                            // dd($addon_order_items);
                                        @endphp
                                        @if ($addon_order_items->isNotEmpty())
                                            @foreach ($addon_order_items as $addon_order_item)
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;-- {!! $addon_order_item->name !!} x {{ $addon_order_item->qty }}</td>
                                                    <td align="right">₹{{ $addon_order_item->price * $addon_order_item->qty }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>SUBTOTAL</th>
                                    <td align="right">₹{{ round($order->subtotal) }}</td>
                                </tr>
                                <tr>
                                    <th>SHIPPING</th>
                                    <td align="right">₹{{ round($order->shipping) }}</td>
                                </tr>
                                <tr>
                                    <th>DISCOUNT</th>
                                    <td align="right" style="color: rgb(197, 81, 81)">₹{{ round($order->discount) }}</td>
                                </tr>
                                <tr>
                                    <th>TOTAL</th>
                                    <td align="right">₹{{ round($order->total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')

@endpush
