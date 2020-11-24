@extends('layouts.master')
@section('content')
<div class="pb-4 pt-4">
    <div class="card card-cascade narrower pb-5">

        <!--Card image-->
        <div
                class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <a href="" class="white-text mx-3">Choose the items you want to view in dashboard</a>
            <div>
                <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('mmrates.index') !!}">
                    <i class="fas fa-arrow-left"></i> @lang('master.Back')
                </a>


                @if(\Illuminate\Support\Facades\Auth::check())
                    <button class="btn btn-outline-white  btn-sm px-2" type="submit" value="Save"
                            id="register_submit"><i
                                class="fas fa-save"></i> @lang('master.Save')
                    </button>
                @endif

            </div>


        </div>


        <div class="px-4">

            <div class="table-wrapper">


                <div class="form-row mt-5 mb-5">
                    @foreach($dashboards as $dashboard)
                    <div class="switch mt-3 d-flex">
                     <label>
                         {!! Form::hidden($dashboard->id,0) !!}
                         @if($alreadyAllocated)
                             {!!Form::checkbox($dashboard->id,null, $dashboard->pivot->active_status, ['id'=>$dashboard->name, 'type'=>'checkbox'])!!}
                         @else
                             {!!Form::checkbox($dashboard->id,null, null, ['id'=>$dashboard->name, 'type'=>'checkbox'])!!}
                         @endif
                       <span class="lever "></span> {!!Form::label($dashboard->name, $dashboard->item)!!}

                      </label>
                       </div>
                        @endforeach
                </div>



            </div>

        </div>

    </div>
</div>
{!!Form::close()!!}
@endsection
@section('javascript')
    <script src="{{ mix('/js/zentreasury-form.js') }}"></script>
    <script src="/js/vendor/jquery-ui.min.js"></script>
    <script src="{{ mix('/js/custom/deals.js') }}"></script>
@stop
