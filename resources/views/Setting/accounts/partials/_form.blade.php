

<div class="pb-4 pt-4">
    <div class="card card-cascade narrower mt-4">

        <!--Card image-->
        <div
                class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
            <a href="" class="white-text mx-3">@if(isset($copy))
                    @includeIf('sub-views.createdByUserText',['deal' => $account,'copy' => $copy, 'type'=>trans('master.Account')])
                @elseif(isset($account))
                    @includeIf('sub-views.createdByUserText',['deal' => $account, 'type'=> trans('master.Account')])
                @else
                    @includeIf('sub-views.createdByUserText',['type'=> trans('master.Account')])
                @endif</a>

            <div>
                @if($addOrEditText == 'Edit')
                    @can('create_account')
                        <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('accounts.copy', $account->id) !!}">
                            <i class="fas fa-clone"></i> @lang('master.Copy')
                        </a>
                    @endcan

                        @can('delete_account')
                            <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('accounts.show', $account->id) !!}">
                                <i class="fas fa-trash"></i> @lang('master.Delete')
                            </a>
                            @endcan
                        @can('edit_account')

                        <button class="btn btn-outline-white  btn-sm px-2" type="submit" value="Save"
                                id="register_submit"><i
                                    class="fas fa-save"></i> @lang('master.Save')
                        </button>
                        @endif



                @endif

                    @if($addOrEditText == 'Add New')
                        @can('create_account')
                    <button class="btn btn-outline-white  btn-sm px-2" type="submit" value="Save"
                            id="register_submit"><i
                                class="fas fa-save"></i> @lang('master.Save')
                    </button>
                @endcan
                    @endif


                    <a class="btn btn-outline-white  btn-sm px-2" href="{!! route('accounts.index') !!}">
                        <i class="fas fa-arrow-left"></i> @lang('master.Back')
                    </a>

            </div>


        </div>


        <div class="px-4">

            <div class="table-wrapper">

                <div class="card-deck mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($company))
                                        {!!Form::select('counterparty_id', $counterparties ,$company,['class'=>'mdb-select   md-form md-outline'])!!}
                                    @else
                                        {!!Form::select('counterparty_id', $counterparties ,null,['class'=>'mdb-select   md-form md-outline','placeholder' =>
                                        trans('master.Select account owner')])!!}
                                    @endif
                                    {!!Form::label('counterparty_id',trans('master.Account owner'))!!}

                                 </div>
                                <div class="col-md-12">
                                    <div class="md-form md-outline">
                                        {!!Form::input('text','account_name',null, array("class"=>"form-control" ))!!}
                                        {!!Form::label('account_name', trans('master.Account name'))!!}
                                    </div>
                                 </div>

                                <div class="col-md-12">
                                    <div class="md-form md-outline">
                                        {!!Form::input('text','bank',null, array("class"=>"form-control" ))!!}
                                        {!!Form::label('bank', trans('master.Bank'))!!}
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="md-form md-outline">
                                        {!!Form::input('text','alternative_account',null, array("class"=>"form-control" ))!!}
                                        {!!Form::label('alternative_account', trans('master.Alternative account number'))!!}

                                    </div>
                                </div>

                                <div class="col-md-12">
                                       <div class="switch mt-3 d-flex">
                                        <label>
                                            {!! Form::hidden('show_liq_view', 0) !!}
                                            {!!Form::checkbox('show_liq_view',1, null, ['class' => 'checkbox'])!!}
                                          <span class="lever "></span> {!!Form::label('show_liq_view', trans('master.Show in liquidity view'),['class'=>'control-label'])!!}


                                        </label>
                                          </div>
                                 </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($addOrEditText == 'Edit')
                                        {!!Form::select('currency_id',$currencies ,null,array("class"=>"mdb-select   md-form md-outline","placeholder" =>
                                        trans("master.Currency"),"disabled" => true))!!}
                                    @else
                                        {!!Form::select('currency_id',$currencies ,null,array("class"=>"mdb-select   md-form md-outline","placeholder" =>
                                        trans("master.Currency")))!!}
                                    @endif
                                    {!!Form::label('currency_id', trans('master.Currency'))!!}

                                 </div>
                                <div class="col-md-12">
                                    <div class="md-form md-outline">
                                        {!!Form::input('text','IBAN',null, array("class"=>"form-control" ))!!}
                                        {!!Form::label('IBAN', trans('master.IBAN'))!!}
                                    </div>
                                 </div>
                                <div class="col-md-12">
                                    {!!Form::select('country_id',$countries ,null,array("class"=>"mdb-select   md-form md-outline","placeholder" =>
                                   trans("master.Country")))!!}
                                    {!!Form::label('country', trans('master.Country'))!!}
                                 </div>
                                <div class="col-md-12">
                                    <div class="md-form md-outline">
                                        {!!Form::input('text','BIC',null, array("class"=>"form-control" ))!!}
                                        {!!Form::label('BIC', trans('master.BIC'))!!}
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-deck mb-4">
                    <div class="card">
                        <div class="card-body">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="md-form md-outline">
                                      {!!Form::input('text','client_account_number',null, array("class"=>"form-control" ))!!}
                                      {!!Form::label('client_account_number', trans('master.Accounting account number'))!!}
                                  </div>
                               </div>
                              <div class="col-md-12">
                                     <div class="switch mt-3 d-flex">
                                      <label>
                                       {!!Form::checkbox('default_counterparty_code',1, null, ['class' => 'checkbox'])!!}

                                   <span class="lever "></span>  {!!Form::label('default_counterparty_code', trans('master.Default counterparty code'))!!}

                                       </label>
                                        </div>
                               </div>
                          </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form md-outline">
                                            {!!Form::input('text','client_account_name',null, array("class"=>"form-control" ))!!}
                                            {!!Form::label('client_account_name', trans('master.Accounting account name'))!!}
                                        </div>
                                     </div>
                                    <div class="col-md-12">
                                        <div class="md-form md-outline">
                                            {!!Form::input('text','default_value_counterparty_code',null, array("class"=>"form-control" ))!!}

                                            {!!Form::label('default_value_counterparty_code', trans('master.Default value counterparty code'))!!}
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>