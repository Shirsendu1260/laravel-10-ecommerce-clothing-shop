@extends('layouts.app')

@section('content')
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
      <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
        <div class="aside-header d-flex d-lg-none align-items-center">
          <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
          <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
        </div>

        <div class="pt-4 pt-lg-0"></div>

        @if ($categories->isNotEmpty())
            <div class="accordion" id="categories-list">
            <div class="accordion-item mb-4 pb-3">
                <h5 class="accordion-header" id="accordion-heading-1">
                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                    Product Category Pages
                    <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                        <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                    </g>
                    </svg>
                </button>
                </h5>
                <div id="accordion-filter-1" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                <div class="accordion-body px-0 pb-0 pt-3">
                    <ul class="list list-inline mb-0">
                        @foreach ($categories as $category)
                            <li class="list-item">
                                <a href="{{ route('shop', $category->slug) }}" class="menu-link menu-link_us-s pt-1 pb-2 {{ ((!empty($category_selected)) && ($category->slug == $category_selected)) ? 'fw-bold' : '' }}">{!! $category->name !!}</a>
                            </li>
                        @endforeach
                        <br>
                        <li class="list-item">
                            <a href="{{ route('shop') }}" class="menu-link menu-link_us-s text-uppercase pt-1 pb-2">UNDO ALL SELECTION</a>
                        </li>
                    </ul>
                </div>
                </div>
            </div>
            </div>
        @endif

        {{-- <div class="accordion" id="color-filters">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-1">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-2" aria-expanded="true" aria-controls="accordion-filter-2">
                Color
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-2" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-1" data-bs-parent="#color-filters">
              <div class="accordion-body px-0 pb-0">
                <div class="d-flex flex-wrap">
                  <a href="#" class="swatch-color js-filter" style="color: #0a2472"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d7bb4f"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #282828"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #b1d6e8"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #9c7539"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d29b48"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #e6ae95"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #d76b67"></a>
                  <a href="#" class="swatch-color swatch_active js-filter" style="color: #bababa"></a>
                  <a href="#" class="swatch-color js-filter" style="color: #bfdcc4"></a>
                </div>
              </div>
            </div>
          </div>
        </div> --}}

        <div class="accordion" id="size-filters">
          <div class="accordion-item mb-4 pb-3">
            <h5 class="accordion-header" id="accordion-heading-size">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-size" aria-expanded="true" aria-controls="accordion-filter-size">
                Sizes
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-size" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-size" data-bs-parent="#size-filters">
              <div class="accordion-body px-0 pb-0">
                <div class="d-flex flex-wrap">
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('xs', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">XS</a>
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('s', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">S</a>
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('m', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">M</a>
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('l', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">L</a>
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('xl', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">XL</a>
                  <a href="javascript:void(0)" class="swatch-size btn btn-sm btn-outline-light mb-3 me-3 js-filter {{ in_array('xxl', explode('--', Request::query('sizes'))) ? 'swatch_active' : '' }}">XXL</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        @if ($brands->isNotEmpty())
            <div class="accordion" id="brand-filters">
            <div class="accordion-item mb-4 pb-3">
                <h5 class="accordion-header" id="accordion-heading-brand">
                <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-brand" aria-expanded="true" aria-controls="accordion-filter-brand">
                    Brands
                    <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                    <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                        <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                    </g>
                    </svg>
                </button>
                </h5>
                <div id="accordion-filter-brand" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-brand" data-bs-parent="#brand-filters">
                <div class="search-field multi-select accordion-body px-0 pb-0">
                    {{-- <div class="search-field__input-wrapper mb-3">
                        <input type="text" name="brand" id="search-brand" class="form-control form-control-sm border-light border-2" placeholder="Search" />
                    </div> --}}
                    <ul class="list list-inline mb-0 brand-list">
                        @include('user.main.brands-list')
                    </ul>
                    <div class="row my-4" id="brands-loading" style="display: none;">
                        <div class="col-md-12 text-center">
                            <div class="spinner-border text-dark" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        @endif

        <div class="accordion" id="price-filters">
          <div class="accordion-item mb-4">
            <h5 class="accordion-header mb-2" id="accordion-heading-price">
              <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-price" aria-expanded="true" aria-controls="accordion-filter-price">
                Price
                <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                  <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0492049 5.27473 -0.049205 5.62357 0.147611 5.83813C0.344427 6.05323 0.664108 6.05323 0.860924 5.83813L5 1.32706L9.13858 5.83867C9.33589 6.05378 9.65507 6.05378 9.85239 5.83867C10.0492 5.62357 10.0492 5.27473 9.85239 5.06018L5.35668 0.159286Z" />
                  </g>
                </svg>
              </button>
            </h5>
            <div id="accordion-filter-price" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-price" data-bs-parent="#price-filters">
              <input class="price-range-slider" type="text" name="price_range" value="" data-slider-min="0" data-slider-max="20000" data-slider-step="1000" data-slider-value="[{{ $min_price }}, {{ $max_price }}]" data-currency="₹" />
              {{-- <input type="text" class="range-slider" name="price_range" value=""> --}}
              <div class="price-range__info d-flex align-items-center mt-2">
                <div class="me-auto">
                  <span class="text-secondary">Min Price: </span>
                  <span class="price-range__min">₹{{ $min_price }}</span>
                </div>
                <div>
                  <span class="text-secondary">Max Price: </span>
                  <span class="price-range__max">₹{{ $max_price }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="shop-list flex-grow-1">
        <div class="swiper-container js-swiper-slider slideshow slideshow_small slideshow_split" data-settings='{
            "autoplay": {
              "delay": 5000
            },
            "slidesPerView": 1,
            "effect": "fade",
            "loop": true,
            "pagination": {
              "el": ".slideshow-pagination",
              "type": "bullets",
              "clickable": true
            }
          }'>
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center" style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2 class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Women's <br /><strong>ACCESSORIES</strong>
                    </h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                        Accessories are the best way to update your look. Add a title edge with new styles and new colors, or go for timeless pieces.
                    </p>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{ asset('assets/user/images/shop/shop_banner3.jpg') }}" width="630" height="450" alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center"
                  style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2 class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Women's <br /><strong>ACCESSORIES</strong>
                    </h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                        Accessories are the best way to update your look. Add a title edge with new styles and new colors, or go for timeless pieces.
                    </p>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{ asset('assets/user/images/shop/shop_banner3.jpg') }}" width="630" height="450" alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>

            <div class="swiper-slide">
              <div class="slide-split h-100 d-block d-md-flex overflow-hidden">
                <div class="slide-split_text position-relative d-flex align-items-center" style="background-color: #f5e6e0;">
                  <div class="slideshow-text container p-3 p-xl-5">
                    <h2 class="text-uppercase section-title fw-normal mb-3 animate animate_fade animate_btt animate_delay-2">
                      Women's <br /><strong>ACCESSORIES</strong>
                    </h2>
                    <p class="mb-0 animate animate_fade animate_btt animate_delay-5">
                        Accessories are the best way to update your look. Add a title edge with new styles and new colors, or go for timeless pieces.
                    </p>
                  </div>
                </div>
                <div class="slide-split_media position-relative">
                  <div class="slideshow-bg" style="background-color: #f5e6e0;">
                    <img loading="lazy" src="{{ asset('assets/user/images/shop/shop_banner3.jpg') }}" width="630" height="450" alt="Women's accessories" class="slideshow-bg__img object-fit-cover" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container p-3 p-xl-5">
            <div class="slideshow-pagination d-flex align-items-center position-absolute bottom-0 mb-4 pb-xl-2"></div>
          </div>
        </div>

        <div class="mb-3 pb-2 pb-xl-3"></div>

        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="{{ route('home') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <a class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
          </div>

          <div class="shop-acs d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
            <select class="shop-acs__select form-select w-auto border-0 py-0 pe-4 order-1 order-md-0" aria-label="Sort Items" name="total-number" id="sorting-selector">
              <option value="" selected>Sort By: None</option>
              <option value="featured" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'featured')) ? 'selected' : '' }}>Sort By: Featured</option>
              <option value="best_selling" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'best_selling')) ? 'selected' : '' }}>Sort By: Best Selling</option>
              <option value="a_to_z" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'a_to_z')) ? 'selected' : '' }}>Sort By: Alphabetically, A-Z</option>
              <option value="z_to_a" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'z_to_a')) ? 'selected' : '' }}>Sort By: Alphabetically, Z-A</option>
              <option value="low_to_high" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'low_to_high')) ? 'selected' : '' }}>Sort By: Price, Low to High</option>
              <option value="high_to_low" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'high_to_low')) ? 'selected' : '' }}>Sort By: Price, High to Low</option>
              <option value="old_to_new" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'old_to_new')) ? 'selected' : '' }}>Sort By: Date, Old to New</option>
              <option value="new_to_old" {{ (!empty($sort_by_selected) && ($sort_by_selected == 'new_to_old')) ? 'selected' : '' }}>Sort By: Date, New to Old</option>
            </select>

            {{-- <div class="shop-asc__seprator mx-3 bg-light d-none d-md-block order-md-0"></div> --}}

            <div class="shop-filter d-flex align-items-center order-0 order-md-3 d-lg-none">
              <button class="btn-link btn-link_f d-flex align-items-center ps-0 js-open-aside" data-aside="shopFilter">
                <svg class="d-inline-block align-middle me-2" width="14" height="10" viewBox="0 0 14 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_filter" />
                </svg>
                <span class="text-uppercase fw-medium d-inline-block align-middle">Filter</span>
              </button>
            </div>
          </div>
        </div>

        @if ($products->isNotEmpty())
            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid" data-page="1">
                @include('user.main.products-con')
            </div>
        @else
            <div class="d-flex justify-content-center align-items-center flex-column py-5">
                <img data-lazy="{{ asset('assets/user/images/404.png') }}" width="600" class="lazy-img">
                <h4 class="mt-3 text-uppercase">No records found.</h4>
            </div>
        @endif

        <div class="row my-5" id="loading" style="display: none;">
            <div class="col-md-12 text-center">
                <div class="spinner-border text-dark" role="status" style="width: 2.7rem; height: 2.7rem;"></div>
            </div>
        </div>

        {{-- <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
          <a href="#" class="btn-link d-inline-flex align-items-center">
            <svg class="me-1" width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_prev_sm" />
            </svg>
            <span class="fw-medium">PREV</span>
          </a>
          <ul class="pagination mb-0">
            <li class="page-item"><a class="btn-link px-1 mx-2 btn-link_active" href="#">1</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">2</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">3</a></li>
            <li class="page-item"><a class="btn-link px-1 mx-2" href="#">4</a></li>
          </ul>
          <a href="#" class="btn-link d-inline-flex align-items-center">
            <span class="fw-medium me-1">NEXT</span>
            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
              <use href="#icon_next_sm" />
            </svg>
          </a>
        </nav> --}}
      </div>
    </section>
  </main>
