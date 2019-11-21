import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//importacion de vistas
import Index from './views/Empleado/index';
import Show from './views/Empleado/Show';

Vue.component('Index', Index)

export default new Router({
    routes: [
        {
            path: '/', component: Index
        },
        {
            path: '/show', name: 'Show', component: Show, props: true
        }

       
    ]
});