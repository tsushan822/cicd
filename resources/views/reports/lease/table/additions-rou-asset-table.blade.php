@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-additions-rou-asset"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Id')</th>
                <th>@lang('master.Entity')</th>
                <th>@lang('master.Report date')</th>
                <th>@lang('master.Start date')</th>
                <th>@lang('master.End date')</th>
                <th>@lang('master.Lease type')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Cost center')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Lease payments before commencement date in currency')</th>
                <th>@lang('master.Lease payments before commencement date in base currency')</th>
                <th>@lang('master.Initial direct cost in currency')</th>
                <th>@lang('master.Initial direct cost in base currency')</th>
                <th>@lang('master.Estimated cost for dismantling restoring asset in currency')</th>
                <th>@lang('master.Estimated cost for dismantling restoring asset in base currency')</th>
                <th>@lang('master.Incentives received in currency')</th>
                <th>@lang('master.Incentives received in base currency')</th>
                <th>@lang('master.Residual value in currency')</th>
                <th>@lang('master.Residual value in base currency')</th>
            </tr>
            </thead>
            <tbody>
            @php($leasePayment = 0)
            @php($leasePaymentBaseCur = 0)
            @php($initialDirectCost = 0)
            @php($initialDirectCostBaseCur = 0)
            @php($estimatedCost = 0)
            @php($estimatedCostBaseCur = 0)
            @php($incentivesReceived = 0)
            @php($incentivesReceivedBaseCur = 0)
            @php($residualVal = 0)
            @php($residualValBaseCur = 0)
            @foreach($leases as $lease)
                <tr>
                    <td><a href="{{ route('leases.edit', $lease->id) }}">{{ $lease->id }}</a></td>
                    <td>{{ $lease->entity->short_name }}</td>
                    <td>{{ $startDate }}</td>
                    <td>{{ $lease->effective_date }}</td>
                    <td>{{ $lease->maturity_date }}</td>
                    <td>{{ $lease->leaseType->type }}</td>
                    <td>{{$lease->portfolio->name}}</td>
                    <td>{{ $lease->cost_center_name ?? optional($lease->costCenter)->short_name }}</td>
                    <td class="cur">{{ $lease->currency->iso_4217_code }}</td>

                    <td class="payment_before_commencement_date">{{ mYFormat($lease->payment_before_commencement_date) }}</td>
                    @php($leasePayment += rnd($lease->payment_before_commencement_date))
                    <td class="payment_before_commencement_date_base_currency">{{ mYFormat($lease->payment_before_commencement_date_base_currency) }}</td>
                    @php($leasePaymentBaseCur += rnd($lease->payment_before_commencement_date_base_currency))

                    <td class="initial_direct_cost">{{ mYFormat($lease->initial_direct_cost) }}</td>
                    @php($initialDirectCost += rnd($lease->initial_direct_cost))
                    <td class="initial_direct_cost_base_currency">{{ mYFormat($lease->initial_direct_cost_base_currency) }}</td>
                    @php($initialDirectCostBaseCur += rnd($lease->initial_direct_cost_base_currency))

                    <td class="cost_dismantling_restoring_asset">{{ mYFormat($lease->cost_dismantling_restoring_asset) }}</td>
                    @php($estimatedCost += rnd($lease->cost_dismantling_restoring_asset))
                    <td class="cost_dismantling_restoring_asset_base_currency">{{ mYFormat($lease->cost_dismantling_restoring_asset_base_currency) }}</td>
                    @php($estimatedCostBaseCur += rnd($lease->cost_dismantling_restoring_asset_base_currency))

                    <td class="lease_incentives_received">{{ mYFormat($lease->lease_incentives_received) }}</td>
                    @php($incentivesReceived += rnd($lease->lease_incentives_received))
                    <td class="lease_incentives_received_base_currency">{{ mYFormat($lease->lease_incentives_received_base_currency) }}</td>
                    @php($incentivesReceivedBaseCur += rnd($lease->lease_incentives_received_base_currency))

                    <td class="residual_value">{{ mYFormat($lease->residual_value) }}</td>
                    @php($residualVal += rnd($lease->residual_value))
                    <td class="residual_value_base_currency">{{ mYFormat($lease->residual_value_base_currency) }}</td>
                    @php($residualValBaseCur += rnd($lease->residual_value_base_currency))
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
                <th></th>
                <th>{{ mYFormat($leasePayment) }}</th>
                <th>{{ mYFormat($leasePaymentBaseCur) }}</th>
                <th>{{ mYFormat($initialDirectCost) }}</th>
                <th>{{ mYFormat($initialDirectCostBaseCur) }}</th>
                <th>{{ mYFormat($estimatedCost) }}</th>
                <th>{{ mYFormat($estimatedCostBaseCur) }}</th>
                <th>{{ mYFormat($incentivesReceived) }}</th>
                <th>{{ mYFormat($incentivesReceivedBaseCur) }}</th>
                <th>{{ mYFormat($residualVal) }}</th>
                <th>{{ mYFormat($residualValBaseCur) }}</th>
            </tr>
            </tfoot>

        </table>
    </div>
@endif