@endsection

@push('scripts')
  {{-- {{ dd(Session::all()) }} --}}

  <script>
    let isLoading = false; // To prevent multiple AJAX calls
    let allProductsLoaded = false; // To stop if no more products are left for further load more call
    let brandsStr = null;
    let sizesStr = null;
    let sortByStr = null;
    let min = 0;
    let max = 20000;
    let urlStr = null;
    let currentAjax = null;

    // Flags
    let brands = false;
    let sizes = false;
    let prices = false;
    let sort = false;
    let loadMore = false;

    @if($products_has_more_pages == false)
      allProductsLoaded = true;
    @endif


    /**************************** Function to load products based on different requests ****************************/
    function fetchProducts() {
        // Prevent this function from running anymore if it is in loading state or no more products are left to append or both
        if(isLoading || allProductsLoaded) {
            return;
        }

        let url = new URL(window.location.href);
        isLoading = true;

        // For brand based filtration Request
        if(brands == true) {
            if((brandsStr != null) && (brandsStr != "")) {
                url.searchParams.set("brands", brandsStr);
            }
            else {
                url.searchParams.delete("brands");
            }

            urlStr = url.href;

            // Update url without page refresh
            window.history.pushState(null, "", urlStr);
        }

        // For size based filtration request
        if(sizes == true) {
            if((sizesStr != null) && (sizesStr != "")) {
                url.searchParams.set("sizes", sizesStr);
            }
            else {
                url.searchParams.delete("sizes");
            }

            urlStr = url.href;

            // Update url without page refresh
            window.history.pushState(null, "", urlStr);
        }

        // For sort by request
        if(sort == true) {
            if((sortByStr != null) && (sortByStr != "")) {
                url.searchParams.set("sort_by", sortByStr);
            }
            else {
                url.searchParams.delete("sort_by");
            }

            urlStr = url.href;

            // Update url without page refresh
            window.history.pushState(null, "", urlStr);
        }

        // For price based filtration request
        if(prices == true) {
            if((min >= 0) && (max <= 20000)) {
                url.searchParams.set("min", min);
                url.searchParams.set("max", max);

                $(".price-range__min").text("₹" + min);
                $(".price-range__max").text("₹" + max);
            }
            else {
                url.searchParams.delete("min");
                url.searchParams.delete("max");
            }

            urlStr = url.href;

            // Update url without page refresh
            window.history.pushState(null, "", urlStr);
        }

        // For load more request
        if(loadMore == true) {
            // Code for incrementing page number
            let page = parseInt($("#products-grid").data("page")) + 1;
            $("#products-grid").data("page", page); // Update page number for next AJAX call
            // console.log("Loading page: " + page);

            url.searchParams.set("page", page);
            urlStr = url.href;
            // alert(urlStr);
        }

        // Abort previous AJAX request if it's still active
        if(currentAjax && currentAjax.readyState != 4) {
            currentAjax.abort();
        }

        // Show loader only if not already visible
        if (!$('#loading').is(':visible')) {
            $('#loading').show();
        }

        currentAjax = $.ajax({
            url: urlStr,
            type: "get",
            dataType: "json",
            success: function(response) {
                $('#loading').fadeOut('fast');
                isLoading = false;

                if(response.products_html.trim() != "") {
                    console.log(`1: ${brands} ${sizes} ${prices} ${sort} ${loadMore}`);

                    if(((brands == true) || (sizes == true) || (prices == true) || (sort == true)) && (loadMore == false)) {
                        $("#products-grid").html(response.products_html.trim());
                    }
                    else if(loadMore == true) {
                        $("#products-grid").append(response.products_html.trim());
                    }

                    if(response.products_has_more_pages == false) {
                        allProductsLoaded = true;
                    }
                }
                else {
                    console.log(`2: ${brands} ${sizes} ${prices} ${sort} ${loadMore}`);

                    // Show no products found
                    $("#products-grid").empty(); // Empty all products
                    $("#no-products-ajax").remove(); // Remove the 'No records found' div (if it was already appended by ajax)
                    $("#products-grid").after(`<div class="d-flex justify-content-center align-items-center flex-column py-5" id="no-products-ajax">
                                                    <img src="{{ asset('assets/user/images/404.png') }}" width="600">
                                                    <h4 class="mt-3 text-uppercase">No records found.</h4>
                                                </div>`); // Add the new 'No records found' div

                    allProductsLoaded = true;
                    // alert("No more records found.");
                }
            },
            error: function(xhr, status, error) {
                $('#loading').fadeOut('fast');
                isLoading = false;
                // console.error("Error");

                // Showing the error except the error that was due to an abort
                if(status != "abort") {
                    Swal.fire({
                        title: "Error!",
                        text: "Error loading more products.",
                        icon: "error"
                    });
                }
            },
        });
    }
  </script>

  <script>
    $(document).ready(function() {
        // Load more on infinite scroll
        $(window).scroll(function() {
            if(($(window).scrollTop() + $(window).height()) > ($(document).height() - 450)) {
                // alert(`Reached bottom - ${$(window).scrollTop() + $(window).height()} vs ${$(document).height() - 100}`);

                @if ($products->isNotEmpty())
                    brands = false;
                    sizes = false;
                    prices = false;
                    sort = false;
                    loadMore = true; // Flag activated

                    fetchProducts();
                @endif
            }
        });

        // Sorting
        $("#sorting-selector").change(function() {
            sortByStr = $(this).val();
            // alert(sortByStr);

            // Reset to page 1 whenever we need to start over the load more call
            $("#products-grid").data("page", 1);

            // Reset to default settings
            isLoading = false;
            allProductsLoaded = false;

            brands = false;
            sizes = false;
            prices = false;
            sort = true; // Flag activated
            loadMore = false;

            fetchProducts();
        });

        // Available sizes based filtration
        $(".swatch-size").click(function() {
            let selectedSizes = $(".swatch_active");
            let selectedSizesLen = selectedSizes.length;

            // Reset to page 1 whenever we need to start over the load more call
            $("#products-grid").data("page", 1);

            // Reset to default settings
            isLoading = false;
            allProductsLoaded = false;

            brands = false;
            sizes = true; // Flag activated
            prices = false;
            sort = false;
            loadMore = false;

            if(selectedSizesLen > 0) {
                sizesStr = "";
                for(let i=0; i<selectedSizesLen; i++) {
                    let size = selectedSizes[i].innerText.toLowerCase();

                    if(i == selectedSizesLen - 1) {
                        sizesStr = sizesStr + size;
                    }
                    else {
                        sizesStr = sizesStr + size + "--";
                    }
                }

                fetchProducts();
                // console.log(sizesStr);
            }
            else {
                sizesStr = null;
                fetchProducts();
            }
        });

        // Brand filtration
        $(document).on("change", ".chk-brand", function() {
            let markedCheckboxes = $(".chk-brand:checked");
            // console.log(markedCheckboxes.length);

            // Reset to page 1 whenever we need to start over the load more call
            $("#products-grid").data("page", 1);

            // Reset to default settings
            isLoading = false;
            allProductsLoaded = false;

            brands = true; // Flag activated
            sizes = false;
            prices = false;
            sort = false;
            loadMore = false;

            if(markedCheckboxes.length > 0) {
                // Append slug of the selected brands to 'brandsArr' array
                let brandsArr = [];
                for(let i=0; i<markedCheckboxes.length; i++) {
                    brandsArr.push(markedCheckboxes[i].value);
                }

                // Get brands as '--' seperated string
                brandsStr = brandsArr.join('--');
                // console.log(brandsStr);

                fetchProducts();
            }
            else {
                brandsStr = null;
                // console.log(brandsStr);

                fetchProducts();
            }
        });

        // Brand Search
        // $("#search-brand").on("input", function() {});

        // Handle the brands show/hide toggling functionality
        let hiddenBrands = $(".hidden-brand");
        $("#toggle-brands").click(function() {
            // If currently the 'MORE ...' link is shown, show all hidden brands
            if (hiddenBrands.hasClass("d-none")) {
                hiddenBrands.removeClass('d-none');
                $(this).text("LESS");
            }
            // If currently the 'LESS' link is shown, hide brands beyond the initial limit
            else {
                hiddenBrands.addClass('d-none');
                $(this).text("MORE ...");
            }
        });

        // Price based filtration
        $(".price-range-slider").on("change", function() {
            let rangeVal = $(this).val();
            rangeVal = rangeVal.split(",");
            min = rangeVal[0];
            max = rangeVal[1];

            // Reset to page 1 whenever we need to start over the load more call
            $("#products-grid").data("page", 1);

            // Reset to default settings
            isLoading = false;
            allProductsLoaded = false;

            brands = false;
            sizes = false;
            prices = true; // Flag activated
            sort = false;
            loadMore = false;

            fetchProducts();
        });
    });
  </script>
@endpush
