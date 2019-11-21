require('./bootstrap');


import Vue from 'vue';

import router from './router';

//importacion de componentes
import Registros from './components/Registros';
Vue.component('Registros', Registros)

const app = new Vue ({
    el: '#app',
    router
});