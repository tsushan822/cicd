@extends('layouts.master')

@section('content')
    <div id="report_ui" class=" pb-4 ">
        <form method="POST" v-bind:action="action" accept-charset="UTF-8" data-parsley-validate="" class="form-horizontal form-label-left">
            <input type="hidden" name="_token"  value="{{ Session::token() }}" />
            <div class=" px-1 cardSimiliarShadow bg-white">

                <section class="dark-grey-text px-2 ">

                    <div class="headingandbuttons pb-2 px-2 pt-2 borderFormImportant boxShadowRemoval">
                        <div class="d-flex justify-content-between">
                            <div class=" d-flex align-items-center">
                                <div class="pageTitleAndinfo  w-100 text-left">
                                    <h2 class="section-heading  d-flex justify-content-center
                                    justify-content-md-start">{{trans('master.Library')}}</h2>
                                </div>
                            </div>
                            <div class="d-flex align-items-center zen_tab">

                            </div>
                            <div class="d-flex align-items-center" id="datatable-buttons">
                                <div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" borderRemoval">
                        <div class="card-deck">
                            <div class="card ml-0 mr-0 ml-1 pl-1 mr-1 px-0 py-0 borderRemoval boxShadowRemoval">
                                <div class="card-body pt-1">
                                    <div class="row px-0 pb-0 d-none" v-show="showRun" :class="{'d-flex':showRun}">
                                        <div class="col-md-12 pl-0">
                                            <div class="classic-tabs mb-2">
                                                <ul class="nav lease_pills md-pills">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" @click="changeUrl('/report-library/multiple')" data-toggle="tab" href="#runReport"
                                                           role="tab">@lang('master.Run report')</a>
                                                    </li>
                                                    <li class="nav-item" v-show="0">
                                                        <a class="nav-link"  @click="changeUrl('/report-schedules/multiple')" data-toggle="tab" href="#scheduleReport"
                                                           role="tab">@lang('master.Schedule Reports')</a>
                                                    </li>
                                                </ul>

                                            </div>

                                            <!-- Tab panels -->
                                            <div class="tab-content pb-0 pl-2 pt-0">


                                                <div class="tab-pane fade in show active"  id="runReport" role="tabpanel">

                                                    <div class="row">
                                                        <div class="col-md-12 text-left">
                                                            <span>@lang('master.Selected Reports:')</span>
                                                            <span   v-for="report in reportLibrary">
                                                                <div class="chip">
                                                                    <span v-text="report"></span>
                                                                </div>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class=" ">

                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="md-form  ">
                                                                            {!!Form::input('text','start_date_new',null, array("id"=>"start_date_new", "class"=>"datepickerm form-control date","placeholder" => "yyyy-mm-dd"))!!}

                                                                            {!!Form::label('start_date_new',
                                                    trans('master.Start date'))!!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="md-form  ">
                                                                            {!!Form::input('text','end_date_new',null, array("id"=>"end_date_new", "class"=>"datepickerm form-control date","placeholder" => "yyyy-mm-dd"))!!}

                                                                            {!!Form::label('end_date_new',
                                                trans('master.End date') . ' / '. trans('master.Report date'))!!}

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        {!!Form::select('file_format',['xlsx' => 'EXCEL','csv' => 'CSV'],null, array("id"=>"file_format", "class"=>"mdb-select   md-form "))!!}

                                                                        {!!Form::label('file_format',
                                                trans('master.Choose format'))!!}

                                                                    </div>
                                                                    <div class="col-md-3 mt-2">
                                                                        <button class="btn btn-info btn-primary-variant-main" :class="{'disabled':reportLibrary.length===0}" type="submit"
                                                                                value="save"
                                                                                name="submit">@lang('master.Run')</button>
                                                                    </div>
                                                                    <div class="col-md-9"></div>
                                                                    <div class="col-md-3">

                                                                        <small v-show="reportLibrary.length===0" class=" text-danger px-2 py-1">
                                                                            Please select at lease one report
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr class="my-3">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="tab-pane fade" id="scheduleReport" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-12 mt-2 pt-1 text-left">
                                                            <span>@lang('master.Selected Reports:')</span>
                                                            <div class="chip text-left" v-for="report in reportLibrary"
                                                                 v-text="report.name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="md-form  ">
                                                                {!!Form::input('text','schedule_start_date',null, array("id"=>"schedule_start_date", "class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}

                                                                {!!Form::label('schedule_start_date', Lang::get('master.Trade date'))!!}

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">

                                                            {!!Form::select('report_sending_day', array('1' => Lang::get('master.SELL'),'0' => Lang::get('master.BUY')), null,array("class"=>"mdb-select   md-form ","id" => "sell_cross")) !!}
                                                            {!!Form::label('report_sending_day', Lang::get('master.Cross'))!!}

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="md-form  ">
                                                                {!!Form::input('text','start_date',null, array("id"=>"trade_date", "class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}

                                                                {!!Form::label('start_date', Lang::get('master.Trade date'))!!}

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="md-form  ">
                                                                {!!Form::input('text','end_date',null, array("id"=>"end_date", "class"=>"datepickerm form-control date","placeholder" => Lang::get('master.yyyy-mm-dd')))!!}

                                                                {!!Form::label('end_date', Lang::get('master.Trade date'))!!}

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {!!Form::select('duration', array('1' => Lang::get('master.SELL'),'0' => Lang::get('master.BUY')), null,array("class"=>"mdb-select   md-form ","id" => "sell_cross")) !!}
                                                            {!!Form::label('duration', Lang::get('master.Cross'))!!}

                                                        </div>
                                                        <div class="col-md-6">
                                                            <button class="btn btn-info btn-primary-variant-main  mt-2" type="submit"
                                                                    value="saveforSchedule"
                                                                    name="submit">@lang('master.Save')</button>
                                                        </div>

                                                    </div>
                                                    <hr class="my-3">
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-1 mx-0">
                                        <div class="col-md-12 pl-0">
                                            <div class="table-wrapper">
                                                <table id="zentable_landscape"
                                                       class="table table-hover"
                                                       cellspacing="0" width="100%" role="grid"
                                                       aria-describedby="datatable-responsive_info" style="width: 100%;">
                                                    <thead class="black-text">
                                                    <tr>
                                                        <th class="black-text">Id</th>
                                                        <th class="black-text">@lang('master.Select')</th>
                                                        <th class="black-text">@lang('master.Action')</th>
                                                        <th class="black-text">@lang('master.Report name')</th>
                                                        <th class="black-text">@lang('master.Custom report name')</th>
                                                        <th class="black-text">@lang('master.Criteria(JSON format)')</th>
                                                        <th class="black-text">@lang('master.Created at')</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reportLibraries as $reportLibrary)
                                                        <tr>
                                                            <td>{{$reportLibrary->id}}</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" name="reportLibrary[]"
                                                                           value="{{$reportLibrary->id}}"
                                                                           id="{{$reportLibrary->id}}"
                                                                           v-on:click="reportLibraryarray('{{ $reportLibrary->custom_report_name }}',{{$reportLibrary->id}},$event)"
                                                                           class="form-check-input"
                                                                    >
                                                                    <label class="form-check-label"
                                                                           for="{{$reportLibrary->id}}"></label>
                                                                </div>
                                                            </td>
                                                            <td><a href="{{ route($reportLibrary->route, $reportLibrary->id )}}"
                                                                   target="_blank"><i
                                                                            class="fas fa-pen-square edit_fontawesome_icon"></i></a>
                                                                <a href="{{route('report-library.delete',$reportLibrary->id)}}"
                                                                   onclick="return confirm('Are you sure you want to delete this ?')"><i
                                                                            class="far fa-minus-square delete_fontawesome_icon"></i></a>
                                                                @if($reportLibrary->report_name != 'Lease Summary Report YTD' && $reportLibrary->report_name != 'Lease Summary Report')
                                                                    <a href="{{route('report-library.make',$reportLibrary->id)}}"><i
                                                                                class="fas fa-arrow-right edit_fontawesome_icon"></i></a>
                                                                @endif
                                                            </td>
                                                            <td>{{ $reportLibrary->report_name }}</td>
                                                            <td>{{ $reportLibrary->custom_report_name }}</td>
                                                            <td>@if( $reportLibrary->criteria == []) Empty @else {{ $reportLibrary->criteria }} @endif</td>
                                                            <td>{{ $reportLibrary->created_at }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>


        </form>
    </div>
@stop
@section('javascript')
    <script src="{{asset('/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        var allTranslation = "{!! __('master.All') !!}";
        $(document).ready(function () {
            var table = $.when($('#report-library').dataTable({
                "aLengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, allTranslation]],
                "iDisplayLength": 50,
                "order": [],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: "copy",
                        className: "buttons-copy btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect "
                    },
                    {
                        extend: "csv",
                        className: "buttons-csvbtn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect",
                        title: 'Report Library',
                        exportOptions: {
                            columns: [0, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: "excel",
                        className: "buttons-excel btn  btn-sm  btn-primary-variant-one  px-2 waves-effect  waves-effect",
                        title: 'Report Library',
                        exportOptions: {
                            columns: [0, 3, 4, 5, 6]
                        }
                    },
                ],
                stateSave: true,
            })).then(function () {
                $('.dt-button').addClass("btn  waves-effect btn-sm").removeClass("dt-button buttons-html5");
                $('input[type=search]').addClass('form-control border-0 bg-light');
            });
        });
    </script>
    <script>
        new Vue({
            el: '#report_ui',
            data: {
                reportLibrary: [],
                showRun: true,
                action:"/report-library/multiple"
            },
            methods: {
                reportLibraryarray: function (name, value, event) {
                    if (event.target.checked) {
                        this.reportLibrary.push(name);
                    }
                    else if (!event.target.checked) {
                        let index = this.reportLibrary.indexOf(name);
                        this.reportLibrary.splice(index, 1);
                    }
                    this.reportLibraryTabVisibility();
                },
                reportLibraryTabVisibility(){
                    if (this.reportLibrary.length > 0) {
                        this.showRun = true;
                    }
                    else {
                        this.showRun = true;
                    }
                },
                changeUrl: function(url){
                    this.action=url;
                }

            }

        });
    </script>
    <style>
        .active-cyan input[type=text] {
            border-bottom: 1px solid #4dd0e1;
            box-shadow: 0 1px 0 0 #4dd0e1;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid white !important;
            border-radius: 6px;
            text-align: center;
            font-size: 16px;
            font-weight: 200;
            letter-spacing: .8px;
            -webkit-transition: .1s ease-out;
            transition: .1s ease-out;
            -webkit-box-shadow: 0 2px 0 transparent;
            box-shadow: 0 2px 0 transparent;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            background:white !important;
            color:black !important;
        }
        #zentable_landscape_previous{

        }

        .pagination .page-item.active .page-link {
            color: unset !important;
            box-shadow: unset !important;
            transition: all 0.2s linear;
            background-color: unset !important;
        }
        .pagination .page-item.active .page-link:hover {
            color: black !important ;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            box-sizing: border-box;
            display: inline-block;
            min-width: 1.5em;
            padding: 0;
            border-radius: 0;
        }
        @media (min-width: 62em){

            .classic-tabs .nav li:first-child {
                margin-left: 10px !important;
            }
        }
        .lease_pills .nav-link.active {
            padding: 5px 0px !important;
        }
        .table.dataTable tbody th, table.dataTable tbody td {
            text-align: left !important;
            position: relative;
            left: 2px;
        }
        .lease_pills .nav-link {
            padding: 5px 0px !important;
        }
        .dataTables_empty{
            text-align: center !important;
        }
    </style>

@stop

@push('form-js')
    <style>
        .table td {
            padding: .3rem 0rem !important;
        }

        .sorting_1:before {
            top: 6px !important;
        }

        .dt-buttons {
            dispaly: none !important;

        }

        .dataTables_filter {
            dispaly: none !important;

        }
    </style>
    <script>
        $( document ).ready(function() {
            $('.dt-button').addClass( "btn btn-sm  btn-primary-variant-one  px-2").removeClass( "dt-button buttons-html5" );
            $('input[type=search]').addClass('form-control border-0 bg-light');
            $(".dt-buttons").appendTo("#datatable-buttons");
            $(".datatable-leases_filter").appendTo("#datatable-buttons");
        });

    </script>

@endpush