@extends('layouts.master')
@section('content')
    @push('header-css')
        <style>
            #main-content-area{
                margin: 0px 0px 0px 0px !important;
                padding:0px 0px 0px 0px !important;
            }
            #slide-out, .float-left{
                display: none !important;

            }

        </style>
    @endpush
    <div id="setupArea">
        <setup-page></setup-page>
    </div>

    @push('vue-scripts')
        <script src="/app/lease-accounting-setup-components/app.js"></script>

    @endpush

@endsection
@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop