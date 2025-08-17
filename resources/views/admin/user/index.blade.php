@extends('layouts.admin-app')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Users</h3>
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
                        <div class="text-tiny">Users</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                @include('layouts.alerts')
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here" class="" name="search" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center p-2">#</th>
                                    <th class="text-center p-2">Name</th>
                                    <th class="text-center p-2">Gender</th>
                                    <th class="text-center p-2">Mobile</th>
                                    <th class="text-center p-2">Email</th>
                                    <th class="text-center p-2">Role</th>
                                    <th class="text-center p-2">Status</th>
                                    <th class="text-center p-2">Joined At</th>
                                    <th class="text-center p-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            @php
                                            $page = !empty(Request::query('page')) ? Request::query('page') : 1;
                                            $index = $key + (($page - 1) * 7) + 1;
                                            @endphp
                                            <td class="text-center p-2">{{ $index }}</td>
                                            <td class="text-center p-2">{{ $user->name }}</td>
                                            <td class="text-center p-2">
                                                @if($user->gender == 'M')
                                                    Male
                                                @elseif($user->gender == 'F')
                                                    Female
                                                @else
                                                    Other
                                                @endif
                                            </td>
                                            <td class="text-center p-2">{{ $user->phonecode }}{{ $user->mobile }}</td>
                                            <td class="text-center p-2"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                            <td class="text-center p-2">
                                                @if($user->role == 'A')
                                                    <span class="badge bg-dark">Admin</span>
                                                @else
                                                    <span class="badge bg-primary">Customer</span>
                                                @endif
                                            </td>
                                            <td class="text-center p-2">
                                                @if($user->status == '1')
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>Active
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger me-2"></i>Inactive
                                                @endif
                                            </td>
                                            <td class="text-center p-2">{{ date('d M, Y, h:m a', strtotime($user->created_at)) }}</td>
                                            <td class="text-center p-2">
                                                <div class="list-icon-function d-flex justify-content-center">
                                                    @if($user->status == '0')
                                                    <a href="javascript:void(0)" onclick="unblockUser('{{ $user->id }}', '{{ $user->name }}')">
                                                        <div class="item text-success delete d-flex flex-row align-items-center">
                                                            <i class="bi bi-unlock-fill me-2"></i><p class="fs-4">Unblock</p>
                                                        </div>
                                                    </a>
                                                    @else
                                                    <a href="javascript:void(0)" onclick="blockUser('{{ $user->id }}', '{{ $user->name }}')">
                                                        <div class="item text-danger delete d-flex flex-row align-items-center">
                                                            <i class="bi bi-lock-fill me-2"></i><p class="fs-4">Block</p>
                                                        </div>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-secondary text-center">Records not found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="divider" style="margin-bottom: 20px"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination justify-content-end">
                        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function unblockUser(userId, username) {
            if(confirm(`Do you really want to unblock this user - ${username}?`)) {
                var url = "{{ route('admin_user_unblock', 'id') }}";
                var newUrl = url.replace('id', userId);

                $.ajax({
                    url: newUrl,
                    type: 'put',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Whatever the response's status may be, redirect to user listing page
                        window.location.reload();
                    },
                    error: function(jqXHR, exception) {
                        alert('Error occured while unblocking the user!');
                    },
                });
            }
        }

        function blockUser(userId, username) {
            if(confirm(`Do you really want to block this user - ${username}?`)) {
                var url = "{{ route('admin_user_block', 'id') }}";
                var newUrl = url.replace('id', userId);

                $.ajax({
                    url: newUrl,
                    type: 'put',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Whatever the response's status may be, redirect to user listing page
                        window.location.reload();
                    },
                    error: function(jqXHR, exception) {
                        alert('Error occured while blocking the user!');
                    },
                });
            }
        }
    </script>
@endpush
