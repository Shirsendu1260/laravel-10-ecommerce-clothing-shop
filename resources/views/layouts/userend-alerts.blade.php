@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3 fs-6 p-3 d-flex align-items-center" role="alert">
        <span>{!! Session::get('success') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: -7px;"></button>
    </div>
@elseif (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3 fs-6 p-3 d-flex align-items-center" role="alert">
        <span>{!! Session::get('error') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: -7px;"></button>
    </div>
@elseif (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show mb-3 fs-6 p-3 d-flex align-items-center" role="alert">
        <span>{!! Session::get('warning') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: -7px;"></button>
    </div>
@endif
