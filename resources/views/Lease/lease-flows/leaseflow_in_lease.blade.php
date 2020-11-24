<div id="cashflows">
    <div class="row tabsrow table-responsive">
            <div class="d-none">
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="pageTitleAndinfo mt-2 w-100 text-left">
                            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start"></h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-2 d-flex justify-content-md-end mt-2 d-flex justify-content-md-end justify-content-sm-center justify-content-center">

                          <div id="flows_button_area">
                              @if(!count($leaseFlows) && !isset($copy))
                                  <a class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light" href="{!! route('lease-flows.generate', $lease->id) !!}">
                                      <i class="fa  fa-cogs copy_fontawesome"></i>
                                      <span> @lang('master.Payment schedule')</span>

                                  </a>
                              @endif

                              @if(!isset($copy) && count($leaseFlows))
                                  @if($buttonShow['clear_all'])
                                      <a class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light" onclick="return confirm('Are you sure to delete all unlocked lease flow ! ?')"
                                         href="{!! route('lease-flows.delete.all', $lease->id) !!}">
                                          <i class="fa  fa-eraser "></i>
                                          <span> @lang('master.Clear all')</span>

                                      </a>
                                  @endif
                              @endif
                          </div>


                        </div>
                    </div>
                </div>
                <hr class="my-3"></hr>
                <div class=" mb-5"></div>
            </div>

        <div class="row">

            <div class="col-md-12">
                @if(count($leaseFlows))
                    <table id="leaseflow_display" class="table  dt-responsive dataTable no-footer dtr-inline collapsed
        "
                           cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info"
                           style="width: 100%; text-align: right">
                        <thead style="text-align: right">
                        <tr>
                            <th>@lang('master.Payment date')</th>
                            <th>@lang('master.Interest calculation start date')</th>
                            <th>@lang('master.Interest calculation end date')</th>
                            <th>@lang('master.Total lease payment')</th>
                            {{--<th>@lang('master.Account')</th>--}}
                            @if($lease->ifrs_accounting)
                                <th>@lang('master.Discounted amount of fixed asset')</th>
                                <th>@lang('master.Lease liability opening balance')</th>
                                <th>@lang('master.Interest cost')</th>
                                <th>@lang('master.Lease liability closing balance')</th>
                                <th>@lang('master.Right-of-use asset opening balance')</th>
                                <th>@lang('master.Depreciation')</th>
                                <th>@lang('master.Right-of-use asset closing balance')</th>
                            @endif
                            <th>@lang('master.Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($leaseFlows as $leaseFlow)
                            <tr class="{{$leaseFlow -> cssClass}}">
                                <td>{{$leaseFlow->payment_date}}</td>
                                <td>{{$leaseFlow->start_date}}</td>
                                <td>{{$leaseFlow->end_date}}</td>
                                <td>{{mYFormat($leaseFlow->total_payment )}}</td>
                                {{--<td>{{optional($leaseFlow->account)->account_name}}</td>--}}
                                @if($lease->ifrs_accounting)
                                    <td>{{mYFormat($leaseFlow->variations)}}</td>
                                    <td>{{mYFormat($leaseFlow->liability_opening_balance)}}</td>
                                    <td>{{mYFormat($leaseFlow -> interest_cost)}}</td>
                                    <td>{{mYFormat($leaseFlow->liability_closing_balance)}}</td>
                                    <td>{{mYFormat($leaseFlow->depreciation_opening_balance)}}</td>
                                    <td>{{mYFormat($leaseFlow->depreciation)}}</td>
                                    <td>{{mYFormat($leaseFlow->depreciation_closing_balance)}}</td>
                                @endif
                                <td>
                                    @if($leaseFlow->end_date)
                                        @if($buttonShow['action'])
                                            <a href="{{route('lease-flows.edit',$leaseFlow->id)}}">
                                                <i class="fas fa-pen-square edit_fontawesome_icon"></i>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13">No lease flow</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                @else
                    <h2>{{trans('master.You dont have any leaseflows. ')}}<a class="text-primary" href="{!! route('lease-flows.generate', $lease->id) !!}">{{trans('master.Create now!')}}</a></h2>
                @endif
            </div>
        </div>
    </div>
</div>

@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop

@push('form-js')
    <script>
        $( document ).ready(function() {
            $('.dt-button').addClass( "btn btn-sm  btn-primary-variant-one  px-2").removeClass( "dt-button buttons-html5" );
            $('input[type=search]').addClass('form-control border-0 bg-light');
            //$(".dt-buttons").children().appendTo("#datatable-buttons");
            $("#flows_button_area").children().appendTo(".dt-buttons");
            $(".datatable-leases_filter").appendTo(".dt-buttons");
        });
    </script>
    @endpush