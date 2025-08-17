@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        {{-- {{ dd(Session::all()) }} --}}
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            @include('layouts.userend-alerts')
            {{-- {{ dd(Session::all()) }} --}}
            <div class="checkout-steps">
                <a href="{{ route('cartpage') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
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
            <form action="{{ route('process_checkout') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING ADDRESS DETAILS</h4>
                            </div>
                            <div class="col-6"></div>
                        </div>

                        @if ($addresses->isNotEmpty())
                            @foreach ($addresses as $address)
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="my-account__address-list">
                                            <input class="form-check-input form-check-input_fill saved-address" type="radio" name="delivery_address_option" id="saved-address-{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="saved-address-{{ $address->id }}">
                                                <div class="my-account__address-list-item">
                                                    <div class="my-account__address-item__detail">
                                                        <p class="fw-bold">{{ $address->name }}</p>
                                                        <p>{{ $address->address }}</p>
                                                        @if (!empty($address->locality))
                                                            <p>{{ $address->locality }}</p>
                                                        @endif
                                                        <p>{{ $address->landmark }}</p>
                                                        <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->zip }}</p>
                                                        <p>Mobile: {{ $address->phonecode }}{{ $address->mobile }}</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="my-account__address-list mt-4">
                                <input class="form-check-input form-check-input_fill" type="radio" name="delivery_address_option" id="new-address" value="new">
                                <label class="form-check-label" for="new-address">
                                    <div class="my-account__address-list-item">
                                        <div class="my-account__address-item__detail">
                                            <p>Add New Address</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @else
                            <input type="hidden" name="delivery_address_option" value="new">
                        @endif
                        @error('delivery_address_option')
                            <p class="delivery-address-option-error mt-4" style="color: rgb(197, 81, 81)">Please select an existing address or add a new one to continue.</p>
                        @enderror

                        <div class="row mt-5" id="new-address-form" style="display: {{ $addresses->isEmpty() ? 'flex' : 'none' }}">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                    <label for="name">Full Name *</label>
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}">
                                    <label for="mobile">Mobile Number *</label>
                                    @error('mobile')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}">
                                    <label for="zip">Pincode *</label>
                                    @error('zip')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}">
                                    <label for="state">State *</label>
                                    @error('state')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}">
                                    <label for="city">Town / City *</label>
                                    @error('city')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating my-3">
                                    <select class="form-control form-control_gray @error('country') is-invalid @enderror" id="country" name="country">
                                        <option value="" selected>Select country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="country">Country *</label>
                                    @error('country')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}">
                                    <label for="address">House No., Building Name *</label>
                                    @error('address')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('locality') is-invalid @enderror" name="locality" value="{{ old('locality') }}">
                                    <label for="locality">Road Name, Area *</label>
                                    @error('locality')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control @error('landmark') is-invalid @enderror" name="landmark" value="{{ old('landmark') }}">
                                    <label for="landmark">Landmark *</label>
                                    @error('landmark')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th align="right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    @if ($cart_items->isNotEmpty())
                                        <tbody>
                                            @foreach ($cart_items as $cart_item)
                                                <tr>
                                                    <td>{{ $cart_item->name }} x {{ $cart_item->qty }}</td>
                                                    <td align="right">₹{{ $cart_item->price * $cart_item->qty }}</td>
                                                </tr>
                                                @php
                                                    $addon_cart_items = get_addon_cart_items($cart_item->id);
                                                    // dd($addon_cart_items);
                                                @endphp
                                                @if ($addon_cart_items->isNotEmpty())
                                                    @foreach ($addon_cart_items as $addon_cart_item)
                                                        <tr>
                                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;- With Addons</td>
                                                            <td align="right">₹{{ $addon_cart_item->price * $addon_cart_item->qty }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SUBTOTAL</th>
                                            <td align="right">₹{{ Session::get('cart.subtotal') }}</td>
                                        </tr>
                                        <tr>
                                            <th>SHIPPING</th>
                                            <td align="right">₹{{ Session::get('cart.shipping') }}</td>
                                        </tr>
                                        <tr>
                                            <th>DISCOUNT</th>
                                            <td align="right" style="color: rgb(197, 81, 81)">₹{{ Session::get('cart.discount') }}</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td align="right">₹{{ Session::get('cart.total') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method" id="checkout_payment_method_3" value="COD">
                                    <label class="form-check-label" for="checkout_payment_method_3">
                                        Cash on delivery
                                        <p class="option-detail">Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method" id="checkout_payment_method_4" value="PP">
                                    <label class="form-check-label" for="checkout_payment_method_4">
                                        PhonePe
                                        <p class="option-detail">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam, iusto!</p>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience throughout this
                                    website, and for other purposes described in our <a href="{{ route('privacy_policy') }}" >privacy policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout d-none" type="submit">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
    {{-- {{ dd(Session::all()) }} --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#checkout_payment_method_3, #checkout_payment_method_4").click(function() {
                $(".btn-checkout").removeClass("d-none");
            });

            $("#new-address").click(function() {
                $("#new-address-form").show();
                $(".delivery-address-option-error").hide();
                $("#new-address-form .form-control").removeClass("is-invalid");
                $(".invalid-feedback").empty();
            });

            $(".saved-address").click(function() {
                $("#new-address-form").hide();
                $(".delivery-address-option-error").hide();
                $("#new-address-form .form-control").removeClass("is-invalid");
                $(".invalid-feedback").empty();
            });

            // If any form related error is returned to the blade, make the form visible
            @if($errors->any() && !$errors->has('delivery_address_option'))
                $('#new-address').prop('checked', true);
                $("#new-address-form").show();
            @endif
        });
    </script>
@endpush
