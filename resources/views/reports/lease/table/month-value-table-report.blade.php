@include('reports.report-library.layout.critera_on_report')
@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-month-payment"
               class="table table-striped dt-responsive table-bordered no-footer dtr-inline collapsed"
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
                    <td>{{$lease->id}}</td>
                    <td>{{$lease->entity->short_name}}</td>
                    <td>{{$lease->counterparty->short_name}}</td>
                    <td>{{$startDate}}</td>
                    <td>{{$lease->leaseType->type}}</td>
                    <td>{{$lease->portfolio->name}}</td>
                    <td>{{ $lease->cost_center_name ?? optional($lease->costCenter)->short_name }}</td>
                    <td>{{$lease->currency->iso_4217_code}}</td>
                    <th>{{rnd($lease -> short_term_liability)}}</th>
                    @php($shortTermLiability = $shortTermLiability + rnd($lease -> short_term_liability))
                    <th>{{rnd($lease -> short_term_liability_base_currency)}}</th>
                    @php($shortTermLiabilityBaseCurrency = $shortTermLiabilityBaseCurrency + rnd($lease -> short_term_liability_base_currency))
                    <th>{{rnd($lease -> long_term_liability)}}</th>
                    @php($longTermLiability = $longTermLiability + rnd($lease -> long_term_liability))
                    <th>{{rnd($lease -> long_term_liability_base_currency)}}</th>
                    @php($longTermLiabilityBaseCurrency = $longTermLiabilityBaseCurrency + rnd($lease -> long_term_liability_base_currency))
                    <th>{{rnd($lease -> total_liability)}}</th>
                    @php($totalLiability = $totalLiability + rnd($lease -> total_liability))
                    <th>{{rnd($lease -> total_liability_base_currency)}}</th>
                    @php($totalLiabilityBaseCurrency = $totalLiabilityBaseCurrency + rnd($lease -> total_liability_base_currency))
                    <th>{{rnd($lease -> total_liability_variation)}}</th>
                    @php($totalLiabilityVariation = $totalLiabilityVariation + rnd($lease -> total_liability_variation))
                    <th>{{rnd($lease -> accrued_interest)}}</th>
                    @php($accruedInterest = $accruedInterest + rnd($lease -> accrued_interest))
                    <td>{{rnd($lease->accrued_interest_base_currency) }} </td>
                    @php($accruedInterestBaseCurrency = $accruedInterestBaseCurrency + rnd($lease->accrued_interest_base_currency))
                    <th>{{rnd($lease -> depreciation_closing_base_currency)}}</th>
                    @php($depreciationBaseCurrency = $depreciationBaseCurrency + rnd($lease -> depreciation_closing_base_currency))
                    <th>{{rnd($lease -> depreciation_closing_selected_currency)}}</th>
                    @php($depreciationSelectedCurrency = $depreciationSelectedCurrency + rnd($lease -> depreciation_closing_selected_currency))
                    <td>{{rnd($lease->monthly_depreciation) }} </td>
                    @php($monthlyDepreciation = $monthlyDepreciation + rnd($lease->monthly_depreciation))
                    <td>{{rnd($lease->monthly_depreciation_selected_currency) }} </td>
                    @php($monthlyDepreciationSelectedCurrency = $monthlyDepreciationSelectedCurrency + rnd($lease->monthly_depreciation_selected_currency))
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
                <th>{{rnd($shortTermLiability)}}</th>
                <th>{{rnd($shortTermLiabilityBaseCurrency)}}</th>
                <th>{{rnd($longTermLiability)}}</th>
                <th>{{rnd($longTermLiabilityBaseCurrency)}}</th>
                <th>{{rnd($totalLiability)}}</th>
                <th>{{rnd($totalLiabilityBaseCurrency)}}</th>
                <th>{{rnd($totalLiabilityVariation)}}</th>
                <th>{{rnd($accruedInterest)}}</th>
                <th>{{rnd($accruedInterestBaseCurrency)}}</th>
                <th>{{rnd($depreciationBaseCurrency)}}</th>
                <th>{{rnd($depreciationSelectedCurrency)}}</th>
                <th>{{rnd($monthlyDepreciation)}}</th>
                <th>{{rnd($monthlyDepreciationSelectedCurrency)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif