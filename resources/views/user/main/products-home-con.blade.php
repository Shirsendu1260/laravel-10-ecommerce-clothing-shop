@foreach ($featured_products as $product)
<div class="col-6 col-md-4 col-lg-3">
    <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
        <div class="pc__img-wrapper">
            @php
                $product_image = DB::table('product_gallery_images')->where('product_id', $product->id)->first();
                // dd($product_image);
            @endphp
            <a href="{{ route('product_details', $product->slug) }}">
                @if (!empty($product_image))
                    <img data-lazy="{{ asset('uploads/product/' . $product_image->name) }}" width="330" height="400" alt="{!! $product->name !!}" class="pc__img" id="lazy-img-{{ $product->slug }}">
                @else
                    <img data-lazy="{{ asset('assets/user/images/img_not_available.jpg') }}" width="330" height="400" alt="image not available" class="pc__img" id="lazy-img-{{ $product->slug }}">
                @endif
            </a>
        </div>

        <div class="pc__info position-relative">
            <h6 class="pc__title"><a href="{{ route('product_details', $product->slug) }}">{!! $product->name !!}</a></h6>
            @if(!empty($product->actual_price))
                <div class="product-card__price d-flex">
                    <span class="money price price-old">₹{{ $product->actual_price }}</span>
                    <span class="money price text-secondary">₹{{ $product->price }}</span>
                </div>
            @else
                <div class="product-card__price d-flex">
                    <span class="money price">₹{{ $product->price }}</span>
                </div>
            @endif

            <div class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                {{-- <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside" data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                    <span class="d-none d-xxl-block">Quick View</span>
                    <span class="d-block d-xxl-none">Quick View</span>
                </button> --}}
                <div class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside" title="Price">
                    ₹{{ $product->price }}
                </div>
                <a href="{{ route('product_details', $product->slug) }}" class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view" title="View">
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
                $date = \Carbon\Carbon::now()->subDays(value: 10);
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

            @if (!empty($product->actual_price))
                @php
                    $discount_rate = round((((float)$product->actual_price - (float)$product->price) / (float)$product->actual_price) * 100);
                @endphp
                <div class="pc-labels__right ms-auto">
                    <span class="pc-label pc-label_sale d-block text-white">-{{ $discount_rate }}%</span>
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    var imgTarget = document.getElementById("lazy-img-{{ $product->slug }}");

    // Apply the intersection observer for lazyloading on the product image
    lazyloadImage(imgTarget);
</script>
@endforeach
