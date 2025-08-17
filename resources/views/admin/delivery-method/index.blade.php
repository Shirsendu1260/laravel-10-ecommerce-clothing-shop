@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Delivery Methods</h3>
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
                        <div class="text-tiny">Delivery Methods</div>
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
                    <a class="tf-button style-1 w208" href="{{ route('admin_delivery_method_create_page') }}"><i class="icon-plus"></i>Add New</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center p-2">#</th>
                                    <th class="text-center p-2">Name</th>
                                    <th class="text-center p-2">Slug</th>
                                    <th class="text-center p-2">Price</th>
                                    <th class="text-center p-2">Updated At</th>
                                    <th class="text-center p-2">Status</th>
                                    <th class="text-center p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($delivery_methods->isNotEmpty())
                                    @foreach ($delivery_methods as $key => $delivery_method)
                                        <tr>
                                            @php
                                            $page = !empty(Request::query('page')) ? Request::query('page') : 1;
                                            $index = $key + (($page - 1) * 7) + 1;
                                            @endphp
                                            <td class="text-center p-2">{{ $index }}</td>
                                            <td class="pname d-flex justify-content-center p-5">
                                                <div class="name d-flex align-items-center">
                                                    <a href="" class="body-title-2">{{ $delivery_method->name }}</a>
                                                </div>
                                            </td>
                                            <td class="text-center p-2">{{ $delivery_method->slug }}</td>
                                            <td class="text-center p-2">₹{{ $delivery_method->price }}</td>
                                            <td class="text-center p-2">{{ date('d M, Y, h:m a', strtotime($delivery_method->updated_at)) }}</td>
                                            <td class="text-center p-2">
                                                @if($delivery_method->status == 1)
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>Active
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger me-2"></i>Inactive
                                                @endif
                                            </td>
                                            <td class="text-center p-2">
                                                <div class="list-icon-function d-flex justify-content-center">
                                                    <a href="{{ route('admin_delivery_method_edit_page', $delivery_method->slug) }}">
                                                        <div class="item edit">
                                                            <i class="icon-edit-3"></i>
                                                        </div>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="deleteDeliveryMethod('{{ $delivery_method->slug }}', '{{ $delivery_method->name }}')">
                                                        <div class="item text-danger delete">
                                                            <i class="icon-trash-2"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-secondary text-center">Records not found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="divider" style="margin-bottom: 20px"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination justify-content-end">
                        {{ $delivery_methods->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteDeliveryMethod(deliveryMethodSlug, deliveryMethodName) {
            if(confirm(`Do you really want to delete this delivery method - ${deliveryMethodName}?`)) {
                var url = "{{ route('admin_delivery_method_destroy', 'slug') }}";
                var newUrl = url.replace('slug', deliveryMethodSlug);

                $.ajax({
                    url: newUrl,
                    type: 'delete',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Whatever the response's status may be, redirect to delivery method listing page
                        window.location.reload();
                    },
                    error: function(jqXHR, exception) {
                        alert('Error occured while removing the delivery method!');
                    },
                });
            }
        }
    </script>
@endpush
