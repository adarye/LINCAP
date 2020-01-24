<<template>
    <div class="small">
        Hola

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
                    datacollection: null,
                    prueba: [],
                    array: ['ene', 'feb']

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
