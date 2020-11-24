<template>
    <div class="col-md-12 pb-5 category_list_area">
        <div class="col-md-12 mb-1 pl-0">
            <h4>Resource Type</h4>
        </div>
        <select v-model="selected" class="browser-default custom-select mb-4">
            <option  value="">All type</option>
            <option v-for="category in mainCategoriesName">
                {{category}}
            </option>
        </select>
        <div  class="col-md-12 mb-2 pl-0">
            <h4>Categories</h4>
        </div>
        <div class="col-md-12 pl-0 d-flex flex-column align-items-start ">
            <div class="custom-control custom-checkbox" v-for="category in subCategories">
                <input type="checkbox" :value="category" v-model="categoryFilter" class="custom-control-input" :id="category">
                <label class="custom-control-label" :for="category" v-text="category"></label>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['categories', 'maincategories'],
        data() {
            return{
                selected: '',
                categoryFilter:[]
            }
        },
        methods: {

        },
        watch:{
            selected: function(value, oldValue){
                this.$emit('filterPosts',value)
            },
            categoryFilter: function(value, oldValue){
                this.$emit('secondLevelCategoryFilter',value)
            }
        },
        mounted() {
        },
        computed: {
            mainCategoriesName: function(){
                return this.maincategories.map((category)=> this.categories[category]);
            },

            subCategories: function(){
                return _.difference(this.categories, this.mainCategoriesName);
            }

        },
        created: function() {

        }
    }
</script>
<style scoped>
.category_list_area h4{
    text-align: left;
    font-size: 1.2rem;
    font-weight: 300;
    color: #2e7097;
}
.custom-control {
    position: relative;
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5rem;
    font-size: 16px;
    line-height: 1.5rem;
    padding-bottom: 1rem;
}
</style>