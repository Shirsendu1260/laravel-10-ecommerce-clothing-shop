@extends('layouts.app')

@push('styles')
    <style>
        p {
            text-align: justify;
            text-justify: inter-word;
        }

        .contact-info p {
            margin-bottom: 10px;
        }

        .contact-info a {
            color: #222222;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">Contact Us</h2>
            </div>

            <div class="about-us__content pb-5 mb-5">
                <div class="mw-930 mb-5 pb-2">
                    <h3 class="mb-3">Get in Touch</h3>
                    <hr>
                    <div class="contact-info">
                        <p><strong>Email:</strong> <a href="mailto:info@yourwebsite.com" target="_blank">info@yourwebsite.com</a></p>
                        <p><strong>Phone:</strong> <a href="tel:+911234554321">+91 12345-54321</a></p>
                        <p><strong>Address:</strong><br>
                            123 Street<br>
                            Kolkata, West Bengal 700001<br>
                            India</p>
                    </div>
                </div>
                <div class="mw-930 mb-5 pb-2">
                    <div class="contact-us__form">
                        @include('layouts.userend-alerts')
                        <form action="{{ route('send_contact_us_form') }}" name="contact-us-form" class="needs-validation" novalidate="" method="POST">
                            @csrf
                            <h3 class="mb-3">Send Us a Message</h3>
                            <hr>
                            <div class="form-floating my-4">
                                <input class="form-control form-control_gray @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required="">
                                <label for="name">Name *</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating my-4">
                                <input class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required="">
                                <label for="email">Email *</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating my-4">
                                <input class="form-control form-control_gray @error('subject') is-invalid @enderror" name="subject" id="subject" value="{{ old('subject') }}" required="">
                                <label for="subject">Subject</label>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="my-4">
                                <textarea class="form-control form-control_gray @error('message') is-invalid @enderror" name="message" id="message" placeholder="Message *" cols="30" rows="8" required="">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="my-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mw-930">
                    <h3 class="mb-3 text-center">Connect With Us</h3>
                    <hr>
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <p class="mb-1">Follow us on social media</p>
                        <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                            <li>
                                <a href="https://www.facebook.com/" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_facebook"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://x.com/" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_twitter"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_instagram"></use>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z">
                                        </path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')

@endpush
