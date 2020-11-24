<div class="pb-4 pt-2">

    <div class=" px-1 cardSimiliarShadow bg-white">


        <!--Section: Content-->
        <section class="dark-grey-text px-2 ">
            <div class="headingandbuttons  px-0 py-2 borderRemoval boxShadowRemoval">
                <div class="d-flex justify-content-between">
                    <div class=" d-flex align-items-center">
                        <div class="pageTitleAndinfo  w-100 text-left">
                            <h2 class="section-heading  d-flex justify-content-center justify-content-md-start">@lang('master.User details')</h2>
                        </div>
                    </div>
                    <div class="d-flex align-items-center zen_tab">

                    </div>
                    <div class="d-flex align-items-center" id="datatable-buttons">
                        <div>
                            <button class="btn btn-sm  btn-primary-variant-main  px-2 waves-effect waves-light"
                                    type="submit" value="save" name="submit"><i
                                        class="fas fa-save"></i>

                                @lang('master.Save')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav ml-2 mr-2 nav-tabs" role="tablist">

                <li class="nav-item">
                    <a class="nav-link text-uppercase borderRadiusRemoval active"
                       data-toggle="tab" href="#user" role="tab">
                        @lang('master.User details')
                        @if($user->verified)
                            <span class="badge badge-success text-lowerCase">@lang('master.Verified')</span>

                        @else
                            <span class="badge badge-danger text-lowerCase"> @lang('master.Unverified')</span>


                        @endif
                    </a>
                </li>
                @if($buttonShow['email_notifications'])
                    <li class="nav-item">
                        <a id="emailId" class="nav-link text-uppercase borderRadiusRemoval "
                           data-toggle="tab" href="#email" role="tab">
                            @lang('master.Email notifications')
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link text-uppercase borderRadiusRemoval "
                       data-toggle="tab" href="#duty" role="tab">
                        @lang('master.Assigned duties')
                    </a>
                </li>
                @if($user->id == auth()->id())
                    <li class="nav-item">
                        <a class="nav-link text-uppercase borderRadiusRemoval "
                           data-toggle="tab" href="#reset" role="tab">
                            @lang('master.Reset password')
                        </a>
                    </li>
                @endif

            </ul>

            <div class="classic-tabs mx-2">


                <!--Grid row-->


                <!-- Pills navs -->


                <!-- Pills panels -->
                <div class="tab-content card  boxShadowRemoval borderRemoval pt-1">
                    <div class="text-center" id="form-error-alert">
                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                             style="margin-left: auto;" data-autohide="false">
                            <div class="toast-header">
                                <svg class="rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg"
                                     preserveAspectRatio="xMidYMid slice"
                                     focusable="false" role="img">
                                    <rect class="toast-danger" fill="red" width="100%" height="100%"/>
                                </svg>
                                <strong class="mr-auto">@lang('Error')</strong>
                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="toast-body">
                                @lang('Required inputs are missing')
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane  fade in show active"
                         id="user" role="tabpanel">


                        <div class=" borderRemoval">
                            <div class="card-deck mb-4">
                                <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                    <div class="card-body ml-2 pl-1 px-0 py-0">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="md-form ">
                                                    @can('edit_user')
                                                        {!!Form::text('name',null, array("class"=>"form-control" ))!!}
                                                    @else
                                                        {!!Form::text('name',null, array('readonly',"class"=>"form-control" ))!!}
                                                    @endcan
                                                    {!!Form::label('name', Lang::get('master.Name'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="md-form ">
                                                    {!!Form::hidden('email',null)!!}
                                                    {!! Form::text('email', null,
                                                    array('disabled',
                                                    'class'=>'form-control',
                                                    'placeholder'=>'E-mail address')) !!}
                                                    {!!Form::label('email', Lang::get('master.Email address'))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none">
                                                {!!Form::select('locale',array('en'=>'English (English)','es'=>'Español (Spanish)',
                                'fi'=>'Suomeksi (Finnish)'),null,array("class"=>"mdb-select   md-form "))!!}
                                                {!!Form::label('locale', Lang::get('master.Language'))!!}

                                            </div>
                                            <div class="col-md-6">
                                                {!!Form::select('active_status',array('0'=>trans('master.Inactive'),'1'=>trans('master.Active')),null,array("class"=>"mdb-select   md-form "))!!}
                                                {!!Form::label('locale', Lang::get('master.Active Status'))!!}
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane  fade in show  d-none"
                         id="authentication" role="tabpanel">


                        <div class=" borderRemoval">
                            <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                <div class="card-body ml-2 pl-1 px-0 py-0">
                                    <div class="row">
                                        <div class="col-md-12 ml-1 pl-0">
                                            <blockquote v-show="!showRun" class="blockquote  text-left bq-primary mb-4">
                                                <p class="px-0 my-0 py-0">{{trans('master.Choose your country code and enter your number without the leading zero eg 401234567')}}
                                                </p>
                                            </blockquote>
                                        </div>
                                        <div class="col-md-12 pl-0 marginTopOnePx">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @can('edit_user')
                                                        {!!Form::select('two_factor_type',array('off'=>trans('master.Off'),'app'=>trans('master.Authy app')),null,array("class"=>"mdb-select   md-form "))!!}
                                                    @else
                                                        {!!Form::hidden('two_factor_type',$user->two_factor_type)!!}
                                                        {!!Form::select('two_factor_type',array('off'=>trans('master.Off'),'app'=>trans('master.Authy app')),null,array("class"=>"mdb-select   md-form ","disabled"))!!}

                                                    @endcan

                                                    {!!Form::label('two_factor_type',trans('master.Two Factor Authentication'))!!}
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>

                                        </div>

                                        <div class="col-md-12 pl-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @can('edit_user')
                                                        {!!Form::select('dialing_code',config('twofactor.dialing_codes'),null,array("class"=>"mdb-select   md-form "))!!}
                                                    @else
                                                        {!!Form::hidden('dialing_code',$user->dialing_code)!!}
                                                        {!!Form::select('dialing_code',config('twofactor.dialing_codes'),null,array("class"=>"mdb-select   md-form ","disabled"))!!}
                                                    @endcan

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="md-form ">
                                                        @can('edit_user')
                                                            {!!Form::text('phone_number',null,array("class"=>"form-control","placeholder" => "401234567"))!!}
                                                        @else
                                                            {!!Form::text('phone_number',null,array("class"=>"form-control","readonly"))!!}
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 pl-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="md-form ">

                                                        @can('is_superadmin')

                                                            {!!Form::input('authy_id','authy_id',null, array('disabled',"class"=>"form-control ", 'placeholder'=>Lang::get('master.Authy Id') ))!!}
                                                            {!!Form::label('authy_id', Lang::get('master.Authy Id'), array("class"=>"active" ))!!}
                                                        @endcan
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($buttonShow['email_notifications'])
                        <div class="tab-pane  fade in show "
                             id="email" role="tabpanel">


                            <div class=" borderRemoval">
                                <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                    <div class="card-body ml-2 pl-1 px-0 py-0">
                                        <div class="row">


                                            <div class="col-md-4 pl-0">
                                                <div class="form-check pl-0 mt-3 text-left">
                                                    {!!Form::hidden('lease_maturing_notify',0)!!}
                                                    {!!Form::checkbox('lease_maturing_notify',1,$maturingNotifications['lease_maturing_notify'], ['id'=>'lease_maturing_notify', 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                    {!!Form::label('lease_maturing_notify',Lang::get('master.Maturing leases notifications'), array("class"=>"form-check-label" ))!!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="md-form mt-0 pt-0 ">
                                                    {!!Form::number('lease_maturing_notify_prior_days',$maturingNotifications['lease_maturing_notify_prior_days'],['id' => 'lease_maturing_notify_prior_days','class' => 'form-control'])!!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="md-form mt-3 ">
                                                    <p>days in advance of maturity date</p>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                    <div class="tab-pane  fade in show "
                         id="duty" role="tabpanel">


                        <div class=" borderRemoval">
                            <div class="card-deck mb-4">
                                <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                    <div class="card-body  px-0 py-0">
                                        <h2 class="section-heading pl-3 text-left">@lang('master.Assigned duties')</h2>
                                        <div class="d-flex flex-column h-100 justify-content-around align-items-start">
                                            @foreach($roles as $role)

                                                <div class="">
                                                    <div class="form-check">
                                                        @can('edit_user')
                                                            {!!Form::checkbox('role[]',$role->id,in_array($role->id,$roleArray), ['id'=>$role->name, 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                        @else
                                                            {!!Form::checkbox('role[]',$role->id,in_array($role->id,$roleArray), ['onclick'=>"return false;",'disabled'=>true,'id'=>$role->name, 'type'=>'checkbox', 'class'=>'form-check-input'])!!}
                                                        @endcan
                                                        {!!Form::label($role->name, $role->label, array("class"=>"form-check-label" ))!!}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                    <div class="card-body ml-2 pl-1 px-0 py-0">
                                        <h2 class="section-heading  text-left">@lang('master.Assigned companies')</h2>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select name="counterparty[]" class="mdb-select colorful-select
                                                dropdown-primary md-form hide-first-element-of-dropdown" multiple
                                                        searchable="@lang('master.Search here..')">
                                                    <option class="d-none" value="" disabled>@lang('master.Select companies')</option>
                                                    @foreach($counterparties as $counterparty)
                                                        @if(in_array($counterparty->id,$counterpartyArray))
                                                            <option value="{!! $counterparty->id !!}"
                                                                    selected>{!! $counterparty->short_name !!}</option>
                                                        @else
                                                            <option value="{!! $counterparty->id !!}">{!! $counterparty->short_name !!}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane  fade in show "
                         id="reset" role="tabpanel">


                        <div class=" borderRemoval">
                            <div class="card ml-0 mr-0 borderRemoval boxShadowRemoval">
                                <div class="card-body ml-2 pl-1 px-0 py-0">
                                    <div id="reset_password">
                                        <form @submit.prevent="reset" @keydown="form.onKeydown($event)">
                                            <div class="row mt-2">
                                                <div class="col-md-12 pl-0">
                                                    <div role="alert" v-if="success"
                                                         class="alert text-center offset-md-0 col-md-12 alert-success">
                                                        {{trans('master.Your password has been successfully changed!')}}

                                                    </div>
                                                </div>
                                                <div class="col-md-3 pl-0">
                                                    <div class="md-form ">
                                                        {!!Form::password('current_password', ["id"=>"current_password",'class' => 'form-control',"v-model"=>"form.current_password",'placeholder'=>trans('master.Current Password')]);!!}
                                                        {!!Form::label('password', trans('master.Current Password'))!!}
                                                        <has-error :form="form" field="current_password"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="md-form ">
                                                        {!!Form::password('password', ["id"=>"password",'class' => 'form-control',"v-model"=>"form.password",'placeholder'=>trans('master.New Password')]);!!}
                                                        {!!Form::label('password', trans('master.New Password'))!!}
                                                        <has-error :form="form" field="password"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="md-form ">
                                                        {!!Form::password('password_confirmation', ["id"=>"end_date",'class' => 'form-control',"v-model"=>"form.password_confirmation",'id'=>'password-confirm','placeholder'=>trans('master.Confirm Password')]);!!}
                                                        {!!Form::label('password_confirmation', trans('master.Confirm Password'))!!}
                                                        <has-error :form="form" field="end_date"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="md-form d-flex mt-2  ">
                                                        <button class="btn btn-sm  btn-primary-variant-alert  px-2 waves-effect waves-light"
                                                                :disabled="form.busy" @click="reset()"><i
                                                                    class="fas fa-save"></i>
                                                            @lang('master.Reset')
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </section>
    </div>
</div>

@push('form-js')
    <script src="{{ mix('/tenant/app.js') }}"></script>

    <script>


        new Vue({
            el: '#reset_password',

            data() {
                return {
                    // Create a new form instance
                    success: false,
                    form: new Form({
                        current_password: '',
                        password: '',
                        password_confirmation: ''

                    })
                }
            },

            methods: {
                reset() {
                    this.success = false;
                    // Submit the form via a POST request
                    this.form.put('/settings/password')
                        .then(({data}) => {
                            this.success = true;
                            this.form = new Form({
                                current_password: '',
                                password: '',
                                password_confirmation: ''

                            })
                        })
                }

            },
            created() {

            }
        })
    </script>
    <script>
        window.onload = function () {
            if (window.location.href.indexOf("email") > 0) {
                $('#emailId').tab('show')
            }

        };
    </script>
@endpush

@push('header-css')
    <style>
    .hide-first-element-of-dropdown > .multiple-select-dropdown >li:first-of-type{
        display:none !important
    }
    </style>
@endpush