@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-month-payment"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Lease Id')</th>
                <th>@lang('master.Entity')</th>
                <th>@lang('master.Counterparty')</th>
                <th>@lang('master.Report date')</th>
                <th>@lang('master.Lease type')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Cost center')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Short-term liability amount in currency')</th>
                <th>@lang('master.Short-term liability amount in base currency')</th>
                <th>@lang('master.Long-term liability amount in currency')</th>
                <th>@lang('master.Long-term liability amount in base currency')</th>
                <th>@lang('master.Total liability in currency')</th>
                <th>@lang('master.Total liability in base currency')</th>
                <th>@lang('master.Currency valuation to liability')</th>
                <th>@lang('master.Accrued interest in currency')</th>
                <th>@lang('master.Accrued interest in base currency')</th>
                <th>@lang('master.Right-of-use asset amount in base currency')</th>
                <th>@lang('master.Right-of-use asset amount in selected currency')</th>
                <th>@lang('master.Depreciation to right-of-use asset in base currency')</th>
                <th>@lang('master.Depreciation to right-of-use asset in selected currency')</th>
            </tr>
            </thead>

            <tbody>
            @php($shortTermLiability = 0)
            @php($shortTermLiabilityBaseCurrency = 0)
            @php($longTermLiability = 0)
            @php($longTermLiabilityBaseCurrency = 0)
            @php($totalLiability = 0)
            @php($totalLiabilityBaseCurrency = 0)
            @php($depreciationBaseCurrency = 0)
            @php($depreciationSelectedCurrency = 0)
            @php($accruedInterest = 0)
            @php($accruedInterestBaseCurrency = 0)
            @php($totalLiabilityVariation = 0)
            @php($monthlyDepreciation = 0)
            @php($monthlyDepreciationSelectedCurrency = 0)
            @foreach($leases as $lease)
                <tr>
                    <td><a target="_blank" href="{{route('leases.edit',$lease->id)}}">{{$lease->id}}</a></td>
                    <td>{{$lease->entity->short_name}}</td>
                    <td>{{$lease->counterparty->short_name}}</td>
                    <td>{{$startDate}}</td>
                    <td>{{$lease->leaseType->type}}</td>
                    <td>{{$lease->portfolio->name}}</td>
                    <td>{{ $lease->cost_center_name ?? optional($lease->costCenter)->short_name }}</td>
                    <td class="cur">{{$lease->currency->iso_4217_code}}</td>
                    <td class="short_term_liability">{{mYFormat($lease -> short_term_liability)}}</td>
                    @php($shortTermLiability = $shortTermLiability + rnd($lease-> short_term_liability))
                    <td class="short_term_liability_base_currency">{{mYFormat($lease-> short_term_liability_base_currency)}}</td>
                    @php($shortTermLiabilityBaseCurrency = $shortTermLiabilityBaseCurrency + rnd($lease-> short_term_liability_base_currency))
                    <td class="long_term_liability">{{mYFormat($lease-> long_term_liability)}}</td>
                    @php($longTermLiability = $longTermLiability + rnd($lease-> long_term_liability))
                    <td class="long_term_liability_base_currency">{{mYFormat($lease-> long_term_liability_base_currency)}}</td>
                    @php($longTermLiabilityBaseCurrency = $longTermLiabilityBaseCurrency + rnd($lease-> long_term_liability_base_currency))
                    <td class="total_liability">{{mYFormat($lease-> total_liability)}}</td>
                    @php($totalLiability = $totalLiability + rnd($lease-> total_liability))
                    <td class="total_liability_base_currency">{{mYFormat($lease-> total_liability_base_currency)}}</td>
                    @php($totalLiabilityBaseCurrency = $totalLiabilityBaseCurrency + rnd($lease-> total_liability_base_currency))
                    <td class="total_liability_variation">{{mYFormat($lease-> total_liability_variation)}}</td>
                    @php($totalLiabilityVariation = $totalLiabilityVariation + rnd($lease-> total_liability_variation))
                    <td class="accrued_interest">{{mYFormat($lease-> accrued_interest)}}</td>
                    @php($accruedInterest = $accruedInterest + rnd($lease-> accrued_interest))
                    <td class="accrued_interest_base_currency">{{mYFormat($lease->accrued_interest_base_currency) }} </td>
                    @php($accruedInterestBaseCurrency = $accruedInterestBaseCurrency + rnd($lease->accrued_interest_base_currency))
                    <td class="depreciation_closing_base_currency">{{mYFormat($lease-> depreciation_closing_base_currency)}}</td>
                    @php($depreciationBaseCurrency = $depreciationBaseCurrency + rnd($lease-> depreciation_closing_base_currency))
                    <td class="depreciation_closing_selected_currency">{{mYFormat($lease-> depreciation_closing_selected_currency)}}</td>
                    @php($depreciationSelectedCurrency = $depreciationSelectedCurrency + rnd($lease-> depreciation_closing_selected_currency))
                    <td class="monthly_depreciation">{{mYFormat($lease->monthly_depreciation) }} </td>
                    @php($monthlyDepreciation = $monthlyDepreciation + rnd($lease->monthly_depreciation))
                    <td class="monthly_depreciation_selected_currency">{{mYFormat($lease->monthly_depreciation_selected_currency) }} </td>
                    @php($monthlyDepreciationSelectedCurrency = $monthlyDepreciationSelectedCurrency + rnd($lease->monthly_depreciation_selected_currency))
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>{{trans('master.Total')}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{mYFormat($shortTermLiability)}}</th>
                <th>{{mYFormat($shortTermLiabilityBaseCurrency)}}</th>
                <th>{{mYFormat($longTermLiability)}}</th>
                <th>{{mYFormat($longTermLiabilityBaseCurrency)}}</th>
                <th>{{mYFormat($totalLiability)}}</th>
                <th>{{mYFormat($totalLiabilityBaseCurrency)}}</th>
                <th>{{mYFormat($totalLiabilityVariation)}}</th>
                <th>{{mYFormat($accruedInterest)}}</th>
                <th>{{mYFormat($accruedInterestBaseCurrency)}}</th>
                <th>{{mYFormat($depreciationBaseCurrency)}}</th>
                <th>{{mYFormat($depreciationSelectedCurrency)}}</th>
                <th>{{mYFormat($monthlyDepreciation)}}</th>
                <th>{{mYFormat($monthlyDepreciationSelectedCurrency)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif