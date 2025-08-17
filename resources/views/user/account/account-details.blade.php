@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Account Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                <div class="col-lg-10">
                    {{-- {{ dd($user) }} --}}
                    <div class="page-content my-account__edit">
                        @include('layouts.userend-alerts')
                        <div class="my-account__edit-form">
                          <form name="account_edit_form" action="{{ route('update_account_details') }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row">
                              <div class="col-md-12">
                                <div class="my-3">
                                  <h5 class="text-uppercase mb-0">Update Account Details</h5>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" value="{{ $user->name }}">
                                  <label for="name">Name</label>
                                  @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="form-floating my-3">
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="" selected>Select your gender</option>
                                        <option value="M" {{ $user->gender == 'M' ? 'selected'  : '' }}>Male</option>
                                        <option value="F" {{ $user->gender == 'F' ? 'selected'  : '' }}>Female</option>
                                        <option value="O" {{ $user->gender == 'O' ? 'selected'  : '' }}>Others</option>
                                    </select>
                                    <label for="gender">Gender</label>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="form-floating my-3">
                                    <select class="form-control @error('phonecode') is-invalid @enderror" id="phonecode" name="phonecode">
                                        <option value="" selected>Select your country phonecode</option>
                                        @if ($countries->isNotEmpty())
                                            @foreach ($countries as $country)
                                                <option value="+{{ $country->phonecode }}" {{ $user->phonecode == $country->phonecode ? 'selected' : '' }}>{{ $country->name }} (+{{ $country->phonecode }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="phonecode">Phonecode</label>
                                    @error('phonecode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="text" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile Number" name="mobile" id="mobile" value="{{ $user->mobile }}">
                                  <label for="mobile">Mobile Number</label>
                                  @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" id="email" value="{{ $user->email }}">
                                  <label for="email">Email Address</label>
                                  @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="my-3">
                                  <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                              </div>
                            </form>
                            <form id="password_change_form" class="mt-5">
                              <div class="col-md-12">
                                <div class="my-3">
                                  <h5 class="text-uppercase mb-4">Password Change</h5>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password">
                                  <label for="old_password">Old Password</label>
                                  <div class="d-flex justify-content-between mt-1">
                                      <p class="input-error"></p>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input pw-toggle">
                                        <label class="form-check-label">Show</label>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                                  <label for="new_password">New Password</label>
                                  <div class="d-flex justify-content-between mt-1">
                                      <p class="input-error"></p>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input pw-toggle">
                                        <label class="form-check-label">Show</label>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="form-floating my-3">
                                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm New Password">
                                  <label for="confirm_password">Confirm New Password</label>
                                  <div class="d-flex justify-content-between mt-1">
                                      <p class="input-error"></p>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input pw-toggle">
                                        <label class="form-check-label">Show</label>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="my-3">
                                  <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $("#password_change_form").submit(function(event) {
        event.preventDefault();
        $('button[type=submit]').prop('disabled', true);

        $.ajax({
            url: "{{ route('change_password') }}",
            type: "put",
            data: $(this).serializeArray(),
            dataType: "json",
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                $('button[type=submit]').prop('disabled', false);

                if (response.status == true) {
                    $('#old_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');
                    $('#new_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');
                    $('#confirm_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');

                    window.location.href = "{{ route('account_details') }}";
                } else {
                    $('button[type=submit]').prop('disabled', false);
                    let errors = response.msg;

                    if (errors.old_password) {
                        $('#old_password').addClass('is-invalid').parent().find('.input-error').addClass('invalid-feedback').css("display", "block").html(errors.old_password);
                    } else {
                        $('#old_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');
                    }

                    if (errors.new_password) {
                        $('#new_password').addClass('is-invalid').parent().find('.input-error').addClass('invalid-feedback').css("display", "block").html(errors.new_password);
                    } else {
                        $('#new_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');
                    }

                    if (errors.confirm_password) {
                        $('#confirm_password').addClass('is-invalid').parent().find('.input-error').addClass('invalid-feedback').css("display", "block").html(errors.confirm_password);
                    } else {
                        $('#confirm_password').removeClass('is-invalid').parent().find('.input-error').removeClass('invalid-feedback').css("display", "block").html('');
                    }

                    document.getElementById("password_change_form").reset(); // Reset the form
                }
            },
            error: function(jqXHR, exception) {
                alert("Something went wrong while changing password!");
            }
        });
    });
  });
</script>
@endpush
