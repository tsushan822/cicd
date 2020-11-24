
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



window.Vue = require('vue');
import VueResource from 'vue-resource/dist/vue-resource.js';
import { Form, HasError, AlertError, AlertErrors } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//register vue plugin with vue
Vue.use(VueResource);


//graph vue component
import Graph from './components/Graph';
import Bar from './components/Bar';
import Bar_with_decimals from './components/Bar_with_decimals';
import Limitsgraph from './components/Limitsgraph';
import Stackedlinegraph from './components/Stackedlinegraph';
import Stackedlinegraphleases from './components/Stackedlinegraphleases';
import Stackedbargraph from './components/Stackedbargraph';
import Stackedbargraph2 from './components/Stackedbargraph2';
import Pie from './components/Pie';
import Pie1 from './components/Pie1';
import Pie2 from './components/Pie2_lease_liability_asset';
import Pie3 from './components/Pie3_lease_type_per_counterparty';
/*import Limitgauge from './components/Limitgauge';
/!*import RadialGauge from './components/RadialGauge';*!/
import RadialGauge from 'vue2-canvas-gauges/src/RadialGauge';*/

const app = new Vue({
    el: '#app',

    //nest graph component
    components: {Stackedlinegraphleases, Pie2, Pie3,}

});
