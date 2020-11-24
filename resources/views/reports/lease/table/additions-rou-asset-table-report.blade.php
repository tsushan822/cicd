@include('reports.report-library.layout.critera_on_report')
@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-additions-rou-asset"
               class="table table-striped dt-responsive table-bordered no-footer dtr-inline collapsed"
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
                    <td>{{ $lease->id }}</td>
                    <td>{{ $lease->entity->short_name }}</td>
                    <td>{{ $startDate }}</td>
                    <td>{{ $lease->effective_date }}</td>
                    <td>{{ $lease->maturity_date }}</td>
                    <td>{{ $lease->leaseType->type }}</td>
                    <td>{{$lease->portfolio->name}}</td>
                    <td>{{ $lease->cost_center_name ?? optional($lease->costCenter)->short_name }}</td>
                    <td class="cur">{{ $lease->currency->iso_4217_code }}</td>

                    <td>{{ rnd($lease->payment_before_commencement_date) }}</td>
                    @php($leasePayment += rnd($lease->payment_before_commencement_date))
                    <td>{{ rnd($lease->payment_before_commencement_date_base_currency) }}</td>
                    @php($leasePaymentBaseCur += rnd($lease->payment_before_commencement_date_base_currency))

                    <td>{{ rnd($lease->initial_direct_cost) }}</td>
                    @php($initialDirectCost += rnd($lease->initial_direct_cost))
                    <td>{{ rnd($lease->initial_direct_cost_base_currency) }}</td>
                    @php($initialDirectCostBaseCur += rnd($lease->initial_direct_cost_base_currency))

                    <td>{{ rnd($lease->cost_dismantling_restoring_asset) }}</td>
                    @php($estimatedCost += rnd($lease->cost_dismantling_restoring_asset))
                    <td>{{ rnd($lease->cost_dismantling_restoring_asset_base_currency) }}</td>
                    @php($estimatedCostBaseCur += rnd($lease->cost_dismantling_restoring_asset_base_currency))

                    <td>{{ rnd($lease->lease_incentives_received) }}</td>
                    @php($incentivesReceived += rnd($lease->lease_incentives_received))
                    <td>{{ rnd($lease->lease_incentives_received_base_currency) }}</td>
                    @php($incentivesReceivedBaseCur += rnd($lease->lease_incentives_received_base_currency))

                    <td>{{ rnd($lease->residual_value) }}</td>
                    @php($residualVal += rnd($lease->residual_value))
                    <td>{{ rnd($lease->residual_value_base_currency) }}</td>
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
                <th>{{ rnd($leasePayment) }}</th>
                <th>{{ rnd($leasePaymentBaseCur) }}</th>
                <th>{{ rnd($initialDirectCost) }}</th>
                <th>{{ rnd($initialDirectCostBaseCur) }}</th>
                <th>{{ rnd($estimatedCost) }}</th>
                <th>{{ rnd($estimatedCostBaseCur) }}</th>
                <th>{{ rnd($incentivesReceived) }}</th>
                <th>{{ rnd($incentivesReceivedBaseCur) }}</th>
                <th>{{ rnd($residualVal) }}</th>
                <th>{{ rnd($residualValBaseCur) }}</th>
            </tr>
            </tfoot>

        </table>
    </div>
@endif