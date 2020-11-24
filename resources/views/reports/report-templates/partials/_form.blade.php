
{{--
<div class="col-md-4 col-sm-12 col-xs-12">
    <h3>@lang('master.Create new report template')</h3>
</div>
<div class="col-md-8 col-sm-12 col-xs-12">
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="btn btn-app" href="{!! route('bookkeeping-settings.index') !!}">
                <i class="fas fa-arrow-left"></i> @lang('master.Back')
            </a>
        </li>

    </ul>
</div>

<div>
    <div class="form-group">
        <table id="report_template_table" class="table-bordered">
            <thead>
            <tr>
                <th>@lang('master.Order')</th>
                <th>@lang('master.Name')</th>
                @if(request('for_txt_file') != 1)
                    <th>@lang('master.Table header')</th>
                @endif
                <th>@lang('master.Default value')</th>
                @if(request('for_txt_file') == 1)
                    <th>@lang('master.Length')</th>
                    @if(!$noHeaderInTextFile)
                        <th>@lang('master.Is header text')</th>
                    @endif
                @endif
                <th>@lang('master.Active')</th>
            </tr>
            </thead>
            <tbody id="sortable">
            @foreach($columns as $item => $value)
                <tr>
                    <td><span class="dropup"><span class="caret"></span></span><span class="dropdown"><span
                                    class="caret"></span></span></td>
                    <td>
                        <label class="control-label col-md-6 col-sm-6 col-xs-8">
                            {!!Form::hidden("column_name[$item]", $item)!!}
                            {!!Form::label($value, $value)!!}
                        </label>
                    </td>

                    @if(request('for_txt_file') != 1)
                        <td>
                            <div class="col-md-6 col-sm-6 col-xs-3">
                                {!! Form::text("table_header[$item]",$value,['id'=>$item, 'class'=>'form-control ','placeholder'=>trans('master.Table header')]) !!}
                            </div>
                        </td>
                    @endif
                    <td>
                        <div class="col-md-6 col-sm-6 col-xs-3">
                            @if(strpos($item,'empty_value') !== false)
                                {!!Form::text("default_value[$item]",null,['id'=>$item,
                                'class'=> 'form-control ', 'placeholder'=>trans('master.Default value')])!!}
                            @endif
                        </div>
                    </td>
                    @if(request('for_txt_file') == 1)
                        <td>
                            <div class="col-md-6 col-sm-6 col-xs-3">
                                {!!Form::text("length[$item]",null,['id'=>$item,  'class'=> 'form-control ','placeholder'=>trans('master.Length')])!!}
                            </div>
                        </td>

                        @if(!$noHeaderInTextFile)
                            <td>
                                <div class="col-md-6 col-sm-6 col-xs-3">
                                    {!! Form::hidden("is_header_text[$item]", 0) !!}
                                    {!! Form::checkbox("is_header_text[$item]",1, 0,  ['id'=>$item, 'class'=>'is_header_text',  'type'=>'checkbox']) !!}
                                </div>
                            </td>
                        @endif
                    @endif
                    <td>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::hidden("active_status[$item]", 0) !!}
                                {!! Form::checkbox("active_status[$item]",1, 0,  ['id'=>$item, 'class'=>'active_status',  'type'=>'checkbox']) !!}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="col-md-12 col-sm-12 col-xs-12 form_outher_layer">
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 1rem">
                <div class="col-md-10 col-xs-12">
                    <label class="control-label col-md-offset-6 col-md-3 col-xs-7">   {!! Form::label
                    ('template_name',trans('master.Template name')) !!}
                    </label>
                    <div class="col-md-3 col-xs-5">
                        {!! Form::input('text','template_name',null, array("id"=>"template_name",
                        "class"=>"form-control","placeholder" => trans("master.Report template name"))) !!}
                        {!! Form::hidden('for_txt_file',request('for_txt_file')) !!}
                    </div>
                </div>
                <div class="col-md-2 col-xs-12">
                    <button id="register_submit" class="btn btn-app" type="submit" value="Save"><i
            class="fas fa-save"></i>
    @lang('master.Add new')
</button>
</div>
</div>
</div>

</div>
</div>
--}}


