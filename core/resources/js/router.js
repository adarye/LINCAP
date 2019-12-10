import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

//importacion de vistas

//Vista de empleados
import IndexEmpleado from '../views/empleados/Index';

//Vista de trabajadores
import Show from '../views/empleados/Show';
import Certificados from '../views/empleados/Certificados';

//Vistas de roles
import IndexRoles from '../views/roles/Index';

//Vista de usuarios
import IndexUsuarios from '../views/usuarios/Index';

//Vista de 404
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
            path: '/certificados',
            name: 'Certificados',
            component: Certificados,
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