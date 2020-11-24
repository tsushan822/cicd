@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-summary-lease"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Account')</th>
                @foreach($dateHeader as $list)
                    <th>{{ $list }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>@lang('master.Fixed amount')</td>
                @foreach($dateHeader as $list)
                    <td id="fixed_amount">{{ mYFormat($total[$list]['Fixed Amount']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Service cost')</td>
                @foreach($dateHeader as $list)
                    <td id="service_cost">{{ mYFormat($total[$list]['Service Cost']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Total lease cost')</td>
                @foreach($dateHeader as $list)
                    <td id="total_lease_cost">{{ mYFormat($total[$list]['Total Lease Cost']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Depreciation')</td>
                @foreach($dateHeader as $list)
                    <td id="depreciation">{{ mYFormat($total[$list]['Depreciation']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Interest Cost')</td>
                @foreach($dateHeader as $list)
                    <td id="interest_cost">{{ mYFormat($total[$list]['Interest Cost']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Accrued Interest')</td>
                @foreach($dateHeader as $list)
                    <td id="accrued_interest">{{ mYFormat($total[$list]['Accrued Interest']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Realised Difference From Change')</td>
                @foreach($dateHeader as $list)
                    <td id="realised_diff_from_change">{{ mYFormat($total[$list]['Realised Difference From Change']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Realised Fx Difference')</td>
                @foreach($dateHeader as $list)
                    <td id="realised_fx_diff">{{ mYFormat($total[$list]['Realised Fx Difference']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Unrealised Fx Difference')</td>
                @foreach($dateHeader as $list)
                    <td id="unrealised_fx_diff">{{ mYFormat($total[$list]['Unrealised Fx Difference']) }}</td>
                @endforeach
            </tr>

            {{--<tr>
                <th colspan="{{count($dateHeader) + 1}}">Changes To Balance Sheet</th>
            </tr>--}}
            <tr>
                <td>@lang('master.Additions To Liability')</td>
                @foreach($dateHeader as $list)
                    <td id="additions_to_liability">{{ mYFormat($total[$list]['Additions To Liability']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Decrease To Liability')</td>
                @foreach($dateHeader as $list)
                    <td id="decrease_to_liability">{{ mYFormat($total[$list]['Decrease To Liability']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Additions To ROA')</td>
                @foreach($dateHeader as $list)
                    <td id="additions_to_roa">{{ mYFormat($total[$list]['Additions To ROA']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Decrease To ROA')</td>
                @foreach($dateHeader as $list)
                    <td id="decrease_to_roa">{{ mYFormat($total[$list]['Decrease To ROA']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Repayment of Loan')</td>
                @foreach($dateHeader as $list)
                    <td id="repayment_of_loan">{{ mYFormat($total[$list]['Repayment of Loan']) }}</td>
                @endforeach
            </tr>

            <tr>
                <td>@lang('master.Lease payment at start date')</td>
                @foreach($dateHeader as $list)
                    <td>{{ mYFormat($total[$list]['Lease payment at start date']) }}</td>
                @endforeach
            </tr>

            <tr>
                <td>@lang('master.Right of use asset amount')</td>
                @foreach($dateHeader as $list)
                    <td id="right_of_use_asset">{{ mYFormat($total[$list]['Right of use asset amount']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Short Term liability')</td>
                @foreach($dateHeader as $list)
                    <td id="short_term_liability">{{ mYFormat($total[$list]['Short Term liability']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Long Term liability')</td>
                @foreach($dateHeader as $list)
                    <td id="long_term_liability">{{ mYFormat($total[$list]['Long Term liability']) }}</td>
                @endforeach
            </tr>
            <tr>
                <td>@lang('master.Total liability')</td>
                @foreach($dateHeader as $list)
                    <td id="total_liability">{{ mYFormat($total[$list]['Total liability']) }}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
@endif