<div class="pb-4 pt-4">
    <div class="card card-cascade narrower mt-4">

        <!--Card image-->
        <div
                class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <a href="" class="white-text mx-3">@lang('master.Create new report template')</a>

            <div>
                <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('bookkeeping-settings.index') !!}">
                    <i class="fas fa-arrow-left"></i> @lang('master.Back')
                </a>
            </div>


        </div>


        <div class="px-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="md-form md-outline ">
                        {!! Form::input('text','template_name',null, array("id"=>"template_name",
                        "class"=>"form-control","placeholder" => trans("master.Report template name"))) !!}
                        {!! Form::label
                 ('template_name',trans('master.Template name')) !!}
                        {!! Form::hidden('for_txt_file',request('for_txt_file')) !!}
                    </div>
                </div>

                <div class="col-md6">
                    <button class="btn d-flex btn-md mt-4 btn-primary  waves-effect waves-light" type="submit" value="send" name="submit"
                            href="{!! url('/import/Guarantee/guarantee') !!}">
                        <i class="fas fa-mail"></i> @lang('master.Create')
                    </button>
                </div>

            </div>

            <div class="table-wrapper">

                <div class="card-deck mb-4">
                    <div class="card boxShadowRemoval">
                       <div class="card-body">
                           <table id="" class="table dt-responsive dataTable no-footer dtr-inline">
                               <thead>
                               <tr>
                                   {{--<th>@lang('master.Order')</th>--}}
                                   <th>@lang('master.Name')</th>
                                   @if(request('for_txt_file') != 1)
                                       <th>@lang('master.Table header')</th>
                                   @endif
                                   <th>@lang('master.Default value')</th>
                                   @if(request('for_txt_file') == 1)
                                       <th>@lang('master.Length')</th>
                                       @if(!$noHeaderInTextFile)
                                           <th>@lang('master.Is header text')</th>
                                       @endif
                                   @endif
                                   <th>@lang('master.Active')</th>
                               </tr>
                               </thead>
                               <tbody id="sortable">
                               @foreach($columns as $item => $value)
                                   <tr>
                                      {{-- <td><span class="dropup"><span class="caret"></span></span><span class="dropdown"><span
                                                       class="caret"></span></span></td>--}}
                                       <td>

                                               {!!Form::hidden("column_name[$item]", $item)!!}
                                               {!!Form::label($value, $value)!!}
                                       </td>

                                       @if(request('for_txt_file') != 1)
                                           <td>
                                               <div class="md-form md-outline">
                                                   {!! Form::text("table_header[$item]",$value,['id'=>$item, 'class'=>'form-control ','placeholder'=>trans('master.Table header')]) !!}
                                               </div>
                                           </td>
                                       @endif
                                       <td>
                                           <div class="col-md-6 col-sm-6 col-xs-3">
                                               <div class="md-form md-outline">
                                                   @if(strpos($item,'empty_value') !== false)
                                                       {!!Form::text("default_value[$item]",null,['id'=>$item,
                                                       'class'=> 'form-control ', 'placeholder'=>trans('master.Default value')])!!}
                                                   @endif
                                               </div>
                                           </div>
                                       </td>
                                       @if(request('for_txt_file') == 1)
                                           <td>
                                               <div class="md-form md-outline">
                                                   {!!Form::text("length[$item]",null,['id'=>$item,  'class'=> 'form-control ','placeholder'=>trans('master.Length')])!!}
                                               </div>
                                           </td>

                                           @if(!$noHeaderInTextFile)
                                               <td>
                                                   <div class="col-md-6 col-sm-6 col-xs-3">
                                                       <div class="switch mt-4 d-flex">
                                                        <label>
                                                            {!! Form::hidden("is_header_text[$item]", 0) !!}
                                                            {!! Form::checkbox("is_header_text[$item]",1, 0,  ['id'=>$item, 'class'=>'is_header_text',  'type'=>'checkbox']) !!}
                                                          <span class="lever "></span>

                                                         </label>
                                                          </div>

                                                   </div>
                                               </td>
                                           @endif
                                       @endif
                                       <td>
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <div class="switch mt-4 d-flex">
                                                    <label>
                                                        {!! Form::hidden("active_status[$item]", 0) !!}
                                                        {!! Form::checkbox("active_status[$item]",1, 0,  ['id'=>$item, 'class'=>'active_status',  'type'=>'checkbox']) !!}
                                                      <span class="lever "></span>

                                                     </label>
                                                      </div>
                                               </div>
                                           </div>
                                       </td>
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
































