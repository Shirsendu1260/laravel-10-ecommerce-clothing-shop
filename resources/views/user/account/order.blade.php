@extends('layouts.app')

@push('scripts')
    <style>
        .pt-90 {
            padding-top: 90px !important;
        }

        .pr-6px {
            padding-right: 6px;
            text-transform: uppercase;
        }

        .my-account .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 40px;
            border-bottom: 1px solid;
            padding-bottom: 13px;
        }

        .my-account .wg-box {
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            padding: 24px;
            flex-direction: column;
            gap: 24px;
            border-radius: 12px;
            background: var(--White);
            box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
        }

        .bg-success {
            background-color: #40c710 !important;
        }

        .bg-danger {
            background-color: #f44032 !important;
        }

        .bg-warning {
            background-color: #f5d700 !important;
            color: #000;
        }

        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;

        }

        .table-transaction th,
        .table-transaction td {
            padding: 0.625rem 1.5rem .25rem !important;
            color: #000 !important;
        }

        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .25rem !important;
            background-color: #6a6e51 !important;
        }

        .table-bordered>:not(caption)>*>* {
            border-width: inherit;
            line-height: 32px;
            font-size: 14px;
            border: 1px solid #e1e1e1;
            vertical-align: middle;
        }

        .table-striped .image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-striped td:nth-child(1) {
            /* min-width: 250px; */
            padding-bottom: 7px;
        }

        .pname {
            display: flex;
            gap: 13px;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #6a6e51;
        }
    </style>
