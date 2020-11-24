<div id="audittrail" aria-labelledby="audittrail-tab">

    <div id="audit_taril_apinner">

        <div id="" class="d-flex justify-content-center" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

        <table id="previewTable" class="table  dt-responsive" width="100%">
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
            <tbody id="ajax-tbody">
            </tbody>
        </table>

    @push('scripts')

        @endpush
</div>