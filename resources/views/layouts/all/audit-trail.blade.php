<div role="tabpanel" class="tab-pane fade" id="audittrail" aria-labelledby="audittrail-tab">
    <div class="row tabsrow table-responsive">
        <table id="audit-trail" class="table dt-responsive dataTable no-footer dtr-inline" width="100%">
            <thead>
            <tr>
                <th>@lang('master.User')</th>
                <th>@lang('master.Action')</th>
                <th>@lang('master.Parameter')</th>
                <th>@lang('master.Value before')</th>
                <th>@lang('master.Value after')</th>
                <th>@lang('master.When')</th>
                <th>@lang('master.Date Time')</th>
                <th>@lang('master.Timezone')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($changes as $change)
                <tr>
                    <td>{!!$change['user']!!}</td>
                    <td>{!!$change['event']!!}</td>
                    <td>{!!$change['title']!!}</td>
                    <td>{!! !is_numeric($change['before']) ?$change['before'] :mYFormat($change['before']) !!}</td>
                    <td>{!! !is_numeric($change['after']) ? $change['after']:mYFormat($change['after']) !!}</td>
                    <td>{!! $change['time']->diffForHumans() !!} </td>
                    <td>{!! $change['time']->toDateTimeString() !!}</td>
                    <td>{!! $change['time']->getTimezone()->getName() !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>