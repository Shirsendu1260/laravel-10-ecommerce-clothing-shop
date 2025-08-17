@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">

        <div class="main-content-wrap">
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Orders</div>
                                        <h4>{{ total_orders_count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Amount</div>
                                        <h4>₹{{ total_orders_amount() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pending Orders</div>
                                        <h4>{{ total_pending_orders_count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pending Orders Amount</div>
                                        <h4>₹{{ total_pending_orders_amount() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-half">
                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Delivered Orders</div>
                                        <h4>{{ total_delivered_orders_count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Delivered Orders Amount</div>
                                        <h4>₹{{ total_delivered_orders_amount() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Canceled Orders</div>
                                        <h4>{{ total_cancelled_orders_count() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Canceled Orders Amount</div>
                                        <h4>₹{{ total_cancelled_orders_amount() }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Revenue Report</h5>
                    </div>
                    <div class="flex flex-wrap gap40">
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Total</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₹{{ $total_amount }}</h4>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Ordered</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₹{{ $total_ordered_amount }}</h4>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t4"></div>
                                    <div class="text-tiny">Delivered</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₹{{ $total_delivered_amount }}</h4>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t3"></div>
                                    <div class="text-tiny">Cancelled</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₹{{ $total_cancelled_amount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">
                @if ($recent_orders->isNotEmpty())
                    <div class="wg-box">
                        <div class="flex items-center justify-between">
                            <h5>Recent orders</h5>
                            <div class="dropdown default">
                                <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin_orders_index') }}">
                                    <span class="view-all">View all</span>
                                </a>
                            </div>
                        </div>
                        <div class="wg-table table-all-user">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center p-2">Order ID</th>
                                            <th class="text-center p-2">Name</th>
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
                                        @foreach ($recent_orders as $recent_order)
                                            <tr>
                                                <td class="text-center p-2">{{ $recent_order->id }}</td>
                                                <td class="text-center p-2">{{ $recent_order->name }}</td>
                                                <td class="text-center p-2">{{ $recent_order->mobile }}</td>
                                                <td class="text-center p-2">₹{{ $recent_order->subtotal }}</td>
                                                <td class="text-center p-2">₹{{ $recent_order->shipping }}</td>
                                                <td class="text-center p-2" style="color: rgb(197, 81, 81)">
                                                    ₹{{ $recent_order->discount }}</td>
                                                <td class="text-center p-2">₹{{ $recent_order->total }}</td>
                                                <td class="text-center p-2">
                                                    @php
                                                        switch ($recent_order->status) {
                                                            case 'ORD':
                                                                echo 'Ordered';
                                                                break;
                                                            case 'SHP':
                                                                echo 'Shipped';
                                                                break;
                                                            case 'DEL':
                                                                echo 'Delivered';
                                                                break;
                                                            case 'CANC':
                                                                echo 'Cancelled';
                                                                break;
                                                        }
                                                    @endphp
                                                </td>
                                                <td class="text-center p-2">
                                                    {{ date('d M, Y', strtotime($recent_order->created_at)) }}
                                                </td>
                                                <td class="text-center p-2">{{ total_order_items_count($recent_order->id) }}</td>
                                                <td class="text-center p-2">
                                                    <a href="{{ route('admin_order_view_page', $recent_order->id) }}">
                                                        <div class="list-icon-function view-icon">
                                                            <div class="item eye">
                                                                <i class="icon-eye"></i>
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
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            console.log("Welcome to Laravel ECOM Admin Panel.");

            // Chart for revenue
            var tfLineChart = (function () {
                var chartBar = function () {
                    var options = {
                        series: [{
                            name: 'Total',
                            data: [{{ $monthly_total_amounts }}]
                        }, {
                            name: 'Ordered',
                            data: [{{ $monthly_total_ordered_amounts }}]
                        },
                        {
                            name: 'Delivered',
                            data: [{{ $monthly_total_delivered_amounts }}]
                        }, {
                            name: 'Cancelled',
                            data: [{{ $monthly_total_cancelled_amounts }}]
                        }
                        ],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: true,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '8.5px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#D3E4FE', '#8F77F3', '#FF5200'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        },
                        yaxis: {
                            show: true,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "₹" + val + ""
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function () { },

                    load: function () {
                        chartBar();
                    },
                    resize: function () { },
                };
            })();

            jQuery(document).ready(function () { });

            jQuery(window).on("load", function () {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function () { });
        });
    </script>
@endpush
