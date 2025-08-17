@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Delivery Timeslot Infomation</h3>
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
                        <a href="{{ route('admin_delivery_timeslots_index') }}">
                            <div class="text-tiny">Delivery Timeslots</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Update Delivery Timeslot</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_delivery_timeslots_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin_delivery_timeslot_edit', $delivery_timeslot->slug) }}" method="POST">
                    @method('put')
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Time Range <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('time_range') is-invalid @enderror" type="text" placeholder="Time Range" name="time_range" value="{{ $delivery_timeslot->time_range }}" tabindex="0" value="" aria-required="true">
                        @error('time_range')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Delivery Timeslot Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow me-3 @error('slug') is-invalid @enderror" type="text" placeholder="Delivery Timeslot Slug" name="slug" value="{{ $delivery_timeslot->slug }}" tabindex="0" value="" aria-required="true" readonly>
                        @error('slug')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Start <span class="tf-color-1">*</span></div>
                        <input type="text" class="flex-grow me-3 @error('start') is-invalid @enderror" id="timePickerFlatpickr1" name="start" value="{{ $delivery_timeslot->start }}" placeholder="Select Start Time">
                        {{-- <input type="hidden" name="start" id="startHiddenInput" value=""> --}}
                        @error('start')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">End <span class="tf-color-1">*</span></div>
                        <input type="text" class="flex-grow me-3 @error('end') is-invalid @enderror" id="timePickerFlatpickr2" name="end" value="{{ $delivery_timeslot->end }}" placeholder="Select End Time">
                        {{-- <input type="hidden" name="end" id="endHiddenInput" value=""> --}}
                        @error('end')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title mb-10">Delivery Method <span class="tf-color-1">*</span></div>
                        <div class="select flex-grow mb-10 @error('delivery_method_id') is-invalid @enderror">
                            <select class="" name="delivery_method_id">
                                <option value="" selected>Select</option>
                                @if($delivery_methods->isNotEmpty())
                                    @foreach ($delivery_methods as $delivery_method)
                                        <option value="{{ $delivery_method->id }}" {{ ($delivery_timeslot->delivery_method_id == $delivery_method->id) ? 'selected' : '' }}>{{ $delivery_method->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('delivery_method_id')
                            <span class="invalid-feedback fs-5" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Status <span class="tf-color-1">*</span></div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="1" {{ ($delivery_timeslot->status == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ ($delivery_timeslot->status == 0) ? 'selected' : '' }}>Inactive</option>
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
            $("input[name='time_range']").on('input', function() {
                let data = $(this).val().toLowerCase().replace(/[^a-z0-9\s]/gi, "").replace(/^\s+|\s+$|\s+(?=\s)/g, "").replace(/[_\s]/g, "-");
                $("input[name='slug']").val(data);
            });



            // Get references to all input elements
            const startTimeInput = $('#timePickerFlatpickr1');
            const endTimeInput = $('#timePickerFlatpickr2');

            // Define common Flatpickr options for time pickers
            const commonTimePickerOptions = {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 1,
                defaultHour: 0, // Example default for start time
                defaultMinute: 0
            };

            // Initialize Flatpickr for the Start Time input
            flatpickr(startTimeInput[0], {
                ...commonTimePickerOptions, // Spread common options
                onChange: function(selectedDates, dateStr, instance) {
                    startTimeInput.val(dateStr);
                }
            });

            // Initialize Flatpickr for the End Time input
            flatpickr(endTimeInput[0], {
                ...commonTimePickerOptions, // Spread common options
                onChange: function(selectedDates, dateStr, instance) {
                    endTimeInput.val(dateStr);
                }
            });
        });
    </script>
@endpush
