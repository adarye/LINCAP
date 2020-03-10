<template>
    <div>
        <vue-headful
            :title="$route.params.categoria == 1 ?  'Lincap | Encuestas completadas':  'Lincap | Evaluaciones completadas ' "
        />
        

        <div v-for="(item, indice) in pruebas" :key="indice">
            <div class="card my-4">
                <div class="card-header">
                    <h4 class="titulo"> {{ item.cz3_nombre }}
                        <span v-show="categoria == 2">
                    <li :class="item.cz4_calificacion >= 3.5 ? 'fa fa-thumbs-up':'fa fa-thumbs-down' "></li>
                    <span :class="item.cz4_calificacion >= 3.5 ? 'badge badge-success':'badge badge-danger'">{{Math.round((item.cz4_calificacion*100))/100}} </span>
                
                        </span>
                        

                      <span class="badge badge-pill badge-danger float-right p-1"
                    v-show=" moment().diff(item.cz3_fecha_cierre) > 0">
                    <p class="lead">Cerrada</p>
                </span>
                <span class="badge badge-pill badge-success float-right p-1"
                    v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0">
                    <p class="lead">Abierta</p>
                </span>
                <span class="badge badge-pill badge-warning float-right p-1"
                    v-show=" moment().diff(item.cz3_fecha_apertura) < 0">
                    <p class="lead">Proximamente</p>
                </span>
                
                </h4>
                   
                </div>
                <div class="card-body">
                    <h5 class="card-title"> {{item.cz3_descripcion}} <button class="btn btn-sm btn-info" v-show="$route.params.categoria == 2" title="Ver estado" @click="obtenerEstado(item.cz3_id)"> <i style="" class="fa fa-search-plus"  ></i></button></h5> 
                    <p class="card-text">Fecha de Apertura: <b>{{ moment(item.cz3_fecha_apertura ).format('LLL') }}</b></p>
                     <p class="card-text">Fecha de Cierre:<b> {{ moment(item.cz3_fecha_cierre ).format('LLL') }}</b></p>
                     <p class="card-text">
                     Elaborado(a) por: <b>{{ item.f200_nombres }} {{ item.f200_apellido1 }}
                    {{ item.f200_apellido2 }}
                    </b>
                    </p>
                    <p class="card-text">Key:<b> {{item.cz3_id}}</b></p>
                    <p class="lead mt-2" v-show="$route.params.categoria == 1">
                        <router-link class="btn btn-primary btn"
                            v-bind:to="'/presentar/encuesta/' + item.cz3_id +'/'+ id" role="button"
                            v-show="moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0 && item.cz4_estado == 0">
                            Presentar</router-link>
                        <router-link class="btn btn-success"
                            v-bind:to="'/presentar/encuesta/' +  item.cz3_id +'/'+ id" role="button"
                            v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0 && item.cz4_estado == 1">
                            Continuar</router-link>
                    </p>
                    <p class="lead mt-2" v-show="$route.params.categoria == '2'">
                        <button @click="presentarEva(item.cz3_id)" class="btn btn-primary btn" role="button"
                            v-show="moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0 && item.cz4_estado == 0">Presentar</button>
                    </p>
                </div>
            </div>
            

        </div>
         <center>

            <div v-show="carga  && pruebas.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-show="carga == false  && pruebas.length == []">
                <h1 v-show="categoria == 1">No tienes encuestas completadas en este momento</h1>
            <h1 v-show="categoria == 2">No tienes evaluaciones completadas en este momento</h1>
            </div>
        </center>

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
                moment: moment,
                categoria: null,
                id: null,
                carga: true
                
            }
        },

        mounted() {
            this.categoria = this.$route.params.categoria
            axios.get(`/api/pruebas/completadas/${this.categoria}`)
                .then(res => {
                    this.pruebas = res.data
                
                })
                setTimeout(
                _ => this.carga = false,
                10000
            )
        },
        methods: {
            obtenerEstado(id){
                axios.get(`/api/pruebas/completadas/estado/${id}`)
                .then(res=>{
                    if(res.data >= 1 ){
                    swal('Advertencia',   res.data + ' pregunta(s) restante(s) por calificar', 'warning')
                    }
                     else if (res.data == 0 ){
                    swal('Correcto', 'Ya esta totalmente calificada', 'success')
                    }
                })
            }

        }
    }

</script>
