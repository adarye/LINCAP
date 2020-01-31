<<template>
    <div class="small">       
        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas</h4>
        <article v-for="(item, indice) in  resSMUR" :key="indice" class="my-3">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{ item.cz5_pregunta }}
                    </p>
                </div>
                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <input class="flat" type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>
                </div>
            </div>
        </article> 
        <GChart type="ColumnChart" :data="chartData[0]" :options="chartOptions" />
        <GChart type="ColumnChart" :data="chartData[1]" :options="chartOptions" />
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
                    chartData : [[
                        ['Pregunta', 'Trabajadores'],
                        ['Si', 10],
                        ['No', 8]],
                        [
                        ['Pregunta', 'Trabajadores'],
                        ['Si', 19],
                        ['No', 100]]
                    ],
                    chartOptions: {
                        chart: {
                            title: 'Encuesta LINCO',
                            subtitle: '',
                        }
                    }
                }
            },
            mounted() {
                this.id = this.$route.params.id
                this.traerSMMR()
                this.traerRa()
                this.traerPregunta_SMUR()
                this.buscar()
            },
            methods: {
                traerRa() {
                    axios.get(`/api/respuestaA/buscar/${this.id}`)
                        .then(res => {
                            this.resRA = res.data
                        })
                },
                traerSMMR() {
                    axios.get(`/api/respuestaM/buscar/${this.id}`)
                        .then(res => {
                            this.resSMMR = res.data
                        })
                },
                traerPregunta_SMUR() {
                    axios.get(`/api/pregunta/index/${this.id}`)
                        .then(res => {
                            this.resSMUR = res.data
                            console.log(res.data[0]['respuestas'].length)
                            for (var i = 0; i < res.data[0]['respuestas'].length; i++) {
                                this.prueba.push(res.data[0]['respuestas'][0].cz7_rta)
                            }
                        })
                },
                buscar() {
                    axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {

                    });
                }
            }
        }

    </script>
