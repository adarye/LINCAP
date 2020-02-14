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
import EstadisticasGP from '../views/gestion_pruebas/Estadisticas';
import Pendientes from '../views/gestion_pruebas/Pendientes';
import Completadas from '../views/gestion_pruebas/Completadas';
import Encuesta from '../js/components/cliente/Encuesta';
import Evaluacion from '../js/components/cliente/Evaluacion';
import Asignacion from '../js/components/gestion_pruebas/ModActivos'
import AdministrarEvaluacion from '../js/components/admin/Evaluacion';

//Vista preguntas 
import IndexPreguntas from '../views/prueba_preguntas/Index.vue';

//Vista de noticias
import IndexNoticias from '../views/noticias/Index.vue';

//Vista de 404
import v404 from '../views/404';


export default new Router({
    mode: 'history',
    routes: [{
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
            path: '/gestion/pruebas/:categoria',
            name: 'IndexGP',
            component: IndexGP

        },
        {
            path: '/gestion/prueba/estadistica/:cat/:id',
            name: 'EstadisticasGP',
            component: EstadisticasGP

        },
        {
            path: '/pruebas/pendientes/:categoria',
            name: 'Pendientes',
            component: Pendientes

        },

        {
            path: '/pruebas/completadas/:categoria',
            name: 'Completadas',
            component: Completadas

        },
        {
            path: '/gestion/pruebas/asignar/:cat/:id',
            name: 'Asignacion',
            component: Asignacion

        },
        {
            path: '/prueba/preguntas/:cat/:id',
            name: 'IndexPreguntas',
            component: IndexPreguntas
        },
        {
            path: '/presentar/encuesta/:id/:empleado',
            name: 'Presentar',
            component: Encuesta
        },
        {
            path: '/presentar/evaluacion/:id/:empleado',
            name: 'PresentarEvaluacion',
            component: Evaluacion
        },
        {
            path: '/administrar/evaluacion/:id/:empleado',
            name: 'AdministrarEvaluacion',
            component: AdministrarEvaluacion
        },
        {
            path: '/',
            name: 'IndexNoticias',
            component: IndexNoticias
        },
        {
            path: '*',
            name: '404',
            component: v404
        }
    ]
});