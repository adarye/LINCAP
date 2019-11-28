require('./bootstrap');


import Vue from 'vue';

import router from './router';

//importacion de componentes
import Usuarios from './components/usuarios/Usuarios';
Vue.component('Usuarios', Usuarios)

const app = new Vue ({
    el: '#app',
    router
});