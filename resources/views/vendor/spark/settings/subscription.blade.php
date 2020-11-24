<spark-subscription :user="user" :team="team" :billable-type="billableType" inline-template>
    <div>
        <div @click="testingupdatesubscription()"></div>
        <div v-show="!activeSubscriptionIsLoading" class="card card-default">
            @include('spark::settings.subscription.subscription-notice')
            <div v-show="needsSubscription || customerNeedsNewPlan" class="row equal calculator_area">
                <div class="col-md-8 left_area" style="padding: 20px 20px;">
                    <div class="col-md-12 left_top_area">
                        <div class="left_top_area_holder d-flex justify-content-between">
                            <h5 v-if="needsSubscription && !customerNeedsNewPlan">Paid Plan</h5>
                            <h5 v-if="!needsSubscription && customerNeedsNewPlan">Switch Paid Plan</h5>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="custom_subscription_type" class="custom-control-input"
                                       id="customSwitch2">
                                <label class="custom-control-label" for="customSwitch2">Yearly</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 lease_number">
                        <div class="row">
                            <div class="col-md-4 " v-for="(plan,index) in plan" @click="selectThisPlan(index)"
                                 :key="index">
                                <div class="form_type" :class="{'form_type_selected':plan.name===custom_selected_plan.name}">
                                    <p v-text="plan.name"></p>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <p class="compare_plan_button_modal_area">
                                    <span>Don't know which package is best for you?</span>
                                    <button class="btn ml-1" data-toggle="modal" data-target="#exampleModalLong">Compare package</button></p>
                            </div>
                        </div>
                        <div class="col-md-12 lease_number">
                            <small v-if="custom_selected_plan"><span v-text="custom_selected_plan.initial_lease"></span>
                                leases included in <span v-text="custom_selected_plan.name"></span> package which starts
                                at $<span v-text="pricing_text"></span>. 1$ per 2 additional Leases.
                            </small>
                            <div class="d-flex mb-1 justify-content-between">
                                <h5>Select number of additional leases</h5>
                                <input disabled type="number" v-model="number_of_additional_lease">
                            </div>
                            <input v-model="number_of_additional_lease" type="range" min="0" step="0" max="500"
                                   class="custom-range">
                            <div class="d-flex justify-content-between">
                                <small>0</small>
                                <small>500</small>
                            </div>
                        </div>
                        <div v-show="0" class="col-md-12 lease_number">
                            <h5>Add-ons</h5>
                            <div class="d-flex justify-content-between">
                                <small>Customize and enhance your paid plan with additional features.</small>
                                <a data-toggle="collapse" href="#collapseExample1" role="button"
                                   aria-expanded="false" aria-controls="collapseExample1" @click="addOnsExpansion()"><i
                                            class="fa fa-minus" v-if="add_ons_expansion"></i><i class="fa fa-plus"
                                                                                                v-else></i></a>
                            </div>
                            <div class="collapse" id="collapseExample1">
                                <div class="list-group checkbox-list-group">
                                    <div class="list-group-item-add-on" v-for="(add_on,index) in add_ons" :key="index">
                                        &nbsp;<label><input type="checkbox" :id="add_on.name" :value="add_on"
                                                            v-model="custom_selected_add_ons"><span
                                                    class="list-group-item-text"><i class="fa fa-fw"></i> <span
                                                        v-text="add_on.name"></span> </span>

                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show="0" class="col-md-12 lease_number">
                            <h5>Recommended service</h5>
                            <div class="d-flex justify-content-between">
                                <small>Upgrade your paid plan with these premium services for expert help and guidance.
                                </small>
                                <a @click="servicesExpansion()" data-toggle="collapse" href="#collapseExample2"
                                   role="button"
                                   aria-expanded="false" aria-controls="collapseExample2"><i class="fa fa-minus"
                                                                                             v-if="services_expansion"></i><i
                                            class="fa fa-plus" v-else></i></a>
                            </div>
                            <div class="collapse" id="collapseExample2">
                                <div class="list-group checkbox-list-group">
                                    <div class="list-group-item-add-on"
                                         v-for="(custom_service,index) in custom_services " :key="index">
                                        &nbsp;<label><input type="checkbox" :id="custom_service.name"
                                                            :value="custom_service"
                                                            v-model="custom_services_selected_services"><span
                                                    class="list-group-item-text"><i
                                                        class="fa fa-fw"></i> <span
                                                        v-text="custom_service.name"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 right_area">
                    <a v-if="customerNeedsNewPlan" v-on:click.prevent="backToactiveSubscription()" href="/main" class="list-group-item text-primary  unsetDefaulBgAndBorder text-transform-uppercase list-group-item-action" style="
    text-decoration: underline;
    font-size: 16px;
