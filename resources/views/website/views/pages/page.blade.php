@extends('website.views.layouts.master')
@push('meta')
    @push('meta')
        <meta name="description" content="page description">
        <meta name="author" content="LeaseAccounting Ltd">
        <title>{{$data['post'][0]->title}}</title>
        <meta property="og:title" content="page description" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->full() }}" />
        <meta property="og:description" content="page description" />
    @endpush
@endpush
@section('content')
    <div class="body_bg_white position-relative  mt-5 ">
        <div class="content_ui">
            <h1 class="text-left h1  mb-3">
                <strong>{{$data['post'][0]->title}}</strong>
            </h1>
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
                        {!! $data['post'][0]->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
    <style>
        .table td {
            font-size:1.2rem !important;
        }
        .table thead th {
            font-size: 1.4rem !important;
        }
        .list-icons{
            list-style: none !important;
            padding: 0rem 1rem;
        }
        .fa-arrow-right{
            margin-right: .5rem;
            color: #028CDE;
        }

    </style>
@endpush