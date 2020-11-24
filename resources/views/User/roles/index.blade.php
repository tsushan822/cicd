@extends('layouts.master')
@section('content')

<div id="reportComponentArea">
    <roles-index></roles-index>
</div>

    @push('vue-scripts')
        <script src="{{ mix('/app/report-components/app.js') }}"></script>

    @endpush

@endsection