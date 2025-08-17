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
                    <div class="text-tiny">Update Product</div>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-end mb-5">
            <a href="{{ route('admin_products_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                <span class="bi bi-arrow-left">&nbsp;Back</span>
            </a>
        </div>

        <form action="{{ route('admin_product_edit', $product->slug) }}" method="POST" class="tf-section-2 form-add-product">
            @method('put')
            @csrf
            {{-- <input type="hidden" name="_token" value="8LNRTO4LPXHvbK2vgRcXqMeLgqtqNGjzWSNru7Xx" autocomplete="off"> --}}
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('name') is-invalid @enderror" type="text" placeholder="Product Name" name="name" value="{{ $product->name }}" tabindex="0" value="" aria-required="true">
                    @error('name')
                        <span class="invalid-feedback fs-5 mb-4" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title mb-10">Product Slug <span class="tf-color-1">*</span></div>
                    <input class="mb-10 @error('slug') is-invalid @enderror" type="text" placeholder="Product Slug" name="slug" value="{{ $product->slug }}" tabindex="0" value="" aria-required="true">
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
                                        <option value="{{ $category->id }}" {{ ($product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                        <option value="{{ $brand->id }}" {{ ($product->brand_id == $brand->id) ? 'selected' : '' }}>{{ $brand->name }}</option>
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

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Available Sizes <span class="tf-color-1">*</span></div>
                    @php
                        $available_sizes = explode(',', $product->available_sizes);
                        // dd($available_sizes);
                    @endphp
                    <div class="mb-10 ht-150 row">
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xs" class="sizes" type="checkbox" value="xs" {{ in_array("xs", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-xs"></label>
                            <label class="lbl text-dark fs-5" for="size-xs">XS (Extra Small)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-s" class="sizes" type="checkbox" value="s" {{ in_array("s", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-s"></label>
                            <label class="lbl text-dark fs-5" for="size-s">S (Small)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-m" class="sizes" type="checkbox" value="m" {{ in_array("m", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-m"></label>
                            <label class="lbl text-dark fs-5" for="size-m">M (Medium)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-l" class="sizes" type="checkbox" value="l" {{ in_array("l", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-l"></label>
                            <label class="lbl text-dark fs-5" for="size-l">L (Large)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xl" class="sizes" type="checkbox" value="xl" {{ in_array("xl", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-xl"></label>
                            <label class="lbl text-dark fs-5" for="size-xl">XL (Extra Large)</label>
                        </div>
                        <div class="checkbox-wrapper-42 mb-10 col-6">
                            <input id="size-xxl" class="sizes" type="checkbox" value="xxl" {{ in_array("xxl", $available_sizes) == true ? 'checked' : '' }} />
                            <label class="cbx" for="size-xxl"></label>
                            <label class="lbl text-dark fs-5" for="size-xxl">XXL (Extra Extra Large)</label>
                        </div>
                    </div>
                    <input type="hidden" name="available_sizes" id="available-sizes" value="{{ $product->available_sizes }}">
                </fieldset>

                <fieldset class="shortdescription">
                    <div class="body-title mb-10">Short Description</div>
                    <textarea class="mb-10 ht-150 summernote" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true">{!! $product->short_description !!}</textarea>
                    <div class="text-tiny mt-4">Do not exceed 255 characters when entering the product's short description.</div>
                </fieldset>

                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea class="mb-10 summernote" name="description" placeholder="Description" tabindex="0" aria-required="true">{!! $product->description !!}</textarea>
                    @error('description')
                        <span class="invalid-feedback fs-5 mt-4 pt-3" role="alert" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </fieldset>
            </div>
            <div class="wg-box">
                <fieldset>
                    <div class="body-title mb-10">Upload Image</div>
                    <div class="upload-image mb-16">
                        {{-- <div class="item">
                            <img src="images/upload/upload-1.png" alt="">
                        </div> --}}
                        <div id="upload-file" class="item up-load dropzone dz-clickable">
                            <label class="uploadfile dz-message needsclick" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span>.</span>
                            </label>
                        </div>
                        @if (!empty($product->image))
                            <div class="" id="img-row">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <img src="{{ asset('uploads/product/thumbnails/' . $product->image) }}" class="card-img-top rounded mb-3" alt="product-image">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger py-2 d-flex align-items-center justify-content-center fw-bold mt-2" onclick="deleteProductImg('{{ $product->slug }}')"><i class="bi bi-trash-fill me-2"></i>Delete</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name="image_id" id="image_id" value="">
                </fieldset>

                <fieldset>
                    <div class="body-title mb-10">Upload Gallery Images</div>
                    @if (($product->gallery_images_count >= 0) && ($product->gallery_images_count < 8))
                        <div class="upload-image mb-10">
                            {{-- <div class="item">
                                <img src="images/upload/upload-1.png" alt="">
                            </div> --}}
                            <div id="galUpload" class="item up-load dropzone dz-clickable" style="display: inline-block;">
                                <label class="uploadfile dz-message needsclick" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or <span class="tf-color">click to browse</span> to select images, then click <span class="tf-color">upload</span>.</span>
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <div class="text-tiny mb-10">Maximum {{ 8 - $product->gallery_images_count }} images are allowed for upload process.</div>
                            <a href="javascript:void(0)" class="btn btn-primary btm-sm fs-5 fw-bold mb-5" id="gal-imgs-upload" style="border-radius: 6px; padding: 7px 20px;">
                                <span class="bi bi-cloud-arrow-up-fill">&nbsp;Upload</span>
                            </a>
                        </div>
                    @else
                        <div class="text-tiny mb-10">You've reached the gallery image limit of 8. Please delete existing images to upload new ones.</div>
                    @endif
                    <div class="row" id="product-gallery-imgs">
                        @php
                            $product_gal_imgs = get_product_gallery_images($product->slug);
                            // dd($product_gal_imgs);
                        @endphp
                        @if ($product_gal_imgs->isNotEmpty())
                            @foreach ($product_gal_imgs as $product_gal_img)
                                <div class="col-sm-6 col-md-3 col-lg-3 col-6 mb-4" id="img-row-{{ $product_gal_img->id }}">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <img src="{{ asset('uploads/product/' . $product_gal_img->name) }}" class="card-img-top rounded mb-3" alt="product-gallery-image">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger py-2 d-flex align-items-center justify-content-center fw-bold mt-2" onclick="deleteProductGalImg('{{ $product_gal_img->id }}')"><i class="bi bi-trash-fill me-2"></i>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div id="product-gallery-imgs-hidden-input">

                    </div>
                </fieldset>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Regular Price (₹) <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('price') is-invalid @enderror" type="text" placeholder="Regular Price" name="price" value="{{ $product->price }}" tabindex="0" value="" aria-required="true">
                        @error('price')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Sale Price (₹) <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('actual_price') is-invalid @enderror" type="text" placeholder="Sale Price" name="actual_price" value="{{ $product->actual_price }}" tabindex="0" value="" aria-required="true">
                        @error('actual_price')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                </div>

                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('sku') is-invalid @enderror" type="text" placeholder="SKU" name="sku" value="{{ $product->sku }}" tabindex="0" value="" aria-required="true">
                        @error('sku')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('qty') is-invalid @enderror" type="number" placeholder="Quantity" name="qty" value="{{ $product->qty }}" tabindex="0" value="" aria-required="true">
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
                                <option value="1" {{ ($product->is_in_stock == 1) ? 'selected' : '' }}>In Stock</option>
                                <option value="0" {{ ($product->is_in_stock == 0) ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Featured <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="is_featured">
                                <option value="0" {{ ($product->is_featured == 0) ? 'selected' : '' }}>No</option>
                                <option value="1" {{ ($product->is_featured == 1) ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="status">
                                <option value="1" {{ ($product->status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ ($product->status == 0) ? 'selected' : '' }}>Inactive</option>
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


        let galleryImagesCount = "{{ $product->gallery_images_count }}";
        let galImgsUploadLeftCount = 8 - parseInt(galleryImagesCount);
        Dropzone.autoDiscover = false;
        const dropzoneGalUpload = new Dropzone("#galUpload", {
            url: "{{ route('temp_images_create') }}",
            type: 'post',
            maxFiles: galImgsUploadLeftCount,
            paramName: 'images',
            addRemoveLinks: true,
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: galImgsUploadLeftCount,
            acceptedFiles: "image/jpeg,image/jpg,image/png",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                const uploader = this;
                this.on('addedfile', function (file) {
                    if (this.files.length > galImgsUploadLeftCount) {
                        this.removeFile(file);
                        alert(`You can only upload at most ${galImgsUploadLeftCount} image(s).`);
                    }
                });
                // Trigger uploads on button click
                $("#gal-imgs-upload").on('click', function () {
                    if (uploader.getQueuedFiles().length > 0) {
                        uploader.processQueue(); // Uploads files one by one in order
                    } else {
                        alert("Please add at least one image to upload.");
                    }
                });
            },
            success: function (file, response) {
                if(response.status == true) {
                    $("#product-gallery-imgs-hidden-input").empty();
                    $("#product-gallery-imgs-hidden-input").append(response.hidden_inputs);
                }
            }
        });

        // Sizes selector
        $(".sizes").change(function() {
            let checkedSizes = $(".sizes:checked");
            let selectedSizesStr = "";
            let checkedSizesLength = checkedSizes.length;

            if(checkedSizesLength > 0) {
                for(let i=0; i<checkedSizesLength; i++) {
                    let checkboxVal = checkedSizes[i].value;

                    if(i == checkedSizesLength - 1) {
                        selectedSizesStr = selectedSizesStr + checkboxVal;
                    }
                    else {
                        selectedSizesStr = selectedSizesStr + checkboxVal + ",";
                    }
                }
            }
            else {
                $("#available-sizes").val(null);
            }

            // console.log(selectedSizesStr);
            $("#available-sizes").val(selectedSizesStr);
        });
    });
</script>

<script>
    function deleteProductImg(productSlug) {
        if(confirm('Do you really want to delete this image?')) {
            var url = "{{ route('product_image_delete', 'slug') }}";
            var newUrl = url.replace('slug', productSlug);

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
                        alert("Failed to delete the product image.");
                    }
                },
                error: function() {
                    alert("Product image deletion operation failed.");
                }
            });
        }
    }
</script>

<script>
    function deleteProductGalImg(productGalImgId) {
        if(confirm('Do you really want to delete this image?')) {
            var url = "{{ route('product_gallery_image_delete', 'imgId') }}";
            var newUrl = url.replace('imgId', productGalImgId);

            $.ajax({
                url: newUrl,
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == true) {
                        // $(`#img-row-${productGalImgId}`).remove();
                        window.location.reload();
                    } else {
                        if(response.notFound == true) {
                            alert(response.msg);
                        }
                        else {
                            alert("Failed to delete the product gallery image.");
                        }
                    }
                },
                error: function() {
                    alert("Product gallery image deletion operation failed.");
                }
            });
        }
    }
</script>
@endpush
