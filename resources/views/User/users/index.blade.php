@extends('layouts.master')
@section('css')
    <style>
        .inactive {
            color: #C0C0C0;
        }

        .inactive .text-primary, .inactive .text-danger, .inactive .glyphicon-user {
            color: #C0C0C0;
        }
    </style>
@stop
@section('content')

    <div class="card  ">

        <div class="card-header crud_table_header mb-2 d-flex justify-content-between ">
            <div  class="d-flex align-items-center">
                <h6 class="  pl-1">
                    <strong> {{trans('master.Assigned duties')}}</strong>
                </h6>
            </div>
            <div id="datatable-buttons">
                @if($view['add_user'])
                    <a class="btn btn-sm  btn-primary-variant-main  px-2" href="{!! route('users.create') !!}">
                        <i class="fas fa-envelope"></i> @lang('master.Send invitation')
                    </a>
                @endif
            </div>

        </div>

        <div class="table-wrapper">
                <!--Table-->
                <table class="table table-hover mb-0  dt-responsive  no-footer dtr-inline
              collapsed">

                    <!--Table head-->
                    <thead>
                    <tr>
                        <th>
                            User
                        </th>
                        @foreach($roles as $role)
                            <th>
                                {!! $role->label !!}
                            </th>
                        @endforeach
                        <th>
                            Edit
                        </th>

                    </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->
                    <tbody>
                    @foreach($users as $user)
                        @if($user->active_status)
                            <tr>
                        @else
                            <tr class="inactive">
                                @endif
                                <td>{!!$user->name!!}</td>
                                @foreach($roles as $role)
                                    <td><i class="{!! getLargeCheckBox($user[$role->name]) !!}"></i></td>
                                @endforeach
                                <td style="text-align: center">
                                    @can('edit_user')
                                        <a href="{!! route('users.edit', $user->id) !!}"><i
                                                    class="fas fa-user"></i></a>
                                    @endcan
                                    @if($user->verified)
                                        <i class="fas fa-check text-sucess"></i>
                                    @else
                                        <i class=" fas fa-times text-danger"></i>

                                    @endif

                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                    <!--Table body-->
                </table>
                <!--Table-->
            </div>

        </div>



    <div class="card mt-4 ">

        <div class="card-header crud_table_header mb-2 d-flex justify-content-between ">
            <div  class="d-flex align-items-center">
                <h6 class="  pl-1">
                    <strong> {{trans('master.Assigned duties')}}</strong>
                </h6>
            </div>
            <div id="datatable-buttons">

            </div>

        </div>

        <div class="table-wrapper">
            <!--Table-->
            <table class="table table-hover mb-0  dt-responsive  no-footer dtr-inline
              collapsed">

                <!--Table head-->
                <thead>
                <tr>
                    <th>
                        User
                    </th>
                    @foreach($userCounterparties as $user)
                        <th> {!!$user->name!!}</th>
                    @endforeach
                </tr>
                </thead>
                <!--Table head-->

                <!--Table body-->
                <tbody>
                @foreach($counterparties as $counterparty)
                    <tr>
                        <td>{!!$counterparty->short_name!!}</td>
                        @foreach($userCounterparties as $user)
                            <td><i class="{!! getLargeCheckBox($user[$counterparty->short_name]) !!}"></i></td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
                <!--Table body-->
            </table>
            <!--Table-->
        </div>

    </div>
@stop

