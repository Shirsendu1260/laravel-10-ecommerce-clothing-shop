@extends('layouts.app')

@push('styles')
<style>
    p {
        text-align: justify;
        text-justify: inter-word;
    }
</style>
@endpush

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title">About US</h2>
        </div>

        <div class="about-us__content pb-5 mb-5">
        <div class="mw-930">
            <p class="mb-5">
                <img class="w-100 h-auto d-block lazy-img" data-lazy="{{ asset('assets/user/images/about/about-1.jpg') }}" width="1410" height="550" alt="" />
            </p>
            <h3 class="mb-4">OUR STORY</h3>
            <p class="fs-6 fw-medium mb-4">Et similique nulla aut galisum excepturi qui molestias ipsum a vero ducimus vel iusto nemo. Qui suscipit nihil aut dolores dolorum sit facilis fuga. Sit rerum inventore aut suscipit omnis sed dolor nemo.</p>
            <p class="mb-4">Lorem ipsum dolor sit amet. Eos excepturi fuga qui voluptatum minima et Quis dolorem sed accusamus quia cum molestiae odit. Et beatae enim ut nobis earum et eaque reprehenderit. Aut nulla unde aut esse molestiae eum quae enim At cumque placeat! Ut Quis sunt aut galisum dignissimos et esse voluptas non nemo velit aut nihil alias sed temporibus possimus et vitae cumque. Et accusantium expedita et iusto quasi quo odit porro aut similique autem id beatae modi eos quia iste. Qui iste cumque qui eveniet exercitationem et quia esse qui ipsa labore aut dignissimos eveniet. Aut provident rerum eos error doloremque est eius optio id libero maxime et laudantium obcaecati. Non corrupti voluptatibus ut expedita quia qui totam dolores At quia blanditiis ab itaque fuga sit dicta assumenda et consequatur debitis. Aut voluptatum quaerat rem labore quia At sequi ipsum ad rerum galisum qui magni accusamus id dolor nobis est veniam blanditiis.</p>
            <div class="row mb-3">
            <div class="col-md-6">
                <h5 class="mb-3">Our Mission</h5>
                <p class="mb-3">Lorem ipsum dolor sit amet. Aut velit nesciunt qui voluptatibus nostrum est nihil corrupti et expedita internos qui impedit expedita. Sit expedita cumque qui sapiente tenetur sit cupiditate dicta aut nostrum illum quo quaerat repellendus.</p>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">Our Vision</h5>
                <p class="mb-3">Lorem ipsum dolor sit amet. Aut velit nesciunt qui voluptatibus nostrum est nihil corrupti et expedita internos qui impedit expedita. Sit expedita cumque qui sapiente tenetur sit cupiditate dicta aut nostrum illum quo quaerat repellendus.</p>
            </div>
            </div>
        </div>
        <div class="mw-930 d-lg-flex align-items-lg-center">
            <div class="image-wrapper col-lg-6">
                <img class="h-auto lazy-img" data-lazy="{{ asset('assets/user/images/about/about-1.jpg') }}" width="450" height="500" alt="">
            </div>
            <div class="content-wrapper col-lg-6 ps-lg-3">
            <h5 class="mb-3">The Company</h5>
            <p>Et ducimus saepe est exercitationem sequi qui commodi architecto quo maiores voluptate? Sit dignissimos fuga hic pariatur modi ut consequatur excepturi sit perferendis illum. Et quibusdam aspernatur ex nulla quos non rerum dolor.</p>
            </div>
        </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')

@endpush
