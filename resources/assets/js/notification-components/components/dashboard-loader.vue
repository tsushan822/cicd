<template>
    <div class="d-none">
    </div>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            checkEnvironmentReadiness(){
                let self=this;
                axios
                    .get('/check-new-environment-is-ready')
                    .then(function (response) {
                        (response.data==='ready') ? self.reloadDashBoardPage(): '';
                    })
            },
            reloadDashBoardPage(){
                window.location.reload();
            }

        },
        mounted(){

        },
        created() {
            setInterval(() => {
                this.checkEnvironmentReadiness();
            },500)
        }
    }
</script>
<style scoped>

</style>