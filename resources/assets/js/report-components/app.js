require('./bootstrap');
window.Vue = require('vue');
// If you want to add to window object
Vue.prototype.translate=require('../../../js/VueTranslation/Translation').default.translate;
Vue.component('roles-index', require('./components/ReportGeneration/RolesIndex.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#reportComponentArea',
});
