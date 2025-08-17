@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Contact Message Information</h3>
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
                        <a href="{{ route('admin_contact_messages_index') }}">
                            <div class="text-tiny">Contact Messages</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Details</div>
                    </li>
                </ul>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin_contact_messages_index') }}" class="btn btn-primary fs-4 fw-bold mb-5" style="border-radius: 7px; padding: 7.5px 25px;">
                    <span class="bi bi-arrow-left">&nbsp;Back</span>
                </a>
            </div>

            <div class="wg-box">
                @include('layouts.alerts')
                <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th class="text-center p-2" style="width:  27px;">Name</th>
                                    <td class="p-2 px-3">{{ $contact_message->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center p-2" style="width:  27px;">Email</th>
                                    <td class="p-2 px-3">{{ $contact_message->email }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center p-2" style="width:  27px;">Subject</th>
                                    <td class="p-2 px-3">{{ $contact_message->subject }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center p-2" style="width:  27px;">Message</th>
                                    <td class="p-2 px-3">{{ $contact_message->message }}</td>
                                </tr>
                                <tr>
                                    <th class="text-center p-2" style="width:  27px;">Is Replied?</th>
                                    <td class="p-2 px-3">
                                        @if($contact_message->is_replied == '1')
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @if($contact_message->is_replied == '0')
                        <div class="bot">
                            <div></div>
                            <form action="{{ route('admin_reply_contact_message', $contact_message->id) }}" method="post" id="contact-msg-reply-form">
                                @csrf
                                <button class="tf-button w208 me-2" type="submit">Reply</button>
                            </form>
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#contact-msg-reply-form").on("submit", function(e) {
                e.preventDefault();

                if(confirm("Do you want to proceed to reply this message?")) {
                    // $(this).submit();
                    this.submit();
                }
            });
        });
    </script>
@endpush
