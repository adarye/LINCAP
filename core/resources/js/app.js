require('./bootstrap');

import Vue from 'vue';

import router from './router';
import swal from 'sweetalert';
//Vue.use(VModal)
import VModal from 'vue-js-modal';
Vue.use(VModal, { dynamic: true, dynamicDefaults: { clickToClose: false, adaptive: true } })

import VueInputRestrictionDirectives from 'vue-input-restriction-directives';
Vue.use(VueInputRestrictionDirectives);

import vClickOutside from 'v-click-outside'
Vue.use(vClickOutside)

//charts

import VueGoogleCharts from 'vue-google-charts'

Vue.use(VueGoogleCharts)

import VueVirtualScroller from 'vue-virtual-scroller'

Vue.use(VueVirtualScroller)

import vueHeadful from 'vue-headful';

Vue.component('vue-headful', vueHeadful);

import excel from 'vue-excel-export'

Vue.use(excel)

import VueExcelXlsx from "vue-excel-xlsx";
Vue.use(VueExcelXlsx);





//AUTORIZACION
window.Vue = require('vue')

//importacion de componentes
import Login from './components/Login';
Vue.component('Login', Login)

import InfPersonal from './components/tabs/InfPersonal';
Vue.component('InfPersonal', InfPersonal)

import InfCorporativa from './components/tabs/InfCorporativa';
Vue.component('InfCorporativa', InfCorporativa)

import ModActivos from './components/gestion_pruebas/ModActivos';
Vue.component('Activos', ModActivos)

import BodyPruebas from './components/gestion_pruebas/BodyPruebas';
Vue.component('Pruebas', BodyPruebas)

import ModRespuestas from './components/prueba_preguntas/ModRespuestas';
Vue.component('MRespuestas', ModRespuestas)

import Respuestas from './components/prueba_preguntas/BodyRespuestas';
Vue.component('Respuestas', Respuestas)

import Editar from './components/prueba_preguntas/EditPregunta';
Vue.component('Editar', Editar)

import InfSST from './components/tabs/InfSST';
Vue.component('InfSST', InfSST)

import BodyNoticias from './components/noticias/BodyNoticias';
Vue.component('BodyNoticias', BodyNoticias)

import CuadroEstadistico from './components/gestion_pruebas/CuadroEstadistico'
Vue.component('CuadroEstadistico', CuadroEstadistico)

import Excel from './components/empleados/Excel'
Vue.component('Excel', Excel)



import autofocus from "vue-autofocus-directive";
Vue.directive("autofocus", autofocus);


// Vue.directive('uppercase', {
//         update(el) {
//             el.value = el.value.toUpperCase()
//         },
//     })
Vue.directive('uppercase', (el, binding) => {
    let processedValue = el.value.toUpperCase();
    el.value = processedValue;
    binding.value = el.value;
});




const app = new Vue({
    el: '#app',
    router

});