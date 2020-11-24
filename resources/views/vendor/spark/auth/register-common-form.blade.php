<transition name="slide-fade">
    <div class="companY_information" v-show="currentStep===0">
        <form  role="form">
            @if (Spark::usesTeams() && Spark::onlyTeamPlans())

                <div class="md-form mb-0">
                    <i class="fas fa-building prefix dark-grey-text"></i>
                    <input type="text" class="form-control" id="team" name="team" v-model="registerForm.team" :class="{'is-invalid': registerForm.errors.has('team')}" >
                    <label for="team" >{{ __('teams.team_name') }}</label>
                    <span class="invalid-feedback" v-show="registerForm.errors.has('team')"> @{{ registerForm.errors.get('team') }}</span>
                </div>

            @endif

            <div class="md-form mb-0">
                <i class="fas fa-user prefix dark-grey-text"></i>
                <input type="text" class="form-control" id="name" name="name" v-model="registerForm.name" :class="{'is-invalid': registerForm.errors.has('name')}" >
                <label for="name" class="active">{{__('Name')}}</label>
                <span class="invalid-feedback" v-show="registerForm.errors.has('name')"> @{{ registerForm.errors.get('name') }}</span>
            </div>


            <div class="md-form mb-0">
                <i class="fas fa-envelope prefix dark-grey-text"></i>
                <input type="email" id="email" class="form-control"  name="email" v-model="registerForm.email" :class="{'is-invalid': registerForm.errors.has('email')}">
                <label for="email" class="active">{{__('E-Mail Address')}}</label>
                <span class="invalid-feedback" v-show="registerForm.errors.has('email')">@{{ registerForm.errors.get('email') }}</span>
            </div>

            <div class="md-form mb-0">
                <i class="fas fa-lock prefix dark-grey-text"></i>
                <input type="password"  id="password" class="form-control" name="password" v-model="registerForm.password" :class="{'is-invalid': registerForm.errors.has('password')}">
                <label for="password" class="active">{{__('Password')}}</label>
                <span class="invalid-feedback" v-show="registerForm.errors.has('password')"> @{{ registerForm.errors.get('password') }}</span>

            </div>


            <div class="md-form mb-0">
                <i class="fas fa-lock prefix dark-grey-text"></i>
                <input type="password" id="passwordc" class="form-control" name="password_confirmation" v-model="registerForm.password_confirmation" :class="{'is-invalid': registerForm.errors.has('password_confirmation')}">
                <label for="passwordc" class="active">{{__('Confirm password')}}</label>
                <span class="invalid-feedback" v-show="registerForm.errors.has('password_confirmation')"> @{{ registerForm.errors.get('password_confirmation') }}</span>

            </div>

            <!-- Terms And Conditions -->
            <div v-show="0" v-if=" ! selectedPlan || selectedPlan.price == 0">
                <div class="form-group row">
                    <div class="col-md-12 mt-2">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="terms" :class="{'is-invalid': registerForm.errors.has('terms')}" v-model="registerForm.terms">
                            <label class="form-check-label" for="terms">
                                {!! __('I Accept :linkOpen The Terms Of Service :linkClose', ['linkOpen' => '<a href="#" data-toggle="modal" data-target="#exampleModalCenter">', 'linkClose' => '</a>']) !!}
                            </label>
                            <input type="hidden" class="form-control" :class="{'is-invalid': registerForm.errors.has('terms')}">
                            <div class="invalid-feedback" v-show="registerForm.errors.has('terms')">
                                <strong>@{{ registerForm.errors.get('terms') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 ">
                        <button class="btn  btn-rounded mt-3 waves-effect waves-light" @click.prevent="register" :disabled="registerForm.busy">
                    <span v-if="registerForm.busy">
                        <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Registering')}}
                    </span>

                            <span v-else>
                        <i class="fa fa-btn fa-check-circle"></i> {{__('Register')}}
                    </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mt-4 pr-2 d-flex justify-content-end">
                    <p v-show="currentStep===0">
                    <div  class="btn btn-light"
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