"><i class="fa fa-arrow-left mt-1 mb-3 pt-1 mr-2"></i>Go back to current paid plan</a>
                    <div class="col-md-12 form_type form_type_selected">
                        <div class="final_calculation">
                            <h5 style="font-weight: normal; text-transform: uppercase">BILLED <span
                                        v-if="custom_subscription_type">Annualy</span> <span v-else>Monthly</span></h5>
                            <h2 style="font-weight: normal;"><span v-text="computedTotal"></span><span
                                        v-if="custom_subscription_type">$/yr</span> <span v-else>$/mo</span></h2>
                            {{-- <p style="font-weight: normal;">ESTIMATED COST TO GET STARTED:</p>
                             <p style="font-weight: normal;">$441.60</p>--}}
                            <button v-if="!customerNeedsNewPlan" @click="createSubscription()" class="btn btn-primary mb-2">
                                <span v-if="!subscriptionButtonLoading">Select</span>
                                <span v-else><i class="fa fa-btn fa-spinner fa-spin"></i> Selecting </span>
                            </button>
                            <button v-else-if="customerNeedsNewPlan" @click="switchCustomSubscription()" class="btn btn-primary mb-2">
                                <span v-if="!subscriptionButtonLoading">Switch</span>
                                <span v-else><i class="fa fa-btn fa-spinner fa-spin"></i> Switching </span>
                            </button>
                            <a data-toggle="modal" data-target="#exampleModalCenter" style="text-decoration: underline">
                                <p>View subscription fee breakdown</p></a>
                            <small><i class="fa fa-asterisk "></i> <span v-text="computedPriceBreakDown.custom_tax_rate"></span>% tax rate is applied on total price</small>
                        </div>
                    </div>
                    <div class="col-md-12 form_type form_type_selected">
                        <div class="final_calculation">
                            <small>We've estimated your monthly cost based on the options you've chosen above. Any
                                applicable taxes are not included, and your subscription fee are subject to increase with additional
                                purchases.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            {{-- --}}{{--End hubspot}}--}}

            <div v-show="!customerNeedsNewPlan" v-if="subscriptionIsOnGracePeriod || subscriptionIsActive" class="total_estimate px-3 py-3">
                <div class="pricing_estimate d-flex justify-content-between px-3">
                    <h5 class="mb-0">Current Active subscription</h5>
                    <div class="d-flex justify-content-right">
                        <button :disabled="customResumingPlanLoading" v-if="subscriptionIsOnGracePeriod"
                                @click="customResumeSubscription()" class=" ml-1 btn  btn-plan btn-warning">
                            <span v-if="!customResumingPlanLoading">Resume subscription</span>
                            <span v-else><i class="fa fa-btn fa-spinner fa-spin"></i> Resuming </span>
                        </button>

                        <button @click="customerNeedsNewPlanButtonClick()" class=" ml-1 btn-default  btn-outline-primary"><i class="fa fa-plus"></i>Switch plan
                        </button>
                    </div>
                </div>
                <div v-if="subscriptionIsOnGracePeriod">
                    <div class="mx-3 py-2">
                        <?php echo __('You have cancelled your subscription to the :planName plan.', ['planName' => '{{ activePlan.name }} ({{ activePlan.interval | capitalize }})']); ?>
                    </div>

                    <div class="mx-3 mb-4">
                        <?php echo __('The benefits of your subscription will continue until your current billing period ends on :date. You may resume your subscription at no extra subscription fee until the end of the billing period.', ['date' => '{{ activeSubscription.ends_at | date }}']); ?>
                    </div>
                </div>
                <div class="recurring_fees px-3 py-1">
                    <h6 class="text-uppercase">Recurring Subscription fees</h6>
                    <div class="recurring_fees_calculation d-flex justify-content-between">
                        <div class="text_left">
                            <p class="mb-0">LeaseAccounting.app <span
                                        v-text="computedPriceBreakDown.selected_plan.name"></span> (<span
                                        v-text="computedPriceBreakDown.selected_plan.initial_lease"></span> lease
                                included)</p>
                        </div>
                        <div class="text_right">
                            <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                        v-text="parseFloat(computedPriceBreakDown.selected_plan.price*10).toFixed(2)+ '$/yr'"></span>
                            </h6>
                            <h6 class="mt-0 mb-0" v-else><span
                                        v-text="parseFloat(computedPriceBreakDown.selected_plan.price).toFixed(2)+ '$/mo'"></span>
                            </h6>
                            <small v-if="custom_subscription_type">(Billed yearly)</small>
                            <small v-else>(Billed monthly)</small>
                        </div>
                    </div>
                </div>

                <div v-if="computedPriceBreakDown.additional_lease">
                    <div class="recurring_fees px-3 py-1">
                        <div class="recurring_fees_calculation d-flex justify-content-between">
                            <div class="text_left">
                                <p class="mb-0"
                                   v-text="computedPriceBreakDown.additional_lease+' additional leases'"></p>
                            </div>
                            <div class="text_right">
                                <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                            v-text="parseFloat(computedPriceBreakDown.additional_lease * .5 * 10).toFixed(2)+ '$/yr'"></span>
                                </h6>
                                <h6 class="mt-0 mb-0" v-else><span
                                            v-text="parseFloat(computedPriceBreakDown.additional_lease * .5).toFixed(2)+ '$/mo'"></span>
                                </h6>
                                <small v-if="custom_subscription_type">(Billed yearly)</small>
                                <small v-else>(Billed monthly)</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="recurring_fees px-3 py-1" v-for="add_ons in computedPriceBreakDown.add_ons">
                    <div class="recurring_fees_calculation d-flex justify-content-between">
                        <div class="text_left">
                            <p class="mb-0" v-text="add_ons.name"></p>
                        </div>
                        <div class="text_right">
                            <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                        v-text="parseFloat(add_ons.price*10).toFixed(2)+ '$/yr'"></span></h6>
                            <h6 class="mt-0 mb-0" v-else><span
                                        v-text="parseFloat(add_ons.price).toFixed(2)+ '$/mo'"></span></h6>
                            <small v-if="custom_subscription_type">(Billed yearly)</small>
                            <small v-else>(Billed monthly)</small>
                        </div>
                    </div>
                </div>

                <div class="recurring_fees px-3 py-1" v-for="services in computedPriceBreakDown.services">
                    <div class="recurring_fees_calculation d-flex justify-content-between">
                        <div class="text_left">
                            <p class="mb-0" v-text="services.name"></p>
                        </div>
                        <div class="text_right">
                            <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                        v-text="parseFloat(services.price*10).toFixed(2)+ '$/yr'"></span></h6>
                            <h6 class="mt-0 mb-0" v-else><span
                                        v-text="parseFloat(services.price).toFixed(2)+ '$/mo'"></span></h6>
                            <small v-if="custom_subscription_type">(Billed yearly)</small>
                            <small v-else>(Billed monthly)</small>
                        </div>
                    </div>
                </div>

                <div class="recurring_fees_calculation px-3 py-1 d-flex justify-content-between">
                    <div class="text_left">
                        <p class="mb-0" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                            Estimated tax on total (<span v-if="computedPriceBreakDown" v-text="computedPriceBreakDown.custom_tax_rate"></span>% of <span v-text="computedtoTalWithOutTax"></span>$)
                        </p>
                    </div>
                    <div class="text_right">
                        <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                    v-text="parseFloat((computedtoTalWithOutTax) * (computedPriceBreakDown.custom_tax_rate/100)).toFixed(2) + '$/yr'"></span>
                        </h6>
                        <h6 class="mt-0 mb-0" v-else><span
                                    v-text="parseFloat((computedtoTalWithOutTax) * (computedPriceBreakDown.custom_tax_rate/100)).toFixed(2)+ '$/mo'"></span>
                        </h6>
                        <small v-if="custom_subscription_type">(Billed yearly)</small>
                        <small v-else>(Billed monthly)</small>
                    </div>
                </div>

                <hr class="mb-3">

                <div class="recurring_fees px-3 py-1">
                    <div class="recurring_fees_calculation d-flex justify-content-between">
                        <div class="text_left">
                            <p class="mb-0" v-if="custom_subscription_type">Yearly subscription fee</p>
                            <p class="mb-0" v-else>Monthly subscription fee</p>
                        </div>
                        <div class="text_right">
                            <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                        v-text="computedTotal.toFixed(2) + '$/yr'"></span></h6>
                            <h6 class="mt-0 mb-0" v-else><span v-text="computedTotal.toFixed(2)+ '$/mo'"></span></h6>
                            <small v-if="custom_subscription_type">(Billed yearly)</small>
                            <small v-else>(Billed monthly)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="plans.length > 0">
                <!-- Trial Expiration Notice -->

                <!-- New Subscription -->
                <div v-if="needsSubscription">
                    @include('spark::settings.subscription.subscribe')
                </div>

                <!-- Update Subscription -->
                <div v-show="!customSolutionForLeaseAccounting" v-if="subscriptionIsActive">
                    @include('spark::settings.subscription.update-subscription')
                </div>

                <!-- Resume Subscription -->
                <div v-show="!customSolutionForLeaseAccounting" v-if="subscriptionIsOnGracePeriod">
                    @include('spark::settings.subscription.resume-subscription')
                </div>

                <!-- Cancel Subscription -->
                <div v-show="!customerNeedsNewPlan"  v-if="subscriptionIsActive">
                    @include('spark::settings.subscription.cancel-subscription')
                </div>
            </div>

            <!-- Plan Features Modal -->
            @include('spark::modals.plan-details')

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body" style="    background-color: #fff !important;
    color: #252422 !important;">
                            <div class="total_estimate px-3 py-3">
                                <div>
                                    <div class="pricing_estimate d-flex justify-content-between px-3">
                                        <h5>Pricing Estimate</h5>
                                        <button type="button" class="close d-flex mt-1" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="recurring_fees px-3 py-1">
                                        <h6 class="text-uppercase">Recurring Subscription fees</h6>
                                        <div class="recurring_fees_calculation d-flex justify-content-between">
                                            <div class="text_left">
                                                <p class="mb-0">LeaseAccounting.app <span
                                                            v-text="computedPriceBreakDown.selected_plan.name"></span>
                                                    (<span v-text="computedPriceBreakDown.selected_plan.initial_lease"></span>
                                                    lease included)</p>
                                            </div>
                                            <div class="text_right">
                                                <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                            v-text="parseFloat(computedPriceBreakDown.selected_plan.price*10).toFixed(2)+ '$/yr'"></span>
                                                </h6>
                                                <h6 class="mt-0 mb-0" v-else><span
                                                            v-text="parseFloat(computedPriceBreakDown.selected_plan.price).toFixed(2)+ '$/mo'"></span>
                                                </h6>
                                                <small v-if="custom_subscription_type">(Billed yearly)</small>
                                                <small v-else>(Billed monthly)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="computedPriceBreakDown.additional_lease">
                                        <div class="recurring_fees px-3 py-1">
                                            <div class="recurring_fees_calculation d-flex justify-content-between">
                                                <div class="text_left">
                                                    <p class="mb-0"
                                                       v-text="computedPriceBreakDown.additional_lease+' additional leases'"></p>
                                                </div>
                                                <div class="text_right">
                                                    <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                                v-text="parseFloat(computedPriceBreakDown.additional_lease * .5 * 10).toFixed(2)+ '$/yr'"></span>
                                                    </h6>
                                                    <h6 class="mt-0 mb-0" v-else><span
                                                                v-text="parseFloat(computedPriceBreakDown.additional_lease * .5).toFixed(2)+ '$/mo'"></span>
                                                    </h6>
                                                    <small v-if="custom_subscription_type">(Billed yearly)</small>
                                                    <small v-else>(Billed monthly)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="recurring_fees px-3 py-1" v-for="add_ons in computedPriceBreakDown.add_ons">
                                        <div class="recurring_fees_calculation d-flex justify-content-between">
                                            <div class="text_left">
                                                <p class="mb-0" v-text="add_ons.name"></p>
                                            </div>
                                            <div class="text_right">
                                                <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                            v-text="parseFloat(add_ons.price*10).toFixed(2)+ '$/yr'"></span>
                                                </h6>
                                                <h6 class="mt-0 mb-0" v-else><span
                                                            v-text="parseFloat(add_ons.price).toFixed(2)+ '$/mo'"></span>
                                                </h6>
                                                <small v-if="custom_subscription_type">(Billed yearly)</small>
                                                <small v-else>(Billed monthly)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="recurring_fees px-3 py-1"
                                         v-for="services in computedPriceBreakDown.services">
                                        <div class="recurring_fees_calculation d-flex justify-content-between">
                                            <div class="text_left">
                                                <p class="mb-0" v-text="services.name"></p>
                                            </div>
                                            <div class="text_right">
                                                <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                            v-text="parseFloat(services.price*10).toFixed(2)+ '$/yr'"></span>
                                                </h6>
                                                <h6 class="mt-0 mb-0" v-else><span
                                                            v-text="parseFloat(services.price).toFixed(2)+ '$/mo'"></span>
                                                </h6>
                                                <small v-if="custom_subscription_type">(Billed yearly)</small>
                                                <small v-else>(Billed monthly)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="recurring_fees_calculation px-3 py-1 d-flex justify-content-between">
                                        <div class="text_left">
                                            <p class="mb-0" data-toggle="tooltip" data-placement="right" title="Tooltip on right">
                                                Estimated tax on total (<span v-if="computedPriceBreakDown" v-text="computedPriceBreakDown.custom_tax_rate"></span>% of <span v-text="computedtoTalWithOutTax"></span>$)
                                            </p>
                                        </div>
                                        <div class="text_right">
                                            <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                        v-text="parseFloat((computedtoTalWithOutTax) * (computedPriceBreakDown.custom_tax_rate/100)).toFixed(2) + '$/yr'"></span>
                                            </h6>
                                            <h6 class="mt-0 mb-0" v-else><span
                                                        v-text="parseFloat((computedtoTalWithOutTax) * (computedPriceBreakDown.custom_tax_rate/100)).toFixed(2)+ '$/mo'"></span>
                                            </h6>
                                            <small v-if="custom_subscription_type">(Billed yearly)</small>
                                            <small v-else>(Billed monthly)</small>
                                        </div>
                                    </div>

                                    <hr class="mb-3">

                                    <div class="recurring_fees px-3 py-1">
                                        <div class="recurring_fees_calculation d-flex justify-content-between">
                                            <div class="text_left">
                                                <p class="mb-0" v-if="custom_subscription_type">Yearly subscription fee</p>
                                                <p class="mb-0" v-else>Monthly subscription fee</p>
                                            </div>
                                            <div class="text_right">
                                                <h6 class="mt-0 mb-0" v-if="custom_subscription_type"><span
                                                            v-text="computedTotal + '$/yr'"></span></h6>
                                                <h6 class="mt-0 mb-0" v-else><span v-text="computedTotal+ '$/mo'"></span>
                                                </h6>
                                                <small v-if="custom_subscription_type">(Billed yearly)</small>
                                                <small v-else>(Billed monthly)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="footer_text px-5 py-5">
                                        <small>
                                            We've estimated your monthly subscription fee based on the options you've chosen. Any
                                            applicable taxes are not included, and your subscription fees are subject to increase with
                                            additional purchases.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer px-5">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            @include('vendor.spark.modals.plan-compare')

        </div>
        <div v-show="activeSubscriptionIsLoading" class="card card-default custom_loader_card">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="spinner-border  text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</spark-subscription>
