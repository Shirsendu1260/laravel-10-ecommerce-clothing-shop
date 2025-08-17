@extends('layouts.app')

@push('styles')
<style>
    .modal-transition {
        transition: all 0.5s ease-in-out;
        opacity: 0;
        transform: translateX(50px);
    }
    .modal-step.active {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }
    .modal-step {
        display: none;
    }
    .btn-modal-trigger {
        border: 2px solid #E4E4E4;
        height: 3.75rem;
        padding: 0 2rem;
        width: 100%;
        text-align: left;
        font-weight: 500;
        color: #333;
        background-color: #ffffff;
        /* box-shadow: 0 4px 6px rgba(0,0,0,0.1); */
    }
    .btn-modal-trigger .arrow {
        float: right;
    }
    .back-link {
        cursor: pointer;
        color: #1d1d1d;
        text-decoration: underline;
        display: inline-block;
        margin-bottom: 10px;
        font-size: 0.9rem;
    }
    .start-over {
        margin-top: 10px;
        text-align: center;
        color: #dc3545;
        cursor: pointer;
        text-decoration: underline;
    }
    .step-indicators {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        position: relative;
    }
    .step-indicator {
        flex: 1;
        text-align: center;
        padding: 0.5rem;
        position: relative;
        color: #666;
        font-size: 0.95rem;
        border-bottom: 2px solid #ccc;
    }
    .step-indicator.active {
        font-weight: bold;
        /* color: #1d1d1d;
        border-color: #1d1d1d; */
    }
    .step-indicator.completed::after {
        content: "";
        display: inline-block;
        width: 10px;
        height: 5px;
        border-left: 2px solid #1d1d1d;
        border-bottom: 2px solid #1d1d1d;
        transform: rotate(-45deg);
        margin-left: 8px;
        margin-top: 2px;
        margin-bottom: 4px;
    }
    .list-group-item-action {
        transition: background-color 0.2s, color 0.2s;
    }
    .list-group-item-action:hover {
        background-color: #f1f1f1;
    }
    .product-single__rating {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="vertical-thumbnail">
                @if ($product_images->isNotEmpty())
                    <div class="product-single__image">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($product_images as $product_image)
                                    <div class="swiper-slide product-single__image-item">
                                        <img class="h-auto lazy-img" data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="674" height="674" alt="" />
                                        <a data-fancybox="gallery" href="{{ asset('uploads/product/' . $product_image->name) }}"  data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_zoom" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if ($product_images->count() > 1)
                                <div class="swiper-button-prev">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg>
                                </div>
                                <div class="swiper-button-next">
                                    <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="swiper-slide product-single__image-item">
                        <img class="h-auto lazy-img" data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="674" height="674" alt="" />
                    </div>
                @endif
                @if ($product_images->isNotEmpty())
                    <div class="product-single__thumbnail">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($product_images as $product_image)
                                    <div class="swiper-slide product-single__image-item">
                                        <img class="h-auto lazy-img" data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="104" height="104" alt="" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="{{ route('shop') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                    </div><!-- /.breadcrumb -->

                    <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        @if (!empty($previous_product))
                            <a href="{{ route('product_details', $previous_product->slug) }}" class="text-uppercase fw-medium">
                                <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_md" />
                                </svg>
                                <span class="menu-link menu-link_us-s">Prev</span>
                            </a>
                        @endif
                        @if (!empty($next_product))
                            <a href="{{ route('product_details', $next_product->slug) }}" class="text-uppercase fw-medium">
                                <span class="menu-link menu-link_us-s">Next</span>
                                <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_md" />
                                </svg>
                            </a>
                        @endif
                    </div><!-- /.shop-acs -->
                </div>

                <h1 class="product-single__name">{!! $product->name !!}</h1>
                @php
                    $rating = get_product_avg_rating($product->id);
                    $rating_int = (int) $rating;
                @endphp
                @if($rating_int > 0)
                    <div class="product-single__rating">
                        <div class="reviews-group d-flex">
                            @for($i = 0; $i < $rating_int; $i++)
                                <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_star" />
                                </svg>
                            @endfor
                        </div>
                        <span class="reviews-note text-capitalize text-secondary ms-1">({{ $rating }}) {{ product_review_count($product->id) }} Reviews</span>
                    </div>
                @endif

                <div class="product-single__price">
                    @if(!empty($product->actual_price))
                        <span class="money price price-old">₹{{ $product->actual_price }}</span>
                        <span class="current-price">₹{{ $product->price }}</span>
                    @else
                        <span class="current-price">₹{{ $product->price }}</span>
                    @endif
                </div>

                <div class="product-single__short-desc">{!! $product->short_description !!}</div>

                @php
                $available_sizes = explode(',', $product->available_sizes);
                $available_sizes_str = implode(', ', $available_sizes);
                // dd($available_sizes);
                @endphp
                @if($product_available_status == true)
                <div class="product-single__addtocart">
                    <div class="d-flex flex-row">
                        <div class="qty-control position-relative me-3">
                            <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                            <div class="qty-control__reduce">-</div>
                            <div class="qty-control__increase">+</div>
                        </div><!-- .qty-control -->

                        <div class="form-floating">
                            <select class="form-control form-control_gray" id="size" name="size">
                                <option value="" selected>Select your preferred size</option>
                                @if (!empty($available_sizes))
                                    @foreach ($available_sizes as $size)
                                        <option value="{{ $size }}">{{ strtoupper($size) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="size">Size *</label>
                        </div>
                    </div>

                    <!-- Trigger Button -->
                    <button id="openModalBtn" class="btn-modal-trigger" data-bs-toggle="modal" data-bs-target="#deliveryModal">
                        <i class="bi bi-calendar3-event me-2"></i><span id="modalBtnText">Select Delivery Date, Method & Time Slot</span>
                        <span class="arrow">&rsaquo;</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">Select Delivery Date</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <!-- Step Indicators -->
                                    <div class="step-indicators">
                                        <div class="step-indicator" id="indicator-step1">Date</div>
                                        <div class="step-indicator" id="indicator-step2">Method</div>
                                        <div class="step-indicator" id="indicator-step3">Timeslot</div>
                                    </div>

                                    <!-- Step 1: Date Picker -->
                                    <div id="step1" class="modal-step active modal-transition">
                                        <input type="date" class="form-control mb-2" id="deliveryDate" min="" />
                                    </div>

                                    <!-- Step 2: Delivery Method -->
                                    <div id="step2" class="modal-step modal-transition">
                                        <div class="back-link" id="backToStep1"><i class="bi bi-arrow-left me-2"></i>Back</div>
                                            @if ($delivery_methods->isNotEmpty())
                                                <div class="list-group">
                                                    @foreach ($delivery_methods as $delivery_method)
                                                        <button class="list-group-item list-group-item-action" data-method="{{ $delivery_method->slug }}" data-cost="{{ $delivery_method->price }}">
                                                            {!! ($delivery_method->slug == 'express-delivery') ? '<i class="bi bi-lightning-charge-fill me-2"></i>' : '' !!}
                                                            {!! ($delivery_method->slug == 'standard-delivery') ? '<i class="bi bi-truck-front-fill me-2"></i>' : '' !!}
                                                            {!! ($delivery_method->slug == 'fixed-time-delivery') ? '<i class="bi bi-clock-fill me-2"></i>' : '' !!}
                                                            {!! ($delivery_method->slug == 'premidnight-delivery') ? '<i class="bi bi-moon-fill me-2"></i>' : '' !!}
                                                            {{ $delivery_method->name }} - ₹{{ $delivery_method->price }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                    <!-- Step 3: Time Slot -->
                                    <div id="step3" class="modal-step modal-transition">
                                        <div class="back-link" id="backToStep2"><i class="bi bi-arrow-left me-2"></i>Back</div>
                                        <div class="list-group" id="timeslotContainer"></div>
                                    </div>

                                    <div class="start-over" id="startOver">Start Over</div>

                                    <input type="hidden" id="selected_date" name="selected_date">
                                    <input type="hidden" id="selected_method" name="selected_method">
                                    <input type="hidden" id="selected_timeslot" name="selected_timeslot">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-addtocart add-to-cart-trigger d-flex align-items-center" data-aside="cartDrawer" data-qty="1" data-product-slug="{{ $product->slug }}" data-size="">
                        Add to Cart
                        <div class="ms-3 spinner-border text-white loading" role="status" style="width: 1rem; height: 1rem; display: none;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
                @else
                <div class="text-red fs-4 mb-3">OUT OF STOCK</div>
                @endif

                <div class="product-single__addtolinks">
                    <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist" data-slug="{{ $product->slug }}">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_heart" />
                        </svg>
                        <span>Add to Wishlist</span>
                    </a>
                </div>
            </div>
            </div>

            <div class="product-single__details-tab mt-5">
                @if ($addon_products->isNotEmpty() && ($product_available_status == true))
                    <section class="products-carousel container px-0 mb-5 pb-1">
                        <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Addon <strong>Products</strong></h2>

                        <div id="addon_products" class="position-relative">
                            <div class="swiper-container js-swiper-slider" data-settings='{
                                    "autoplay": false,
                                    "slidesPerView": 4,
                                    "slidesPerGroup": 4,
                                    "effect": "none",
                                    "loop": false,
                                    "pagination": {
                                        "el": "#addon_products .addon_products-pagination",
                                        "type": "bullets",
                                        "clickable": true
                                    },
                                    "navigation": {
                                        "nextEl": "#addon_products .products-carousel__next",
                                        "prevEl": "#addon_products .products-carousel__prev"
                                    },
                                    "breakpoints": {
                                        "320": {
                                            "slidesPerView": 2,
                                            "slidesPerGroup": 2,
                                            "spaceBetween": 14
                                        },
                                        "768": {
                                            "slidesPerView": 3,
                                            "slidesPerGroup": 3,
                                            "spaceBetween": 24
                                        },
                                        "992": {
                                            "slidesPerView": 4,
                                            "slidesPerGroup": 4,
                                            "spaceBetween": 30
                                        }
                                    }
                                }'>
                                <div class="swiper-wrapper">
                                    @foreach ($addon_products as $addon_product)
                                        <div class="swiper-slide product-card border p-3">
                                            <div class="pc__img-wrapper">
                                                @if (!empty($addon_product->image))
                                                    <img data-lazy="{{ asset('uploads/addon-product/thumbnails/' . $addon_product->image) }}" width="330" height="400" alt="{!! $addon_product->name !!}" class="pc__img lazy-img">
                                                @else
                                                    <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="330" height="400" alt="image not available" class="pc__img lazy-img">
                                                @endif
                                                {{-- <button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-addon-add-cart" data-addon-slug="{{ $addon_product->slug }}" title="Add">
                                                    Add
                                                </button> --}}
                                            </div>

                                            <div class="pc__info position-relative">
                                                <h6 class="pc__title">
                                                    <div>{!! $addon_product->name !!}</div>
                                                    <div class="pc__category">{!! $addon_product->brand !!}</div>
                                                </h6>

                                                <div class="product-card__price d-flex">
                                                    <span class="money price">₹{{ $addon_product->price }}</span>
                                                </div>

                                                @if($addon_product->qty > 0)
                                                <button type="button" class="btn btn-primary btn-sm text-uppercase mt-2 js-addon-add-cart" data-addon-slug="{{ $addon_product->slug }}">Add</button>

                                                <div class="quantity-selector-container mt-2" style="display: none">
                                                    <div class="input-group input-group-sm">
                                                        <button type="button" class="h-75 btn btn-sm btn-outline-secondary minus-btn" data-addon-slug="{{ $addon_product->slug }}" title="Decrease">-</button>
                                                        <input type="text" class="h-75 form-control bg-white text-center quantity-input" value="1" readonly data-addon-slug="{{ $addon_product->slug }}" title="Addon Quantity">
                                                        <button type="button" class="h-75 btn btn-sm btn-outline-secondary plus-btn" data-addon-slug="{{ $addon_product->slug }}" title="Increase">+</button>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-between">
                                                @php
                                                    $date = \Carbon\Carbon::now()->subDays(value: 10);
                                                    $addon_product_updated_date = \Carbon\Carbon::parse($addon_product->updated_at);

                                                    if ($addon_product_updated_date->gte($date)) {
                                                        echo "<div class='pc-labels__left me-2'>
                                                                    <span class='pc-label pc-label_new d-block bg-white shadow-sm'>NEW</span>
                                                                </div>";
                                                    }
                                                @endphp

                                                @if($addon_product->qty == 0)
                                                    <div class='pc-labels__left'>
                                                        <span class="pc-label pc-label_sale d-block text-white">UNAVAILABLE</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div><!-- /.swiper-wrapper -->
                            </div><!-- /.swiper-container js-swiper-slider -->

                            @if ($addon_products->count() > 1)
                                <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_md" />
                                    </svg>
                                </div>
                                <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_md" />
                                    </svg>
                                </div>
                            @endif

                            <div class="addon_products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                        </div>

                    </section>
                @endif

                @include('layouts.userend-alerts')
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link nav-link_underscore" id="tab-additional-info-tab" data-bs-toggle="tab" href="#tab-additional-info" role="tab" aria-controls="tab-additional-info" aria-selected="false">Additional Information</a>
                    </li>
                    @if($product_ratings->isNotEmpty() || (Auth::check() && ($user_bought_product == true) && ($user_rated_product == false)))
                        <li class="nav-item" role="presentation">
                            <a class="nav-link nav-link_underscore" id="tab-reviews-tab" data-bs-toggle="tab" href="#tab-reviews" role="tab" aria-controls="tab-reviews" aria-selected="false">Reviews ({{ $product_ratings_count }})</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                        <div class="product-single__description">{!! $product->description !!}</div>
                    </div>
                    <div class="tab-pane fade" id="tab-additional-info" role="tabpanel" aria-labelledby="tab-additional-info-tab">
                        <div class="product-single__addtional-info">
                            <div class="item d-flex flex-row align-items-center">
                                <label class="h6">Brand</label>
                                <div class="d-flex align-items-center">
                                    @if(!empty($product->brand_image))
                                        <img class="rounded-circle m-0 p-0 me-2" src="{{ asset('uploads/brand/thumbnails/' . $product->brand_image) }}" width="36" height="36" alt="brand-logo" loading="lazy">
                                    @endif
                                    <span>{{ $product->brand }}</span>
                                </div>
                            </div>
                            <div class="item">
                                <label class="h6">SKU</label>
                                <span>{{ $product->sku }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Available Sizes</label>
                                <span>{{ strtoupper($available_sizes_str) }}</span>
                            </div>
                            <div class="item">
                                <label class="h6">Category</label>
                                <span>{{ $product->category }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-reviews" role="tabpanel" aria-labelledby="tab-reviews-tab">
                        @if($product_ratings->isNotEmpty())
                            <h2 class="product-single__reviews-title">Reviews</h2>
                            <div class="product-single__reviews-list">
                                @foreach($product_ratings as $rating)
                                    <div class="product-single__reviews-item">
                                        <div class="customer-avatar">
                                            <img loading="lazy" src="{{ asset('assets/user/images/avatar.jpg') }}" alt="{{ $rating->name }}">
                                        </div>
                                        <div class="customer-review">
                                            <div class="customer-name">
                                                <h6 class="me-3">{{ $rating->name }}</h6>
                                                <div class="reviews-group d-flex">
                                                    @php
                                                        $rating_int = (int)$rating->rating;
                                                    @endphp
                                                    @for($i = 1; $i <= $rating_int; $i++)
                                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                                            <use href="#icon_star" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="review-date">{{ date('d M, Y', strtotime($rating->updated_at)) }}</div>
                                            <div class="review-text">
                                                <p>{{ $rating->comment }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if (Auth::check() && ($user_bought_product == true) && ($user_rated_product == false))
                            <div class="product-single__review-form">
                                <form name="customer-review-form" action="{{ route('submit_rating', $product->slug) }}" method="post">
                                    @csrf
                                    <h5>Be the first to review “{!! $product->name !!}”.</h5>
                                    <p>Your email address will not be published. Required fields are marked '*'.</p>
                                    <div class="select-star-rating">
                                        <label>Your rating *</label>
                                        <span class="ms-2 star-rating">
                                            <svg class="star-rating__star-icon" data-rating="1" width="17" height="17" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                            <svg class="star-rating__star-icon" data-rating="2" width="17" height="17" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                            <svg class="star-rating__star-icon" data-rating="3" width="17" height="17" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                            <svg class="star-rating__star-icon" data-rating="4" width="17" height="17" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                            <svg class="star-rating__star-icon" data-rating="5" width="17" height="17" fill="#ccc" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.1429 5.04687C11.1429 4.84598 10.9286 4.76562 10.7679 4.73884L7.40625 4.25L5.89955 1.20312C5.83929 1.07589 5.72545 0.928571 5.57143 0.928571C5.41741 0.928571 5.30357 1.07589 5.2433 1.20312L3.73661 4.25L0.375 4.73884C0.207589 4.76562 0 4.84598 0 5.04687C0 5.16741 0.0870536 5.28125 0.167411 5.3683L2.60491 7.73884L2.02902 11.0871C2.02232 11.1339 2.01563 11.1741 2.01563 11.221C2.01563 11.3951 2.10268 11.5558 2.29688 11.5558C2.39063 11.5558 2.47768 11.5223 2.56473 11.4754L5.57143 9.89509L8.57813 11.4754C8.65848 11.5223 8.75223 11.5558 8.84598 11.5558C9.04018 11.5558 9.12054 11.3951 9.12054 11.221C9.12054 11.1741 9.12054 11.1339 9.11384 11.0871L8.53795 7.73884L10.9688 5.3683C11.0558 5.28125 11.1429 5.16741 11.1429 5.04687Z" />
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-row">
                                            <input type="hidden" id="form-input-rating" name="rating" value="" />
                                            @error('rating')
                                                <span class="text-red fw-light mt-2 rating-alert" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <textarea id="form-input-review" class="form-control form-control_gray @error('comment') is-invalid @enderror" name="comment" placeholder="Your Review" cols="30" rows="8"></textarea>
                                        @error('comment')
                                            <span class="text-red fw-light rating-alert" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-action">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        @if ($related_products->isNotEmpty())
            <section class="products-carousel container">
                <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

                <div id="related_products" class="position-relative">
                    <div class="swiper-container js-swiper-slider" data-settings='{
                            "autoplay": false,
                            "slidesPerView": 4,
                            "slidesPerGroup": 4,
                            "effect": "none",
                            "loop": false,
                            "pagination": {
                                "el": "#related_products .products-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "navigation": {
                                "nextEl": "#related_products .products-carousel__next",
                                "prevEl": "#related_products .products-carousel__prev"
                            },
                            "breakpoints": {
                                "320": {
                                    "slidesPerView": 2,
                                    "slidesPerGroup": 2,
                                    "spaceBetween": 14
                                },
                                "768": {
                                    "slidesPerView": 3,
                                    "slidesPerGroup": 3,
                                    "spaceBetween": 24
                                },
                                "992": {
                                    "slidesPerView": 4,
                                    "slidesPerGroup": 4,
                                    "spaceBetween": 30
                                }
                            }
                        }'>
                        <div class="swiper-wrapper">
                            @foreach ($related_products as $product)
                                <div class="swiper-slide product-card">
                                    <div class="pc__img-wrapper">
                                        @php
                                        $product_image = DB::table('product_gallery_images')->where('product_id', $product->id)->first();
                                        @endphp
                                        @if (!empty($product_image))
                                            <a href="{{ route('product_details', $product->slug) }}" >
                                                <img data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="330" height="400" alt="{!! $product->name !!}" class="pc__img lazy-img">
                                            </a>
                                        @else
                                            <a href="{{ route('product_details', $product->slug) }}" >
                                                <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="330" height="400" alt="image not available" class="pc__img lazy-img">
                                            </a>
                                        @endif
                                        {{-- <button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button> --}}
                                    </div>

                                    <div class="pc__info position-relative">
                                        <p class="pc__category">{!! $product->category !!}</p>
                                        <h6 class="pc__title">
                                            <a href="{{ route('product_details', $product->slug) }}" >{!! $product->name !!}</a>
                                            <div class="pc__category">{!! $product->brand !!}</div>
                                        </h6>

                                        @if(!empty($product->actual_price))
                                            <div class="product-card__price d-flex">
                                                <span class="money price price-old">₹{{ $product->actual_price }}</span>
                                                <span class="money price price-sale">₹{{ $product->price }}</span>
                                            </div>
                                        @else
                                            <div class="product-card__price d-flex">
                                                <span class="money price">₹{{ $product->price }}</span>
                                            </div>
                                        @endif

                                        {{-- <div class="d-flex align-items-center mt-1">
                                            <a href="#" class="swatch-color pc__swatch-color" style="color: #222222"></a>
                                            <a href="#" class="swatch-color swatch_active pc__swatch-color" style="color: #b9a16b"></a>
                                            <a href="#" class="swatch-color pc__swatch-color" style="color: #f5e6e0"></a>
                                        </div> --}}
                                        @php
                                            $rating = get_product_avg_rating($product->id);
                                            $rating_int = (int) $rating;
                                        @endphp
                                        @if($rating_int > 0)
                                            <div class="product-card__review d-flex align-items-center">
                                                <div class="reviews-group d-flex">
                                                    @for($i = 0; $i < $rating_int; $i++)
                                                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                                                            <use href="#icon_star" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="reviews-note text-capitalize text-secondary ms-1">({{ $rating }}) {{ product_review_count($product->id) }} Reviews</span>
                                            </div>
                                        @endif

                                        <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist" data-slug="{{ $product->slug }}" title="Add To Wishlist">
                                            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_heart" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-between">
                                        @php
                                        $date = \Carbon\Carbon::now()->subDays(value: 10);
                                        $product_updated_date = \Carbon\Carbon::parse($product->updated_at);

                                        if ($product_updated_date->gte($date)) {
                                            echo "<div class='pc-labels__left me-2'>
                                                        <span class='pc-label pc-label_new d-block bg-white shadow-sm'>NEW</span>
                                                    </div>";
                                        }
                                        @endphp

                                        @if($product->qty == 0)
                                            <div class='pc-labels__left'>
                                                <span class="pc-label pc-label_sale d-block text-white">UNAVAILABLE</span>
                                            </div>
                                        @endif

                                        @if (!empty($product->actual_price))
                                            @php
                                            $discount_rate = (int) ((((float) $product->actual_price - (float) $product->price) / (float) $product->actual_price) * 100);
                                            @endphp
                                            <div class="pc-labels__right ms-auto">
                                                <span class="pc-label pc-label_sale d-block text-white">-{{ $discount_rate }}%</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    @if ($related_products->count() > 1)
                        <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg>
                        </div><!-- /.products-carousel__prev -->
                        <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                            <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg>
                        </div><!-- /.products-carousel__next -->
                    @endif

                    <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                    <!-- /.products-pagination -->
                </div><!-- /.position-relative -->

            </section><!-- /.products-carousel container -->
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Quantity selection
            $(".qty-control__increase").click(function() {
                let qty = parseInt($(this).parent().children().first().val());

                qty++;
                $(this).parent().children().first().val(qty);

                $(".add-to-cart-trigger").data("qty", qty);
            });
            $(".qty-control__reduce").click(function() {
                let qty = parseInt($(this).parent().children().first().val());

                if(qty > 1) {
                    qty--;
                    $(this).parent().children().first().val(qty);
                    $(".add-to-cart-trigger").data("qty", qty);
                }
                else {
                    $(this).parent().children().first().val(1);
                    $(".add-to-cart-trigger").data("qty", 1);
                }
            });

            // Size selection
            $("#size").change(function() {
                // console.log($(this).val());
                $(".add-to-cart-trigger").data("size", $(this).val());
            });


            // Adding addon products
            let addonProducts = [];
            $(".js-addon-add-cart").click(function() {
                // Hide add button and show quantity selector
                $(this).hide();
                let qtySelector = $(this).next(".quantity-selector-container");
                qtySelector.show();

                // Set addon quantity to 1 when added
                qtySelector.find(".quantity-input").val(1);

                let addonSlug = $(this).data("addon-slug");
                // console.log(addonSlug);

                let addonProductObject = {
                    'addonSlug': addonSlug,
                    'addonQty': 1
                };

                addonProducts.push(addonProductObject);
                // console.log(addonProducts);
            });


            // Increase quantity of addon products
            $(".plus-btn").click(function() {
                let qtySelector = $(this).prev();

                // Increase quantity
                let qty = parseInt(qtySelector.val()) + 1;

                // Update quantity in the quantity selector
                qtySelector.val(qty);

                let addonSlug = $(this).data("addon-slug");

                const index = addonProducts.findIndex(function(addonProductObject) {
                    if(addonProductObject.addonSlug == addonSlug) {
                        return true;
                    }
                    else {
                        return false;
                    }
                });

                // Visit the object located in the array of the specific index and update the quantity
                addonProducts[index].addonQty = qty;
                // console.log(addonProducts);
            });


            // Decrease quantity of addon products
            $(".minus-btn").click(function() {
                let qtySelector = $(this).next();
                let addonSlug = $(this).data("addon-slug");

                if(qtySelector.val() > 1) {
                    // Decrease quantity
                    let qty = parseInt(qtySelector.val()) - 1;

                    // Update quantity in the quantity selector
                    qtySelector.val(qty);

                    const index = addonProducts.findIndex(function(addonProductObject) {
                        if(addonProductObject.addonSlug == addonSlug) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    });

                    // Visit the object located in the array of the specific index and update the quantity
                    addonProducts[index].addonQty = qty;
                }
                else {
                    // Set quantity to 1
                    qtySelector.val(1);

                    const index = addonProducts.findIndex(function(addonProductObject) {
                        if(addonProductObject.addonSlug == addonSlug) {
                            return true;
                        }
                        else {
                            return false;
                        }
                    });

                    addonProducts.splice(index, 1); // Remove just one element from the given index of the array

                    // Hide quantity selector
                    $(this).parent().parent().hide();

                    // Show add button
                    $(this).parent().parent().prev().show();
                }

                // console.log(addonProducts);
            });


            /* ---------------- Start of 'Date, Delivery Method & Timeslot Selector' ---------------- */
            const today = new Date().toISOString().split('T')[0];
            // Date() => Wed Jun 04 2025 12:34:56 GMT+0530 (India Standard Time)
            // Date().toISOString() => 025-06-04T07:04:56.123Z
            // Date().toISOString().split('T') => ["2025-06-04", "07:04:56.123Z"]
            // Date().toISOString().split('T')[0] => "2025-06-04"
            console.log(today);
            $('#deliveryDate').attr('min', today);

            function setActiveIndicator(stepNumber) {
                $('.step-indicator').removeClass('active completed');
                if (stepNumber > 1) $('#indicator-step1').addClass('completed');
                if (stepNumber > 2) $('#indicator-step2').addClass('completed');
                $('#indicator-step' + stepNumber).addClass('active');
            }

            function showStep(stepNumber) {
                $('.modal-step').removeClass('active');
                setTimeout(function() {
                    $('#step' + stepNumber).addClass('active');
                }, 10);

                const titles = ["Select Delivery Date", "Select Delivery Method & Time Slot", "Select Time Slot"];
                const currentWindowTitle = titles[stepNumber - 1];
                $('.modal-title').text(currentWindowTitle);
                setActiveIndicator(stepNumber);
            }

            function resetSelections() {
                $('#deliveryDate').val('');
                $('#selected_date').val('');
                $('#selected_method').val('');
                $('#selected_timeslot').val('');
                $('#modalBtnText').html('Select Delivery Date, Method & Time Slot');
                $('#timeslotContainer').empty();
                $('.step-indicator').removeClass('active completed');
                showStep(1);
            }

            function getTimeslots(methodSlug, selectedDate, callbackFunction) {
                $.ajax({
                    url: "{{ route('get_timeslots') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        method_slug: methodSlug,
                        selected_date: selectedDate,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        const timeslots = response.timeslots;
                        callbackFunction(timeslots);
                    },
                    error: function() {
                        alert("Error while fetching the timeslots.");
                    }
                });
            }

            $('#deliveryModal').on('show.bs.modal', function () {
                showStep(1);
            });

            $('#deliveryDate').on('change', function () {
                $('#selected_date').val(this.value);
                showStep(2);
            });

            $('#step2 button').on('click', function () {
                const methodSlug = $(this).data('method');
                const cost = $(this).data('cost');
                $('#selected_method').val(methodSlug);

                let timeslots = [];
                getTimeslots(methodSlug, $('#selected_date').val(), function(timeslots_array) {
                    timeslots = timeslots_array;

                    $('#timeslotContainer').hide();
                    $('#timeslotContainer').empty();

                    timeslots.forEach(function (timeslot) {
                        // console.log(timeslot);
                        $('#timeslotContainer').append(`<button class="list-group-item list-group-item-action" data-slot-slug="${timeslot.slug}" data-time-range="${timeslot.time_range}" data-cost="${timeslot.method_cost}" data-method-slug="${timeslot.method_slug}" data-method-name="${timeslot.method_name}">${timeslot.time_range}</button>`);
                    });

                    $('#timeslotContainer').fadeIn('fast');
                    showStep(3);
                });
            });

            $(document).on('click', '#timeslotContainer button', function () {
                const slotSlug = $(this).data('slot-slug');
                const timeRange = $(this).data('time-range');
                const methodSlug = $(this).data('method-slug');
                const methodName = $(this).data('method-name');
                const cost = $(this).data('cost');
                $('#selected_timeslot').val(slotSlug);

                const date = new Date($('#selected_date').val());
                const formattedDate = date.toLocaleDateString('en-US', {
                    weekday: 'short',
                    day: '2-digit',
                    month: 'short'
                });

                const finalText = `${formattedDate}, ${timeRange} - ${methodName}: ₹${cost}`;
                $('#modalBtnText').html(finalText);
                $('#deliveryModal').modal('hide');
            });

            $('#backToStep1').on('click', function () {
                showStep(1);
            });

            $('#backToStep2').on('click', function () {
                showStep(2);
            });

            $('#startOver').on('click', function () {
                resetSelections();
            });
            /* ---------------- End of 'Date, Delivery Method & Timeslot Selector' ---------------- */


            // Add To Cart trigger
            $(".add-to-cart-trigger").click(function() {
                $.ajax({
                    url: "{{ route('add_to_cart') }}",
                    type: "post",
                    dataType: "json",
                    data: {
                        product_qty: $(this).data("qty"),
                        product_slug: $(this).data("product-slug"),
                        product_size: $(this).data("size"),
                        selected_date: $('#selected_date').val(),
                        selected_method: $('#selected_method').val(),
                        selected_timeslot: $('#selected_timeslot').val(),
                        addon_products: addonProducts,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $(".loading").fadeIn("fast");
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $(".loading").fadeOut("fast");
                        }, 800);

                        if(response.status == true) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.msg,
                                toast: true,
                                showConfirmButton: false,
                            });
                            setTimeout(function() {
                                window.location.href = "{{ route('cartpage') }}";
                            }, 1700);
                        }
                        else {
                            if(response.notFound == true) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Product not found, unable to add the product to cart.",
                                    icon: "error"
                                });
                            }
                            else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.msg,
                                    icon: "error"
                                });
                            }
                        }
                    },
                    error: function() {
                        $(".loading").fadeOut("fast");
                        $(".add-to-cart-status").fadeOut("fast");
                        alert("Error while adding the product to cart.");
                    }
                });
            });


            // For submitting rating
            $(".star-rating__star-icon").click(function() {
                const rating = $(this).data("rating");
                console.log(rating);

                $("#form-input-rating").val(rating);
            });

            // If any validation related error for rating form is returned to the blade, then manually trigger click for the reviews tab
            if($(".rating-alert").length > 0) {
                // alert("Rating validation returned.");
                $('#tab-reviews-tab')[0].click();

                // Jump to the reviews tab area
                const review_tab_link = document.getElementById('tab-reviews-tab');
                if (review_tab_link) {
                    review_tab_link.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            // If session alert shown on rating submission, then jump to the reviews tab area
            if($(".alert").length > 0) {
                $('#tab-reviews-tab')[0].click();

                const review_tab_link = document.getElementById('tab-reviews-tab');
                if (review_tab_link) {
                    review_tab_link.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }

            $(".product-single__rating").click(function() {
                $('#tab-reviews-tab')[0].click();

                const review_tab_link = document.getElementById('tab-reviews-tab');
                if (review_tab_link) {
                    review_tab_link.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
@endpush
