require('./bootstrap');
window.Vue = require('vue');
// If you want to add to window object
Vue.component('slide-component', require('./components/textSlide').default);
Vue.component('report-reveal-component', require('./components/reportRevealer.vue').default);
Vue.component('blog-retrival-component', require('./components/blogRetriver.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});
