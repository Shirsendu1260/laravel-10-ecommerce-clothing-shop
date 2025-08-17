@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Delivery Method Information</h3>
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
                        <a href="{{ route('admin_delivery_methods_index') }}">
                            <div class="text-tiny">Delivery Methods</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">New Delivery Method</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_delivery_methods_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin_delivery_method_create') }}" method="POST">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Delivery Method Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('name') is-invalid @enderror" type="text" placeholder="Delivery Method Name" name="name" value="{{ old('name') }}" tabindex="0" value="" aria-required="true">
                        @error('name')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Delivery Method Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('slug') is-invalid @enderror" type="text" placeholder="Delivery Method Slug" name="slug" value="{{ old('slug') }}" tabindex="0" value="" aria-required="true" readonly>
                        @error('slug')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="description">
                        <div class="body-title mb-10">Description</div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true">{{ old('description') }}</textarea>
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Price <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('price') is-invalid @enderror" type="number" placeholder="Price" name="price" value="{{ old('price') }}" tabindex="0" value="" aria-required="true">
                        @error('price')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Status <span class="tf-color-1">*</span></div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208 me-2" type="submit">Save</button>
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
        });
    </script>
@endpush
