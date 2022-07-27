/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

 window.Vue = require('vue').default;
 
 import ConfirmDialog from "./Mixins/ConfirmDialog.vue";
 import Notification from "./Mixins/Snackbar.vue";
 
 Vue.mixin(ConfirmDialog);
 Vue.mixin(Notification);


 import apexchart from './plugins/apexchart';
 import vuetify from './plugins/vuetify';
 import router from './plugins/router';
 import store from './plugins/store';
 import Axios from './plugins/axios';

 Vue.prototype.$admin = Axios
 
 
 import App from './Layouts/App.vue';
 // import moment from 'moment'
 // Vue.prototype.moment = moment
 
 
 import Vue from "vue";
 import VueQrcodeReader from "vue-qrcode-reader";
 
 Vue.use(VueQrcodeReader);
 
 
 const app = new Vue({
     router,
     store,
     vuetify,
     el: '#app',
     render: h => h(App)
 });
 