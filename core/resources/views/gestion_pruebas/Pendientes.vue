<template>
    <div>
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-if=" $route.params.categoria == 1" class="breadcrumb-item"><i class="fa fa-pencil">
                    </i>  Encuestas
                    </li>
                <li v-if=" $route.params.categoria == 2" class="breadcrumb-item"><i class="fa fa-file-text">
                      </i> Evaluaciones
                    </li>
                 <li class="breadcrumb-item"><i class="fa fa-clock-o"></i> <router-link v-bind:to="'/pruebas/pendientes/' + $route.params.categoria"> Pendientes</router-link></li>
                 <li class="breadcrumb-item active" aria-current="page"></li>

            </ol>
        </nav>
        <vue-headful
            :title="$route.params.categoria == 1 ?  'Lincap | Encuestas pendientes':  'Lincap | Evaluaciones pendientes ' " />

        <div v-for="(item, indice) in pruebas" :key="indice">
            <div class="card my-4">
                <div class="card-header">
                    <h4 class="titulo"> {{ item.cz3_nombre }}
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
                    <h5 class="card-title"> {{item.cz3_descripcion}} </h5>
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
                <div v-show="pruebas == '' && categoria == 1" class="jumbotron shadow-lg p-3 mb-5 bg-white rounded">
                    <h1>No tienes encuestas en este momento</h1>
                </div>
                <div v-show="pruebas == '' && categoria == 2 " class="jumbotron shadow-lg p-3 mb-5 bg-white rounded">
                    <h1>No tienes evaluaciones en este momento</h1>
                </div>
            </div>
        </center>

    </div>
</template>
<script>
    import moment from "moment";
    moment.locale("es");
    import router from '../../js/router'

    export default {

        data() {
            return {
                pruebas: [],
                fecha_actual: '',
                moment: moment,
                id: null,
                categoria: "",
                carga: true
            }
        },

        beforeMount() {
            this.id = user.id
            this.categoria = this.$route.params.categoria
            axios.get(`/api/pruebas/pendientes/${this.$route.params.categoria}`)
                .then(res => {
                    this.pruebas = res.data
                })
            setTimeout(
                _ => this.carga = false,
                2000
            )
        },
        methods: {
            presentarEva(prueba) {
                swal({
                        title: "Advertencia",
                        text: "Si te sales o recargas la pagina después de estar en la evaluación, la prueba sera anulada.",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true
                    })
                    .then(willDelete => {
                        if (willDelete) {

                            router.push('/presentar/evaluacion/' + prueba + '/' + this.id)
                        }


                    })
            }

        }
    }

</script>
