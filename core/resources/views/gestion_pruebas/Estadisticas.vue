<<template>
    <div class="small">
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
                <div class="col-md-6">
                    <GChart type="ColumnChart" :data="chartData[indice]" :options="chartOptions" />

                </div>
                <div class="col-md-6">
                    <GChart class="mb-5" type="PieChart" :data="chartData[indice]" :options="chartOptions" />

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

                <GChart type="ColumnChart" :data="chartData2[i]" :options="chartOptions" />
                <GChart type="PieChart" :data="chartData2[i]" :options="chartOptions" />

            </div>


        </article>


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
                            title: 'Encuesta LINCO',
                            subtitle: ''
                        }
                    },
                    pregunta: 0
                }
            },
            created() {
                this.id = this.$route.params.id
                this.traerSMMR()
                this.traerPregunta_SMUR()
                this.buscar()
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

                    });
                },
                buscarRes(id, j, rta) {
                    axios.get(`/api/estadistica/buscar/smur/${id}`).then(res => {
                        //  this.chartData.push([rta])
                        this.chartData[j].push([rta, res.data])
                    });
                },
                buscarRes2(id, j, rta) {
                    axios.get(`/api/estadistica/buscar/smmr/${id}`).then(res => {
                        console.log(res.data)
                        this.chartData2[j].push([rta, res.data])
                    });
                }
            }
        }

    </script>
