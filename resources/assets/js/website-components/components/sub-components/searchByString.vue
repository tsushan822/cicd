<template>
    <div class="col-md-12 mt-5 pb-5 mb-1">
        <input v-model="searchInput" type="text" id="exampleForm2" placeholder="Search new and tips.." class="form-control">
        <div v-if="loading" class="spinner-border custom-spinner"></div>
        <small class="d-flex mt-1 " v-if="searchHasReturnedEmptyResult">Noting found from the search criteria!</small>
    </div>
</template>
<script>
    export default {
        data() {
            return{
                searchInput:'',
                loading:false,
                searchHasReturnedEmptyResult:false,
            }
        },
        methods: {
            searchBlogPost: _.debounce(function(){
                this.loading=true;
                let self=this;
                axios.get('/blog-search', {
                    params: {
                        search: self.searchInput,
                    }
                })
                    .then(response => {
                     if(!response.data.length){
                         self.searchHasReturnedEmptyResult=true;
                     }
                     self.$emit('searchResult',response.data);
                     self.loading=false;
                    });
            },700)
        },
        watch:{
            searchInput: function(value, oldValue){
                if(value ===''){
                    this.$emit('searchResult',[]);
                    this.searchHasReturnedEmptyResult=false;
                }
                else{
                    this.searchHasReturnedEmptyResult=false;
                    this.searchBlogPost(value);
                }
            }
        },
        mounted() {
        },
        created: function() {

        }
    }
</script>
<style scoped>
    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
        color:#2e7097;
        opacity: 1; /* Firefox */
    }

    :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: #2e7097;
    }
    .custom-spinner{
        position: absolute;
        top: 10px;
        right: 22px;
        color: #008cde;
        width:1rem;
        height:1rem;
    }
</style>