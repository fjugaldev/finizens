import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import store from './vuex/store'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
require('./app.scss');

Vue.config.productionTip = false;
Vue.prototype.$http = axios;


new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App},
});

