<template>
    <div>
       <div class="nav_back" v-show="stepnumber!==0" @click="previousStep()">
            <i class="fa fa-arrow-left"></i> Back
        </div>
        <div class="step-number"><span v-text="stepnumber+1"></span>/3</div>
        <h3 v-text="currentStep.title"></h3>
        <div class="sub" v-text="currentStep.subTitle"></div>
    </div>
</template>
<script>
    export default {
        props:['stepnumber'],
        data() {
            return {
                steps:[
                    {
                        title:'Try LeaseAccounting.app for 30 days',
                        subTitle:'We just need a few details'
                    },
                    {
                        title:'Try LeaseAccounting.app for 30 days',
                        subTitle:'please select a package'

                    },
                    {
                        title:'Try LeaseAccounting.app for 30 days',
                        subTitle:'please provide card details'

                    }
                ]
            }
        },
        methods: {
            previousStep(){
                this.$emit('previous-step');
            }
        },
        mounted() {

        },
        created: function() {

        },
        computed: {
            currentStep: function(){
                let currentStep = this.steps[this.stepnumber];
                if(this.stepnumber === 0){
                    currentStep.showNavigation = false;
                    return currentStep;
                }
                else{
                    currentStep.showNavigation = false;
                    return currentStep;
                }
            }
        }
    }
</script>
<style scoped>

</style>