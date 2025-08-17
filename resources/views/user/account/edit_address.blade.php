@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Saved Addresses</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__address">
                      <div class="row">
                        <div class="col-6">
                            <p class="notice">The following address will be used on the checkout page by default.</p>
                        </div>
                          <div class="col-6 text-right">
                              <a href="{{ route('addresses') }}" class="btn btn-sm btn-danger">Back</a>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-12">
                              <div class="card mb-5">
                                  <div class="card-header">
                                      <h5>Edit Saved Address</h5>
                                  </div>
                                  <div class="card-body">
                                      <form action="{{ route('update_address', $address->id) }}" method="POST">
                                          @csrf
                                          @method('put')
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $address->name }}">
                                                      <label for="name">Full Name *</label>
                                                      @error('name')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-6">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $address->mobile }}">
                                                      <label for="mobile">Mobile Number *</label>
                                                      @error('mobile')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ $address->zip }}">
                                                      <label for="zip">Pincode *</label>
                                                      @error('zip')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-floating mt-3 mb-3">
                                                      <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ $address->state }}">
                                                      <label for="state">State *</label>
                                                      @error('state')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $address->city }}">
                                                      <label for="city">Town / City *</label>
                                                      @error('city')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-3">
                                                  <div class="form-floating my-3">
                                                      <select class="form-control form-control_gray @error('country') is-invalid @enderror" id="country" name="country">
                                                          <option value="" selected>Select country</option>
                                                          @foreach($countries as $country)
                                                              <option value="{{ $country->name }}" {{ !empty($address->country) ? 'selected' : '' }}>{{ $country->name }}</option>
                                                          @endforeach
                                                      </select>
                                                      <label for="country">Country *</label>
                                                      @error('country')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-5">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $address->address }}">
                                                      <label for="address">House No., Building Name *</label>
                                                      @error('address')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-4">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('locality') is-invalid @enderror" name="locality" value="{{ $address->locality }}">
                                                      <label for="locality">Road Name, Area *</label>
                                                      @error('locality')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>
                                              <div class="col-md-12">
                                                  <div class="form-floating my-3">
                                                      <input type="text" class="form-control @error('landmark') is-invalid @enderror" name="landmark" value="{{ $address->landmark }}">
                                                      <label for="landmark">Landmark *</label>
                                                      @error('landmark')
                                                          <p class="invalid-feedback">{{ $message }}</p>
                                                      @enderror
                                                  </div>
                                              </div>  
                                              <div class="col-md-6">
                                                  <div class="form-check">
                                                      <input class="form-check-input" type="checkbox" value="1" id="is_default" name="is_default" {{ !empty($address->is_default) ? 'checked' : '' }}>
                                                      <label class="form-check-label" for="is_default">
                                                          Make as Default address
                                                      </label>
                                                  </div>
                                              </div>  
                                              <div class="col-md-12 text-right">
                                                  <button type="submit" class="btn btn-success">Save</button>
                                              </div>                                     
                                          </div>
                                      </form> 
                                  </div>
                              </div>
                          </div>
                        </div>
                      <hr>                    
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')

@endpush
