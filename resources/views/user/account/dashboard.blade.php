@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">My Account</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account.account-nav')
                </div>
                <div class="col-lg-10">
                    <div class="page-content my-account__dashboard">
                        <p>Hello <strong>{{ Auth::user()->name }}</strong>,</p>
                        <p>From your account dashboard you can view your
                            <a class="underline-link" href="{{ route('user_orders') }}">recent orders</a>,
                            manage your <a class="underline-link" href="{{ route('addresses') }}">shipping addresses</a>,
                            and <a class="underline-link" href="{{ route('account_details') }}">edit your password and account details</a>.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
@endpush
