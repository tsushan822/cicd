@if(isset($startDate))
    <div class="table-responsive px-1 cardSimiliarShadow bg-white">
        <table id="datatable-rou-asset"
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
                @foreach(array_reverse($value) as $key1 => $value1)
                    <tr>
                        @if($key1 == 'Total')
                            <td><h5>{{$key1}} - @lang('master.'.$key)</h5></td>
                        @else
                            <td>{{$key1}}</td>
                        @endif
                        @foreach($dateHeader as $list)
                            <td class="{{str_slug($key)}}-{{str_slug($key1)}}-{{str_slug($list)}}">{{ mYFormat($value1[$list]) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endif