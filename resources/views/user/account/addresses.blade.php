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
                        @include('layouts.userend-alerts')
                        <div class="row mt-1">
                          <div class="col-6">
                            <p class="notice">The following addresses will be used on the checkout page by default.</p>
                          </div>
                          <div class="col-6 text-right">
                            <a href="{{ route('create_address') }}" class="btn btn-sm btn-info">Add New</a>
                          </div>
                        </div>
                        @if($addresses->isNotEmpty())
                            <div class="my-account__address-list row">
                              <h5>Shipping Addresses</h5>
                              @foreach($addresses as $address)
                                  <div class="my-account__address-item col-md-6">
                                    <div class="my-account__address-item__title d-flex justify-content-between">
                                      <h5>
                                        {{ $address->name }}
                                        @if($address->is_default == '1')
                                            <i class="fa fa-check-circle text-primary ms-3"></i>
                                        @endif
                                      </h5>
                                      <div>
                                        <a href="javascript:void(0)" class="make-address-default me-3" data-id="{{ $address->id }}">Make Default</a>
                                        <a href="{{ route('edit_address', $address->id) }}">Edit</a>
                                      </div>
                                    </div>
                                    <div class="my-account__address-item__detail">
                                        <p>{{ $address->address }}</p>
                                        @if (!empty($address->locality))
                                            <p>{{ $address->locality }}</p>
                                        @endif
                                        <p>{{ $address->landmark }}</p>
                                        <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->zip }}</p>
                                        <p>Mobile: {{ $address->phonecode }}{{ $address->mobile }}</p>
                                    </div>
                                  </div>
                                  @if (!$loop->last)
                                    <hr>
                                  @endif
                              @endforeach
                            </div>
                        @else
                            <div class="my-account__address-list row"><h5>No Saved Addresses Found.</h5></div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $(".make-address-default").click(function() {
            let address_id = $(this).data("id");
            // alert(address_id);

            Swal.fire({
                title: "Do you really want to make this address to default?",
                icon: "info",
                showCancelButton: true, // Show "Cancel" button
                confirmButtonColor: '#1d1d1d', // Black shade
                cancelButtonColor: '#dc3545', // Red shade
            })
            .then(function(result) {
                if(result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('make_default_address') }}",
                        type: "post",
                        dataType: "json",
                        data: {
                            address_id: address_id,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == true) {
                                window.location.reload();
                            }
                            else {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: response.msg,
                                    toast: true,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        },
                        error: function() {
                            alert("Error while making the address to default.");
                        },
                    });
                }
            });
        });
    });
</script>
@endpush
