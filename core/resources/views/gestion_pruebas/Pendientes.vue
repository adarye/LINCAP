<template>
<div>
    <div v-if="pruebas == '' " class="jumbotron shadow-lg p-3 mb-5 bg-white rounded"><h1>No tienes encuestas en este momento</h1></div>
<div v-for="(item, indice) in pruebas" :key="indice">
    <div class="jumbotron shadow-lg p-3 mb-5 bg-white rounded">
        <span class="badge badge-pill badge-danger float-right p-1" v-show=" moment().diff(item.cz3_fecha_cierre) > 0"><p class="lead">Cerrada</p></span>
         <span class="badge badge-pill badge-success float-right p-1" v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0"><p class="lead">Abierta</p></span>
         <span class="badge badge-pill badge-warning float-right p-1" v-show=" moment().diff(item.cz3_fecha_apertura) < 0"><p class="lead">Proximamente</p></span>
        <h1>{{ item.cz3_nombre }}</h1>
        <p class="lead">Fecha de Apertura: {{ moment(item.cz3_fecha_apertura ).format('LLL') }} </p>
          <p class="lead">Fecha de Cierre: {{ moment(item.cz3_fecha_cierre ).format('LLL') }} </p>
          <p class="lead">Elaborado(a) por: {{ item.f200_nombres }} {{ item.f200_apellido1 }} {{ item.f200_apellido2 }}</p>
        <hr class="my-4">
        <p>{{ item.cz3_descripcion }}</p>
        
        <p class="lead">
            
               <router-link class="btn btn-primary btn-lg" v-bind:to="'/presentar/encuesta/'+ item.cz3_id " role="button" v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0">Presentar</router-link>
               
        </p>
        
    </div>
    
</div>

</div>
</template>
<script>
import moment from "moment";
    moment.locale("es");
    export default {
        data() {
            return {
                pruebas: [],
                fecha_actual: '',
                moment: moment
            }
        },

        mounted() {           
            axios.get(`/api/pruebas/pendientes/${this.$route.params.categoria}`)
                .then(res => {
                    this.pruebas = res.data               
                })
        },
        methods:{
            
        }
    }

</script>
