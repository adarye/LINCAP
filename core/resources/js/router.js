import Vue from 'vue';
import Router from 'vue-router';
import VueRouter from 'vue-router';

Vue.use(VueRouter);


//importacion de vistas

//Vista de empleados
import IndexEmpleado from '../views/empleados/Index';
import Activos from '../views/empleados/Activos';
import Retirados from '../views/empleados/Retirados';
import InfCorporativa from '../views/empleados/InfCorporativa';

//Vista de trabajadores
import Show from '../views/empleados/Show';
import Certificados from '../views/empleados/Certificados';

//Vistas de roles
import IndexRoles from '../views/roles/Index';

//Vista de usuarios
import IndexUsuarios from '../views/usuarios/Index';
import RestartPassword from '../views/usuarios/RestartPassword';

//Vista Gestion Pruebas

import IndexGP from '../views/gestion_pruebas/Index';

//Vista de 404
import v404 from '../views/404';

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/empleado/:id',
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
            path: '/empleados/activos',
            name: 'Activos',
            component: Activos                    
        },
        {
            path: '/empleados/retirados',
            name: 'Retirados',
            component: Retirados
            
        },
        {
            path: '/empleados/InfCorporativa',
            name: 'InfCorporativa',
            component: InfCorporativa
            
        },
        {
            path: '/empleados/contrasena',
            name: 'RestartPassword',
            component: RestartPassword
            
        },
        {
            path: '/gestion/pruebas',
            name: 'IndexGP',
            component: IndexGP 
            
        },
        {
            path: '*',
            name:'404',
            component: v404
        }    
    ]
});