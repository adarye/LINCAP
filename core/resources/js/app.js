require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import router from './router';

Vue.use(VModal)

//importacion de componentes
//import Lista from './components/usuarios/Lista';
//Vue.component('Lista', Lista)

const app = new Vue ({
    el: '#app',
    router
});