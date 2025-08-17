@php
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/admin/images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/sweetalert.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/custom.css') }}">

    <style>
        .dropzone {
            border: none;
            background: transparent;
            padding: 0;
        }

        .dz-message {
            margin: 0;
        }

        .dz-remove {
            padding-top: 8.5px;
            color: #2275fc;
        }

        .product-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 15px;
            transition: all 0.3s ease;
            padding-right: 5px;
        }

        .product-item .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            gap: 10px;
            flex-shrink: 0;
            padding: 5px;
            border-radius: 10px;
            background: #eff4f8;
        }

        #box-content-search li {
            list-style: none;
        }

        #box-content-search .product-item {
            margin-bottom: 10px;
        }
    </style>

    @stack('styles')
</head>

<body class="body">
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                <!-- <div id="preload" class="preload-container">
                    <div class="preloading">
                        <span></span>
                    </div>
                </div> -->

                <div class="section-menu-left">
                    <div class="box-logo">
                        {{-- <a href="index.html" id="site-logo-inner">
                            <img class="" id="logo_header" alt="" src="images/logo/logo.png"
                                data-light="images/logo/logo.png" data-dark="images/logo/logo.png">
                        </a> --}}
                        @include('layouts.admin-app-logo')
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{ route('admin_dashboard') }}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_product_create_page') }}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_products_index') }}" class="">
                                                <div class="text">Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Addon Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_addon_product_create_page') }}" class="">
                                                <div class="text">Add Addon Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_addon_products_index') }}" class="">
                                                <div class="text">Addon Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Brands</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_brand_create_page') }}" class="">
                                                <div class="text">New Brand</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_brands_index') }}" class="">
                                                <div class="text">Brands</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Categories</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_category_create_page') }}" class="">
                                                <div class="text">New Category</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_categories_index') }}" class="">
                                                <div class="text">Categories</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Delivery Methods</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_delivery_method_create_page') }}" class="">
                                                <div class="text">New Delivery Method</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_delivery_methods_index') }}" class="">
                                                <div class="text">Delivery Methods</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Delivery Timeslots</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_delivery_timeslot_create_page') }}" class="">
                                                <div class="text">New Delivery Timeslot</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_delivery_timeslots_index') }}" class="">
                                                <div class="text">Delivery Timeslots</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Coupons</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_coupon_create_page') }}" class="">
                                                <div class="text">New Coupon</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin_coupons_index') }}" class="">
                                                <div class="text">Coupons</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Orders</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="" class="">
                                                <div class="text">Orders</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="order-tracking.html" class="">
                                                <div class="text">Order tracking</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
                                <li class="menu-item">
                                    <a href="{{ route('admin_orders_index') }}" class="">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Orders</div>
                                        @if(total_pending_orders_count() > 0)
                                            <span class="badge rounded-pill bg-primary">{{ total_pending_orders_count() }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin_contact_messages_index') }}" class="">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Contact Messages</div>
                                        @if(non_replied_contact_msgs_count() > 0)
                                        <span class="badge rounded-pill bg-primary">{{ non_replied_contact_msgs_count() }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin_slides_index') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Sliders</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin_users_index') }}" class="">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">Users</div>
                                    </a>
                                </li>

                                {{-- <li class="menu-item">
                                    <a href="settings.html" class="">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Settings</div>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="section-content-right">
                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                {{-- <a href="index-2.html">
                                    <img class="" id="logo_header_mobile" alt=""
                                        src="images/logo/logo.png" data-light="images/logo/logo.png"
                                        data-dark="images/logo/logo.png" data-width="154px" data-height="52px"
                                        data-retina="images/logo/logo.png">
                                </a> --}}
                                {{-- <div id="logo_header_mobile">
                                    <a href="{{ route('admin_dashboard') }}"
                                        class="text-secondary text-decoration-none fs-3 fw-bold">LE <span
                                            class="text-dark">ADMIN</span></a>
                                </div> --}}
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>

                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search products here" id="search-input" class="show-search" name="search" tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button id="search-btn" type="button"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">
                                        <ul id="box-content-search"></ul>
                                    </div>
                                </form>

                            </div>

                            <div class="header-grid">
                                <!-- <div class="popup-wrap message type-header">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end has-content"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li>
                                                <h6>Notifications</h6>
                                            </li>
                                            <li>
                                                <div class="message-item item-1">
                                                    <div class="image">
                                                        <i class="icon-noti-1"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Discount available</div>
                                                        <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                            at, ullamcorper nec diam</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-2">
                                                    <div class="image">
                                                        <i class="icon-noti-2"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Account has been verified</div>
                                                        <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                            et</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-3">
                                                    <div class="image">
                                                        <i class="icon-noti-3"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order shipped successfully</div>
                                                        <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                            sollicitudin</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-item item-4">
                                                    <div class="image">
                                                        <i class="icon-noti-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                        </div>
                                                        <div class="text-tiny">Ultricies at rhoncus at ullamcorper
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><a href="#" class="tf-button w-full">View all</a></li>
                                        </ul>
                                    </div>
                                </div> -->
                                {{-- {{ dd(Auth::user()) }} --}}

                                @if (Auth::check())
                                    <div class="popup-wrap user type-header">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="header-user wg-user">
                                                    <span class="image">
                                                        <img class="border" src="{{ asset('assets/admin/images/avatar/user.png') }}" alt="user-icon">
                                                    </span>
                                                    <span class="flex flex-column">
                                                        <span class="body-title mb-2">{{ Auth::user()->name }}</span>
                                                        <span class="text-tiny">{{ Auth::user()->email }}</span>
                                                    </span>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end has-content"
                                                aria-labelledby="dropdownMenuButton3">
                                                <li>
                                                    <a href="{{ route('admin_account_details') }}" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-user"></i>
                                                        </div>
                                                        <div class="body-title-2">Account</div>
                                                    </a>
                                                </li>
                                                {{-- <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-mail"></i>
                                                        </div>
                                                        <div class="body-title-2">Inbox</div>
                                                        <div class="number">27</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-file-text"></i>
                                                        </div>
                                                        <div class="body-title-2">Taskboard</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-headphones"></i>
                                                        </div>
                                                        <div class="body-title-2">Support</div>
                                                    </a>
                                                </li> --}}
                                                <li>
                                                    <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="user-item">
                                                        <div class="icon">
                                                            <i class="icon-log-out"></i>
                                                        </div>
                                                        <div class="body-title-2">Log out</div>
                                                    </a>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="main-content">

                        {{-- Main content here --}}
                        @yield('content')

                        <div class="bottom-page" style="gap: 0px">
                            <div class="body-text">© 2025 {{ config('app.name', 'Laravel') }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ dd(Auth::user()->email) }} --}}

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dropzone-min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".summernote").summernote({
                height: 250,
                toolbar: [
                    ['bold'],
                    ['italic'],
                    ['underline'],
                    ['clear'], // Remove Font Style button
                    ['ul'], // Bulleted list button
                    ['ol'],   // Ordered list button
                    ['codeview'],
                ],
            });
        });
    </script>

    <script>
        // For searching
        let current_search_ajax = null;

        function search_products() {
            let search = $("#search-input").val();

            // Abort previous AJAX request if it's still active
            if(current_search_ajax && current_search_ajax.readyState != 4) {
                current_search_ajax.abort();
            }

            if(search.length >= 2) {
                current_search_ajax = $.ajax({
                    url: "{{ route('admin_search') }}",
                    type: "get",
                    dataType: "json",
                    data: {search: search},
                    success: function(response) {
                        $("#box-content-search").empty();

                        $.each(response.searched_products, function(index, item) {
                            let url = "{{ route('admin_product_edit_page', 'product_slug') }}";
                            url = url.replace("product_slug", item.slug);
                            let img_src = item.image ? `{{ asset('uploads/product/thumbnails' ) }}/${item.image}` : `{{ asset('assets/user/images/img_not_available.jpg') }}`;

                            $("#box-content-search").append(`
                                <li>
                                  <ul>
                                    <li class="product-item gap14 mb-10">
                                      <div class="image no-bg"><img loading="lazy" src="${img_src}" alt="${item.name}" /></div>
                                      <div class="flex items-center justify-between gap20 flex-row">
                                        <div class="name">
                                          <a href="${url}" class="body-text">${item.name}</a>
                                        </div>
                                      </div>
                                    </li>
                                    <li class="mb-10">
                                      <div class="divider"></div>
                                    </li>
                                  </ul>
                                </li>
                            `);
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Showing the error except the error that was due to an abort
                        if(textStatus != "abort") {
                            alert("Error while searching products.");
                        }
                    }
                });
            }
        }

        $(document).ready(function() {
            $("#search-input").on("input", function() { search_products(); });
            $("#search-btn").click(function() { search_products(); });

            $("#search-input").on("submit", function(e) {
                e.preventDefault();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
