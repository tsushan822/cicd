
@extends('layouts.master')

@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
        {{ csrf_field() }}
    <div class="pb-4 ">

        <div class=" px-1 cardSimiliarShadow bg-white">

            <section class="dark-grey-text px-2 ">

                <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                    <div class="d-flex justify-content-between">
                        <div class=" d-flex align-items-center">
                            <div class="pageTitleAndinfo  w-100 text-left">
                                <h2 class="section-heading  d-flex justify-content-center justify-content-md-start">@lang('master.Invite user')</h2>
                            </div>
                        </div>
                        <div class="d-flex align-items-center zen_tab">

                        </div>
                        <div class="d-flex align-items-center" id="datatable-buttons">
                            <div>
                                <a class="btn btn-sm  btn-primary-variant-one  px-2 waves-effect waves-light" href="{!! route('users.index') !!}">
                                    <i class="fas fa-arrow-left"></i>  @lang('master.Back')
                                </a>
                                <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                        type="submit" value="save" name="submit" id="register_submit"><i
                                            class="fas fa-envelope"></i>
                                    @lang('master.Send invitation')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=" borderRemoval">
                    <div class="card-deck">
                        <div class="card ml-0 mr-0 ml-1 pl-1 px-0 py-0 borderRemoval boxShadowRemoval">
                            <div class="card-body pt-1">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::text('name', null, ['id'=>'name', 'class' => 'form-control','placeholder'=>trans('master.Name')])!!}
                                            {!!Form::label('name', trans('master.Name'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form ">
                                            {!!Form::email('email', null, ['id'=>'Email', 'class' => 'form-control','type'=>'email','placeholder'=>trans('master.Email')])!!}
                                            {!!Form::label('email', trans('master.Email'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="md-form d-none">
                                            {!!Form::password('password', ['class' => 'form-control','placeholder'=>trans('master.Password')]);!!}
                                            {!!Form::label('password', trans('master.Password'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-none">
                                        <div class="md-form ">
                                            {!!Form::password('password_confirmation', ['class' => 'form-control','id'=>'password-confirm','placeholder'=>trans('master.Confirm Password')]);!!}
                                            {!!Form::label('password_confirmation', trans('master.Confirm Password'))!!}
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="col-md-12 text-left md-form pl-0">
                                            <label for="roles" class="active">{{trans('master.Assign company (select at leaset one or more)')}}</label>
                                        </div>
                                        {!!Form::hidden('locale',auth()->user()->locale)!!}
                                        {!!Form::hidden('active_status',1)!!}
                                        <div class="col-md-12 pl-0 new_account_company d-flex">
                                            <select name="counterparty[]" class="mdb-select w-100 colorful-select dropdown-primary md-form hide-first-element-of-dropdown" multiple searchable="@lang('master.Search here..')">
                                                <option value="" disabled selected>{{trans('master.Choose')}}</option>
                                                @foreach($counterparties as $counterparty)
                                                    @if(in_array($counterparty->id,$counterpartyArray))
                                                        <option value="{!! $counterparty->id !!}" selected>{!! $counterparty->short_name !!}</option>

                                                    @else
                                                        <option value="{!! $counterparty->id !!}">{!! $counterparty->short_name !!}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 new_account_roles">
                                        <div class="col-md-12 text-left md-form pl-0">
                                            <label for="roles" class="active">{{trans('master.Roles (select at leaset one or more)')}}</label>
                                        </div>
                                        <div class="col-md-12 pl-0 d-flex justify-content-start flex-wrap">
                                            @foreach($roles as $role)

                                                <div class="form-check  form-check-inline">
                                                    @can('edit_user')
                                                        {!!Form::checkbox('role[]',$role->id,in_array($role->id,$roleArray), ['id'=>$role->name, 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                    @else
                                                        {!!Form::checkbox('role[]',$role->id,in_array($role->id,$roleArray), ['onclick'=>"return false;",'disabled'=>true,'id'=>$role->name, 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                    @endcan
                                                    {!!Form::label($role->name, $role->label, array("class"=>"form-check-label active" ))!!}
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card d-none ml-0 mr-1 ml-0 pl-0 pr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                            <div class="card-body pt-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <blockquote v-show="!showRun" class="blockquote  text-left bq-primary mb-4">
                                            <p class="bq-title px-0 py-0">{{trans('master.Phone number')}}</p>
                                            <p class="px-0 my-0 py-0">{{trans('master.Choose your country code and enter your number without the leading zero eg 401234567')}}
                                            </p>
                                        </blockquote>
                                    </div>
                                    <div class="col-md-12">
                                        @can('edit_user')
                                            {!!Form::select('two_factor_type',array('off'=>trans('master.Off'),'app'=>trans('master.Authy app')),null,array("class"=>"mdb-select   md-form "))!!}
                                        @else
                                            {!!Form::hidden('two_factor_type',$user ?? ''->two_factor_type)!!}
                                            {!!Form::select('two_factor_type',array('off'=>trans('master.Off'),'app'=>trans('master.Authy app')),null,array("class"=>"mdb-select   md-form ","disabled"))!!}

                                        @endcan

                                        {!!Form::label('two_factor_type',trans('master.Two Factor Authentication'))!!}
                                    </div>

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @can('edit_user')
                                                    {!!Form::select('dialing_code',config('twofactor.dialing_codes'),null,array("class"=>"mdb-select   md-form "))!!}
                                                @else
                                                    {!!Form::hidden('dialing_code',$user ?? ''->dialing_code)!!}
                                                    {!!Form::select('dialing_code',config('twofactor.dialing_codes'),null,array("class"=>"mdb-select   md-form ","disabled"))!!}
                                                @endcan

                                            </div>

                                            <div class="col-md-6">
                                                <div class="md-form ">
                                                    @can('edit_user')
                                                        {!!Form::text('phone_number',null,array("class"=>"form-control","placeholder" => "401234567"))!!}
                                                    @else
                                                        {!!Form::text('phone_number',null,array("class"=>"form-control","readonly"))!!}
                                                    @endcan

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </section>
        </div>
    </div>
    </form>

@endsection
@push('header-css')
    <style>
        .hide-first-element-of-dropdown > .multiple-select-dropdown >li:first-of-type{
            display:none !important
        }
    </style>
@endpush