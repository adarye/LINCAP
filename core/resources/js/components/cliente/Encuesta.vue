<template>
    <div>
        <h4 class="display-5 titulo mb-3" v-show="resRA.length">Preguntas con respuesta abierta</h4>
        <article v-for="(dato, i) in resRA" :key="`A-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{dato.cz5_pregunta }}</p>
                </div>
                <div class="col-md-2">
                </div>

            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <textarea rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
                    </textarea>
                </div>
            </div>
        </article>


        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas</h4>
        <article v-for="(item, indice) in  resSMUR" :key="indice" class="my-3">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{ item.cz5_pregunta }}
                    </p>
                </div>
                <div class="col-md-2">
                    
                </div>

                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <input class="flat" type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>
                </div>
            </div>
        </article>


        <h4  class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple respuestas</h4>
        <article v-for="(item3, i) in resSMMR" :key="`o-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>
                
            </div>
            <div class="col-md-12">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                    <input class="flat" type="checkbox" :value="item4.cz8_id">{{ item4.cz8_rta }}
                </article>
            </div>
        </article>


    </div>
</template>
<script>
    import EventBus from '../../bus';
    export default {
        data() {
            return {
                resSMUR: [],
                resRA: [],
                resSMMR: [],
                contador: 1,
                params: null,
                id: null
            };
        },
        mounted() {
            this.id = this.$route.params.id
            this.cargar();
            EventBus.$on('cargar', (item) => {
                this.cargar()
            });

        },
        methods: {
            traerRa() {
                console.log(this.id)
                axios.get(`/api/respuestaA/buscar/${this.id}`)
                    .then(res => {
                        this.resRA = res.data
                        console.log(this.resRA)
                    })
            },
            traerSMMR() {
                console.log(this.id)
                axios.get(`/api/respuestaM/buscar/${this.id}`)
                    .then(res => {
                        this.resSMMR = res.data
                        console.log(this.resSMMR)
                    })
            },
            traerPregunta_SMUR() {
                axios.get(`/api/pregunta/index/${this.id}`)
                    .then(res => {
                        this.resSMUR = res.data
                        console.log(this.resSMUR)
                    })

            },
            contar() {
                this.contador = this.contador + 1
            },
           
            cargar() {
                this.traerSMMR()
                this.traerRa();
                this.traerPregunta_SMUR();
            }
           
        },
        computed: {}
    };

</script>
