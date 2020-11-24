

    <div>
            <div class="alert alert-danger"
                 v-if="registerForm.errors.has('form')">
                {{__('We had trouble validating your card. It\'s possible your card provider is preventing us from charging the card. Please contact your card provider or customer support.')}}
            </div>
<div class="companY_information mt-4 pt-1">
    <form role="form">

        {{--<div class="row">
            <div class="col-md-12">
                <div class="md-form mb-0 ">
                    <i class="fas fa-user prefix dark-grey-text"></i>
                    <input type="text" class="form-control"
                           id="name" name="name"
                           v-model="cardForm.name">
                    <label for="name"
                           class="active">{{__('Cardholder\'s Name')}}</label>
                </div>
            </div>
        </div>
--}}
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                      <label class="small d-none mb-1 active" for="name">{{__('Cardholder\'s Name')}}</label>
                    <input class="form-control py-4"  type="text"
                           id="name" name="name"
                           v-model="cardForm.name" placeholder="{{__('Cardholder\'s Name')}}">
                    <div class="span_holder position-relative">
                    </div>
                </div>
            </div>
        </div>


       {{-- <div class="row">
            <div class="col-md-12">
                <div class="md-form mb-0 ">
                    <i class="fas fa-user prefix dark-grey-text"
                       style="top: -.5rem;"></i>
                    <div id="card-element" style="    margin-left: 2.5rem;
    width: calc(100% - 2.5rem);
    margin-top: 1.5rem;"></div>
                    <input type="hidden" class="form-control"
                           :class="{'is-invalid': cardForm.errors.has('card')}">
                    <span class="invalid-feedback"
                          v-show="cardForm.errors.has('card')">
                                                                        @{{ cardForm.errors.get('card') }}</span>
                </div>
            </div>
        </div>--}}
        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group">
                    <div id="card-element" class="py-4 form-control" ref="stripeCardElementRef"></div>
                    <div v-if="cardElement">
                        <div v-show="cardElement._invalid" class="span_holder position-relative"><span class="invalid-feedback ml-0"> The card details is invalid</span></div>
                    </div>
                </div>
            </div>
        </div>




    @if (Spark::collectsBillingAddress())
        @include('spark::auth.register-address')
    @endif

    <!-- ZIP Code -->
        <div class="form-group row"
             v-if=" ! spark.collectsBillingAddress">
            <label class="col-md-4 col-form-label text-md-right">{{__('ZIP / Postal Code')}}</label>

            <div class="col-md-6">
                <input type="text" class="form-control"
                       name="zip" v-model="registerForm.zip"
                       :class="{'is-invalid': registerForm.errors.has('zip')}">

                <span class="invalid-feedback"
                      v-show="registerForm.errors.has('zip')">
                                            @{{ registerForm.errors.get('zip') }}
                                        </span>
            </div>
        </div>

        <!-- Coupon Code -->
        <div class="form-group row" v-if="query.coupon">
            <label class="col-md-4 col-form-label text-md-right">{{__('Coupon Code')}}</label>

            <div class="col-md-6">
                <input type="text" class="form-control"
                       name="coupon"
                       v-model="registerForm.coupon"
                       :class="{'is-invalid': registerForm.errors.has('coupon')}">

                <span class="invalid-feedback"
                      v-show="registerForm.errors.has('coupon')">
                                            @{{ registerForm.errors.get('coupon') }}
                                        </span>
            </div>
        </div>

        <!-- Terms And Conditions -->
       {{-- <div class="form-group row">
            <div class="col-md-6">
                <div class="form-check">
                    <label class="form-check-label terms-and-service-checkbox text-left w-100">
                        <input type="checkbox"
                               class="form-check-input terms-and-service-checkbox-input"
                               v-model="registerForm.terms">
                        {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="/terms" class="link_custom_color" target="_blank">', 'linkClose' => '</a>']) !!}
                    </label>
                    <input type="hidden" class="form-control"
                           :class="{'is-invalid': registerForm.errors.has('terms')}">
                    <span class="invalid-feedback"
                          v-show="registerForm.errors.has('terms')">
                                                <strong>@{{ registerForm.errors.get('terms') }}</strong>
                                            </span>
                </div>
            </div>
        </div>--}}

        <div class="form-row">
            <div class="col-md-12">
                <div class="form-group d-flex pl-4" style="color:#abb7c4">
                    <input type="checkbox"
                           class="form-check-input terms-and-service-checkbox-input"
                           v-model="registerForm.terms">
                    {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="/page/terms" class="link_custom_color link-custom-position" target="_blank">', 'linkClose' => '</a>']) !!}
                    <input type="hidden" class="form-control"
                           :class="{'is-invalid': registerForm.errors.has('terms')}">
                    <div class="span_holder position-relative">
                       <span class="invalid-feedback"
                             v-show="registerForm.errors.has('terms')">
                                                <strong>@{{ registerForm.errors.get('terms') }}</strong>
                                            </span>
                    </div>
                </div>
            </div>
        </div>



        <!-- Tax / Price Information -->
        <div class="form-group row"
             v-if="spark.collectsEuropeanVat && countryCollectsVat && selectedPlan">
            <label class="col-md-4 col-form-label text-md-right">&nbsp;</label>

            <div class="col-md-6">
                <div class="alert vat-info-area text-left"
                     style="margin: 0;">
                    <strong>{{__('Tax')}}:</strong> @{{
                    taxAmount(selectedPlan) | currency }}
                    <br><br>
                    <strong>{{__('Total Price Including Tax')}}
                        :</strong>
                    @{{ priceWithTax(selectedPlan) | currency }}
                    @{{ selectedPlan.type == 'user' &&
                    spark.chargesUsersPerSeat ? '/ '+
                    spark.seatName : '' }}
                    @{{ selectedPlan.type == 'user' &&
                    spark.chargesUsersPerTeam ? '/ '+
                    __('teams.team') : '' }}
                    @{{ selectedPlan.type == 'team' &&
                    spark.chargesTeamsPerSeat ? '/ '+
                    spark.teamSeatName : '' }}
                    @{{ selectedPlan.type == 'team' &&
                    spark.chargesTeamsPerMember ? '/ '+
                    __('teams.member') : '' }}
                    / @{{ __(selectedPlan.interval) | capitalize
                    }}
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4 pr-2 d-flex justify-content-end">
                <p v-if="currentStep===0">
                <div  class="btn btn-light  btn-primary-variant-main  px-5 waves-effect waves-light"
                      @click.prevent="register"
                      :disabled="registerForm.busy">
                                                                                <span v-if="registerForm.busy">
                                                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Registering')}}
                                            </span>

                    <span v-else>
                                                                                    <i class="fa fa-btn fa-check-circle"></i> {{__('Register')}}</span>
                </div>
                </p>
            </div>
        </div>
    </form>

</div>
        </div>