@endpush

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Order Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                <div class="col-lg-10">
                    @include('layouts.userend-alerts')
                    <div class="wg-box mt-5 mb-5 border">
                        <div class="row">
                            <div class="col-6">
                                <h5>Ordered Details</h5>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-sm btn-danger" href="{{ route('user_orders') }}">Back</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-transaction">
                                <tbody>
                                    <tr>
                                        <th>Order ID</th>
                                        <td>{{ $order->unique_oid }}</td>
                                        <th>Mobile</th>
                                        <td>{{ $order->phonecode }}{{ $order->mobile }}</td>
                                        <th>Zipcode</th>
                                        <td>{{ $order->zip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td colspan="2">{{ date('d M, Y, h:m a', strtotime($order->created_at)) }}</td>
                                        <th>Cancelled Date</th>
                                        <td colspan="2">
                                            @php
                                                if(!empty($order->cancelled_date) && ($order->status == 'CANC')) {
                                                    echo date('d M, Y, h:m a', strtotime($order->cancelled_date));
                                                }
                                                else {
                                                    if($order->status == 'DEL') {
                                                        echo 'Not Applicable';
                                                    }
                                                    else {
                                                        echo 'Not Cancelled Yet';
                                                    }
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td colspan="5">
                                            @php
                                                switch ($order->status) {
                                                    case 'ORD':
                                                        echo '<span class="badge bg-warning text-dark">Ordered</span>';
                                                        break;
                                                    case 'DEL':
                                                        echo '<span class="badge bg-success">Delivered</span>';
                                                        break;
                                                    case 'CANC':
                                                        echo '<span class="badge bg-danger">Cancelled</span>';
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($order_items->isNotEmpty())
                        <div class="wg-box wg-table table-all-user border">
                            <div class="row">
                                <div class="col-6">
                                    <h5>Ordered Items</h5>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl. No.</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">SKU</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Delivered Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_items as $key => $order_item)
                                            @php
                                                $page = !empty(Request::query('page')) ? Request::query('page') : 1;
                                                $index = $key + (($page - 1) * 3) + 1;
                                            @endphp
                                            <tr>
                                                <td class="text-center p-2">{{ $index }}</td>
                                                <td class="pname d-flex justify-content-center p-2">
                                                    <div class="image">
                                                        @if (!empty($order_item->image))
                                                            <img src="{{ asset('uploads/product/thumbnails/' . $order_item->image) }}" alt="{{ $order_item->name }}" class="image">
                                                        @else
                                                            <img src="{{ asset('assets/admin/images/unavailable.png') }}" alt="image not available" class="image">
                                                        @endif
                                                    </div>
                                                    <div class="name d-flex align-items-center">
                                                        <a href="{{ route('product_details', $order_item->slug) }}" class="body-title-2">{{ $order_item->name }}</a>
                                                    </div>
                                                </td>
                                                <td class="text-center p-2">₹{{ round($order_item->price) }}</td>
                                                <td class="text-center p-2">{{ $order_item->qty }}</td>
                                                <td class="text-center p-2">{{ $order_item->sku }}</td>
                                                <td class="text-center p-2">{{ $order_item->category }}</td>
                                                <td class="text-center p-2">{{ $order_item->brand }}</td>
                                                <td class="text-center p-2">
                                                    @php
                                                        if(!empty($order_item->delivered_date) && ($order->status == 'DEL')) {
                                                            echo date('d M, Y, h:m a', strtotime($order_item->delivered_date));
                                                        }
                                                        else {
                                                            if($order->status == 'CANC') {
                                                                echo 'Not Applicable';
                                                            }
                                                            else {
                                                                echo 'Not Delivered Yet';
                                                            }
                                                        }
                                                    @endphp
                                            </tr>
                                            @php
                                                $addon_order_items = DB::table('addon_cart')
                                                                        ->join('addon_products', 'addon_products.id', '=', 'addon_cart.addon_product_id')
                                                                        ->join('brands', 'brands.id', '=', 'addon_products.brand_id')
                                                                        ->join('categories', 'categories.id', '=', 'addon_products.category_id')
                                                                        ->where('addon_cart.cart_id', $order_item->cart_id)
                                                                        ->select('addon_products.id as addon_product_id', 'addon_products.slug', 'addon_products.name', 'addon_products.image', 'addon_products.price', 'addon_products.sku', 'addon_cart.qty', 'brands.name as a_brand', 'categories.name as a_category')
                                                                        ->get();
                                            @endphp
                                            @if ($addon_order_items->isNotEmpty())
                                                @foreach ($addon_order_items as $addon_order_item)
                                                    <tr>
                                                        <td class="text-center p-2"></td>
                                                        <td class="pname d-flex justify-content-center p-2">
                                                            <div class="image">
                                                                @if (!empty($addon_order_item->image))
                                                                    <img src="{{ asset('uploads/addon-product/thumbnails/' . $addon_order_item->image) }}" alt="{{ $addon_order_item->name }}" class="image">
                                                                @else
                                                                    <img src="{{ asset('assets/admin/images/unavailable.png') }}" alt="image not available" class="image">
                                                                @endif
                                                            </div>
                                                            <div class="name d-flex align-items-center">{{ $addon_order_item->name }}</div>
                                                        </td>
                                                        <td class="text-center p-2">₹{{ round($addon_order_item->price) }}</td>
                                                        <td class="text-center p-2">{{ $addon_order_item->qty }}</td>
                                                        <td class="text-center p-2">{{ $addon_order_item->sku }}</td>
                                                        <td class="text-center p-2">{{ $addon_order_item->a_category }}</td>
                                                        <td class="text-center p-2">{{ $addon_order_item->a_brand }}</td>
                                                        <td class="text-center p-2"></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $order_items->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                    <div class="wg-box mt-5 border">
                        <h5>Shipping Address</h5>
                        <div class="my-account__address-item col-md-6">
                            <div class="my-account__address-item__detail">
                                <p class="fw-bold">{{ $order->name }}</p>
                                <p>{{ $order->address }}</p>
                                @if (!empty($order->locality))
                                    <p>{{ $order->locality }}</p>
                                @endif
                                <p>{{ $order->landmark }}</p>
                                <p>{{ $order->city }}, {{ $order->state }}, {{ $order->country }} - {{ $order->zip }}</p>
                                <p>Mobile: {{ $order->phonecode }}{{ $order->mobile }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="wg-box mt-5 border">
                        <h5>Transactions</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-transaction">
                                <tbody>
                                    <tr>
                                        <th class="text-center p-2">Subtotal</th>
                                        <th class="text-center p-2">Shipping</th>
                                        <th class="text-center p-2">Discount</th>
                                        <th class="text-center p-2">Total</th>
                                        <th class="text-center p-2">Payment Mode</th>
                                        <th class="text-center p-2">Payment Status</th>
                                        <th class="text-center p-2">Order Status</th>
                                        <th class="text-center p-2">Order Date</th>
                                        <th class="text-center p-2">Cancelled Date</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center p-2">₹{{ round($order->subtotal) }}</td>
                                        <td class="text-center p-2">₹{{ round($order->shipping) }}</td>
                                        <td class="text-center p-2" style="color: rgb(197, 81, 81) !important">₹{{ round($order->discount) }}</td>
                                        <td class="text-center p-2">₹{{ round($order->total) }}</td>
                                        <td class="text-center p-2">{{ $transaction_details->mode == 'COD' ? 'Cash On Delivery' : 'PhonePe' }}</td>
                                        <td class="text-center p-2">
                                            @php
                                                switch ($transaction_details->status) {
                                                    case 'PEND':
                                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                        break;
                                                    case 'APP':
                                                        echo '<span class="badge bg-success">Approved</span>';
                                                        break;
                                                    case 'DEC':
                                                        echo '<span class="badge bg-danger">Declined</span>';
                                                        break;
                                                    case 'REF':
                                                        echo '<span class="badge bg-secondary">Refunded</span>';
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center p-2">
                                            @php
                                                switch ($order->status) {
                                                    case 'ORD':
                                                        echo '<span class="badge bg-warning text-dark">Ordered</span>';
                                                        break;
                                                    case 'DEL':
                                                        echo '<span class="badge bg-success">Delivered</span>';
                                                        break;
                                                    case 'CANC':
                                                        echo '<span class="badge bg-danger">Cancelled</span>';
                                                        break;
                                                }
                                            @endphp
                                        </td>
                                        <td class="text-center p-2">{{ date('d M, Y, h:m a', strtotime($order->created_at)) }}</td>
                                        <td class="text-center p-2">
                                            @php
                                                if(!empty($order->cancelled_date) && ($order->status == 'CANC')) {
                                                    echo date('d M, Y, h:m a', strtotime($order->cancelled_date));
                                                }
                                                else {
                                                    if($order->status == 'DEL') {
                                                        echo 'Not Applicable';
                                                    }
                                                    else {
                                                        echo 'Not Cancelled Yet';
                                                    }
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($order->status == 'ORD')
                        <div class="wg-box mt-5 text-right border">
                            <div id="cancel-order">
                                <input type="hidden" name="unique_oid" id="unique_oid" value="{{ $order->unique_oid }}">
                                <button type="submit" class="btn btn-danger cancel-order-btn">Cancel Order</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $(".cancel-order-btn").click(function() {
            let uniqueOID = $(this).prev().val();
            // console.log(uniqueOID);

            Swal.fire({
                title: "Do you really want to cancel this order?",
                icon: "warning",
                showCancelButton: true, // Show "Cancel" button
                confirmButtonColor: '#dc3545', // Red color for the "Yes, delete it!" button
                cancelButtonColor: '#1d1d1d', // Black shade
                confirmButtonText: 'Yes, cancel it!', // Custom text for confirm button
            })
            .then(function(result) {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('cancel_order') }}",
                        type: "put",
                        dataType: "json",
                        data: {
                            unique_oid: uniqueOID,
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
                            alert("Error while cancelling the order.");
                        },
                    });
                }
            });
        });
    });
</script>
@endpush
