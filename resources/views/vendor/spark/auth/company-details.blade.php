<transition name="slide-fade">
    <div class="companY_information mt-4 pt-1" v-show="currentStep===0">
        <form  role="form">
            <div class="form-row">
                @if (Spark::usesTeams() && Spark::onlyTeamPlans())
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1  active d-none" for="team" >{{ __('teams.team_name') }}</label>
                        <input class="form-control py-4" id="team" name="team" v-model="registerForm.team" :class="{'is-invalid': registerForm.errors.has('team')}" placeholder="Enter company name">
                    <div class="span_holder position-relative">
                        <span class="invalid-feedback ml-0" v-show="registerForm.errors.has('team')"> @{{ registerForm.errors.get('team') }}</span>
                    </div>
                    </div>
                </div>
                @endif

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small  mb-1 active d-none" for="name">{{__('Name')}}</label>
                        <input class="form-control py-4"  id="name" name="name" v-model="registerForm.name" :class="{'is-invalid': registerForm.errors.has('name')}" placeholder="Enter your name">
                        <div class="span_holder position-relative">
                        <span class="invalid-feedback ml-0" v-show="registerForm.errors.has('team')"> @{{ registerForm.errors.get('team') }}</span>
                        </div>
                        </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="small  mb-1 active d-none" for="email">{{__('E-Mail Address')}}</label>
                        <input class="form-control py-4"  id="email"  name="email" v-model="registerForm.email" :class="{'is-invalid': registerForm.errors.has('email')}" placeholder="Enter your email">
                        <div class="span_holder position-relative">
                        <span class="invalid-feedback ml-0" v-show="registerForm.errors.has('email')">@{{ registerForm.errors.get('email') }}</span>
                        </div>
                        </div>
                </div>
            </div>

            <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1  active d-none" for="password">{{__('Password')}}</label>
                                <input class="form-control py-4" type="password"  id="password"  name="password" v-model="registerForm.password" :class="{'is-invalid': registerForm.errors.has('password')}" placeholder="Enter password">
                                <div class="span_holder position-relative">
                                <span class="invalid-feedback ml-0" v-show="registerForm.errors.has('password')"> @{{ registerForm.errors.get('password') }}</span>
                                </div>
                                </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small  mb-1 active d-none" for="passwordc">{{__('Confirm password')}}</label>
                                <input class="form-control py-4" type="password" id="passwordc" name="password_confirmation" v-model="registerForm.password_confirmation" :class="{'is-invalid': registerForm.errors.has('password_confirmation')}" placeholder="Confirm passsword">
                                    <div class="span_holder position-relative">
                                    <span class="invalid-feedback ml-0" v-show="registerForm.errors.has('password_confirmation')"> @{{ registerForm.errors.get('password_confirmation') }}</span>
                                    </div>
                            </div>
                        </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4 pr-2 d-flex justify-content-end">
                    <p v-show="currentStep===0">
                    <div  class="btn btn-light   btn-primary-variant-main  px-5 waves-effect waves-light"
                          @click="validateRegisterData()">
                    <span v-if="!intialRegisterRequestIsLOading">
                     <i class="fa fa-btn fa-arrow-right"></i> Next
                    </span>
                        <span v-else><i class="fa fa-btn fa-spinner fa-spin"></i> Loading </span>
                    </div>
                    </p>
                </div>
            </div>
        </form>
    </div>
</transition>

@push('header-scripts-area')
    <style>
        .companY_information{
            font-family: nunito;
        }
        .companY_information label{
            font-size: 14px;
            font-weight: 300;
            display:none ;
        }
        .companY_information input{

        }
        .icon-stack{
            position: absolute;
            left: 16px;
            bottom: 30px;
            height: 1.2rem;
            width: 1.2rem;
            padding: .2rem;
        }
        .companY_information .span_holder{

        }
        .span_holder{
            height: 20px;
        }

    </style>
@endpush