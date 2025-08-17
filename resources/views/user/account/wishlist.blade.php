@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Wishlist</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__wishlist">
                        @if ($products->isNotEmpty())
                            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid" data-page="1">
                                @include('user.main.wishlisted-products-con')
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
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        let isLoading = false; // To prevent multiple AJAX calls
        let allWishlistedProductsLoaded = false; // To stop if no more wishlisted products are left to load

        function loadMoreWishlistedProducts() {
            // Prevent the AJAX from triggering if it is in loading state or no more wishlisted products are left to append or both
            if (isLoading || allWishlistedProductsLoaded) {
                return;
            }

            isLoading = true;

            // Code for incrementing page number
            let page = parseInt($("#products-grid").data("page")) + 1;
            $("#products-grid").data("page", page); // Update page number for next AJAX call
            // console.log("Loading page: " + page);

            // Add 'page' parameter to url
            let url_string = window.location.href;
            let url = new URL(url_string);
            url.searchParams.set("page", page);
            url_string = url.href;
            // alert(url_string);

            $.ajax({
                url: url_string,
                type: "get",
                dataType: "json",
                beforeSend: function () {
                    $('#loading').fadeIn('fast');
                },
                success: function (response) {
                    $('#loading').fadeOut('fast');
                    isLoading = false;

                    if (response.wishlisted_products_html.trim() != "") {
                        $("#products-grid").append(response.wishlisted_products_html.trim());

                        if (response.wishlisted_products_has_more_pages == false) {
                            allWishlistedProductsLoaded = true;
                        }
                    }
                    else {
                        allWishlistedProductsLoaded = true;
                        // alert("No more records found.");
                    }
                },
                error: function () {
                    $('#loading').fadeOut('fast');
                    isLoading = false;
                    Swal.fire({
                        title: "Error!",
                        text: "Error loading more products.",
                        icon: "error"
                    });
                },
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            // Load more on infinite scroll
            $(window).scroll(function () {
                if (($(window).scrollTop() + $(window).height()) > ($(document).height() - 350)) {
                    // alert(`Reached bottom - ${$(window).scrollTop() + $(window).height()} vs ${$(document).height() - 100}`);

                    @if ($products->isNotEmpty())
                        loadMoreWishlistedProducts();
                    @endif
                }
            });

            // Remove from wishlist trigger
            $(document).on("click", ".js-remove-wishlist", function() {
                let wishlistId = $(this).data("wishlist-id");

                Swal.fire({
                    title: "Do you really want to remove this item from wishlist?",
                    icon: "warning",
                    showCancelButton: true, // Show "Cancel" button
                    confirmButtonColor: '#dc3545', // Red color for the "Yes, delete it!" button
                    cancelButtonColor: '#1d1d1d', // Black shade
                    confirmButtonText: 'Yes, remove it!', // Custom text for confirm button
                })
                .then(function(result) {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('remove_from_wishlist') }}",
                            type: "delete",
                            dataType: "json",
                            data: {
                                id: wishlistId,
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
                                        position: "top-end",
                                        icon: "error",
                                        title: response.msg,
                                        toast: true,
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                }
                            },
                            error: function() {
                                alert("Error while removing the product from wishlist.");
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
