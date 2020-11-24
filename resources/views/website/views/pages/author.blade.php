@extends('website.views.layouts.master')
@push('meta')
    <meta name="description" content="Latest news and tips by {{$data['posts'][0]->name}}">
    <meta name="author" content="LeaseAccounting Ltd">
    <title>Latest news and tips by {{$data['posts'][0]->name}}</title>
    <meta property="og:title" content="Blogs written by{{ $data['posts'][0]->name }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->full() }}" />
    <meta property="og:description" content="Latest news and tips by {{$data['posts'][0]->name}}" />
@endpush
@section('content')
    <div>
        <div class="blog_parent_holder pb-5 position-relative">
            <div class="content_ui pb-4 text-black">
                <header class="pt-lg-2 mt-lg-2 pb-lg-0 pb-md-0 pb-sm-2  mt-5 pt-5 bg-img-repeat mt-md-5 mt-sm-5 mt-xs-5 pt-md-5 pt-sm-5 pt-xs-5 ">
                    <div class="page-header-content">
                        <div class="row mt-5 ">
                            <div class="col-lg-12 text-white col-md-12 col-sm-12">
                                <div class="pl-3  pb-3">
                                    <div class="profile_holder d-flex flex-column align-items-center">
                                        <div class="profile_image_holder  ">
                                            <img src="{{$data['posts'][0]->avatar}}" class="img-fluid">
                                        </div>
                                        <div class="text-dark pl-2">
                                            <h1 class="page-header-title  text-dark text-center">{{$data['posts'][0]->name}}</h1>
                                            <div id="bio-holder">
                                                {!! $data['posts'][0]->bio !!}
                                            </div>
                                            <div id="social-icons-top-bio" class="d-flex justify-content-center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <svg id="features_part" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150" style="overflow: hidden; vertical-align: middle; position: absolute; bottom: 0px; left: 0px;">
                <path fill="#fff" fill-opacity="1" d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path>
            </svg>
        </div>
    </div>
    <div id="app" class="blog_listing_holder position-relative pb-5">
        <div class="content_ui text-dark">
            <blog-retrival-component :authorslug="'{{$data['posts'][0]->slug}}'" :author="true"></blog-retrival-component>
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 150" style="overflow: hidden; vertical-align: middle;">
        <path fill="#028CDE" fill-opacity="1" d="M0,0L120,26.7C240,53,480,107,720,112C960,117,1200,75,1320,53.3L1440,32L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path>
    </svg>
    <div class="last_call_to_register">
        <div class="content_ui pb-4">
            <div class="container text-white">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8 col-md-10 text-center my-10 py-10">
                        <h3 class="mb-4 pt-4 ">Ready to get Started?</h3>
                        <p class="page_paragraph pb-2">We are offering you thirty day free trials to test the greatest LeaseAccounting software out in the web!</p>
                        <a href="{{route('register')}}" class="btn btn-sm btn-rounded  btn-primary-variant-one  px-5 waves-effect waves-light">FREE TRIAL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('header-scripts-area')
    <link rel="stylesheet" href="{{ mix('/css/website.css') }}">
@endpush

@push('footer-scripts-top')
    <script src="{{ mix('/app/website-components/app.js') }}"></script>
    <script>
        //using var for old browser support
        document.addEventListener("DOMContentLoaded", function(event) {
            var linkedinLogoWithUrl='<a class="li-ic" href="" id="bioLinkedinId" target="_blank"> <i class="fab fa-linkedin-in fa-lg mr-2 fa-2x"> </i> <span class="d-none">Linkedin logo</span></a>';
            var instaGramLogoWithUrl='<a class="ins-ic" href="" id="bioInstaGramId" target="_blank"> <i class="fab fa-instagram fa-lg  mr-2  fa-2x"> </i> <span class="d-none">Instragram logo</span> </a>';
            function contains(selector, text) {
                var elements = document.querySelectorAll(selector);
                return [].filter.call(elements, function(element){
                    return RegExp(text).test(element.textContent);
                });
            }
          //create linkedin link
          var linkedinUrl=  contains('p', 'https://www.linkedin.com')[0].innerText;
          var linkedinLogo=  contains('p', 'https://www.linkedin.com')[0].innerHTML=linkedinLogoWithUrl;
          document.getElementById("bioLinkedinId").setAttribute("href", linkedinUrl);
           //create instragram link
          var insTagramUrl=  contains('p', 'https://www.instagram.com')[0].innerText;
          var insTagramUrlLogo=  contains('p', 'https://www.instagram.com')[0].innerHTML=instaGramLogoWithUrl;
          document.getElementById("bioInstaGramId").setAttribute("href", insTagramUrl);
          //move linkedin and instragram to another div
          var linkedin=contains('p', 'Linkedin logo')[0];
          var instragram=contains('p', 'Instragram logo')[0];
          document.getElementById('social-icons-top-bio').appendChild(instragram);
          document.getElementById('social-icons-top-bio').appendChild(linkedin);

        });
    </script>
@endpush