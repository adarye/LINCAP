<template>
    <div>
        <h4 class="display-5 titulo mb-3" v-show="resRA.length">Preguntas con respuesta abierta</h4>
        <article v-for="(dato, i) in resRA" :key="`A-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{dato.cz5_pregunta }}</p>
                </div>
                <div class="col-md-2">
                    <button @click="editar(dato)" class="fa fa-pencil float-right btn-sm btn-primary" />
                    <button @click="eliminar(dato.cz5_id)" class="fa fa-trash float-right btn-sm btn-danger"></button>
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
                    <button @click="editar(item)" class="fa fa-pencil float-right btn-sm btn-primary" />
                    <button @click="eliminar(item.cz5_id)" class="fa fa-trash float-right btn-sm btn-danger" />
                </div>

                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <input :checked="item2.cz7_id == item2.cz7_rta_correcta" class="flat" type="radio" @click="guardarSMURcorrecta(item2)" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>
                </div>
            </div>
        </article>


        <h4  class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple respuestas</h4>
        <article v-for="(item3, indice) in resSMMR" :key="`o-${indice}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>
                <div class="col-md-2">
                    <button @click="editar(item3)" class="fa fa-pencil float-right btn-sm btn-primary" />
                    <button @click="eliminar(item3.cz5_id)" class="fa fa-trash float-right btn-sm btn-danger" />
                </div>
            </div>
            <div class="col-md-12">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                    <input v-model="inputs[indice]"  :disabled="inputs[indice].length >= item3.cz5_n_rtas_correctas && inputs[indice].indexOf(item4.cz8_id) === -1"   @click="guardarSMMRcorrecta(item4,item4.cz8_id == item4.cz8_rta_correcta)"  class="flat" type="checkbox" :value="item4.cz8_id" >{{ item4.cz8_rta }}
                    <!-- :checked="item4.cz8_id == item4.cz8_rta_correcta" -->
                </article>
            </div>
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
                contador: 1,
                params: null,
                inputs: []
            };
        },
        mounted() {
            this.validarInicio()
            console.log('bodyrespuestas')
             this.cargarPreguntas();
            EventBus.$on('cargar', (item) => {
                this.cargarPreguntas()
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
                  var id_pp = ""
                
                axios.get(`/api/respuestaM/buscar/${this.id}`)
                    .then(res => {
                        
                        res.data
                        this.resSMMR = res.data
                        console.log(this.resSMMR)

                        for(var i = 0; i < res.data.length; i++ ){
                           this.inputs.push([])
                              for(var j = 0; j < res.data[i].smmr.length; j++ ){
                                   
                                   if(res.data[i].smmr[j].cz8_id == res.data[i].smmr[j].cz8_rta_correcta){
                                       this.inputs[i].push(res.data[i].smmr[j].cz8_id)
                                   }

                              }
                           
                        }
                        console.log(this.inputs)

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
            editar(dato) {
                this.$modal.show('editar')
                this.params = dato
                console.log(dato)
            },
            eliminar(id) {
                swal({
                    title: "Advertencia",
                    text: "¿Esta seguro de eliminar esta pregunta?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios.delete(`/api/pregunta/delete/${id}`)
                            .then(res => {
                                console.log(res.data)
                                this.cargarPreguntas();
                                swal("Eliminado", {
                                    icon: "success"
                                });
                            });
                    }
                });


            },
            cargarPreguntas() {
                this.traerSMMR()
                this.traerRa();
                this.traerPregunta_SMUR();
            },
            hide() {

                this.$modal.hide('editar')
            },
            guardarSMURcorrecta(item){
                if(this.$route.params.cat == 2){
                axios.put('/api/smur/update', item)
                .then(res=>{
                    console.log(res.data)
                })
                }
            },
             guardarSMMRcorrecta(item, opcion){
                  if(this.$route.params.cat == 2){
                    //   if(){}
                    console.log(this.inputs)
                 console.log(opcion)
                axios.put(`/api/smmr/update/${opcion}`, item)
                .then(res=>{
                    console.log(res.data)
                })
                  }
            }, validarInicio(){
                axios.get(`/api/prueba/inicio/${this.id}`)
                .then(res=>{
                    console.log(res.data)
                     if(res.data != ""){
                         this.$router.go(-1)
                     }
                })
            }
        },
        computed: {}
    };

</script>
