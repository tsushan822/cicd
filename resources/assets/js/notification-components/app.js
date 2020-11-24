require('./bootstrap');
window.Vue = require('vue');
// If you want to add to window object
Vue.component('notification', require('./components/notification.vue').default);
Vue.component('dashboard-loader', require('./components/dashboard-loader.vue').default);
Vue.component('redirect-freshdesk', require('./components/redirectToFreshDesk.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

// set default config
Vue.$cookies.config('500d','','spark.test')
const app = new Vue({
    el: '#notificationArea',
});
