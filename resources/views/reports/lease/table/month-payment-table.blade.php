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
                <th>@lang('master.Payment date')</th>
                <th>@lang('master.Lease type')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Cost center')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Total lease payment in currency')</th>
                <th>@lang('master.Total lease payment in base currency')</th>
                <th>@lang('master.Fixed asset amount in currency')</th>
                <th>@lang('master.Fixed asset amount in base currency')</th>
                <th>@lang('master.Servicecost in lease in currency')</th>
                <th>@lang('master.Servicecost in lease in base currency')</th>
                <th>@lang('master.Repayment of loan in currency')</th>
                <th>@lang('master.Repayment of loan in base currency')</th>
                <th>@lang('master.Realised FX difference')</th>
                <th>@lang('master.Interest cost in currency')</th>
                <th>@lang('master.Interest cost in base currency')</th>
            </tr>
            </thead>
            <tbody>
            @php($total = 0)
            @php($totalBaseCurrency = 0)
            @php($fixedPayment = 0)
            @php($fixedPaymentBaseCurrency = 0)
            @php($fees = 0)
            @php($feesBaseCurrency = 0)
            @php($repayment = 0)
            @php($repaymentBaseCurrency = 0)
            @php($realisedFx = 0)
            @php($interestCost = 0)
            @php($interestCostBaseCurrency = 0)
            @foreach($leaseFlows as $leaseFlow)
                <tr>
                    <td>
                        <a target="_blank"
                           href="{{route('leases.edit',$leaseFlow->lease_id)}}">{{$leaseFlow->lease_id}}</a>
                    </td>
                    <td>{{$leaseFlow->lease->entity->short_name}}</td>
                    <td>{{$leaseFlow->lease->counterparty->short_name}}</td>
                    <td>{{$leaseFlow->payment_date}}</td>
                    <td>{{$leaseFlow->lease->leaseType->type}}</td>
                    <td>{{$leaseFlow->lease->portfolio->name}}</td>
                    <td>{{ $leaseFlow->cost_center_name ?? optional($leaseFlow->lease->costCenter)->short_name }}</td>
                    <td class="cur">{{$leaseFlow->lease->currency->iso_4217_code}}</td>
                    <td class="total">{{mYFormat(rnd($leaseFlow->total_payment))}}</td>
                    @php($total = $total + rnd($leaseFlow->total_payment))
                    <td class="total_base_currency">{{mYFormat(rnd($leaseFlow->total_base_currency))}}</td>
                    @php($totalBaseCurrency = $totalBaseCurrency + rnd($leaseFlow->total_base_currency))
                    <td class="fixed_payment">{{mYFormat(rnd($leaseFlow->fixed_payment))}}</td>
                    @php($fixedPayment = $fixedPayment + rnd($leaseFlow->fixed_payment))
                    <td class="fixed_payment_base_currency">{{mYFormat(rnd($leaseFlow->fixed_payment_base_currency))}}</td>
                    @php($fixedPaymentBaseCurrency = $fixedPaymentBaseCurrency + rnd($leaseFlow->fixed_payment_base_currency))
                    <td class="fees">{{mYFormat(rnd($leaseFlow->fees))}}</td>
                    @php($fees = $fees + rnd($leaseFlow->fees))
                    <td class="fees_base_currency">{{mYFormat(rnd($leaseFlow->fees_base_currency))}}</td>
                    @php($feesBaseCurrency = $feesBaseCurrency + rnd($leaseFlow->fees_base_currency))
                    <td class="repayment">{{mYFormat(rnd($leaseFlow->repayment))}}</td>
                    @php($repayment = $repayment + rnd($leaseFlow->repayment))
                    <td class="repayment_base_currency">{{mYFormat(rnd($leaseFlow->repayment_base_currency))}}</td>
                    @php($repaymentBaseCurrency = $repaymentBaseCurrency + rnd($leaseFlow->repayment_base_currency))
                    <td>{{mYFormat(rnd($leaseFlow->realised_fx_difference))}}</td>
                    @php($realisedFx = $realisedFx + rnd($leaseFlow->realised_fx_difference))
                    <td class="interest_cost">{{mYFormat(rnd($leaseFlow->interest_cost))}}</td>
                    @php($interestCost = $interestCost + rnd($leaseFlow->interest_cost))
                    <td class="interest_cost_base_currency">{{mYFormat(rnd($leaseFlow->interest_cost_base_currency))}}</td>
                    @php($interestCostBaseCurrency = $interestCostBaseCurrency + rnd($leaseFlow->interest_cost_base_currency))
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
                <th>{{mYFormat($total)}}</th>
                <th>{{mYFormat($totalBaseCurrency)}}</th>
                <th>{{mYFormat($fixedPayment)}}</th>
                <th>{{mYFormat($fixedPaymentBaseCurrency)}}</th>
                <th>{{mYFormat($fees)}}</th>
                <th>{{mYFormat($feesBaseCurrency)}}</th>
                <th>{{mYFormat($repayment)}}</th>
                <th>{{mYFormat($repaymentBaseCurrency)}}</th>
                <th>{{mYFormat($realisedFx)}}</th>
                <th>{{mYFormat($interestCost)}}</th>
                <th>{{mYFormat($interestCostBaseCurrency)}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif