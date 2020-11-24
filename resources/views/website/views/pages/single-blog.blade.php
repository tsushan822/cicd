@extends('website.views.layouts.master')
@push('meta')
    <title>{{$data['post']->title}}</title>
    <meta name="description" content="$data['meta']['meta_description']">
    <meta name="author" content="LeaseAccounting Ltd">
    <meta property="og:title" content="{{$data['post']->title}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ url()->full() }}"/>
    <meta property="og:description" content="$data['meta']['meta_description']"/>
@endpush
@section('content')
    <div class="body_bg_white position-relative  mt-5 ">
        <div class="content_ui blog-title-and-profile">
            <h1 class="text-left h1  mb-3">
                <strong>{{$data['post']->title}}</strong>
            </h1>
            <div class="row">
                <div class="col-md-12 col-xl-12 d-flex profile-social-area  justify-content-between ">
                   <div class="d-flex profile_area">
                       <p class="font-small dark-grey-text mb-1">
                           <a href="/author/{{$data['author']->slug}}" ><img class="blog-avatar" src="{{$data['author']->avatar}}" alt="{{$data['author']->name}}"> {{$data['author']->name}}</a>
                       </p>
                       <p class="font-small pt-2 grey-text mb-0 ml-3">
                           <i class="far fa-clock dark-grey-text"></i> {{ format_date($data['post']->publish_date) }}
                       </p>
                   </div>

                    <!-- Go to www.addthis.com/dashboard to customize your tools -->
                    <div class="addthis_inline_share_toolbox"></div>

                </div>
            </div>
        </div>
        <div class="svg_holder_parent d-none d-md-block" style="
    position: absolute;
    top: 100%;
    left: 0;
">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#EFFAFD" fill-opacity="1" d="M0,96L1440,128L1440,320L0,320Z"></path>
            </svg>
        </div>
    </div>

    <div class="body_bg">
        <div class="content_ui">
            <div class="row px-3  pt-3">
                <!--Grid column-->
                <div class="col-md-12 col-xl-12">
                    <!--Grid row-->
                    <div class="row mt-2 single_blog_holder">
                        <div class="image_holder pb-4">
                            @if($data['post']->featured_image)
                                <img src="{{$data['post']->featured_image}}"
                                     alt="$post->title" class="img-fluid">
                            @else
                                <img src="https://mdbootstrap.com/img/Photos/Others/images/94.jpg" class="img-fluid"
                                     alt="Image not available">
                            @endif
                        </div>
                        {!! $data['post']->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5fa149afe3ccc2d9"></script>


@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
@endpush