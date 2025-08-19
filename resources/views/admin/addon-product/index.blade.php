@extends('layouts.admin-app')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>All Addon Products</h3>
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
                    <div class="text-tiny">All Addon Products</div>
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
                <a class="tf-button style-1 w208" href="{{ route('admin_addon_product_create_page') }}"><i class="icon-plus"></i>Add New Addon Product</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center p-2">#</th>
                                <th class="text-center p-2">Name</th>
                                <th class="text-center p-2">SKU</th>
                                <th class="text-center p-2">Price</th>
                                <th class="text-center p-2">Category</th>
                                <th class="text-center p-2">Brand</th>
                                <th class="text-center p-2">Stock</th>
                                <th class="text-center p-2">Quantity</th>
                                <th class="text-center p-2">Updated At</th>
                                <th class="text-center p-2">Status</th>
                                <th class="text-center p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($addon_products->isNotEmpty())
                                @foreach ($addon_products as $key => $addon_product)
                                    @php
                                    $page = !empty(Request::query('page')) ? Request::query('page') : 1;
                                    $index = $key + (($page - 1) * 7) + 1;
                                    @endphp
                                    <tr>
                                        <td class="text-center p-2">{{ $index }}</td>
                                        <td class="pname d-flex justify-content-center p-5">
                                            <div class="image">
                                                @if (!empty($addon_product->image))
                                                    <img src="{{ asset('uploads/addon-product/thumbnails/' . $addon_product->image) }}" alt="{{ $addon_product->name }}" class="image">
                                                @else
                                                    <img src="{{ asset('assets/admin/images/unavailable.png') }}" alt="image not available" class="image">
                                                @endif
                                            </div>
                                            <div class="name d-flex align-items-center">
                                                <a href="{{ route('admin_addon_product_edit_page', $addon_product->slug) }}" class="body-title-2">{{ $addon_product->name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-center p-2">{{ $addon_product->sku }}</td>
                                        <td class="text-center p-2">₹{{ $addon_product->price }}</td>
                                        <td class="text-center p-2">{{ $addon_product->category }}</td>
                                        <td class="text-center p-2">{{ $addon_product->brand }}</td>
                                        <td class="text-center p-2">
                                            @if ($addon_product->is_in_stock == 1)
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>In Stock
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger me-2"></i>Out of Stock
                                            @endif
                                        </td>
                                        <td class="text-center p-2">{{ $addon_product->qty }}</td>
                                        <td class="text-center p-2">{{ date('d M, Y, g:i A', strtotime($addon_product->updated_at)) }}</td>
                                        <td class="text-center p-2">
                                            @if($addon_product->status == 1)
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>Active
                                            @else
                                                <i class="bi bi-x-circle-fill text-danger me-2"></i>Inactive
                                            @endif
                                        </td>
                                        <td class="text-center p-2">
                                            <div class="list-icon-function d-flex justify-content-center align-items-center">
                                                <a href="{{ route('admin_addon_product_edit_page', $addon_product->slug) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <a href="javascript:void(0)" onclick="deleteAddonProduct('{{ $addon_product->slug }}', '{{ $addon_product->name }}')">
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
                                    <td colspan="14" class="text-secondary text-center">Records not found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="divider" style="margin-bottom: 20px"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination justify-content-end">
                {{ $addon_products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteAddonProduct(addonProductSlug, addonProductName) {
        if(confirm(`Do you really want to delete this addon product - ${addonProductName}?`)) {
            var url = "{{ route('admin_addon_product_destroy', 'slug') }}";
            var newUrl = url.replace('slug', addonProductSlug);

            $.ajax({
                url: newUrl,
                type: 'delete',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Whatever the response's status may be, redirect to addon product listing page
                    window.location.reload();
                },
                error: function(jqXHR, exception) {
                    alert('Error occured while removing the addon product!');
                },
            });
        }
    }
</script>
@endpush
