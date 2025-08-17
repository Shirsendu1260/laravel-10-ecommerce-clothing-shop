@extends('layouts.admin-app')

@section('content')
    {{-- {{ dd($order_items) }} --}}
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin_dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order Details</div>
                    </li>
                </ul>
            </div>

            @include('layouts.alerts')

            @if ($order_items->isNotEmpty())
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Ordered Products</h5>
                        </div>
                        <a class="tf-button style-1 w208" href="{{ route('admin_orders_index') }}">Back</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center p-2" style="width: 90px;">Sl. No.</th>
                                    <th class="text-center p-2">Name</th>
                                    <th class="text-center p-2">Price</th>
                                    <th class="text-center p-2">Quantity</th>
                                    <th class="text-center p-2">SKU</th>
                                    <th class="text-center p-2">Category</th>
                                    <th class="text-center p-2">Brand</th>
                                    <th class="text-center p-2">Expected At</th>
                                    <th class="text-center p-2">Delivered At</th>
                                    <th class="text-center p-2" style="width: 230px;">Action</th>
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
                                        <td class="pname d-flex justify-content-center p-5">
                                            <div class="image">
                                                @if (!empty($order_item->image))
                                                    <img src="{{ asset('uploads/product/thumbnails/' . $order_item->image) }}" alt="{{ $order_item->name }}" class="image">
                                                @else
                                                    <img src="{{ asset('assets/admin/images/unavailable.png') }}" alt="image not available" class="image">
                                                @endif
                                            </div>
                                            <div class="name d-flex align-items-center">
                                                <a href="{{ route('admin_product_edit_page', $order_item->slug) }}" class="body-title-2">{{ $order_item->name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-center p-2">₹{{ round($order_item->price) }}</td>
                                        <td class="text-center p-2">{{ $order_item->qty }}</td>
                                        <td class="text-center p-2">{{ $order_item->sku }}</td>
                                        <td class="text-center p-2">{{ $order_item->category }}</td>
                                        <td class="text-center p-2">{{ $order_item->brand }}</td>
                                        <td class="text-center p-2">{{ date('d M, Y', strtotime($order_item->order_date)) }}</td>
                                        <td class="text-center p-2">{{ !empty($order_item->delivered_date) ? date('d M, Y, h:m a', strtotime($order_item->delivered_date)) : 'Not Delivered Yet' }}</td>
                                        <td class="text-center p-2">
                                            <div class="update-delivery-date-div">
                                                <input type="hidden" name="order_item_id" value="{{ $order_item->id }}">
                                                <input type="text" class="form-control bg-light border update-del-date" name="delivered_date" value="{{ $order_item->delivered_date }}" placeholder="Select Delivered Date" {{ !empty($order_item->delivered_date) || ($order->status != 'ORD') ? 'disabled' : '' }}>
                                                <button type="submit" class="btn btn-sm btn-outline-primary py-2 px-3 rounded mt-2 update-delivery-date {{ !empty($order_item->delivered_date) || ($order->status != 'ORD') ? 'd-none' : '' }}"><i class="bi bi-check-lg"></i> Update</button>
                                            </div>
                                        </td>
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
                                                <td class="pname d-flex justify-content-center p-5">
                                                    <div class="image">
                                                        @if (!empty($addon_order_item->image))
                                                            <img src="{{ asset('uploads/addon-product/thumbnails/' . $addon_order_item->image) }}" alt="{{ $addon_order_item->name }}" class="image">
                                                        @else
                                                            <img src="{{ asset('assets/admin/images/unavailable.png') }}" alt="image not available" class="image">
                                                        @endif
                                                    </div>
                                                    <div class="name d-flex align-items-center">
                                                        <a href="{{ route('admin_addon_product_edit_page', $addon_order_item->slug) }}" class="body-title-2">{{ $addon_order_item->name }}</a>
                                                    </div>
                                                </td>
                                                <td class="text-center p-2">₹{{ round($addon_order_item->price) }}</td>
                                                <td class="text-center p-2">{{ $addon_order_item->qty }}</td>
                                                <td class="text-center p-2">{{ $addon_order_item->sku }}</td>
                                                <td class="text-center p-2">{{ $addon_order_item->a_category }}</td>
                                                <td class="text-center p-2">{{ $addon_order_item->a_brand }}</td>
                                                <td class="text-center p-2"></td>
                                                <td class="text-center p-2"></td>
                                                <td class="text-center p-2"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $order_items->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

            <div class="wg-box mt-5">
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

            <div class="wg-box mt-5">
                <h5>Order & Transaction Details</h5>
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
                                <td class="text-center p-2" style="color: rgb(197, 81, 81)">₹{{ round($order->discount) }}</td>
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
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Select all inputs with the class 'update-del-date'
            const deliveryDateSelectors = $('.update-del-date');

            // Define shared Flatpickr options
            const commonTimePickerOptions = {
                enableTime: true,
                noCalendar: false,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 1,
                defaultHour: new Date().getHours(),
                defaultMinute: new Date().getMinutes(),
            };

            // Initialize Flatpickr for each input individually
            deliveryDateSelectors.each(function () {
                flatpickr(this, {
                    ...commonTimePickerOptions,
                    onChange: function (selectedDates, dateStr, instance) {
                        // Optional: Handle date change per input if needed
                        console.log("Selected time:", dateStr);
                    }
                });
            });



            // Update delivery date of the order item
            $(".update-delivery-date").click(function() {
                let delItemId = $(this).prev().prev().val();
                let delDatetime = $(this).prev().val();
                // console.log(del_item_id);
                // console.log(del_datetime);

                $.ajax({
                    url: "{{ route('admin_update_delivered_date') }}",
                    type: "put",
                    dataType: "json",
                    data: {
                        del_item_id: delItemId,
                        del_datetime: delDatetime,
                    },
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function() {
                        alert("Error occurred while updating this items's delivery date.");
                    }
                });
            });
        });
    </script>
@endpush
