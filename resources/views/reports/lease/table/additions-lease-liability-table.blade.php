@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-addition-liability"
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
                <th>@lang('master.Exercise price in currency')</th>
                <th>@lang('master.Exercise price in base currency')</th>
                <th>@lang('master.Residual value guarantee in currency')</th>
                <th>@lang('master.Residual value guarantee in base currency')</th>
                <th>@lang('master.Penalties for terminating the lease in currency')</th>
                <th>@lang('master.Penalties for terminating the lease in base currency')</th>
            </tr>
            </thead>
            <tbody>
            @php($exercisePrice = 0)
            @php($exercisePriceBaseCur = 0)
            @php($residualValue = 0)
            @php($residualValueBaseCur = 0)
            @php($penaltiesForTerminating = 0)
            @php($penaltiesForTerminatingBaseCur = 0)
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
                    <td class="exercise_price">{{ mYFormat($lease->exercise_price) }}</td>
                    @php($exercisePrice += rnd($lease->exercise_price))
                    <td class="exercise_price_base_currency">{{ mYFormat($lease->exercise_price_base_currency) }}</td>
                    @php($exercisePriceBaseCur += rnd($lease->exercise_price_base_currency))
                    <td class="residual_value_guarantee">{{ mYFormat($lease->residual_value_guarantee) }}</td>
                    @php($residualValue += rnd($lease->residual_value_guarantee))
                    <td class="residual_value_guarantee_base_currency">{{ mYFormat($lease->residual_value_guarantee_base_currency) }}</td>
                    @php($residualValueBaseCur += rnd($lease->residual_value_guarantee_base_currency))
                    <td class="penalties_for_terminating">{{ mYFormat($lease->penalties_for_terminating) }}</td>
                    @php($penaltiesForTerminating += rnd($lease->penalties_for_terminating))
                    <td class="penalties_for_terminating_base_currency">{{ mYFormat($lease->penalties_for_terminating_base_currency) }}</td>
                    @php($penaltiesForTerminatingBaseCur += rnd($lease->penalties_for_terminating_base_currency))
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>{{ trans('master.Total') }}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ mYFormat($exercisePrice) }}</th>
                <th>{{ mYFormat($exercisePriceBaseCur) }}</th>
                <th>{{ mYFormat($residualValue) }}</th>
                <th>{{ mYFormat($residualValueBaseCur) }}</th>
                <th>{{ mYFormat($penaltiesForTerminating) }}</th>
                <th>{{ mYFormat($penaltiesForTerminatingBaseCur) }}</th>
            </tr>
            </tfoot>
        </table>
    </div>
@endif