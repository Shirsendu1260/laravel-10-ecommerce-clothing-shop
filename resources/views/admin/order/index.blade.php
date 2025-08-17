@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
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
                        <div class="text-tiny">Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                @include('layouts.alerts')
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here" class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center p-2">Order ID</th>
                                    <th class="text-center p-2">Customer Name</th>
                                    <th class="text-center p-2">Recipient Name</th>
                                    <th class="text-center p-2">Mobile</th>
                                    <th class="text-center p-2">Subtotal</th>
                                    <th class="text-center p-2">Shipping</th>
                                    <th class="text-center p-2">Discount</th>
                                    <th class="text-center p-2">Total</th>
                                    <th class="text-center p-2">Status</th>
                                    <th class="text-center p-2">Order Date</th>
                                    <th class="text-center p-2">Total Items</th>
                                    <th class="text-center p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->isNotEmpty())
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center p-2">{{ $order->id }}</td>
                                            <td class="text-center p-2">{{ $order->customer_name }}</td>
                                            <td class="text-center p-2">{{ $order->name }}</td>
                                            <td class="text-center p-2">{{ $order->mobile }}</td>
                                            <td class="text-center p-2">₹{{ $order->subtotal }}</td>
                                            <td class="text-center p-2">₹{{ $order->shipping }}</td>
                                            <td class="text-center p-2" style="color: rgb(197, 81, 81)">₹{{ $order->discount }}</td>
                                            <td class="text-center p-2">₹{{ $order->total }}</td>
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
                                            <td class="text-center p-2">{{ date('d M, Y', strtotime($order->created_at)) }}</td>
                                            <td class="text-center p-2">{{ total_order_items_count($order->id) }}</td>
                                            <td class="text-center p-2">
                                                <a href="{{ route('admin_order_view_page', $order->id) }}">
                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="icon-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-secondary text-center">Records not found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="divider" style="margin-bottom: 20px"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination justify-content-end">
                        {{ $orders->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush
