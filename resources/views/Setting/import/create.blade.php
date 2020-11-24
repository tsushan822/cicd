@extends('layouts.master')
@section('css')
@stop
@section('content')
    <section class=" mb-4 pb-3 alert black-text primary-background ">

        <div class="jumbotron mt-4 mb-0">
            <div class="row">
            {!!Form::open(array('url'=>"/{$item}/import",'files' => true, 'name' => "{$item}_upload",'id' => "{$item}_upload", 'class'=>'w-100 md-form')) !!}
            <!--Grid column-->
                <div class="col-md-6 mb-4">
                    <div class="upload-button-wrapper">
                        <img src="/img/copy.png" style="max-height: 300px" class="img-fluid z-depth-1-half" alt="">
                        <br/>
                        @if($item=="360t")
                            {!! Form::file("{$item}_excel[]",array('multiple'=>true, "class"=>"btn text-white primary-background mt-4 btn-sm float-left waves-effect waves-light")) !!}
                        @else
                            {!! Form::file("{$item}_excel",array('id' => 'file_select',"class"=>"btn text-white primary-background mt-4 btn-sm float-left waves-effect waves-light")) !!}
                        @endif
                    </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 mb-4">

                    <!-- Main heading -->
                    <h3 class="h3 mb-3"> @if(!$item=="360t")
                            Import 360T
                        @else
                            Import {{ ucfirst($item) }}
                        @endif</h3>
                    <p>Download the samples and check against our data structure</p>
                    <hr>

                    @if($item!=="360t")
                        <span class="btn primary-background btn-md text-white"
                              onclick="previewInfo('{{$item}}')">@lang('master.Download Sample')</span>
                    @endif
                    <span class="btn primary-background btn-md text-white" onclick="previewExcelFile('{{$item}}')"> @lang('master.Check')
                </span>
                    <button id='{{$item}}_import_button' class="btn primary-background btn-md text-white" type="submit"
                            value="submit"
                            name="submit" style="display:none"> @lang('master.Import')
                    </button>
                    @if(auth()->user()->hasRole('super') && request()->segment(3) == 'lease')
                        <button id='{{$item}}_import_large' class="btn primary-background btn-md text-white"
                                type="submit"
                                value="submit_large" name="submit" style="display:none">@lang('master.Import Large')
                        </button>
                    @endif

                </div>
                <!--Grid column-->
                {!! Form::close() !!}
            </div>
        </div>
    </section>



    <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Loading</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body" id="getCode">

                    <div class="loader"></div>

                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn primary-background btn-md text-white" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="getInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!--Header-->
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('master.Please, download the sample file.')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!--Body-->
                <div class="modal-body">

                    <div class="col-md-12 justify-content-center mb-4">
                        <a target="_blank" style="color:blue" href="#"
                           id="download_template_excel"><i
                                    class="fas fa-file-excel fa-2x mr-4 mr-4 primary-background p-3 white-text rounded"
                                    aria-hidden="true"></i></a>
                    </div>
                    <div class="col-md-12 justify-content-center">
                        <h4>{{trans('master.Download sample excel')}}</h4>
                    </div>
                    <div class="col-md-6 d-none mb-4">
                        <a target="_blank" style="color:blue" href="#" id="download_template_csv"><i
                                    class="fas fa-file-csv fa-2x mr-4 mr-4 primary-background p-3 white-text rounded"
                                    aria-hidden="true"></i></a>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="button" class="btn primary-background btn-md text-white" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal: modalCart -->

    <!--Grid row-->
@stop

@section('javascript')
    <script src="{{ mix('/js/custom/import.js') }}"></script>
@stop

