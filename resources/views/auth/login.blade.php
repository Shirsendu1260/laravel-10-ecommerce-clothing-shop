@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login"
                        role="tab" aria-controls="tab-item-login" aria-selected="true">Login To Your Account</a>
                </li>
            </ul>
            @include('layouts.userend-alerts')
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        <form method="POST" action="{{ route('login') }}" name="login-form" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required="" autocomplete="email" autofocus="">
                                <label for="email">Email address *</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="pb-3"></div>

                            <div class="form-floating mb-3 pb-2">
                                <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required="" autocomplete="current-password">
                                <label for="customerPasswodInput">Password *</label>
                                <div class="d-flex justify-content-between mt-1">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input pw-toggle">
                                        <label class="form-check-label">Show</label>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Login</button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">No account yet?</span>
                                <a href="{{ route('register') }}" class="btn-text js-show-register">Register</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
