<div id="cost-center-split-view-active">
   {{-- <div class="form-group">
        <h3><u>{{ trans('master.Cost center splits') }}</u></h3>
    </div>--}}
    <div class="row pt-2 pb-2 text-white rgba-stylish-strong row-eq-height">
        <div class="col-md-4 text-left ">
            <h6 class="card-title mb-0">@lang('master.Cost center')</h6>
        </div>
        <div class="col-md-4 text-left">
            <h6 class="card-title mb-0">@lang('master.Percentage')</h6>

        </div>
        <div class="col-md-4 text-left">
            <h6 class="card-title mb-0">@lang('master.Description')</h6>

        </div>
    </div>

       <div class="row d-flex justify-content-center">
           @foreach($costCenterSplits as $costCenter)

           <div class="col-md-4 mb-0 text-left">
                <div class="form-check mt-4 pl-0">
                    {!!Form::hidden("cost_center_split_id[$costCenter->id]",0)!!}
                    {!!Form::checkbox("cost_center_split_id[$costCenter->id]", null ,$costCenter->exists,['class'=>' form-check-input cost_center_split_checkbox','id'=> "cost_center_split_id[$costCenter->id]", 'data-id'=>$costCenter->id])!!}
                    {!!Form::label("cost_center_split_id[$costCenter->id]",$costCenter->short_name,array("class"=>"form-check-label" ))!!}
                </div>
            </div>
           <div class="col-md-4 mb-0 text-left">
               <div class="col-md-8">
                   <div class="md-form md-outline">
                       {!!Form::input("decimal","percentage[$costCenter->id]",$costCenter->percentage,['id' =>'percentage cost_center_split_input',
                         'class' =>'form-control',"placeholder" => "%", 'data-id'=>'percentage['.$costCenter->id.']'])!!}
                   </div>
               </div>
            </div>
           <div class="col-md-4 mb-0 text-left pt-1 mt-4 pl-0">
               <strong>{{$costCenter -> long_name}}</strong>
            </div>
           @endforeach

       </div>
    </div>