@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show mb-3 fs-5 d-flex align-items-center" role="alert">
        <span>{!! Session::get('success') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: -3px;"></button>
    </div>
@elseif (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3 fs-5 d-flex align-items-center" role="alert">
        <span>{!! Session::get('error') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="top: -3px;"></button>
    </div>
@endif
