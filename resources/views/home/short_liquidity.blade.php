<div class="table-responsive">

    <table class="table table-bordered table-condensed">
        <thead>
        <th><img style="min-width: 9%; vertical-align: top; padding-top: 1px;"
                 src="/vendor/famfamfam/png/{!!$returnValue['liquidity']['account']->currency->iso_3166_code!!}.png"> {!! $returnValue['liquidity']['account']->account_name !!}
        </th>
        @foreach($returnValue['liquidity']['range'] as $item)
            @php ($sum[$item] = 0)
            <th>{!! $item !!}</th>
        @endforeach
        </thead>

        <tbody>

        {{--Get all account balances--}}
        @foreach($returnValue['liquidity']['data']['balance_amount'] as $accountBalance)
            <tr>
                <td>Opening Balance</td>
                @foreach($returnValue['liquidity']['range'] as $item)
                    @if($accountBalance->balance_date == $item)
                        <td>
                            <a href="{!! route('accountbalances.edit',$accountBalance -> id) !!}">{!! $accountBalance ->balance_amount !!}</a>
                        </td>
                        @php($sum[$item] = $sum[$item] + $accountBalance ->balance_amount)
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        @foreach($returnValue['liquidity']['data']['fxdeals'] as $fxDeal)
            <tr>
                <td>
                    <a href="{!! route('fxdeals.edit',$fxDeal->id) !!}">Fx {!! $fxDeal->dealType->long_name !!} {!! $fxDeal->id !!}</a>
                </td>
                @foreach($returnValue['liquidity']['range'] as $item)
                    @if($fxDeal->maturity_date == $item)
                        <td class="of_number_to_be_evaluated">

                            <a href="{!! route('fxdeals.edit',$fxDeal->id) !!}">{!! number_format($fxDeal->notional_currency_amount,2) !!}</a>
                        </td>
                        @php($sum[$item] = $sum[$item] + $fxDeal -> notional_currency_amount)
                    @elseif($fxDeal->maturity_date == $item)
                        <td class="of_number_to_be_evaluated">

                            <a href="{!! route('fxdeals.edit',$fxDeal->id) !!}">{!! number_format($fxDeal->cross_currency_amount,2) !!}</a>
                        </td>
                        @php($sum[$item] = $sum[$item] + $fxDeal -> cross_currency_amount)
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        @foreach($returnValue['liquidity']['data']['dealflows'] as $dealFlow)
            <tr>
                <td>
                    <a href="{!! route('mmdeals.edit',$dealFlow->mmDeal->id) !!}">
                        {!! $dealFlow->mmDeal->instrument->instrument_name !!} {!! $dealFlow->mmDeal->id!!}
                    </a>
                </td>
                @foreach($returnValue['liquidity']['range'] as $item)
                    @if($dealFlow->payment_date == $item)
                        <td class="of_number_to_be_evaluated">
                            <a href="{!! route('mmdeals.edit',$dealFlow->mmDeal->id) !!}">{!! number_format($dealFlow->amortization_amount,2) !!}</a>
                        </td>
                        @php($sum[$item] = $sum[$item] + $dealFlow->amortization_amount)
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        @foreach($returnValue['liquidity']['data']['guaranteeflows'] as $guaranteeFlow)
            <tr>
                <td>
                    <a href="{!! route('guarantees.edit',$guaranteeFlow->guarantee_id) !!}">
                        Guarantee {!! $guaranteeFlow->guarantee_id !!}
                    </a>
                </td>
                @foreach($returnValue['liquidity']['range'] as $item)
                    @if($guaranteeFlow->payment_date == $item)
                        <td class="of_number_to_be_evaluated">
                            <a href="{!! route('guarantees.edit',$guaranteeFlow->guarantee_id) !!}">
                                {!! number_format($dealFlow->amortization_amount,2) !!}</a>
                        </td>
                        @php($sum[$item] = $sum[$item] + $guaranteeFlow->amount)
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        <tr>
            <td>Closing Balance</td>
            {{--If first day put that else calculate today and yesterday sum--}}
            @foreach($returnValue['liquidity']['range'] as $item)
                @if($item != \Carbon\Carbon::today()->toDateString())
                    <?php $sum[$item] = $sum[$item] + $sum[getPreviousBusinessDay($item)]; ?>
                @endif
                <td>{!! number_format($sum[$item],2) !!}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <div class="col-sm-offset-11"><a href="{{route('short.liquidity')}}">
            <button class="btn btn-primary">See all</button>
        </a></div>
</div>