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
                <th>@lang('master.Realised difference in P&L in currency')</th>
                <th>@lang('master.Realised difference in P&L in base currency')</th>
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
            <?php $rownr = 1; ?>
            @foreach($leaseFlows as $item)

                <tr>
                    <td><a target="_blank" href="{{route('leases.edit',$item->id)}}">{{$item->id}}</a></td>
                    <td>{{$item->entity}}</td>
                    <td>{{$item->counterparty}}</td>
                    <td>{{$item->date_of_change}}</td>
                    <td>{{$item->lease_type}}</td>
                    <td>{{$item->portfolio}}</td>
                    <td>{{$item->cost_center}}</td>
                    <td class="cur{{$rownr}}">{{$item->currency}}</td>
                    <td class="liability_opening_balance{{$rownr}}">{{mYFormat(rnd($item->liability_opening_balance))}}</td>
                    @php($liabilityOpeningBalance = $liabilityOpeningBalance + rnd($item->liability_opening_balance))
                    <td class="liability_opening_balance_addition{{$rownr}}">{{mYFormat(rnd($item->liability_opening_balance_addition))}}</td>
                    @php($liabilityOpeningBalanceAddition = $liabilityOpeningBalanceAddition + rnd($item->liability_opening_balance_addition))
                    <td class="liability_opening_balance_decrease{{$rownr}}">{{mYFormat(rnd($item->liability_opening_balance_decrease))}}</td>
                    @php($liabilityOpeningBalanceDecrease = $liabilityOpeningBalanceDecrease + rnd($item->liability_opening_balance_decrease))
                    <td class="depreciation_opening_balance{{$rownr}}">{{mYFormat(rnd($item->depreciation_opening_balance))}}</td>
                    @php($depreciation = $depreciation + rnd($item->depreciation_opening_balance))
                    <td class="depreciation_opening_balance_addition{{$rownr}}">{{mYFormat(rnd($item->depreciation_opening_balance_addition))}}</td>
                    @php($depreciationAdditionBaseCurrency = $depreciationAdditionBaseCurrency + rnd($item->depreciation_opening_balance_addition))
                    <td class="depreciation_opening_balance_decrease{{$rownr}}">{{mYFormat(rnd($item->depreciation_opening_balance_decrease))}}</td>
                    @php($depreciationDecreaseBaseCurrency = $depreciationDecreaseBaseCurrency + rnd($item->depreciation_opening_balance_decrease))
                    <td class="realised_difference{{$rownr}}">{{mYFormat(rnd($item->realised_difference))}}</td>
                    @php($realisedDifference = $realisedDifference + rnd($item->realised_difference))
                    <td class="realised_difference_base_currency{{$rownr}}">{{mYFormat(rnd($item->realised_difference_base_currency))}}</td>
                    @php($realisedDifferenceBaseCurrency = $realisedDifferenceBaseCurrency + rnd($item->realised_difference_base_currency))
                    <td class="realised_fx_difference{{$rownr}}">{{ mYFormat(rnd($item->realised_fx_difference)) }}</td>
                    @php($realisedFxDifference = $realisedFxDifference + rnd($item->realised_fx_difference))
                </tr>
                <?php $rownr++; ?>
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
                <th>{{mYFormat($liabilityOpeningBalance)}}</th>
                <th>{{mYFormat($liabilityOpeningBalanceAddition)}}</th>
                <th>{{mYFormat($liabilityOpeningBalanceDecrease)}}</th>
                <th>{{mYFormat($depreciation)}}</th>
                <th>{{mYFormat($depreciationAdditionBaseCurrency)}}</th>
                <th>{{mYFormat($depreciationDecreaseBaseCurrency)}}</th>
                <th>{{mYFormat($realisedDifference)}}</th>
                <th>{{mYFormat($realisedDifferenceBaseCurrency)}}</th>
                <th>{{mYFormat($realisedFxDifference)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif