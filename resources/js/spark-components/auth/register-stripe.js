var base = require('auth/register-stripe');
import customNavigation from '../custom/custom-navigation'
Vue.component('spark-register-stripe', {
    mixins: [base],
    components:{
      'custom-navigation': customNavigation
    },
    data() {
        return {
            steps: [
                {
                    name: 'Company information',
                    active: false,
                    completed_state: false
                },
                {
                    name: 'Select a package',
                    active: false,
                    completed_state: false
                },
                {
                    name: 'Payment details',
                    active: false,
                    completed_state: false
                }

            ],
            currentStep:0,
            customRegistrationPlanSelector:false,
            intialRegisterRequestIsLOading:false,
            monthlyPlanSwitch:false,

        }
    },

    methods: {
        nextStep(){
            this.currentStep= this.currentStep + 1;
        },
        previousStep(){
            (this.currentStep) ?  this.currentStep= this.currentStep-1: this.currentStep=0;
        },
        setActiveStep(){
            this.steps[this.currentStep].active=true
        },
        customSelectedPlan(plan_id, monthlyPlanSwitch){
            if(!monthlyPlanSwitch){
                this.selectedPlan=this.plans[plan_id];
            }
            else{
                this.selectedPlan=this.plans[plan_id+3];
            }
            this.registerForm.customPlanNameRegister=this.selectedPlan.name
            this.registerForm.plan=this.selectedPlan.id
            this.currentStep=2;
        },
        //Validation
        validateRegisterData(){
            this.intialRegisterRequestIsLOading=true;
            let self=this;
            axios.post('/register/rules',{
                team:this.registerForm.team,
                name:this.registerForm.name,
                email:this.registerForm.email,
                password:this.registerForm.password,
                password_confirmation:this.registerForm.password_confirmation
            })
                .then(function (response) {
                    // this.registerForm.errors.forget();
                    if(response.data.errors){
                        self.registerForm.errors.errors=response.data.errors
                    }
                    else{
                        self.registerForm.errors.forget();
                        self.currentStep=1;
                    }
                })
                .catch(function (error) {

                })
                .finally(()=>{
                    self.intialRegisterRequestIsLOading=false;
                    self.selectedPlan=null;
                })
            ;
        },



    },

    mounted(){

    },

    created(){
        this.setActiveStep();
    },

    computed:{
        selectedPackageClass: function () {
          return  this.plans.indexOf(this.selectedPlan)
        }
    }

});