<template>
    <div class=" p-2">
        <vue-headful
            :title="$route.params.cat == 1 ?  'Estadísticas encuesta | ' + titulo:  'Estadísticas evaluación | ' + titulo "
        />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-show=" $route.params.cat == 1" class="breadcrumb-item"><i class="fa fa-pencil">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Encuestas</router-link>
                    </i></li>
                <li v-show=" $route.params.cat == 2" class="breadcrumb-item"><i class="fa fa-file-text">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Evaluaciones</router-link>
                    </i></li>
                <li class="breadcrumb-item">{{titulo}}</li>
                 <li class="breadcrumb-item"><i class="fa fa-bar-chart"> Estadisticas</i></li>

            </ol>
        </nav>
        <div class="col-md-12">
        <CuadroEstadistico></CuadroEstadistico>
        </div>
        <div class="row mt-3">
            <div class="col-md-4  col-sm-2  has-feedback">
                <select v-model="selectSede" @change="filtrar()" class="form-control">
                    <option value="SEDES">SEDES</option>
                    <option v-for="(item, indice) in sedes" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}
                    </option>
                </select>
            </div>
            <div class="col-md-4 mt-1">
                <button class="btn btn-primary" @click="$modal.show('cargos')">Filtrar por cargos</button>
            </div>
        </div>
        
     
        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas
        </h4>
        <div v-for="(item, indice) in  resSMUR" :key="indice" class="my-5">
            <div class="my-4" v-show="chartData != '[]'">
                <div class="row mt-2">
                    <div class="col-md-12 col-center">
                        <center class="alert alert-color">
                            <h2 class="lead title-pregunta">{{ item.cz5_pregunta }}
                            </h2>
                        </center>
                    </div>

                </div>
                <div class="col-md-12">
                    <GChart type="ColumnChart" :data="chartData[indice]" :options="chartOptions"
                        style="width: 100%; height: 100%;" />

                </div>
                <div class="col-md-12">
                    <GChart class="mb-5" type="PieChart" :data="chartData[indice]" :options="chartOptions"
                        style="width: 100%; height: 100%;" />

                </div>
            </div>
        </div>

        <h4 class="display-5 titulo mt-5" v-show=" resSMMR.length">Preguntas de selección multiple con multiple
            respuestas
        </h4>
        <article v-for="(item, i) in  resSMMR" :key="`o-${i}`" class="my-5">

            <div class="row">
                <div class="col-md-12 col-center">
                    <center class="alert alert-color">
                        <h2 class="lead title-pregunta">{{ item.cz5_pregunta }}
                        </h2>
                    </center>
                </div>

            </div>
            <div class="col-md-12">

                <GChart type="ColumnChart" :data="chartData2[i]" :options="chartOptions"
                    style="width: 100%; height: 100%;" />


            </div>
            <div class="col-md-12">
                <GChart type="PieChart" :data="chartData2[i]" :options="chartOptions"
                    style="width: 100%; height: 130%" />
            </div>
        </article>

        <modal name="cargos" :clickToClose="false" :adaptive="true" :width="525" :height="425">
            <div class="table-responsive-md table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col" class="texto">Cargo</th>

                            <th scope="col" class="texto">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, i) in cargos" :key="`o-${i}`">


                            <th scope="row">{{ item.c0763_descripcion }}</th>


                            <td>

                                <input type="checkbox" name="eleccion"
                                    :checked="cargos_filtro.filter(id => id == item.c0763_rowid ) != ''"
                                    @click="incluir(item.c0763_rowid, $event.target.checked)">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-info mt-3" @click="filtrar">
                Filtrar <li class="fa fa-filter"></li>
            </button>
            <button type="button" class="btn btn-danger mt-3" @click="$modal.hide('cargos');">
                Cerrar
            </button>
        </modal>


    </div>
