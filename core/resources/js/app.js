require('./bootstrap');

import Vue from 'vue';

import router from './router';
import swal from 'sweetalert';
//Vue.use(VModal)
import VModal from 'vue-js-modal';
Vue.use (VModal , {  dynamic: true ,  dynamicDefaults: {  clickToClose: false } } ) 

import VueInputRestrictionDirectives from 'vue-input-restriction-directives';
Vue.use(VueInputRestrictionDirectives);

import vClickOutside from 'v-click-outside'
Vue.use(vClickOutside)

//importacion de componentes
import Login from './components/Login';
Vue.component('Login', Login)

import InfPersonal from './components/tabs/InfPersonal';
Vue.component('InfPersonal', InfPersonal)

import InfCorporativa from './components/tabs/InfCorporativa';
Vue.component('InfCorporativa', InfCorporativa)

import InfSST from './components/tabs/InfSST';
Vue.component('InfSST', InfSST)


Vue.directive('uppercase', {
	update (el) {
		el.value = el.value.toUpperCase()
	},
})


const app = new Vue ({
    el: '#app',
    router
   
    
});