<template>
    <div class="d-none">
    </div>
</template>
<script>
    export default {
        data() {
            return {
                redirectUrl:'https://zentreasuryservice.freshworks.com/login?redirect_uri=https://leaseaccounting.freshdesk.com/freshid/customer_authorize_callback&client_id=78368727158800390&slug=lease'
            }
        },
        methods: {

        },
        mounted(){
            window.location.href=this.redirectUrl;
        },
        created() {

        }
    }
</script>
<style scoped>

</style>