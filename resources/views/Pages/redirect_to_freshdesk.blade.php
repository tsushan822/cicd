@extends('layouts.dashboard')
@section('css')

@stop
@section('content')
        @push('checkEnvironmentReadiness')
            <redirect-freshdesk></redirect-freshdesk>
        @endpush
        <div class="spinner_area_holder">
            <div class="d-flex justify-content-center dashboard-custom-spinner-area flex-column align-items-center" style="min-height: 97vh;">
                <div class="w-100">
                    <div class="spinner-border dashboard-custom-spinner" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <h5 class="w-100 mt-5 ml-4">Redirecting you to knowledgebase.....</h5>

            </div>
        </div>
@stop
@section('javascript')
    <!-- chart -->
    <script src="{{ mix('/tenant/app.js') }}"></script>

@stop

