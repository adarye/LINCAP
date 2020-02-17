<template>
    <div>
        

        <div v-for="(item, indice) in pruebas" :key="indice">
            <div class="jumbotron shadow-lg p-3 mb-5 bg-white rounded">
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
                <h1 class="titulo">{{ item.cz3_nombre }}</h1><h4 v-show="categoria == 2"><button class="badge badge-primary" @click="obtenerEstado(item.cz3_id)">Ver estado</button></h4>
               
               

                <h4 v-show="item.cz4_calificacion >= 3.5">
                    <li class="fa fa-thumbs-up"></li>
                    <span class="badge badge-success">{{Math.round((item.cz4_calificacion*100))/100}} </span>
                    
                </h4>

                <h4 v-show="item.cz4_calificacion < 3.5 && categoria == 2">
                    <li class="fa fa-thumbs-down"></li> <span
                        class="badge badge-danger">{{Math.round((item.cz4_calificacion*100))/100}}
                    </span>
                </h4>
                <p class="lead">Fecha de Apertura: {{ moment(item.cz3_fecha_apertura ).format('LLL') }} </p>
                <p class="lead">Fecha de Cierre: {{ moment(item.cz3_fecha_cierre ).format('LLL') }} </p>
                <p class="lead">Elaborado(a) por: {{ item.f200_nombres }} {{ item.f200_apellido1 }}
                    {{ item.f200_apellido2 }}</p>
                <hr class="my-4">
                <p>{{ item.cz3_descripcion }}</p>

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
                    console.log(this.pruebas)
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
                    console.log(res.data)
                    if(res.data >= 1 ){
                    swal('En proceso', 'Solo hace falta ' + res.data + ' pregunta(s) por calificar')
                    }
                     else if (res.data == 0 ){
                    swal('Calificada', 'Ya esta totalmente calificada')
                    }
                })
            }

        }
    }

</script>
