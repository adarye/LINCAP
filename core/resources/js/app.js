require('./bootstrap');

import Vue from 'vue';
import VModal from 'vue-js-modal';
import router from './router';
import swal from 'sweetalert';
Vue.use(VModal)
//Vue.use (VModal , {  dynamic : true ,  dynamicDefaults : {  clickToClose : false } } )      
import VueInputRestrictionDirectives from 'vue-input-restriction-directives';
Vue.use(VueInputRestrictionDirectives);

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