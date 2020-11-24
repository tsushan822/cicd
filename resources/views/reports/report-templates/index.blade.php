@extends('layouts.master')

@section('content')

    <div class="pb-4 pt-4">
        <div class="card card-cascade narrower mt-4">

            <!--Card image-->
            <div
                    class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                <a href="" class="white-text mx-3">@lang('master.Report template')</a>

                <div>
                    <a class="btn btn-outline-white  btn-sm px-2"
                       href="{!! route('bookkeeping-settings.index') !!}">
                        <i class="fas fa-arrow-left"></i> @lang('master.Back')
                    </a>
                </div>



            </div>


            <div class="px-4">

                <div class="table-wrapper">
                    <table class="table table-bordered">

                        <thead>
                        <tr>
                            <th>{{ trans('master.Column name') }}</th>
                            @if(!$template -> for_txt_file)
                                <th>{{ trans('master.Table header') }}</th>
                            @endif
                            <th>{{ trans('master.Default value') }}</th>
                            @if($template -> for_txt_file)
                                <th>{{ trans('master.Length') }}</th>
                                <th>{{ trans('master.Is header') }}</th>
                            @endif
                            <th>{{ trans('master.Order') }}</th>
                            <th>{{ trans('master.Active status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tableOrder as $item)
                            <tr>
                                <td>{{ $item->column_name }}</td>
                                @if(!$template -> for_txt_file)
                                    <td>{{ $item->table_header }}</td>
                                @endif
                                <td>{{ $item->default_value }}</td>
                                @if($template -> for_txt_file)
                                    <td>{{ $item->length }}</td>
                                    <td><i class="{{ getLargeCheckBox( $item->is_header_text) }}"></i></td>
                                @endif
                                <td> {{$item->order}}</td>
                                <td><i class="{{ getLargeCheckBox( $item->active_status) }}"></i></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@endsection

