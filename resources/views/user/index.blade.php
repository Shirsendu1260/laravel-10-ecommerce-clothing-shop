@extends('layouts.app')

@section('content')
    <main>
        @if ($slides->isNotEmpty())
        <section class="swiper-container js-swiper-slider swiper-number-pagination slideshow"
            data-settings='{
                        "autoplay": {
                        "delay": 5000
                        },
                        "slidesPerView": 1,
                        "effect": "fade",
                        "loop": true
                    }'>
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide">
                        <div class="overflow-hidden position-relative h-100">
                            <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                                <img src="{{ asset('uploads/slide/' . $slide->image) }}" loading="lazy" width="542" height="733" alt="Woman Fashion 1" class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />
                                <div class="character_markup type2">
                                    <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">{{ $slide->tagline }}</p>
                                </div>
                            </div>
                            <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                                <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">New Arrivals</h6>
                                <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">{{ $slide->title }}</h2>
                                <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">{{ $slide->subtitle }}</h2>
                                <a href="{{ $slide->link }}" class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">Shop Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="container">
                <div class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5"></div>
            </div>
        </section>
        @endif

        <div class="container mw-1620 bg-white border-radius-10">
            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
            <section class="category-carousel container">
                <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">You Might Like</h2>

                <div class="position-relative">
                    <div class="swiper-container js-swiper-slider"
                        data-settings='{
                                    "autoplay": {
                                        "delay": 5000
                                    },
                                    "slidesPerView": 8,
                                    "slidesPerGroup": 1,
                                    "effect": "none",
                                    "loop": true,
                                    "navigation": {
                                        "nextEl": ".products-carousel__next-1",
                                        "prevEl": ".products-carousel__prev-1"
                                    },
                                    "breakpoints": {
                                        "320": {
                                        "slidesPerView": 2,
                                        "slidesPerGroup": 2,
                                        "spaceBetween": 15
                                        },
                                        "768": {
                                        "slidesPerView": 4,
                                        "slidesPerGroup": 4,
                                        "spaceBetween": 30
                                        },
                                        "992": {
                                        "slidesPerView": 6,
                                        "slidesPerGroup": 1,
                                        "spaceBetween": 45,
                                        "pagination": false
                                        },
                                        "1200": {
                                        "slidesPerView": 8,
                                        "slidesPerGroup": 1,
                                        "spaceBetween": 60,
                                        "pagination": false
                                        }
                                    }
                                    }'>
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                <div class="swiper-slide">
                                    <img loading="lazy" class="w-100 h-auto mb-3" src="{{ asset('uploads/category/thumbnails/' . $category->image) }}" width="124" height="124" alt="{!! $category->name !!}" />
                                    <div class="text-center">
                                        <a href="{{ route('shop', $category->slug) }}" class="menu-link fw-medium">{!! $category->name !!}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div><!-- /.swiper-wrapper -->
                    </div><!-- /.swiper-container js-swiper-slider -->

                    <div
                        class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_prev_md" />
                        </svg>
                    </div><!-- /.products-carousel__prev -->
                    <div
                        class="products-carousel__next products-carousel__next-1 position-absolute top-50 d-flex align-items-center justify-content-center">
                        <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_next_md" />
                        </svg>
                    </div><!-- /.products-carousel__next -->
                </div><!-- /.position-relative -->
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="hot-deals container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Hot Deals</h2>
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
                        <h2>Summer Sale</h2>
                        <h2 class="fw-bold">40% - 55% Off</h2>

                        <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                            data-date="18-3-2024" data-time="06:50">
                            <div class="day countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Days</span>
                            </div>

                            <div class="hour countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Hours</span>
                            </div>

                            <div class="min countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Mins</span>
                            </div>

                            <div class="sec countdown-unit">
                                <span class="countdown-num d-block"></span>
                                <span class="countdown-word text-uppercase text-secondary">Sec</span>
                            </div>
                        </div>

                        <a href="{{ route('shop') }}" class="btn-link default-underline text-uppercase fw-medium mt-3">View All</a>
                    </div>
                    <div class="col-md-6 col-lg-8 col-xl-80per">
                        <div class="position-relative">
                            <div class="swiper-container js-swiper-slider"
                                data-settings='{
                                            "autoplay": {
                                            "delay": 5000
                                            },
                                            "slidesPerView": 4,
                                            "slidesPerGroup": 4,
                                            "effect": "none",
                                            "loop": false,
                                            "breakpoints": {
                                            "320": {
                                                "slidesPerView": 2,
                                                "slidesPerGroup": 2,
                                                "spaceBetween": 14
                                            },
                                            "768": {
                                                "slidesPerView": 2,
                                                "slidesPerGroup": 3,
                                                "spaceBetween": 24
                                            },
                                            "992": {
                                                "slidesPerView": 3,
                                                "slidesPerGroup": 1,
                                                "spaceBetween": 30,
                                                "pagination": false
                                            },
                                            "1200": {
                                                "slidesPerView": 4,
                                                "slidesPerGroup": 1,
                                                "spaceBetween": 30,
                                                "pagination": false
                                            }
                                            }
                                        }'>
                                <div class="swiper-wrapper">
                                    @foreach ($summer_sale_products as $product)
                                        @php
                                            $product_images = DB::table('product_gallery_images')
                                                                    ->where('product_id', $product->id)
                                                                    ->orderBy('id', 'ASC')
                                                                    ->take(2)
                                                                    ->get();
                                        @endphp
                                        <div class="swiper-slide product-card product-card_style3">
                                            <div class="pc__img-wrapper">
                                                <a href="{{ route('product_details', $product->slug) }}" >
                                                    @if ($product_images->isNotEmpty())
                                                        @if(count($product_images) > 1)
                                                            @foreach ($product_images as $key => $product_image)
                                                                @if($key == 0)
                                                                    <img data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="258" height="313" alt="{!! $product->name !!}" class="pc__img lazy-img">
                                                                @elseif ($key == 1)
                                                                    <img data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="258" height="313" alt="{!! $product->name !!}" class="pc__img pc__img-second lazy-img">
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <img data-lazy="{{ asset('uploads/product/' . $product_images->first()->name) }}" width="258" height="313" alt="{!! $product->name !!}" class="pc__img lazy-img">
                                                        @endif
                                                    @else
                                                        <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="258" height="313" alt="{!! $product->name !!}" class="pc__img lazy-img">
                                                    @endif
                                                </a>
                                            </div>

                                            <div class="pc__info position-relative">
                                                <h6 class="pc__title"><a href="{{ route('product_details', $product->slug) }}" >{!! $product->name !!}</a></h6>
                                                <div class="product-card__price d-flex">
                                                    <span class="money price price-old">₹{{ $product->actual_price }}</span>
                                                    <span class="money price text-secondary">₹{{ $product->price }}</span>
                                                </div>

                                                <div class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                                                    {{-- <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                                    <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view" data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                                        <span class="d-none d-xxl-block">Quick View</span>
                                                        <span class="d-block d-xxl-none">Quick View</span>
                                                    </button> --}}
                                                    <div class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside" title="Price">
                                                        ₹{{ $product->price }}
                                                    </div>
                                                    <a href="{{ route('product_details', $product->slug) }}"  class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view" title="View">
                                                        <span class="d-none d-xxl-block">View</span>
                                                        <span class="d-block d-xxl-none">View</span>
                                                    </a>
                                                    <button class="pc__btn-wl bg-transparent border-0 js-add-wishlist" data-slug="{{ $product->slug }}" title="Add To Wishlist">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <use href="#icon_heart" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-between">
                                                @php
                                                    $date = \Carbon\Carbon::now()->subDays(value: 8);
                                                    $product_updated_date = \Carbon\Carbon::parse($product->updated_at);

                                                    if($product_updated_date->gte($date)) {
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

                                                <div class="pc-labels__right ms-auto">
                                                    <span class="pc-label pc-label_sale d-block text-white">-{{ $product->discount }}%</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div><!-- /.swiper-container js-swiper-slider -->
                        </div><!-- /.position-relative -->
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="category-banner container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img class="h-auto lazy-img"
                                data-lazy="{{ asset('assets/user/images/home/demo3/category_9.jpg') }}" width="690"
                                height="665" alt="" />
                            <div class="category-banner__item-mark">
                                Starting at ₹1000
                            </div>
                            <div class="category-banner__item-content lazy-img">
                                <h3 class="mb-0">Womens' Wear</h3>
                                <a href="{{ route('shop', 'womens-wear') }}" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-banner__item border-radius-10 mb-5">
                            <img class="h-auto lazy-img"
                                data-lazy="{{ asset('assets/user/images/home/demo3/category_10.jpg') }}" width="690"
                                height="665" alt="" />
                            <div class="category-banner__item-mark">
                                Starting at ₹300
                            </div>
                            <div class="category-banner__item-content">
                                <h3 class="mb-0">Sweatshirts for Men</h3>
                                <a href="{{ route('shop', 'sweatshirts-for-men') }}" class="btn-link default-underline text-uppercase fw-medium">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

            <section class="products-grid container">
                <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

                <div class="row" id="featured-products-grid" data-page="1">
                    @include('user.main.products-home-con')
                </div>
                <div class="row my-5" id="loading" style="display: none;">
                    <div class="col-md-12 text-center">
                        <div class="spinner-border text-dark" role="status" style="width: 2.7rem; height: 2.7rem;"></div>
                    </div>
                </div>

                <div class="text-center mt-2">
                    <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" id="load-more-featured-products" href="javascript:void(0)">Load More</a>
                </div>
            </section>
        </div>

        <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
    </main>
@endsection

@push('scripts')
    <script>
        let isLoading = false; // To prevent multiple AJAX calls
        let allFeaturedProductsLoaded = false; // To stop if no more products are left to load

        function loadMoreFeaturedProducts() {
            // Prevent the AJAX from triggering if it is in loading state or no more products are left to append or both
            if(isLoading || allFeaturedProductsLoaded) {
                return;
            }

            isLoading = true;

            // Code for incrementing page number
            let page = parseInt($("#featured-products-grid").data("page")) + 1;
            $("#featured-products-grid").data("page", page);

            // Add 'page' parameter to url
            let url_string = window.location.href;
            let url = new URL(url_string);
            url.searchParams.set("page", page);
            url_string = url.href;

            $.ajax({
                url: url_string,
                type: "get",
                dataType: "json",
                beforeSend: function() {
                    $('#loading').fadeIn('fast');
                    $("#load-more-featured-products").fadeOut('fast');
                },
                success: function(response) {
                    $('#loading').fadeOut('fast');
                    isLoading = false;

                    if(response.featured_products_html.trim() != "") {
                        $("#featured-products-grid").append(response.featured_products_html.trim());

                        if(response.featured_products_has_more_pages == false) {
                            allFeaturedProductsLoaded = true;
                        }
                        else {
                            $("#load-more-featured-products").fadeIn('fast');
                        }
                    }
                    else {
                        allFeaturedProductsLoaded = true;
                    }
                },
                error: function() {
                    isLoading = false;
                    $('#loading').fadeOut('fast');
                    Swal.fire({
                        title: "Error!",
                        text: "Error loading more products.",
                        icon: "error"
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            console.log("Welcome to Laravel ECOM.");

            // Load more featured products
            $("#load-more-featured-products").click(function() {
                loadMoreFeaturedProducts();
            });
        });
    </script>
@endpush
