@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-facility-overview"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <th>@lang('master.Lease Id')</th>
                <th>@lang('master.Entity')</th>
                <th>@lang('master.Portfolio')</th>
                <th>@lang('master.Currency')</th>
                <th>@lang('master.Customer reference')</th>
                <th>@lang('master.Agreement type')</th>
                <th>@lang('master.Start date')</th>
                <th>@lang('master.Contracts first possible termination day')</th>
                <th>@lang('master.Notice period in months')</th>
                <th>@lang('master.Lease end date')</th>
                <th>@lang('master.Total lease cost')</th>
                <th>@lang('master.Capital rent per month (rent/m2)')</th>
                <th>@lang('master.Maintenance rent per month (rent/m2)')</th>
                <th>@lang('master.Total monthly rent/m2 by grained surface')</th>
                <th>@lang('master.Square metres')</th>
                <th>@lang('master.Grained surface area')</th>
                <th>@lang('master.Number of employees')</th>
                <th>@lang('master.Employees last updated')</th>
                <th>@lang('master.Number of workstations')</th>
                <th>@lang('master.Workstations last updated')</th>
                <th>@lang('master.Total monthly rent/square metre')</th>
                <th>@lang('master.Total monthly rent/employees')</th>
                <th>@lang('master.Total monthly rent/workstations')</th>
                <th>@lang('master.Square metres/employee')</th>
                <th>@lang('master.Parking cost per month')</th>
                <th>@lang('master.Number of parking spaces')</th>
                <th>@lang('master.Parking space cost/employee')</th>
                <th>@lang('master.Counterparty')</th>
                <th>@lang('master.Other cost per month')</th>
                <th>@lang('master.Renovation and rent free periods')</th>
                <th>@lang('master.Rent security deposit')</th>
                <th>@lang('master.Rent security type')</th>
                <th>@lang('master.Rent security expiry date')</th>
                <th>@lang('master.Rent security received back')</th>
                <th>@lang('master.Lease type')</th>
            </tr>
            </thead>

            <tbody>
            @foreach($returnData as $lease)
            @php($totalMonthlyPerGrained = (($lease -> capital_rent_per_month_base_currency + $lease ->
            maintenance_rent_per_month_base_currency) * $lease -> grained_surface_area) / ($lease ->square_metres == 0 ? 1:$lease -> square_metres) )
                <tr>
                    <td>{{ $lease -> id }}</td>
                    <td>{{ $lease -> entity -> short_name }}</td>
                    <td>{{ $lease -> portfolio -> name }}</td>
                    <td class="cur">{{ $lease -> currency -> iso_4217_code }}</td>
                    <td>{{ $lease -> customer_reference }}</td>
                    <td>{{ trans("master.".$lease -> agreement_type) }}</td>
                    <td>{{ $lease -> effective_date }}</td>
                    <td>{{ $lease -> contracts_first_possible_termination_day }}</td>
                    <td>{{ $lease -> notice_period_in_months }}</td>
                    <td>{{ $lease -> lease_end_date }}</td>
                    <td>{{ rnd($lease -> total_lease_base_currency) }}</td>
                    <td>{{ rnd($lease -> capital_rent_per_month_base_currency) }}</td>
                    <td>{{ rnd($lease -> maintenance_rent_per_month_base_currency) }}</td>
                    <td>{{ rnd($totalMonthlyPerGrained) }}</td>
                    <td>{{ rnd($lease -> square_metres) }}</td>
                    <td>{{ rnd($lease -> grained_surface_area) }}</td>
                    <td>{{ rnd($lease -> number_of_employees,0) }}</td>
                    <td>{{ $lease -> employees_last_updated }}</td>
                    <td>{{ rnd($lease -> number_of_workstations,0) }}</td>
                    <td>{{ $lease -> workstations_last_updated }}</td>
                    <td>{{ floatval($lease -> square_metres) ? rnd($totalMonthlyPerGrained/$lease -> square_metres):0 }}</td>
                    <td>{{ $lease -> number_of_employees ? rnd($totalMonthlyPerGrained/$lease -> number_of_employees):0 }}</td>
                    <td>{{ $lease -> number_of_workstations ? rnd($totalMonthlyPerGrained/$lease -> number_of_workstations):0 }}</td>
                    <td>{{ $lease -> number_of_employees ? rnd($lease -> square_metres / $lease -> number_of_employees) : 0}}</td>
                    <td>{{ rnd($lease -> parking_cost_per_month_base_currency) }}</td>
                    <td>{{ rnd($lease -> number_of_parking_spaces,0) }}</td>
                    <td>{{ $lease -> number_of_parking_spaces ? rnd($lease -> parking_cost_per_month_base_currency / $lease -> number_of_parking_spaces) : 0}}</td>
                    <td>{{ $lease -> counterparty -> short_name }}</td>
                    <td>{{ rnd($lease -> other_cost_per_month_base_currency ) }}</td>
                    <td>{{ $lease -> renovation_and_rent_free_periods }}</td>
                    <td>{{ rnd($lease -> rent_security_deposit_base_currency ) }}</td>
                    <td>{{ trans("master.".$lease -> rent_security_type)}}</td>
                    <td>{{ $lease -> rent_security_expiry_date }}</td>
                    <td>{{ $lease -> rent_security_received_back ? trans('master.Yes') : trans('master.No') }}</td>
                    <td>{{ $lease -> leaseType->type }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif