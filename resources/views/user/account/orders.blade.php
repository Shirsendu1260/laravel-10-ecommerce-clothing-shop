@extends('layouts.app')

@push('scripts')
    <style>
        .table> :not(caption)>tr>th {
        padding: 0.625rem 1.5rem .625rem !important;
        background-color: #6a6e51 !important;
        }

        .table>tr>td {
        padding: 0.625rem 1.5rem .625rem !important;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
        border-width: 1px 1px;
        border-color: #6a6e51;
        }

        .table> :not(caption)>tr>td {
        padding: .8rem 1rem !important;
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
    </style>
@endpush

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Orders</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                @if ($orders->isNotEmpty())
                    <div class="col-lg-10">
                        <div class="wg-table table-all-user mt-5">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center p-3">Order ID</th>
                                            <th class="text-center p-3">Name</th>
                                            <th class="text-center p-3">Mobile</th>
                                            <th class="text-center p-3">Subtotal</th>
                                            <th class="text-center p-3">Shipping</th>
                                            <th class="text-center p-3">Discount</th>
                                            <th class="text-center p-3">Total</th>
                                            <th class="text-center p-3">Status</th>
                                            <th class="text-center p-3">Order Date</th>
                                            <th class="text-center p-3">Items</th>
                                            <th class="text-center p-3"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="text-center p-3"><a href="{{ route('user_order', $order->unique_oid) }}">{{ $order->unique_oid }}</a></td>
                                                <td class="text-center p-3">{{ $order->name }}</td>
                                                <td class="text-center p-3">{{ $order->phonecode }}{{ $order->mobile }}</td>
                                                <td class="text-center p-3">₹{{ $order->subtotal }}</td>
                                                <td class="text-center p-3">₹{{ $order->shipping }}</td>
                                                <td class="text-center text-red p-3">₹{{ $order->discount }}</td>
                                                <td class="text-center p-3">₹{{ $order->total }}</td>
                                                <td class="text-center p-3">
                                                    @php
                                                        switch ($order->status) {
                                                            case 'ORD':
                                                                echo '<span class="badge bg-warning">Ordered</span>';
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
                                                <td class="text-center p-3">{{ date('d M, Y h:m', strtotime($order->created_at)) }}</td>
                                                <td class="text-center p-3">{{ total_order_items_count($order->id) }}</td>
                                                <td class="text-center p-3">
                                                    <a href="{{ route('user_order', $order->unique_oid) }}">
                                                        <div class="list-icon-function view-icon">
                                                            <div class="item eye">
                                                                <i class="fa fa-eye"></i>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('scripts')

@endpush
