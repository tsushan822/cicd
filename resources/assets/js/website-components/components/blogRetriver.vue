<template>
    <div :class="{'mt-md-4 pt-md-3':!author}">
        <div class="row blog_card_area">
            <div v-if="!author" class="col-lg-3 pl-0 col-md-6 d-none d-md-block col_bg_left boxShadow">
                <div class="input-group input-group-lg">
                    <searchByString @searchResult="showSearchResult"></searchByString>
                    <listByCategory :maincategories="maincategories" :categories="categories" @secondLevelCategoryFilter="secondLevelCategoryFilter" @filterPosts="filterPostsByCategory"></listByCategory>

                </div>

            </div>
            <blogPostLoader :authorslug="authorslug" :author="author" ref="childBlogPostLoader" @activateObserver="activateObserver()" @turnOffObserver="disconnectObserver"></blogPostLoader>
            <div v-show="intersectionHtmlTag" ref="loading_more" id="intersection_id"></div>
        </div>
    </div>

</template>
<script>
    import blogPostLoader from './sub-components/blog-post-loader.vue'
    import listByCategory from './sub-components/listByCategory.vue'
    import searchByString from './sub-components/searchByString.vue'
    export default {
        components:{blogPostLoader, listByCategory, searchByString},
        props:['categories', 'maincategories','author','authorslug'],
        data() {
            return {
                observer:null,
                blogLoaderCounter:1,
                allBlogHasBeenLoaded:false,
                intersectionHtmlTag:false,
            }
        },
        methods: {
            activateIntersectionObserver(){
                const options = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 1.0
                };
                this.observer = new IntersectionObserver((element)=>{
                  if(element[0].isIntersecting && !this.allBlogHasBeenLoaded){
                      this.blogLoaderCounter++;
                  }
                }, options);
                this.observer.observe(this.$refs.loading_more);
            },
            disconnectObserver(){
                this.allBlogHasBeenLoaded=true;
            },
            activateObserver(){
                this.intersectionHtmlTag=true;
                this.activateIntersectionObserver();

            },
            filterPostsByCategory(category){
                this.$refs.childBlogPostLoader.filterByCategory=category;
            },
            //second level category filter
            secondLevelCategoryFilter(category){
                this.$refs.childBlogPostLoader.categoryFilter=category;
            },
            showSearchResult(result){
                this.$refs.childBlogPostLoader.searchresult=result;
            }

        },
        watch:{
            blogLoaderCounter: function(value, oldValue){
                this.$refs.childBlogPostLoader.loadMoreBlogs(value);
            }
        },
        mounted() {

        },
        created: function() {

        }
    }
</script>
<style scoped>
    #intersection_id{
        position:absolute;
        bottom:0;
    }
    .boxShadow{
        box-shadow: 1px 1px 1px #e3ecee;
    }
    .col_bg_left{
        background: #fcfbfb8f;
    }
</style>