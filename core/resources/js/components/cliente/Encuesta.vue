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
                  
                    <textarea :disabled="editar ? false : true" v-model="respuestas_ra[i]"  @change="guardarRA(dato.cz5_id, dato.cz5_gp_id,  dato.cz5_categoria, respuestas_ra[i] )" rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
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
                        <!-- {{respuestas.filter(cz7_id => cz7_id == item.cz7_id )}} -->
                        
                        <input :disabled="editar ? false : true"
                         @click="guardarSMUR(item.cz5_id, item.cz5_gp_id, item2.cz7_id, item.cz5_categoria)" 
                         :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''"  class="flat" type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}                 
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
                    <input 
                    :disabled="editar ? false : true"
                     @click="guardarSMMR(item3.cz5_id, item3.cz5_gp_id, item4.cz8_id, item3.cz5_categoria)" 
                    class="flat" type="checkbox" :checked="respuestas_smmr.filter(cz8_id => cz8_id == item4.cz8_id ) != ''" :value="item4.cz8_id">{{ item4.cz8_rta }}
                </article>
            </div>
        </article>

        <button v-show="editar" @click="finalizar" class="btn btn-danger mt-4" type="button">Finalizar</button>


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
                id: null,
                rta_ra: '',
                respuestas_smur: [],
                respuestas_smmr: [],
                respuestas_ra: [],
                editar:true


            };
        },
        mounted() {
            if(this.$route.params.empleado != user.id){
                this.editar = false
            }
           
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
                this.buscar()
                this.buscarResmur()
                this.buscarResmmr()
                this.buscarRa();
            },
            guardarRA(id_pp, id_gp, categoria, ra){
                console.log(ra)
                 axios.post('/api/respuesta/ra/guardar', {id_gp: id_gp, id_pp: id_pp,  categoria: categoria, rta_ra: ra })
                .then(res =>{
                    console.log(res.data)
                })
            },
            guardarSMUR(id_pp, id_gp, id_rta, categoria){
                axios.post('/api/respuesta/smur/guardar', {id_gp: id_gp, id_pp: id_pp, id_rta:id_rta, categoria: categoria })
                .then(res =>{
                    console.log(res.data)
                })
            },
               guardarSMMR(id_pp, id_gp, id_rta, categoria){
                axios.post('/api/respuesta/smmr/guardar', {id_gp: id_gp, id_pp: id_pp, id_rta:id_rta, categoria: categoria })
                .then(res =>{
                    console.log(res.data)
                })
            },
            buscarResmur(){
                axios.get(`/api/respuesta/smur/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                   
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_smur.push(res.data[i].cz11_rta)
                    }
                     console.log(this.respuestas_smur)
                   
                })
            },
            buscarResmmr(){
                axios.get(`/api/respuesta/smmr/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                   
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_smmr.push(res.data[i].cz11_rta)
                    }
                     console.log(this.respuestas_smmr)
                   
                })
            },
            buscarRa(){
             axios.get(`/api/respuesta/ra/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                    // this.respuestas_ra = res.data
                   
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_ra.push( res.data[i].cz11_rta_ra)
                    }      
                    console.log(this.respuestas_ra)        
                })

            },
             buscar() {
            axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                this.id = res.data.cz3_id
            });
        },
        finalizar(){
            axios.put(`/api/pruebas/finalizar/${this.$route.params.id}`)
            .then(res=>{
                console.log(res.data)
            })
        }
           
        },
        computed: {
           
        }
    };

</script>
