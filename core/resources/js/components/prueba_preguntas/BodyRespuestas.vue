<template>
    <div>
<<<<<<< HEAD
       
        <article v-for="(item, indice) in preguntas" :key="indice">
=======
        <p v-show="resRA.length">Preguntas con respuesta abierta.</p>
        <article v-for="(dato, i) in resRA" :key="`A-${i}`">
>>>>>>> 53d491668783f12a86a0fb3f26782ccaba67d472
            <div class="row mt-2">
                <div class="col-md-8">
                    <p class="lead">{{  dato.cz5_pregunta }}</p>
                </div>
                <a @click="editar(dato)" class="fa fa-pencil float-right" />
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <textarea rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
                    </textarea>
                </div>
            </div>
        </article>
        <p v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas.</p>
        <article v-for="(item, indice) in  resSMUR" :key="indice" class="my-3">
            <div class="row mt-2">
                <div class="col-md-8">
                    <p class="lead">{{ indice  + 1 + '. ' + item.cz5_pregunta }} <a @click="editar(item)" class="fa fa-pencil float-right" /></p>
                     
                </div>
                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <input class="flat" type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>
                </div>
            </div>
        </article>
        <p v-show="resSMMR.length">Preguntas de selección multiple con multiple respuestas.</p>
        <article v-for="(item3, i) in resSMMR" :key="`o-${i}`">
            <div class="row mt-2">
                <div class="col-md-12">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>
<<<<<<< HEAD
            </div>   
=======
            </div>
            <div class="col-md-12">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                    <input class="flat" type="checkbox" :value="item4.cz8_id"> {{ item4.cz8_rta }}
                </article>
            </div>
>>>>>>> 53d491668783f12a86a0fb3f26782ccaba67d472
        </article>
        <modal name="editar" :clickToClose="false" :adaptive="true" :width="450" :height="450">
            <Editar v-on:hide="hide" v-bind="{params : params}">
            </Editar>
        </modal>
    </div>
</template>
<script>
    import EventBus from '../../bus';
    export default {
        props: ["id"],
        data() {
            return {
                resSMUR: [],
                resRA: [],
                resSMMR: [],
                contador: 0,
                params: null
            };
        },
<<<<<<< HEAD
        methods: {      
            cargar() {  
                for (var i in this.preguntas) {                   
                  axios.get(`/api/respuestaS/buscar/${this.preguntas[i].cz5_id}`).then(res => {
                     console.log(res.data);
                    this.respuestas.push(res.data)
                 });              
                }                  
            },
=======
        mounted() {
            this.traerRa();
            this.traerSMMR();
            this.traerPregunta_SMUR();

            EventBus.$on('cargar', (item) => {
                this.traerSMMR()
                this.traerRa();
                this.traerPregunta_SMUR();

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
            editar(dato){
                this.$modal.show('editar')
                this.params = dato
                 console.log(dato)
            },
             hide(){
                 
            this.$modal.hide('editar')
        }
>>>>>>> 53d491668783f12a86a0fb3f26782ccaba67d472
        },
        computed: {}
    };

</script>
