@if(isset($files))
    @can('view_document')
        <div class="swap_type_header">
            <h2 class="section-heading d-flex">
                @lang('master.Files')
            </h2>
        </div>
                <div class="row tabsrow table-responsive">
                    <table  class="table attachment-table-hide-footer  wrap  no-footer"
                           width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>@lang('master.File')</th>
                            <th>@lang('master.Created at')</th>
                            <th>@lang('master.Size')</th>
                            <th>@lang('master.Action')</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>@lang('master.File')</th>
                            <th>@lang('master.Created at')</th>
                            <th>@lang('master.Size')</th>
                            <th>@lang('master.Action')</th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{!! $loop->iteration !!}</td>
                                <td><a onclick="return confirm ('@lang('master.Do you want to download this file?')')"
                                            href="/download/{{$module}}/{{$id}}/{{$file['name']}}">
                                        {!! $file['icon'] !!} {{$file['name']}}</a></td>
                                <td>{!! \Carbon\Carbon::createFromTimestamp($file['date'])->diffForHumans() !!}</td>
                                <td>{!! $file['size'] !!} B</td>
                                <td>@can('delete_document')<a
                                            onclick="return confirm ('@lang('master.Are you sure you want to delete this file?')')"
                                            href="/delete/{{$module}}/{{$id}}/{{$file['name']}}">@lang('master.Delete')</a>@endcan
                                </td>
                            </tr>
                        @empty
                            <td colspan="5"> @lang('master.No files')</td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
    @endcan
@endif

@push('header-scripts-area')
    <style>
        .attachment-table-hide-footer> tfoot:first-of-type {
            display:none !important
        }
    </style>
@endpush