</template>
<script>
    import {
        GChart
    } from 'vue-google-charts'


    export default {
        components: {
            GChart
        },
        data() {
            return {
                id: null,
                resSMMR: [],
                resRA: [],
                resSMUR: [],
                prueba: [],
                datacollection: null,
                chartData: [],
                chartData2: [],
                chartOptions: {

                    chart: {
                        title: 'Estadisticas LINCO',
                        subtitle: ''
                    }
                },
                pregunta: 0,
                sedes: "",
                selectSede: "SEDES",
                cargos: [],
                cargos_filtro: [],
                titulo: "",
                id_log: null
            }
        },
        created() {
            this.id_log = user.id
            this.id = this.$route.params.id
            this.traerPregunta_SMUR()
            this.traerSMMR()

            this.buscar()
            this.buscarSedes()
            this.buscarCargos()
        },
        methods: {
            traerSMMR() {
                axios.get(`/api/respuestaM/buscar/${this.id}`)
                    .then(res => {
                        this.resSMMR = res.data
                        for (var j = 0; j < this.resSMMR.length; j++) {
                            this.chartData2.push([
                                ['Respuestas', 'Trabajadores']
                            ])

                            for (var i = 0; i < res.data[j]['smmr'].length; i++) {
                                this.buscarRes2(res.data[j]['smmr'][i].cz8_id, j, res.data[j]['smmr']
                                    [i].cz8_rta)

                            }

                        }

                    })
            },
            traerPregunta_SMUR() {
                const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Cargando estadisticas...</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false,
                    timer: 10000
                });

                axios.get(`/api/pregunta/index/${this.id}`)
                    .then(res => {
                        this.resSMUR = res.data

                        for (var j = 0; j < this.resSMUR.length; j++) {
                            this.chartData.push([
                                ['Respuestas', 'Trabajadores']
                            ])

                            for (var i = 0; i < res.data[j]['respuestas'].length; i++) {
                                this.buscarRes(res.data[j]['respuestas'][i].cz7_id, j, res.data[j]['respuestas']
                                    [i].cz7_rta)

                            }


                        }

                    })
            },
            buscar() {
                axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                    this.titulo = res.data.cz3_nombre

                });
            },
            buscarRes(id, j, rta) {

                console.log(this.selectSede)
                axios.post('/api/estadistica/buscar/smur', {
                    id: id,
                    co: this.selectSede,
                    cargos: this.cargos_filtro,
                    id_prueba: this.id
                }).then(res => {
                    console.log(res.data)
                    //  this.chartData.push([rta])
                    this.chartData[j].push([rta, res.data])
                });
            },
            buscarRes2(id, j, rta) {
                axios.post('/api/estadistica/buscar/smmr', {
                    id: id,
                    co: this.selectSede,
                    cargos: this.cargos_filtro,
                    id_prueba: this.id
                }).then(res => {

                    this.chartData2[j].push([rta, res.data])
                });
            },
            buscarSedes() {
                axios.get('/api/getCO')
                    .then(res => {
                        this.sedes = res.data
                        console.log(res.data)
                    })
            },
            buscarCargos() {
                axios.get('/api/estadistica/cargar/cargos')
                    .then(res => {
                        this.cargos = res.data

                    })

            },
            filtrar() {
                this.chartData = []
                this.chartData2 = []
                this.traerPregunta_SMUR()
                this.traerSMMR()
            },
            incluir(id, event) {
                if (event == true) {
                    this.cargos_filtro.push(id)
                } else if (event == false) {

                    for (var i = 0; i < this.cargos_filtro.length; i++) {
                        if (this.cargos_filtro[i] === id) {
                            this.cargos_filtro.splice(i, 1);
                        }
                    }

                }
                console.log(this.cargos_filtro)
            }
        },
        computed: {
            cargaFinalizada() {
                if (this.resSMMR.length == this.chartData2.length) {
                    console.log(this.resSMMR.length + ' ' + this.chartData2.length)
                    // swal('Estadisticas','Han sido cargadas correctamente','success')
                }
            }
        }
    }

</script>
