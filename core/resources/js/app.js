require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import router from './router';
import swal from 'sweetalert';
import VueDropdown from 'vue-dynamic-dropdown';

Vue.use(VModal)

//importacion de componentes
import Login from './components/Login';
Vue.component('Login', Login)



const app = new Vue ({
    el: '#app',
    router
});