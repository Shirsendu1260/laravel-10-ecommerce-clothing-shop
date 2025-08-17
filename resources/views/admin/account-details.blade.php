@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Account Infomation</h3>
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
                        <div class="text-tiny">My Account Details</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_dashboard') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <div class="wg-box">
                <div class="col-lg-12">
                    <div class="page-content my-account__edit">
                        <div class="my-account__edit-form">
                            @include('layouts.alerts')
                            <form name="account_edit_form" action="{{ route('admin_update_account_details') }}" method="POST" class="form-new-product form-style-1">
                                @csrf
                                @method('put')
                                <div class="my-3">
                                    <h5 class="text-uppercase mb-0">Update Account Details</h5>
                                </div>
                                <fieldset class="name">
                                    <div class="body-title">Name <span class="tf-color-1">*</span></div>
                                    <input type="text" class="flex-grow @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" value="{{ $admin->name }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title">Gender <span class="tf-color-1">*</span></div>
                                    <div class="select flex-grow @error('gender') is-invalid @enderror">
                                        <select class="" name="gender">
                                            <option value="" selected>Select your gender</option>
                                            <option value="M" {{ $admin->gender == 'M' ? 'selected'  : '' }}>Male</option>
                                            <option value="F" {{ $admin->gender == 'F' ? 'selected'  : '' }}>Female</option>
                                            <option value="O" {{ $admin->gender == 'O' ? 'selected'  : '' }}>Others</option>
                                        </select>
                                    </div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title">Phonecode <span class="tf-color-1">*</span></div>
                                    <div class="select flex-grow @error('phonecode') is-invalid @enderror">
                                        <select class="" name="phonecode">
                                            <option value="" selected>Select your country phonecode</option>
                                            @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                    <option value="+{{ $country->phonecode }}" {{ $admin->phonecode == $country->phonecode ? 'selected' : '' }}>{{ $country->name }} (+{{ $country->phonecode }})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('phonecode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>
                                    <input type="text" class="flex-grow @error('mobile') is-invalid @enderror" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ $admin->mobile }}">
                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title">Email Address <span class="tf-color-1">*</span></div>
                                    <input type="email" class="flex-grow @error('email') is-invalid @enderror" placeholder="Email Address" name="email" id="email" value="{{ $admin->email }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </fieldset>
                                <div class="mb-3 mt-1 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary tf-button w208">Save</button>
                                </div>
                            </form>
                            <form id="password_change_form" class="form-new-product form-style-1 mt-5 pt-3">
                                <div class="my-3">
                                    <h5 class="text-uppercase mb-0">Change Password</h5>
                                </div>
                                <fieldset class="name">
                                    <div class="body-title pb-3">Old Password <span class="tf-color-1">*</span></div>
                                    <input type="password" class="flex-grow" id="old_password" name="old_password" placeholder="Old Password">
                                    <div class="checkbox-wrapper-42 col-1">
                                        <input id="show_op" class="sizes pw-toggle" type="checkbox">
                                        <label class="cbx" for="show_op"></label>
                                        <label class="lbl text-dark fs-5" for="show_op">Show</label>
                                    </div>
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title pb-3">New Password <span class="tf-color-1">*</span></div>
                                    <input type="password" class="flex-grow" id="new_password" name="new_password" placeholder="New Password">
                                    <div class="checkbox-wrapper-42 col-1">
                                        <input id="show_np" class="sizes pw-toggle" type="checkbox">
                                        <label class="cbx" for="show_np"></label>
                                        <label class="lbl text-dark fs-5" for="show_np">Show</label>
                                    </div>
                                </fieldset>
                                <fieldset class="name">
                                    <div class="body-title pb-3">Confirm New Password <span class="tf-color-1">*</span></div>
                                    <input type="password" class="flex-grow" id="confirm_password" name="confirm_password" placeholder="Confirm New Password">
                                    <div class="checkbox-wrapper-42 col-1">
                                        <input id="show_cp" class="sizes pw-toggle" type="checkbox">
                                        <label class="cbx" for="show_cp"></label>
                                        <label class="lbl text-dark fs-5" for="show_cp">Show</label>
                                    </div>
                                </fieldset>
                                <div class="mb-3 mt-1 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary tf-button w208">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#password_change_form").submit(function(event) {
                event.preventDefault();
                $('button[type=submit]').prop('disabled', true);

                $.ajax({
                    url: "{{ route('admin_change_password') }}",
                    type: "put",
                    data: $(this).serializeArray(),
                    dataType: "json",
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                    success: function(response) {
                        $('button[type=submit]').prop('disabled', false);
                        window.location.href = "{{ route('admin_account_details') }}";
                    },
                    error: function(jqXHR, exception) {
                        alert("Something went wrong while changing admin password!");
                    }
                });
            });


            // Show/hide password
            $(".pw-toggle").change(function () {
                let password_input = $(this).closest(".name").find(".flex-grow").first();

                if (password_input.attr("type") == "password") {
                    password_input.attr("type", "text");
                } else {
                    password_input.attr("type", "password");
                }
            });
        });
    </script>
@endpush
