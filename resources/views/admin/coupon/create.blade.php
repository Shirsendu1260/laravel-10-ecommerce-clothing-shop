@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupon Information</h3>
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
                        <a href="{{ route('admin_coupons_index') }}">
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add Coupon</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_coupons_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <form action="{{ route('admin_coupon_create') }}" method="POST" class="tf-section-2">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Coupon Code <span class="tf-color-1">*</span></div>
                        <input class="mb-10 @error('code') is-invalid @enderror" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{ old('code') }}" aria-required="true">
                        @error('code')
                            <span class="invalid-feedback fs-5 mb-4" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description</div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true">{{ old('description') }}</textarea>
                        <div class="text-tiny mt-4">Do not exceed 255 characters when entering the coupon's description.</div>
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Max Uses</div>
                            <input class="mb-10 @error('max_uses') is-invalid @enderror" type="number" placeholder="Max Uses" name="max_uses" tabindex="0" value="{{ old('max_uses') }}" aria-required="true">
                            @error('max_uses')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset class="brand">
                            <div class="body-title mb-10">Max Uses per User</div>
                            <input class="mb-10 @error('max_uses_per_user') is-invalid @enderror" type="number" placeholder="Max Uses per User" name="max_uses_per_user" tabindex="0" value="{{ old('max_uses_per_user') }}" aria-required="true">
                            @error('max_uses_per_user')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Type <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="type">
                                <option value="fixed" {{ (old('type') == 'fixed') ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ (old('type') == 'percent') ? 'selected' : '' }}>Percent</option>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <div class="wg-box">
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Discount <span class="fw-light">('₹' for 'Fixed' and '%' for 'Percent' type)</span> <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('discount') is-invalid @enderror" type="text" placeholder="Discount" name="discount" tabindex="0" value="{{ old('discount') }}" aria-required="true">
                            @error('discount')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Minimum Cart Amount (₹) <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('min_cart_amount') is-invalid @enderror" type="text" placeholder="Minimum Cart Amount" name="min_cart_amount" tabindex="0" value="{{ old('min_cart_amount') }}" aria-required="true">
                            @error('min_cart_amount')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Starts At <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('starts_at') is-invalid @enderror" id="starts-at" type="text" placeholder="Starts At" name="starts_at" tabindex="0" value="{{ old('starts_at') }}" aria-required="true">
                            @error('starts_at')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Expires At <span class="tf-color-1">*</span></div>
                            <input class="mb-10 @error('expires_at') is-invalid @enderror" id="expires-at" type="text" placeholder="Expires At" name="expires_at" tabindex="0" value="{{ old('expires_at') }}" aria-required="true">
                            @error('expires_at')
                                <span class="invalid-feedback fs-5" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Status <span class="tf-color-1">*</span></div>
                        <div class="select mb-10">
                            <select class="" name="status">
                                <option value="1" {{ (old('status') == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (old('status') == 0) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
            // Get references to all input elements
            const startDateInput = $('#starts-at');
            const endDateInput = $('#expires-at');

            // Define common Flatpickr options for date pickers
            const commonDatePickerOptions = {
                enableTime: false,
                noCalendar: false,
                dateFormat: "Y-m-d",
            };

            // Initialize Flatpickr for the Start date input
            flatpickr(startDateInput[0], {
                ...commonDatePickerOptions, // Spread common options
                onChange: function (selectedDates, dateStr, instance) {
                    startDateInput.val(dateStr);
                }
            });

            // Initialize Flatpickr for the End date input
            flatpickr(endDateInput[0], {
                ...commonDatePickerOptions, // Spread common options
                onChange: function (selectedDates, dateStr, instance) {
                    endDateInput.val(dateStr);
                }
            });
    </script>
@endpush
