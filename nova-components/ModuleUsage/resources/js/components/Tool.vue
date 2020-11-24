<template>
    <div>
        <div>
            <heading class="mb-3">Module Usage Per Customer</heading>
        </div>

        <div >

            <div class="flex flex-wrap -mx-3 mb-3">
                <div class="px-3 mb-6 mt-4 w-1/3" v-for="item in clientsList">
                    <div class="card relative metric px-6 py-4 relative">
                        <!---->
                        <div class="flex mb-4">
                            <h3 class="mr-3 text-base text-80 font-bold">{{item.name}}</h3>
                            <!---->
                        </div>

                        <div class=" ">
                                <p class="module_name" v-text="item.module.name"></p>
                                <progress-bar  :bg-color="color(item.module.available_number, item.module.module_usage)"  size="medium" :val="percentageCalculator(item.module.available_number, item.module.module_usage)" :text="bartext(item.module.available_number, item.module.module_usage)" ></progress-bar>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
    import ProgressBar from 'vue-simple-progress'

    export default {
        components: {
            ProgressBar
        },
        data() {
            return {
                clientsList:[],
                loading:true

            }
        },
        methods: {


            color(noOfContracts, usedContracts){

                if(usedContracts > noOfContracts){

                    return "red";
                }

            },

            bartext(noOfContracts, usedContracts){

                return usedContracts.toString()+'/'+ noOfContracts;

            },

            percentageCalculator(noOfContracts, usedContracts){

                noOfContracts=parseInt(noOfContracts);

                usedContracts=parseInt(usedContracts);

                if(usedContracts<noOfContracts){

                    return parseInt((usedContracts/noOfContracts)*100);
                }
                else if(usedContracts>noOfContracts){

                    return parseInt(100/(usedContracts/noOfContracts));
                }

            }

        },
        created() {
            let self=this;
            Nova.request().get('/getclientsinfo').then(response => {
                response.data.forEach(function(element){
                    console.log(element);
                    self.clientsList.push({
                        name: element.name,
                        module: element.module
                    });
                },self);
                console.log(self.clientsList);

            })

        },
        watch: {},

        computed: {},

        mounted() {
            //

        },
    }
</script>

<style>
    /* Scoped Styles */
    .module_name{
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 8px;
    }
</style>
