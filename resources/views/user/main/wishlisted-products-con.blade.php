@foreach ($products as $w_product)
<div class="product-card-wrapper" id="wishlisted-product-card-{{ $w_product->wishlist_id }}">
    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
    <div class="pc__img-wrapper">
        <div class="swiper-container background-img js-swiper-slider" data-settings='{"resizeObserver": true}'>
        <div class="swiper-wrapper">
            {{-- @php
                $product_images = DB::table('product_gallery_images')->where('product_id', $product->id)->get();
                // dd($product_images);
            @endphp
            @if ($product_images->isNotEmpty())
                @foreach ($product_images as $image)
                    <div class="swiper-slide">
                        <a href="{{ route('product_details', $product->slug) }}" >
                            <img data-lazy="{{ asset('uploads/product/' . $image->name) }}" width="330" height="400" alt="{!! $product->name !!}" class="pc__img">
                        </a>
                    </div>
                @endforeach
            @else
                <div class="swiper-slide">
                    <a href="{{ route('product_details', $product->slug) }}" >
                        <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="330" height="400" alt="image not available" class="pc__img">
                    </a>
                </div>
            @endif --}}
            @php
                $product_image = DB::table('product_gallery_images')->where('product_id', $w_product->id)->first();
                // dd($product_image);
            @endphp
            @if (!empty($product_image))
                <div class="swiper-slide">
                    <a href="{{ route('product_details', $w_product->slug) }}" >
                        <img data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="330" height="400" alt="{!! $w_product->name !!}" class="pc__img" id="lazy-img-{{ $w_product->slug }}">
                    </a>
                </div>
            @else
                <div class="swiper-slide">
                    <a href="{{ route('product_details', $w_product->slug) }}" >
                        <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="330" height="400" alt="image not available" class="pc__img" id="lazy-img-{{ $w_product->slug }}">
                    </a>
                </div>
            @endif
        </div>
        {{-- <span class="pc__img-prev">
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_prev_sm" />
            </svg>
        </span>
        <span class="pc__img-next">
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_next_sm" />
            </svg>
        </span> --}}
        </div>
        {{-- <button class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button> --}}
    </div>

    <div class="pc__info position-relative">
        <p class="pc__category">{!! $w_product->category !!}</p>
        <h6 class="pc__title">
            <a href="{{ route('product_details', $w_product->slug) }}" >{!! $w_product->name !!}</a>
            <div class="pc__category">{!! $w_product->brand !!}</div>
        </h6>

        @if(!empty($w_product->actual_price))
            <div class="product-card__price d-flex">
                <span class="money price price-old">₹{{ $w_product->actual_price }}</span>
                <span class="money price price-sale">₹{{ $w_product->price }}</span>
            </div>
        @else
            <div class="product-card__price d-flex">
                <span class="money price">₹{{ $w_product->price }}</span>
            </div>
        @endif

        {{-- <div class="d-flex align-items-center mt-1">
            <a href="#" class="swatch-color pc__swatch-color" style="color: #222222"></a>
            <a href="#" class="swatch-color swatch_active pc__swatch-color" style="color: #b9a16b"></a>
            <a href="#" class="swatch-color pc__swatch-color" style="color: #f5e6e0"></a>
        </div> --}}
        @php
            $rating = get_product_avg_rating($w_product->id);
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
                <span class="reviews-note text-capitalize text-secondary ms-1">({{ $rating }}) {{ product_review_count($w_product->id) }} Reviews</span>
            </div>
        @endif

        <button class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-remove-wishlist" data-wishlist-id="{{ $w_product->wishlist_id }}" title="Remove From Wishlist" style="transition: transform 0.24s ease-in-out;" onmouseover="this.style.transform='scale(1.13)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fa fa-trash fs-4" style="color: #ca001b"></i>
        </button>
    </div>

    <div class="pc-labels position-absolute top-0 start-0 w-100 d-flex justify-content-between">
        @php
            $date = \Carbon\Carbon::now()->subDays(value: 10);
            $product_updated_date = \Carbon\Carbon::parse($w_product->updated_at);

            if($product_updated_date->gte($date)) {
                echo "<div class='pc-labels__left'>
                            <span class='pc-label pc-label_new d-block bg-white shadow-sm'>NEW</span>
                        </div>";
            }
        @endphp

        @if (!empty($w_product->actual_price))
            @php
                $discount_rate = (int)((((float)$w_product->actual_price - (float)$w_product->price) / (float)$w_product->actual_price) * 100);
            @endphp
            <div class="pc-labels__right ms-auto">
                <span class="pc-label pc-label_sale d-block text-white">-{{ $discount_rate }}%</span>
            </div>
        @endif
    </div>

    </div>
</div>
<script>
    var imgTarget = document.getElementById("lazy-img-{{ $w_product->slug }}");

    // Apply the intersection observer for lazyloading on the product image
    lazyloadImage(imgTarget);
</script>
@endforeach
