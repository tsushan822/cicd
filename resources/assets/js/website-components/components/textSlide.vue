<template>
    <div>
        <div class="slider_content pb-5">
            <div class="content_ui content_ui_padding text-black">
                <div class="mb-4 pt-4 h3-title">How it works</div>
                <p class="page_paragraph pb-2">Manage your leases from anywhere and store data securely in the Cloud.</p>
                <div class="page-header-content">
                    <div class="row">
                        <div class="col-lg-6 silder_list_images">
                            <img :class="currentSelectedImage(index)" v-for="(img, index) in sliders" :src="img.src" :key="index" class="img-fluid"  :alt="img.title">
                        </div>
                        <div class="col-lg-6">
                            <ul class="text_slide_ul">
                                <li v-on:mouseover="selectSliderItemOnHover(index)" @mouseleave="turnOffHoverState(index)"  @click="changeSliderItem(index)" :class="currentSelectedSlider(index)"  v-for=" (slider, index) in sliders" :key="index"  v-html="slider.title"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                sliders:[
                    {
                        title:'<p>Simple and powerful dashboard to show you the <b>big</b> picture.</p>',
                        src:'/img/compressed/dashboard_img-min.png',
                    },
                    {
                        title:'<p>Manage all your <b>leases</b> in one place, in one simple register.</p>',
                        src:'/img/compressed/dashboard_img_2-min.png',
                    },
                    {
                        title:'<p>All lease details within <b>one</b> view</p>',
                        src:'/img/compressed/dashboard_img_3-min.png',
                    },
                    {
                        title:'<p>Simple reports to help you create all the needed notes for your <b>financial</b> reporting</p>',
                        src:'/img/compressed/dashboard_img_3-min.png',

                    },

                ],
                selectedItem:0,
                hoverState:true,
            }
        },
        methods: {
            currentSelectedSlider(index){
                return {
                     selected: Boolean(index===this.selectedItem),
                }
            },
            currentSelectedImage(index){
                return{
                    opacityOne: (index===this.selectedItem)
                }
            },
            changeItem(){
                if(!this.hoverState){
                    if(this.selectedItem+1 < this.sliders.length){
                        this.selectedItem++;
                    }
                    else{
                        this.selectedItem=0;
                    }
                }
            },
            changeSliderItem(index){
                this.selectedItem=index;
            },
            //mouse enter
            selectSliderItemOnHover:_.debounce(function(index){
                this.selectedItem=index;
                this.hoverState=true;
            },50),
            //mouse leave
            turnOffHoverState(index) {
                //change to false
                this.hoverState = true;
            },
            },
        mounted() {

        },
        created: function() {
            var self = this;
            setInterval(()=>{
                this.changeItem();
            }, 5000);
        }
    }
</script>
<style scoped>
    .topBar {
        border-bottom: 1px solid #f1f1f1;
        margin-bottom: 5px;
    }

    .dropdown_ara_fix {
        max-height: 300px;
        overflow: scroll;
        width: 232px !important;
    }

    .notification_list_item {
        margin: 3px 0px;
    }

    .notifications_listing {
        cursor: pointer
    }

    .single_notification_item_text_area {
        font-size: 12px;
    }

    .notifications_listing_text_block:hover {
        text-decoration: underline;
    }

    .notifications_listing_text_block {
        display: inline;
    }

    .badge:hover {
        text-decoration: none !important;
    }

    .cusrsorPointer {
        cursor: pointer;
    }
    .silder_list_images{
        position:relative;
    }
    .silder_list_images img{
        position:relative;
        top:0;
        left:0;
        opacity:0;
        transition:display 300ms ease 0ms;
        display:none;
    }
    .opacityOne{
        opacity:1 !important;
        display:block !important;
    }
    .content_ui_padding{
        padding-bottom: 6rem !important;
    }

</style>