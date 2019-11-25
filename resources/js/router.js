import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//importacion de vistas
import Index from './views/empleados/Index';
import Show from './views/empleados/Show';

import IndexRoles from './views/roles/Index';
import ShowRoles from './views/roles/Show';


Vue.component('Index', Index)

export default new Router({
    routes: [
        {
            path: '/', component: Index
        },
        {
            path: '/show', name: 'Show', component: Show, props: true
        },
        {
            path:'/roles', name:'Roles', component: IndexRoles, props:true
        },
        {
            path:'/roles/show', name:'ShowRol', component: ShowRoles, props:true
        }


       
    ]
});