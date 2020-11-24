@extends('layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/vendor/datatables/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="/css/custom/datatables/datatables_custom.css">
<link rel="stylesheet" type="text/css" href="/css/custom/datatables/nonDatatables.css">
<script src="/js/vendor/Chart.js"></script>



<style>
    .chart-legend li span{
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;



    }
    .chart-legend {

        float:right;


    }

    ul
    {font-size: 12px;
     list-style-type: none;
    }

    ul
    {font-size: 12px;
     list-style-type: none;
    }


    th.rotate {
        /* Something you can count on */
        height: 40px;
        //white-space: nowrap;
    }

    th.rotate > div {
        transform: 
            /* Magic Numbers */
            translate(0px, 0px)
            /* 45 is really 360 - 45 */
            rotate(315deg);
        //width: 30px;
    }
    th.rotate > div > span {
        //border-bottom: 1px solid #ccc;
        //padding: 5px 10px;
    }
    table.dataTable tbody td.cell {
        padding:  0px 0px 0px 8px; 
    }
</style>
@stop
@section('content')
<?php $row = 0; ?> 

<div class="wrp clearfix">

    <div class="fluid">
        <div class="widget grid12">
            <div class="widget-header">
                <div class="widget-title">Global liquidity view (k{!!$baseccy!!})</div>
            </div>



            <div class="widget-content">




                <div class="row">

                    <div class="col-md-11">
                        <canvas id="canvas" height="400" width="950" ></canvas>
                    </div>
                    <div class="col-md-1">

                        <div id="js-legend" class="chart-legend"></div>
                    </div>



                </div>
                <div class="col-md-12">
                    <table class="display dataTable">

                        <thead class="page-header">

                            <tr>
                                <th class="sorting_1" style="font-size:6px">Company
                                </th>
                                @foreach($rangeHeader as $rangeH) 
                                <th class="sorting_1 rotate" style="font-size:6px"><div><span>{!!$rangeH!!}</span></div></th>

                        @endforeach

                        </tr>


                        </thead>
                        <tfoot>
                        <th class="sorting_1" style="font-size:6px">
                        </th>
                        @foreach($totalCounterparty as $totalcounter) 
                        <th class="cell" style="font-size:6px; padding:  0px 0px 0px 8px"><div><span>
                                {!!$english_format_number = number_format($totalcounter)!!}
                            </span></div></th>

                        @endforeach

                        </tfoot>







                        <tbody>
                            @foreach($counterpartiesrange as $counterparty)
                            @foreach ($counterparty['accounts'] as $account)
                            @if($account['counterparty']==$counterparty['name'])

                            @if($row!=1)
                            <tr role="row" class="even">
                                <?php $row = 1; ?>  

                                @else <tr role="row" class="odd">
                                <?php $row = 0; ?> 
                                @endif    


                                <td class="sorting_1" style="font-size:10px">
                                    {!!$counterparty['name']!!} {!!$account['accountName']!!}
                                </td>
                                @foreach($account['balancesBase'] as $balancesBase) 
                                <td class="cell" style="font-size:8px">

                                    {!!$english_format_number = number_format($balancesBase/1000)!!}

                                </td>

                                @endforeach
                                @foreach($account['forecastsBase'] as $forecastsBase) 
                                <td class="cell" style="font-size:8px">

                                    {!!$english_format_number = number_format($forecastsBase/1000)!!}

                                </td>

                                @endforeach

                            </tr>

                            @endif

                            @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>  
</div> 


@stop
@section('javascript')
<script src="/js/custom/liquidity.js"></script>


<script>
    var overlayData = {
        labels: <?php echo json_encode($rangeHeader); ?>,
        datasets: [{
                label: "Cash level forecast",
                type: "bar",
                fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data: <?php echo json_encode($totalForecasts); ?>
            }, {
                label: "Account balances",
                type: "bar",
                fillColor: "rgba(131,137,235,0.5)",
                strokeColor: "rgba(131,137,235,0.8)",
                highlightFill: "rgba(131,137,235,0.75)",
                highlightStroke: "rgba(131,137,235,1)",
                data: <?php echo json_encode($rangeTOTALACT); ?>
            }, {
                label: "GROSS DEBT",
                type: "line",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: <?php echo json_encode($debt); ?>
            }
        ]
    };


    var myOverlayChart = new Chart(document.getElementById("canvas").getContext("2d")).Overlay(overlayData, {
        scaleBeginAtZero: true,
        populateSparseData: true,
        overlayBars: true,
        datasetFill: true,
        labelLength: 11,
        tooltipTemplate: "<%= value %>%"


    });

    document.getElementById("js-legend").innerHTML = myOverlayChart.generateLegend();


</script>@stop
