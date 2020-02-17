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
                <h1 class="titulo">{{ item.cz3_nombre }}</h1>
                <p class="lead">Fecha de Apertura: {{ moment(item.cz3_fecha_apertura ).format('LLL') }} </p>
                <p class="lead">Fecha de Cierre: {{ moment(item.cz3_fecha_cierre ).format('LLL') }} </p>
                <p class="lead">Elaborado(a) por: {{ item.f200_nombres }} {{ item.f200_apellido1 }}
                    {{ item.f200_apellido2 }}</p>
                <hr class="my-4">
                <p>{{ item.cz3_descripcion }}</p>

                <p class="lead" v-show="$route.params.categoria == 1">
                    <router-link class="btn btn-primary btn-lg"
                        v-bind:to="'/presentar/encuesta/' + item.cz3_id +'/'+ id" role="button"
                        v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0 && item.cz4_estado == 0">
                        Presentar</router-link>
                    <router-link class="btn btn-success btn-lg"
                        v-bind:to="'/presentar/encuesta/' +  item.cz3_id +'/'+ id" role="button"
                        v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0 && item.cz4_estado == 1">
                        Continuar</router-link>
                </p>
                <p class="lead" v-show="$route.params.categoria == '2'">
                    <button @click="presentarEva(item.cz3_id)" class="btn btn-primary btn-lg"
                        role="button">Presentar</button>
                </p>

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
            console.log(this.id)
            axios.get(`/api/pruebas/pendientes/${this.$route.params.categoria}`)
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
            presentarEva(prueba) {
                swal({
                        title: "Advertencia",
                        text: "Si te sales despues de estar en la evaluacion, la prueba sera anulada.",
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
