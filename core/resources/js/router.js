import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//importacion de vistas
import Index from './views/empleados/Index';
import Show from './views/empleados/Show';

import IndexRoles from './views/roles/Index';
import ShowRoles from './views/roles/Show';
import CreateRoles from './views/roles/Create';

import IndexUsuarios from './views/usuarios/Index';

export default new Router({
    routes: [
        {
            path: '/', name:'IndexEmpleado', component: Index
        },
        {
            path: '/show', name: 'Show', component: Show, props: true
        },
        {
            path:'/roles', name:'Roles', component: IndexRoles, props:true
        },
        {
            path:'/roles/show/:id', name:'ShowRol', component: ShowRoles, props:true
        },
        {
            path:'/roles/create', name:'CreateRol', component: CreateRoles, props:true
        },
        {
            path:'/usuarios', name:'IndexUsuario', component: IndexUsuarios, props:true
        }       
    ]
});