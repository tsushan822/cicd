<table>
    <tbody>
    @foreach($criteria as $key => $value)
        <tr>
            <td>{{ trans('master.'.$key) }}</td>
            @if(is_array($value))
                @foreach($value as $item)
                    <td>{{ $item }}</td>
                @endforeach
            @else
                <td>{{ $value }}</td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>