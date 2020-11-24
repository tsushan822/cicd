var base = require('settings/subscription');
import customNavigation from '../custom/custom-navigation'
Vue.component('spark-subscription', {
    mixins: [base],
    components:{
        'custom-navigation': customNavigation
    },
    data() {
        return {
            plan:  [{"name":"Basic","initial_lease":20,"price":199,"selected":true},
                {"name":"Professional","initial_lease":50,"price":399,"selected":false},
                {"name":"Business","initial_lease":400,"price":699,"selected":false}
            ],
            add_ons: [],
            custom_services: [],
            custom_subscription_type: false,
            custom_selected_plan: null,
            custom_selected_add_ons: [],
            custom_services_selected_services: [],
            number_of_additional_lease: 0,
            add_ons_expansion: false,
            services_expansion: false,
            subscriptionButtonLoading: false,
            watchActiveSubscription:null,
            customResumingPlanLoading:false,
            customerNeedsNewPlan:false,
            activeSubscriptionIsLoading:true,
            customSolutionForLeaseAccounting:true,
            monthlyPlanSwitch:false,

        };
    },
    methods: {
        selectThisPlan(index) {
            this.custom_selected_plan = false;
            this.plan.map(plan => plan.selected = false)
            this.plan[index].selected = true;
            this.custom_selected_plan = this.plan[index];
            this.number_of_additional_lease = 0;
        },
        add_ons_calculate() {
            if (this.custom_subscription_type) {
                return Number(this.custom_selected_add_ons.reduce((accumulator, currentValue) => accumulator + currentValue.price, 0) * 10);
            }
            return Number(this.custom_selected_add_ons.reduce((accumulator, currentValue) => accumulator + currentValue.price, 0));

        },
        services_calculate() {
            if (this.custom_subscription_type) {
                return Number(this.custom_services_selected_services.reduce((accumulator, currentValue) => accumulator + currentValue.price, 0) * 10);
            }
            return Number(this.custom_services_selected_services.reduce((accumulator, currentValue) => accumulator + currentValue.price, 0));

        },
        addOnsExpansion() {
            this.add_ons_expansion = !this.add_ons_expansion;
        },
        servicesExpansion() {
            this.services_expansion = !this.services_expansion;
        },
        customCalculateAmount() {
            if (this.custom_selected_plan) {
                let planPrice = (this.custom_subscription_type) ? Number(this.custom_selected_plan.price * 10) : Number(this.custom_selected_plan.price);
                let additionaLeasePrice = (this.custom_subscription_type) ? Number(this.number_of_additional_lease * (.5 *10)): Number(this.number_of_additional_lease * .5);
                let addOnsPrice = this.add_ons_calculate();
                let servicePrice = this.services_calculate();
                let totalCost= Number(parseFloat(planPrice + additionaLeasePrice + addOnsPrice + servicePrice).toFixed(2));
                let totalCostWithTax= Number(parseFloat(totalCost+ (totalCost * (this.team.custom_tax_rate/100))).toFixed(2));

                return totalCostWithTax;

            }
        },
        selectPlan(plan) {
            this.plans.push(plan);
            this.$refs.subscribeComponentRef.selectPlan(plan);
        },

        customResumeSubscription(){
            this.customResumingPlanLoading=true;
            this.$refs.subscribeComponentRef.updateSubscription(this.activePlan);
            setTimeout(() => this.customResumingPlanLoading=false, 5000);
        },

        setEditView(activePlan){
            this.custom_subscription_type= !(activePlan.period==='month');
            this.custom_selected_plan=this.plan.filter(plan=>{
                return plan.name===activePlan.plan_name
            })[0];
            this.custom_selected_add_ons=JSON.parse(activePlan.add_ons).filter(e=>e.checked).map(e=>{
                e.checked=false;
                return e;
            });
            this.custom_services_selected_services=JSON.parse(activePlan.services).filter(e=>e.checked).map(e=>{
                e.checked=false;
                return e;
            });
            this.number_of_additional_lease=activePlan.number_of_leases;
            this.watchActiveSubscription= activePlan
        },

        activeSubscriptionDataSetter(){
            let self=this;
            axios.get("/settings/teams/" + this.team.id + "/subscription/activeplan/get", {
                params: {
                    plan_id:self.activeSubscription.provider_plan
                }

            }).then(function (response) {
                self.setEditView(response.data);
            }).finally(() => {
                self.activeSubscriptionIsLoading=false
            });
        },

        customerNeedsNewPlanButtonClick(){
            this.customerNeedsNewPlan=true;
        },

        backToactiveSubscription(){
            /*this.customerNeedsNewPlan=false;
            this.setEditView(this.watchActiveSubscription);*/
            window.location.reload()
        },
        createSubscription() {
            let self = this;
            this.subscriptionButtonLoading = true;
            axios.post("/settings/teams/" + this.team.id + "/subscription/create", {
                amount: self.customCalculateAmount(),
                interval: (self.custom_subscription_type) ? 'year' : 'month',
                number_of_leases: self.number_of_additional_lease,
                team_id: self.team.id,
                plan_name: self.custom_selected_plan.name,
                add_ons:JSON.stringify(self.custom_selected_add_ons),
                services:JSON.stringify(self.custom_services_selected_services)
            }).then(function (response) {
                let plan = response.data;
                plan.id = response.data.plan_id;
                //self.selectPlan(plan);
                self.updateSubscription(plan.id);
            }).finally(() => {
                self.subscriptionButtonLoading = false;
                self.backToactiveSubscription();
            });
        },
        switchCustomSubscription(){
            let self = this;
            this.subscriptionButtonLoading = true;
            axios.post("/settings/teams/" + this.team.id + "/subscription/create", {
                amount: self.customCalculateAmount(),
                interval: (self.custom_subscription_type) ? 'year' : 'month',
                number_of_leases: self.number_of_additional_lease,
                team_id: self.team.id,
                plan_name: self.custom_selected_plan.name,
                add_ons:JSON.stringify(self.custom_selected_add_ons),
                services:JSON.stringify(self.custom_services_selected_services)
            }).then(function (response) {
                let plan = response.data;
                plan.id = response.data.plan_id;
                /* self.selectPlan(plan);
                 self.updateSubscription(plan);*/
                self.updateSubscription(plan);
            }).finally(() => {
                /* self.subscriptionButtonLoading = false;
                 self.backToactiveSubscription();*/
                // self.reloadCurrentPage();
            });
        },

        reloadCurrentPage(){
            window.location.reload();
        },

        setInitialData(){
            let self=this;
            this.activeSubscriptionIsLoading=true
            axios.get('/settings/subscription/info')
                .then(response => {
                    self.$nextTick(()=>{
                        //self.plan = response.data.plan;
                        self.add_ons = response.data.add_ons;
                        self.custom_services = response.data.custom_services;
                        self.custom_selected_plan = self.plan.filter(plan => {
                            return plan.selected
                        })[0];
                        self.activeSubscriptionDataSetter();
                    });
                })
        }

    },
    watch:{
        activeSubscription: function(value,OldValue){
            this.activeSubscriptionDataSetter();
        }
    },
    async mounted() {},
    created(){
        this.setInitialData();
        Bus.$on('canceledSubscription', ()=>{});
    },
    computed: {
        pricing_text: function () {
            if (this.custom_selected_plan) {
                if (this.custom_subscription_type) {
                    let priceString = String(this.custom_selected_plan.price * 10);
                    return priceString + '/year';
                }
                return String(this.custom_selected_plan.price) + '/month';
            }
        },
        computedTotal() {
            //
            if (this.custom_selected_plan) {
                let planPrice = (this.custom_subscription_type) ? Number(this.custom_selected_plan.price * 10) : Number(this.custom_selected_plan.price);
                let additionaLeasePrice = (this.custom_subscription_type) ? Number(this.number_of_additional_lease * .5 * 10) : Number(this.number_of_additional_lease * .5);
                let addOnsPrice = this.add_ons_calculate();
                let servicePrice = this.services_calculate();
                let totalCost= Number(parseFloat(planPrice + additionaLeasePrice + addOnsPrice + servicePrice).toFixed(2));
                let totalCostWithTax= Number(parseFloat(totalCost+ (totalCost * (this.team.custom_tax_rate/100))).toFixed(2));
                return totalCostWithTax;

            }
        },

        computedtoTalWithOutTax(){
            if (this.custom_selected_plan) {
                let planPrice = (this.custom_subscription_type) ? Number(this.custom_selected_plan.price * 10) : Number(this.custom_selected_plan.price);
                let additionaLeasePrice = (this.custom_subscription_type) ? Number(this.number_of_additional_lease * .5 * 10) : Number(this.number_of_additional_lease * .5);
                let addOnsPrice = this.add_ons_calculate();
                let servicePrice = this.services_calculate();
                return  Number(parseFloat(planPrice + additionaLeasePrice + addOnsPrice + servicePrice).toFixed(2));

            }
        },

        computedPriceBreakDown() {
            if (this.custom_selected_plan) {
                let priceBreakDown = {
                    add_ons: [],
                    services: [],
                    selected_plan: {},
                    additional_lease: 0
                };
                priceBreakDown['add_ons'] = this.custom_selected_add_ons.map(e => {
                    return {
                        name: e.name,
                        price: e.price,
                    }
                });
                priceBreakDown['services'] = this.custom_services_selected_services.map(e => {
                    return {
                        name: e.name,
                        price: e.price,
                    }
                });
                priceBreakDown['selected_plan'] = this.custom_selected_plan;

                priceBreakDown['additional_lease'] = this.number_of_additional_lease;

                //testing this.team.custom_tax_rate
                priceBreakDown['custom_tax_rate'] = this.team.custom_tax_rate ;

                return priceBreakDown;
            }
        }

    }
});
