@extends('layouts.master')

@section('content')

{!!Form::model($counterparty,['id'=>'counterparty-update-form','method'=>'PATCH', 'route'=>
['counterparties.update', $counterparty->id],'data-parsley-validate class'=>'form-horizontal form-label-left'])!!}
@include('Setting/counterparties/partials/_form',['addOrEditText'=>'Edit'])
{!!Form::close()!!}



@stop

@section('javascript')
<script src="{{ mix('/js/zentreasury-form.js') }}"></script>
<script src="/js/vendor/jquery-ui.min.js"></script>
<script src="{{ mix('/js/custom/deals.js') }}"></script>
<script src="{{ mix('/js/custom/audit_trail.js') }}"></script>

@stop