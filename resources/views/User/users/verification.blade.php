@extends('layouts.master')
@section('content')
    <div class="card card-cascade narrower mt-5 mb-5">

        <!--Card image-->
        <form class="form-horizontal" method="post" action="{{ route('post-new-account-verification') }}">
            {{ csrf_field() }}
            <div
                    class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">

                <a href="" class="white-text mx-3">@lang('master.Verify User')</a>
                <div>
                    @if($user->verified == 0)
                    <input type="button" class="btn btn-outline-white  btn-sm px-2" value="Close">
                    <input type="submit" class="btn btn-outline-white  btn-sm px-2" value="Verify">
                    @endif
                </div>


            </div>
            <!--/Card image-->

            <div class="px-4 mt-5 mb-5">

                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                           <div class="row">
                               <div class="col-md-12">
                                   <input type="hidden" name="user_id" value="{!! $user->id !!}">
                                   <div class="md-form md-outline">
                                       <input id="name" type="text" class="form-control" name="name" disabled
                                              value="{!! $user->name !!}"
                                              autofocus>
                                   </div>
                                </div>
                               <div class="col-md-12">
                                   <div class="md-form md-outline">
                                       <input id="name" type="text" disabled class="form-control" name="name"
                                              value="{!! $user->email !!}">
                                       {!!Form::label('email', trans('master.Email'))!!}
                                   </div>
                                </div>
                               <div class="col-md-12">
                                      <p class="note note-primary">
                                   @if($user->verified)
                                       Already Verified
                                   @else
                                      Unverified
                                       @endif
                                      </p>
                                </div>
                               @if(!$user->verified)
                               <div class="col-md-12">

                                   <select name="role[]" class="mdb-select colorful-select dropdown-primary md-form" multiple searchable="Search here..">
                                       @foreach($roles as $role)
                                       <option value="{!! $role->id !!}">{!! $role->label !!}</option>
                                       @endforeach
                                   </select>
                                   <label class="mdb-main-label">Choose Roles</label>
                                   <button class="btn-save btn btn-primary btn-sm">Save</button>

                               </div>
                               @else

                               <div class="col-md-12">
                                   @foreach($userRoles as $userRole)
                                       <div class="chip primary">
                                           {!! $userRole->label !!}
                                       </div>
                                   @endforeach
                                </div>
                               @endif
                           </div>

                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

@endsection