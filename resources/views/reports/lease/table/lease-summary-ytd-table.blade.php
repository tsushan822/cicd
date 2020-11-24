@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-summary-lease"
               class="table  dt-responsive  no-footer dtr-inline collapsed"
               cellspacing="0" width="100%" role="grid" aria-describedby="datatable-responsive_info">
            <thead>
            <tr>
                <td> @lang('master.Account')</td>
                @foreach($dateHeader as $list)
                    <th>{{ $list }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($total as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    @foreach($value as $key1 => $value1)
                        <td>{{ mYFormat($value1) }}</td>
                    @endforeach
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@endif