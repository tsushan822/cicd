{{--<!-- Address -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address" lazy :class="{'is-invalid': registerForm.errors.has('address')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
        </span>
    </div>
</div>--}}
<div class="form-row">

    <div class="col-md-6">
        <div class="form-group">
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
               <input class="form-control py-4"  type="text"  placeholder="{{__('State')}}" v-model.lazy="registerForm.state" :class="{'is-invalid': registerForm.errors.has('state')}">
            <div class="span_holder position-relative">
                  <span class="invalid-feedback" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
            </div>
        </div>
    </div>

</div>

<div class="form-row">

    <div class="col-md-6">
        <div class="form-group">
            <input class="form-control py-4"  type="text"  id="zip" name="zip" v-model.lazy="registerForm.zip" :class="{'is-invalid': registerForm.errors.has('zip')}" placeholder="{{__('Postal Code')}}">
            <div class="span_holder position-relative">
                    <span class="invalid-feedback" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <div class="form-control py-4">
                <select id="country" v-model.lazy="registerForm.country" :class="{'is-invalid': registerForm.errors.has('country')}" class="country-select">
                    @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                        <option value="{{ $key }}">{{ $country }}</option>
                    @endforeach
                </select>
            </div>
            <div class="span_holder position-relative">
                  <span class="invalid-feedback" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
                  </span>
            </div>
        </div>
    </div>

</div>

{{--<div class="row">
    <div class="col-md-6">
        <div class="md-form mb-0">
            <i class="fas fa-envelope prefix dark-grey-text countries_fa"></i>
            <select id="country" v-model.lazy="registerForm.country" :class="{'is-invalid': registerForm.errors.has('country')}" class="mdb-select col-md-11 md-form">
                @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                    <option value="{{ $key }}">{{ $country }}</option>
                @endforeach
            </select>
            <label for="country" class="active countryLabel">{{__('Country')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('country')">
            @{{ registerForm.errors.get('country') }}
            </span>
        </div>
    </div>
</div>--}}


{{--<div class="row">
    <div class="col-md-12">
        <div class="md-form mb-0">
            <i class="fas fa-user prefix dark-grey-text"></i>
            <input type="text" class="form-control" id="address" name="address" v-model="registerForm.address" lazy :class="{'is-invalid': registerForm.errors.has('address')}" >
            <label for="address" class="active">{{__('Address')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
            </span>
        </div>
    </div>
</div>--}}

{{--<div class="col-md-6">
    <div class="md-form mb-0">
        <i class="fas fa-user prefix dark-grey-text"></i>
        <input type="text" class="form-control" id="zip" name="zip" v-model.lazy="registerForm.zip" :class="{'is-invalid': registerForm.errors.has('zip')}" >
        <label for="zip" class="active">{{__('Postal Code')}}</label>
        <span class="invalid-feedback" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
    </div>
</div>--}}

{{--<!-- Address Line 2 -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('Address Line 2')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model="registerForm.address_line_2" lazy :class="{'is-invalid': registerForm.errors.has('address_line_2')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
        </span>
    </div>
</div>--}}

{{--<div class="row">
    <div class="col-md-12">
        <div class="md-form mb-0">
            <i class="fas fa-user prefix dark-grey-text"></i>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2" v-model="registerForm.address_line_2" lazy :class="{'is-invalid': registerForm.errors.has('address_line_2')}" >
            <label for="address_line_2" class="active">{{__('Address Line 2')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('address_line_2')">  @{{ registerForm.errors.get('address_line_2') }}</span>
        </div>

    </div>
</div>--}}

{{--<!-- City -->
<div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right">{{__('City')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.city" :class="{'is-invalid': registerForm.errors.has('city')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
        </span>
    </div>
</div>--}}

{{--<div class="row">
    <div class="col-md-12">
        <div class="md-form mb-0">
            <i class="fas fa-user prefix dark-grey-text"></i>
            <input type="text" class="form-control" id="city" name="city" v-model.lazy="registerForm.city" :class="{'is-invalid': registerForm.errors.has('city')}" >
            <label for="city" class="active">{{__('City')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
        </span>
        </div>
    </div>
</div>--}}


{{--<!-- State & ZIP Code -->
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
</div>--}}

{{--<div class="row">
    <div class="col-md-6">
        <div class="md-form mb-0">
            <i class="fas fa-user prefix dark-grey-text"></i>
            <input type="text" class="form-control" id="state" name="state" v-model.lazy="registerForm.state" :class="{'is-invalid': registerForm.errors.has('state')}" >
            <label for="state" class="active">{{__('State')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="md-form mb-0">
            <i class="fas fa-user prefix dark-grey-text"></i>
            <input type="text" class="form-control" id="zip" name="zip" v-model.lazy="registerForm.zip" :class="{'is-invalid': registerForm.errors.has('zip')}" >
            <label for="zip" class="active">{{__('Postal Code')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
        </div>
    </div>
</div>--}}

<!-- Country -->
{{--<div class="form-group row">
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
</div>--}}

{{--<div class="row">
    <div class="col-md-6">
        <div class="md-form mb-0">
            <i class="fas fa-envelope prefix dark-grey-text countries_fa"></i>
            <select id="country" v-model.lazy="registerForm.country" :class="{'is-invalid': registerForm.errors.has('country')}" class="mdb-select col-md-11 md-form">
                @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                    <option value="{{ $key }}">{{ $country }}</option>
                @endforeach
            </select>
            <label for="country" class="active countryLabel">{{__('Country')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('country')">
            @{{ registerForm.errors.get('country') }}
            </span>
        </div>
    </div>
</div>--}}

{{--<!-- European VAT ID -->
<div class="form-group row" v-if="countryCollectsVat">
    <label class="col-md-4 col-form-label text-md-right">{{__('VAT ID')}}</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" v-model.lazy="registerForm.vat_id" :class="{'is-invalid': registerForm.errors.has('vat_id')}">

        <span class="invalid-feedback" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}
        </span>
    </div>
</div>--}}

{{--<div class="row" v-if="countryCollectsVat">
    <div class="col-md-12">
        <div class="md-form mb-0">
            <i class="fas fa-envelope prefix dark-grey-text"></i>
            <input class="form-control" type="text" id="vat_id" v-model.lazy="registerForm.vat_id" :class="{'is-invalid': registerForm.errors.has('vat_id')}">
            <label for="vat_id" class="active">{{__('VAT ID')}}</label>
            <span class="invalid-feedback" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}</span>
        </div>
    </div>
</div>--}}

<div class="form-row" v-if="countryCollectsVat">

    <div class="col-md-12">
        <div class="form-group">
            <input class="form-control py-4"  type="text" id="vat_id" v-model.lazy="registerForm.vat_id" :class="{'is-invalid': registerForm.errors.has('vat_id')}" placeholder="{{__('VAT ID')}}">
            <div class="span_holder position-relative">
                 <span class="invalid-feedback" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}</span>
            </div>
        </div>
    </div>

</div>
