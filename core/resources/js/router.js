import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//importacion de vistas
import IndexEmpleado from '../views/empleados/Index';
import Show from '../views/empleados/Show';

import IndexRoles from '../views/roles/Index';


import IndexUsuarios from '../views/usuarios/Index';

import v404 from '../views/404';

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'showEmpleado',
            component: Show,
            props: true
        },       
        {
            path: '/empleados',
            name: 'IndexEmpleado',
            component: IndexEmpleado,
            props: true
        },
        {
            path: '/show',
            name: 'Show',
            component: Show,
            props: true
        },
        {
            path: '/roles',
            name: 'Roles',
            component: IndexRoles,
        },      
        {
            path: '/usuarios',
            name: 'IndexUsuario',
            component: IndexUsuarios
            
        }, 
        {
            path: '*',
            component: v404
        }    
    ]
});