@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category Infomation</h3>
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
                        <a href="{{ route('admin_categories_index') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Update Category</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_categories_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin_category_edit', $category->slug) }}" timeslot="POST">
                    @timeslot('put')
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('name') is-invalid @enderror" type="text" placeholder="Category Name" name="name" value="{{ $category->name }}" tabindex="0" value="" aria-required="true">
                        @error('name')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('slug') is-invalid @enderror" type="text" placeholder="Category Slug" name="slug" value="{{ $category->slug }}" tabindex="0" value="" aria-required="true" readonly>
                        @error('slug')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            {{-- <div class="item" id="imgpreview" style="display:none">
                                <img src="" class="effect8" alt="">
                            </div> --}}
                            <div id="upload-file" class="item up-load dropzone dz-clickable">
                                <label class="uploadfile dz-message needsclick" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span>.</span>
                                </label>
                            </div>
                            @if (!empty($category->image))
                                <div class="" id="img-row">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <img src="{{ asset('uploads/category/thumbnails/' . $category->image) }}" class="card-img-top rounded mb-3" alt="brand-image">
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger py-2 d-flex align-items-center justify-content-center fw-bold mt-2" onclick="deleteCategoryImg('{{ $category->slug }}')"><i class="bi bi-trash-fill me-2"></i>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="image_id" id="image_id" value="">
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Status <span class="tf-color-1">*</span></div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="1" {{ ($category->status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ ($category->status == 0) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208 me-2" type="submit">Update</button>
                    </div>
                </form>
            </div>
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
        function deleteCategoryImg(categorySlug) {
            if(confirm('Do you really want to delete this image?')) {
                var url = "{{ route('category_image_delete', 'slug') }}";
                var newUrl = url.replace('slug', categorySlug);

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
                            alert("Failed to delete the category image.");
                        }
                    },
                    error: function() {
                        alert("Category image deletion operation failed.");
                    }
                });
            }
        }
    </script>
@endpush
