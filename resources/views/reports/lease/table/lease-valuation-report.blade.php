@include('reports.report-library.layout.critera_on_report')

@if(isset($startDate))
    <div class="table-responsive">
        <table id="datatable-lease-valuation"
               class="table table-striped dt-responsive table-bordered no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Lease Id')</th>
                <th>@lang('master.Entity')</th>
                <th>@lang('master.Report date')</th>
                <th>@lang('master.Lease type')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Cost center')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Total liability in currency')</th>
                <th>@lang('master.Total liability in base currency')</th>
                <th>@lang('master.Discount value in currency')</th>
                <th>@lang('master.Discount value in base currency')</th>
                <th>@lang('master.Currency Valuation')</th>
                <th>@lang('master.Price difference')</th>
                <th>@lang('master.Total valuation')</th>
            </tr>
            </thead>
            <tbody>
            @php($discountAmount = 0)
            @php($discountAmountBaseCurrency = 0)
            @php($totalLiability = 0)
            @php($totalLiabilityBaseCurrency = 0)
            @php($currencyValuation = 0)
            @php($priceDifference = 0)
            @php($totalValuation = 0)
            @foreach($returnData as $lease)
                <tr>
                    <td>
                        <a target="_blank"
                           href="{{route('leases.edit',$lease->id)}}">{{$lease->id}}</a>
                    </td>
                    <td>{{ $lease->entity->short_name }}</td>
                    <td>{{ $startDate }}</td>
                    <td>{{ $lease->leaseType->type }}</td>
                    <td>{{ $lease->portfolio->name }}</td>
                    <td>{{ $lease->cost_center_name ?? optional($lease->costCenter)->short_name }}</td>
                    <td class="cur">{{ $lease->currency->iso_4217_code }}</td>
                    <td class="total_liability">{{ rnd($lease->total_liability) }}</td>
                    @php($totalLiability += rnd($lease->total_liability))
                    <td class="total_liability_base_currency">{{ rnd($lease->total_liability_base_currency) }}</td>
                    @php($totalLiabilityBaseCurrency += rnd($lease->total_liability_base_currency))
                    <td class="discount_instrument">{{ rnd($lease->discount_instrument) }}</td>
                    @php($discountAmount += rnd($lease->discount_instrument))
                    <td class="discount_instrument_base_currency">{{ rnd($lease->discount_instrument_base_currency) }}</td>
                    @php($discountAmountBaseCurrency += rnd($lease->discount_instrument_base_currency))
                    <td class="currency_valuation">{{ rnd($lease->currency_valuation) }}</td>
                    @php($currencyValuation += rnd($lease->currency_valuation))
                    <td class="price_difference">{{ rnd($lease -> price_difference) }}</td>
                    @php($priceDifference += rnd($lease->price_difference))
                    <td class="total_valuation">{{ rnd($lease -> total_valuation) }}</td>
                    @php($totalValuation += rnd($lease->total_valuation))
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
                <th>{{ rnd($totalLiability) }}</th>
                <th>{{ rnd($totalLiabilityBaseCurrency) }}</th>
                <th>{{ rnd($discountAmount) }}</th>
                <th>{{ rnd($discountAmountBaseCurrency) }}</th>
                <th>{{ rnd($currencyValuation) }}</th>
                <th>{{ rnd($priceDifference) }}</th>
                <th>{{ rnd($totalValuation) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif