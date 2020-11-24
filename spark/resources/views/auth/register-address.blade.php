<!-- Address -->
<div class="form-row">

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text" v-model="registerForm.address" lazy :class="{'is-invalid': registerForm.errors.has('address')}" placeholder="{{__('Address')}}">
            <div class="span_holder position-relative">
                 <span class="invalid-feedback" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
                 </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text" v-model="registerForm.address_line_2" lazy :class="{'is-invalid': registerForm.errors.has('address_line_2')}" placeholder="{{__('Address Line 2')}}">
            <div class="span_holder position-relative">
                <span class="invalid-feedback" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
                </span>
            </div>
        </div>
    </div>

</div>


<div class="form-row">

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text"  v-model.lazy="registerForm.city" :class="{'is-invalid': registerForm.errors.has('city')}" placeholder="{{__('City')}}">
            <div class="span_holder position-relative">
                   <span class="invalid-feedback" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
                   </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text"  placeholder="{{__('State')}}" v-model.lazy="registerForm.state" :class="{'is-invalid': registerForm.errors.has('state')}">
            <div class="span_holder position-relative">
                  <span class="invalid-feedback" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
            </div>
        </div>
    </div>

</div>


{{--<div class="form-row">

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text" v-model="registerForm.address" lazy :class="{'is-invalid': registerForm.errors.has('address')}" placeholder="{{__('Address')}}">
            <div class="span_holder position-relative">
                 <span class="invalid-feedback" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
                 </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>                   </div>
            <input class="form-control py-4"  type="text" v-model="registerForm.address_line_2" lazy :class="{'is-invalid': registerForm.errors.has('address_line_2')}" placeholder="{{__('Address Line 2')}}">
            <div class="span_holder position-relative">
                <span class="invalid-feedback" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
                </span>
            </div>
        </div>
    </div>

</div>--}}




{{--<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address" lazy :class="{'is-invalid': registerForm.errors.has('address')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
        </span>
    </div>
</div>

<!-- Address Line 2 -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address Line 2')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address_line_2" lazy :class="{'is-invalid': registerForm.errors.has('address_line_2')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
        </span>
    </div>
</div>--}}

<!-- City -->
{{--<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('City')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.city" :class="{'is-invalid': registerForm.errors.has('city')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
        </span>
    </div>
</div>--}}

<!-- State & ZIP Code -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('State & ZIP / Postal Code')}}</label>

    <!-- State -->
    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="{{__('State')}}" v-model.lazy="registerForm.state" :class="{'is-invalid': registerForm.errors.has('state')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
    </div>

    <!-- Zip Code -->
    <div class="col-sm-3">
        <input type="text" class="form-control" placeholder="{{__('Postal Code')}}" v-model.lazy="registerForm.zip" :class="{'is-invalid': registerForm.errors.has('zip')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
    </div>
</div>

<!-- Country -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Country')}}</label>

    <div class="col-sm-6">
        <select class="form-control" v-model.lazy="registerForm.country" :class="{'is-invalid': registerForm.errors.has('country')}">
            @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                <option value="{{ $key }}">{{ $country }}</option>
            @endforeach
        </select>

        <span class="invalid-feedback" v-show="registerForm.errors.has('country')">
            @{{ registerForm.errors.get('country') }}
        </span>
    </div>
</div>

<!-- European VAT ID -->
<div class="form-group row" v-if="countryCollectsVat">
    <label class="col-md-4 col-form-label text-md-right">{{__('VAT ID')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.vat_id" :class="{'is-invalid': registerForm.errors.has('vat_id')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}
        </span>
    </div>
</div>
