@extends('layouts.admin-app')

@section('content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Addon Product Information</h3>
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
                    <a href="{{ route('admin_addon_products_index') }}">
                        <div class="text-tiny">Addon Products</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Update Addon Product</div>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-end mb-5">
            <a href="{{ route('admin_addon_products_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                <span class="bi bi-arrow-left">&nbsp;Back</span>
            </a>
        </div>

        <form action="{{ route('admin_addon_product_edit', $addon_product->slug) }}" method="POST" class="tf-section-2">
            @method('put')
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Addon Product Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('name') is-invalid @enderror" type="text" placeholder="Addon Product Name" name="name" tabindex="0" value="{{ $addon_product->name }}" aria-required="true">
                    @error('name')
                        <span class="invalid-feedback fs-5 mb-4" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Addon Product Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('slug') is-invalid @enderror" type="text" placeholder="Addon Product Slug" name="slug" tabindex="0" value="{{ $addon_product->slug }}" aria-required="true">
                    @error('slug')
                        <span class="invalid-feedback fs-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </fieldset>

                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select mb-10 @error('category_id') is-invalid @enderror">
                            <select class="" name="category_id">
                                <option value="" selected>Choose a category</option>
                                @if($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($addon_product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('category_id')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="brand">
                        <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                        <div class="select mb-10 @error('brand_id') is-invalid @enderror">
                            <select class="" name="brand_id">
                                <option value="" selected>Choose a brand</option>
                                @if($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ ($addon_product->brand_id == $brand->id) ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('brand_id')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                </div>
            </div>

            <div class="wg-box">
                <fieldset>
                    <div class="body-title mb-10">Upload Image</div>
                    <div class="upload-image mb-16">
                        <div id="upload-file" class="item up-load dropzone dz-clickable">
                            <label class="uploadfile dz-message needsclick" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span>.</span>
                            </label>
                        </div>
                        @if (!empty($addon_product->image))
                            <div class="" id="img-row">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <img src="{{ asset('uploads/addon-product/thumbnails/' . $addon_product->image) }}" class="card-img-top rounded mb-3" alt="Addon product image">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger py-2 d-flex align-items-center justify-content-center fw-bold mt-2" onclick="deleteAddonProductImg('{{ $addon_product->slug }}')"><i class="bi bi-trash-fill me-2"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="image_id" id="image_id" value="">
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Price (₹) <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('price') is-invalid @enderror" type="text" placeholder="Price" name="price" tabindex="0" value="{{ $addon_product->price }}" aria-required="true">
                        @error('price')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('sku') is-invalid @enderror" type="text" placeholder="SKU" name="sku" tabindex="0" value="{{ $addon_product->sku }}" aria-required="true">
                        @error('sku')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('qty') is-invalid @enderror" type="number" placeholder="Quantity" name="qty" tabindex="0" value="{{ $addon_product->qty }}" aria-required="true">
                        @error('qty')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Stock <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="is_in_stock">
                                <option value="1" {{ ($addon_product->is_in_stock == 1) ? 'selected' : '' }}>In Stock</option>
                                <option value="0" {{ ($addon_product->is_in_stock == 0) ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="status">
                                <option value="1" {{ ($addon_product->status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ ($addon_product->status == 0) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </fieldset>
                </div>
                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("input[name='name']").on('input', function() {
            let data = $(this).val().toLowerCase().replace(/[^a-z0-9\s]/gi, "").replace(/^\s+|\s+$|\s+(?=\s)/g, "").replace(/[_\s]/g, "-");
            $("input[name='slug']").val(data);
        });


        Dropzone.autoDiscover = false;
        const dropzone = $("#upload-file").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp_image_create') }}",
            type: 'post',
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response);
            }
        });
    });
</script>

<script>
    function deleteAddonProductImg(addonProductSlug) {
        if(confirm('Do you really want to delete this image?')) {
            var url = "{{ route('addon_product_image_delete', 'slug') }}";
            var newUrl = url.replace('slug', addonProductSlug);

            $.ajax({
                url: newUrl,
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == true) {
                        $("#img-row").remove();
                    } else {
                        alert("Failed to delete the addon product image.");
                    }
                },
                error: function() {
                    alert("Addon product image deletion operation failed.");
                }
            });
        }
    }
</script>

@endpush
