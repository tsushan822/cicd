@include('reports.report-library.layout.critera_on_report')
@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-change-lease"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Lease Id')</th>
                <th>@lang('master.Entity')</th>
                <th>@lang('master.Counterparty')</th>
                <th>@lang('master.Date of change')</th>
                <th>@lang('master.Lease type')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Cost center')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Changes to liability in currency')</th>
                <th>@lang('master.Additions to liability in base currency')</th>
                <th>@lang('master.Decrease to liability in base currency')</th>
                <th>@lang('master.Changes to right-of-use assets in currency')</th>
                <th>@lang('master.Additions to right-of-use assets in base currency')</th>
                <th>@lang('master.Decrease to right-of-use assets in base currency')</th>
                <th>@lang('master.Realised difference in PL in currency')</th>
                <th>@lang('master.Realised difference in PL in base currency')</th>
                <th>@lang('master.Realised FX difference')</th>
            </tr>
            </thead>
            <tbody>
            @php($liabilityOpeningBalance = 0)
            @php($liabilityOpeningBalanceAddition = 0)
            @php($liabilityOpeningBalanceDecrease = 0)
            @php($depreciation = 0)
            @php($depreciationAdditionBaseCurrency = 0)
            @php($depreciationDecreaseBaseCurrency = 0)
            @php($realisedDifference = 0)
            @php($realisedFxDifference = 0)
            @php($realisedDifferenceBaseCurrency = 0)
            @foreach($leaseFlows as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->entity}}</td>
                    <td>{{$item->counterparty}}</td>
                    <td>{{$item->date_of_change}}</td>
                    <td>{{$item->lease_type}}</td>
                    <td>{{$item->portfolio}}</td>
                    <td>{{$item->cost_center}}</td>
                    <td>{{$item->currency}}</td>
                    <td>{{rnd($item->liability_opening_balance)}}</td>
                    @php($liabilityOpeningBalance += rnd($item->liability_opening_balance))
                    <td>{{rnd($item->liability_opening_balance_addition)}}</td>
                    @php($liabilityOpeningBalanceAddition += rnd($item->liability_opening_balance_addition))
                    <td>{{rnd($item->liability_opening_balance_decrease)}}</td>
                    @php($liabilityOpeningBalanceDecrease += rnd($item->liability_opening_balance_decrease))
                    <td>{{rnd($item->depreciation_opening_balance)}}</td>
                    @php($depreciation += rnd($item->depreciation_opening_balance))
                    <td>{{rnd($item->depreciation_opening_balance_addition)}}</td>
                    @php($depreciationAdditionBaseCurrency += rnd($item->depreciation_opening_balance_addition))
                    <td>{{rnd($item->depreciation_opening_balance_decrease)}}</td>
                    @php($depreciationDecreaseBaseCurrency += rnd($item->depreciation_opening_balance_decrease))
                    <td>{{rnd($item->realised_difference)}}</td>
                    @php($realisedDifference += rnd($item->realised_difference))
                    <td>{{rnd($item->realised_difference_base_currency)}}</td>
                    @php($realisedDifferenceBaseCurrency += rnd($item->realised_difference_base_currency))
                    <td>{{ mYFormat(rnd($item->realised_fx_difference)) }}</td>
                    @php($realisedFxDifference = $realisedFxDifference + rnd($item->realised_fx_difference))
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>@lang('master.Total')</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{$liabilityOpeningBalance}}</th>
                <th>{{$liabilityOpeningBalanceAddition}}</th>
                <th>{{$liabilityOpeningBalanceDecrease}}</th>
                <th>{{$depreciation}}</th>
                <th>{{$depreciationAdditionBaseCurrency}}</th>
                <th>{{$depreciationDecreaseBaseCurrency}}</th>
                <th>{{$realisedDifference}}</th>
                <th>{{$realisedDifferenceBaseCurrency}}</th>
                <th>{{$realisedFxDifference }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif