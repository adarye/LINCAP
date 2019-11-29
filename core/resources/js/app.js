require('./bootstrap');


import Vue from 'vue';

import router from './router';

//importacion de componentes
import Lista from './components/usuarios/Lista';
Vue.component('Lista', Lista)

const app = new Vue ({
    el: '#app',
    router
});