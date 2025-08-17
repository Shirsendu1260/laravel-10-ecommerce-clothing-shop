@extends('layouts.admin-app')

@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Product Infomation</h3>
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
                    <a href="{{ route('admin_products_index') }}">
                        <div class="text-tiny">Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">View Product</div>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-end mb-5">
            <a href="javascript:void(0)" onclick="window.close();" class="btn btn-dark fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                <span class="bi bi-x">&nbsp;Close</span>
            </a>
        </div>

        <form class="tf-section-2 form-add-product">
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Product Name" name="name" value="{{ $product->name }}" tabindex="0" value="" aria-required="true" readonly>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Product Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Product Slug" name="slug" value="{{ $product->slug }}" tabindex="0" value="" aria-required="true" readonly>
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="category_id">
                                <option value="{{ $product->category_id }}" selected>{{ $product->category }}</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="brand_id">
                                <option value="{{ $product->brand_id }}" selected>{{ $product->brand }}</option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Available Sizes <span class="tf-color-1">*</span></div>
                    @php
                        $available_sizes = explode(',', $product->available_sizes);
                        // dd($available_sizes);
                    @endphp
                    <div class="mb-10 ht-150 row">
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xs" class="sizes" type="checkbox" value="xs" {{ in_array("xs", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-xs"></label>
                            <label class="lbl text-dark fs-5" for="size-xs">XS (Extra Small)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-s" class="sizes" type="checkbox" value="s" {{ in_array("s", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-s"></label>
                            <label class="lbl text-dark fs-5" for="size-s">S (Small)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-m" class="sizes" type="checkbox" value="m" {{ in_array("m", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-m"></label>
                            <label class="lbl text-dark fs-5" for="size-m">M (Medium)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-l" class="sizes" type="checkbox" value="l" {{ in_array("l", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-l"></label>
                            <label class="lbl text-dark fs-5" for="size-l">L (Large)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xl" class="sizes" type="checkbox" value="xl" {{ in_array("xl", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-xl"></label>
                            <label class="lbl text-dark fs-5" for="size-xl">XL (Extra Large)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xxl" class="sizes" type="checkbox" value="xxl" {{ in_array("xxl", $available_sizes) == true ? 'checked' : '' }} disabled />
                            <label class="cbx" for="size-xxl"></label>
                            <label class="lbl text-dark fs-5" for="size-xxl">XXL (Extra Extra Large)</label>
                        </div>
                    </div>
                    <input type="hidden" name="available_sizes" id="available-sizes" value="{{ $product->available_sizes }}">
                </fieldset>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description</div>
                    <textarea class="mb-10 ht-150 summernote" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" readonly>{!! $product->short_description !!}</textarea>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 summernote" name="description" placeholder="Description" tabindex="0" aria-required="true" readonly>{!! $product->description !!}</textarea>
                </fieldset>
            </div>
            <div class="wg-box">
                @if (!empty($product->image))
                    <fieldset>
                        <div class="body-title mb-10">Image</div>
                        <div class="upload-image mb-16">
                            <div class="" id="img-row">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <img src="{{ asset('uploads/product/thumbnails/' . $product->image) }}" class="card-img-top rounded mb-3" alt="product-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endif

                @php
                    $product_gal_imgs = get_product_gallery_images($product->slug);
                    // dd($product_gal_imgs);
                @endphp
                @if ($product_gal_imgs->isNotEmpty())
                    <fieldset>
                        <div class="body-title mb-10">Gallery Images</div>
                        <div class="row" id="product-gallery-imgs">
                            @foreach ($product_gal_imgs as $product_gal_img)
                                <div class="col-sm-6 col-md-3 col-lg-3 col-6 mb-4" id="img-row-{{ $product_gal_img->id }}">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <img src="{{ asset('uploads/product/' . $product_gal_img->name) }}" class="card-img-top rounded mb-3" alt="product-gallery-image">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                @endif

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price (₹) <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Regular Price" name="price" value="{{ $product->price }}" tabindex="0" value="" aria-required="true" readonly>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price (₹) <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Sale Price" name="actual_price" value="{{ $product->actual_price }}" tabindex="0" value="" aria-required="true" readonly>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="SKU" name="sku" value="{{ $product->sku }}" tabindex="0" value="" aria-required="true" readonly>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="number" placeholder="Quantity" name="qty" value="{{ $product->qty }}" tabindex="0" value="" aria-required="true" readonly>
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="is_in_stock">
                                @if ($product->is_in_stock == 1)
                                    <option value="1" selected>In Stock</option>
                                @else
                                    <option value="0" selected>Out of Stock</option>
                                @endif
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="is_featured">
                                @if ($product->is_featured == 1)
                                    <option value="1" selected>Yes</option>
                                @else
                                    <option value="0" selected>No</option>
                                @endif
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="status">
                                @if ($product->status == 1)
                                    <option value="1" selected>Yes</option>
                                @else
                                    <option value="0" selected>No</option>
                                @endif
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $(".note-editable").attr('contenteditable','false');
        $(".note-editable").addClass('bg-white');
    });
</script>
@endpush
