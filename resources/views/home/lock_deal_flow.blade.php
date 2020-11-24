{{--<table class="table table-bordered">
    <thead>
    <th>Id</th>
    <th>Interest Calc Start Date</th>
    <th>Ineterest Calc End Date</th>
    <th>Mm Deal Id</th>
    <th>Amortization Amount</th>
    <th>Locked</th>
    </thead>
    <tbody>
    @forelse($dealFlows as $dealFlow)
        <tr>
            <td>{!! $dealFlow->id !!}</td>
            <td>{!! $dealFlow->interest_calc_start_date !!}</td>
            <td>{!! $dealFlow->interest_calc_end_date !!}</td>
            <td>{!! $dealFlow->mm_deal_id !!}</td>
            <td>{!! $dealFlow->amortization_amount !!}</td>
            <td>{!! $dealFlow->locked?"Yes":"No" !!}</td>
        </tr>
    @empty
        No Data Present
    @endforelse
    </tbody>
</table>--}}

<div id="dealFlows">
    <div class="x_panel tile overflow_hidden">
        <div class="x_title">

            <h2>Non-Locked Deal Flows</h2>

            <div class="badge msg-badge">@{{dealFlows.length}}</div>


            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
            <small>Showing any non-confirmed intercompany fx deal</small>
        </div>

        <div class="x_content">
            {{--   <div class="dashboard-widget-content">

                <table class="table table-striped" style="width:100%;margin-bottom: 0px;">


                    <thead>

                    <tr class="headings">

                        <th>Deal</th>

                        <th>Counterparty</th>


                        <th>Confirmed</th>

                    </tr>
                    </thead>


                    <tbody>


                    <tr v-repeat="deal: deals">

                        <td>
                            @{{ deal.dealtype.name}}
                            @{{ deal.id}}

                        </td>
                        <td>
                            @{{ deal.counterparty.shortName}}


                        </td>

                        <td>
                            <form method="PATCH" v-on="submit: onSubmitForm(deal)">
                                <button type="submit" class="btn btn-default">Confirmed</button>
                            </form>
                        </td>

                    </tr>


                    </tr>
                    </tbody>
                </table>
            </div>--}}
        </div>
    </div>
</div>

