<template>
        <div  :class="{'col-md-12':author, 'col-lg-9 col-md-6': !author}">
            <div class="col-md-12 number-of-tips-area" :class="{'justify-content-center mb-5':author}" >Showing <strong class="ml-1 mr-1" v-text="filteredPostByCategoryName.length"></strong> news and tips to you</div>
            <transition-group  name="fade" class="row row-eq-height">
                    <article v-if="filteredPostByCategoryName.length"  v-for="(blog,index) in filteredPostByCategoryName" class="mb-5" :class="{'col-md-3':author, 'col-lg-4 col-md-12': !author}" :key="blog.id">
                        <div  class="card post-preview  borderRemoval borderRadiusRemoval lift h-100">
                            <a :href="`/articles/${blog.slug}`">
                                <img :src="blog.featured_image" :alt="blog.title" class="img-fluid">
                                <div class="card-body">
                                    <h5 class="card-title text-left" v-text="blog.title"></h5>
                                    <div class="text-left">
                                        <p v-text="wordExcerpt(blog.body)"></p>
                                    </div>
                                </div>
                            </a>
                            <a :href="`/author/${blog.author.slug}`">
                                <div class="card-footer">
                                    <div class="post-preview-meta">
                                        <img :src="blog.author.avatar" :alt="blog.author.name" class="post-preview-meta-img">
                                        <div class="post-preview-meta-details">
                                            <div class="post-preview-meta-details-name text-left" v-text="blog.author.name"></div>
                                            <div class="post-preview-meta-details-date text-left" v-text="dateFormat(blog.publish_date)"></div>
                                            <div class="post-preview-meta-details-read-time pt-1 text-left"><span v-text="readCounter(blog.body)"></span> mins read</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </article>
                </transition-group>
            <div class="row noting_found_area" v-if="!filteredPostByCategoryName.length">
                <div class="col-md-12 noting_found_area_col d-flex align-items-center justify-content-center">
                    <h3 class="page-header-title text-dark">Noting Found!</h3>
                </div>
            </div>
            <div class="row" v-show="this.searchresult.length === 0">
                <div class="col-md-12">
                    <div v-if="loading" class="d-flex justify-content-center ">
                        <strong class="mr-2">Loading news and tips</strong>
                        <div class="spinner-border custom-spinner-load-more" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    export default {
        props:['author','authorslug'],
        data() {
            return {
                blogs:[],
                loading:false,
                firstIterationOfBlogPostsIsDone:false,
                filterByCategory:'',
                categoryFilter:[],
                searchresult:[]
            }
        },
        methods: {
            loadMoreBlogs: function(pageNumber){
                this.loading=true;
                let self=this;
                axios.get('/blog', {
                    params: {
                        ajax: true,
                        page:pageNumber,
                        author:(self.author)? self.authorslug: 'nonAuthor'
                    }
                })
                    .then(response => {
                        self.blogs=_.concat(self.blogs,response.data.data.posts.data);
                        self.loading=false;
                        if(response.data.data.posts.next_page_url === null){
                            self.turnOffObserverOfParentComponent();
                        }
                        if(!self.firstIterationOfBlogPostsIsDone){
                            this.$emit("activateObserver");
                            self.firstIterationOfBlogPostsIsDone=true;
                        }
                    });
            },
            turnOffObserverOfParentComponent(){
                this.$emit("turnOffObserver");
            },

            readCounter(text){
               let stringWithoutHtmlTags=  text.replace(/(<([^>]+)>)/gi, '');
               let wordCount= stringWithoutHtmlTags.split(' ').length;
               return Math.ceil(wordCount / 200)
            },

            dateFormat(date){
                let d = new Date(date);
                let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
                let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
                let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
                return (`${da} ${mo}, ${ye}`)
            },
            //return first 10 words
            wordExcerpt(text){
               let stringWithoutHtmlTags=text.replace(/(<([^>]+)>)/gi, '');
               let firstTenWords=stringWithoutHtmlTags.split(' ').splice(0,10).join(" ");
               return firstTenWords+ '...';
            }

        },

        mounted() {
        },
        created: function() {
            this.loadMoreBlogs(1);
        },
        computed:{
            filteredPostByCategoryName: function(){

                let blogsToShow= (this.searchresult.length) ? this.searchresult : this.blogs;

                if(this.filterByCategory === ""){
                    if(this.categoryFilter.length){
                        return blogsToShow.filter(blog=> {
                            let allTagsOfABlog=blog.tags.map(tag=>tag.name);
                            let categoryDiffernceBetweenArrays= _.difference(this.categoryFilter, allTagsOfABlog);
                            if(_.isEqual(this.categoryFilter, categoryDiffernceBetweenArrays)){
                                return false;
                            }
                            return true;
                        });
                    }
                    return blogsToShow;

                }
                else{
                    let firstLevelBlogPostsByCategory= blogsToShow.filter(blog=>{
                        let allTagsOfABlog=blog.tags.map(tag=>tag.name)
                        if(allTagsOfABlog.indexOf(this.filterByCategory)>-1){
                            return true
                        }
                        return false;
                    })
                    if(this.categoryFilter.length){
                        return firstLevelBlogPostsByCategory.filter(blog=> {
                            let allTagsOfABlog=blog.tags.map(tag=>tag.name);
                            let categoryDiffernceBetweenArrays= _.difference(this.categoryFilter, allTagsOfABlog);
                            if(_.isEqual(this.categoryFilter, categoryDiffernceBetweenArrays)){
                                return false;
                            }
                            return true;
                        });
                    }
                    return firstLevelBlogPostsByCategory;

                }
            }
        }
    }
</script>
<style scoped>
.preloader-wrapper{
    position: absolute;
    left: 42%;
    bottom: 0;
}
.card-body{
    min-height: 200px;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
    .noting_found_area_col{
        min-height:300px;
    }
.custom-spinner-load-more{
    width: 1rem;
    height: 1rem;
    color: #008cde;
}
    .number-of-tips-area{
        font-size: 1.2rem;
        display: flex;
        margin-bottom: 1rem;
        font-weight: 300;
        font-family: Nunito;
    }
</style>