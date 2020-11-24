@extends('layouts.master')
@section('content')
{!!Form::model($portfolio,['id'=>'portfolio-update-form','method'=>'PATCH', 'route'=>['portfolios.update', $portfolio->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}

@include('Setting/portfolios/partials/_form')
{!!Form::close()!!}



@stop
@section('javascript')
<script src="{{ mix('/js/zentreasury-form.js') }}"></script>
<script src="/js/vendor/jquery-ui.min.js"></script>
<script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop