<template>
    <div>
        <center>
            <h1>{{ datos.cz3_nombre }}</h1>
        </center>
        <nav class="navbar navbar-light bg-light my-2">
            <modal name="crear" :clickToClose="false" :adaptive="true" :width="450" :height="450">
                <div class="login_wrapper">
                    <div class="animate form login_form">
                        <section class="login_content">
                            <form @submit.prevent="crear">
                                <h1>Pregunta</h1>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                    <textarea rows="4" cols="50" v-max-length="300" v-autofocus class="form-control"
                                        v-model="pregunta" placeholder="Nueva Pregunta" onfocus />

                                    </div>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                 <select v-model="tipo_respuesta" class="form-control">
                           <option value="smur">Seleccion multiple con unica respuesta</option>
                           <option  value="smmr"> Seleccion multiple con multiples respuesta</option>
                           <option  value="ra"> Respuesta Abierta</option>
                            </select>
                                </div>
                                <div class="col-md-9 col-center col-sm-7 form-group has-feedback">
                                    <div v-if="tipo_respuesta == 'smur' || tipo_respuesta == 'smmr' ">
                                        <input v-max-length="300" v-autofocus  class="form-control"
                                        v-model="n_respuestas" placeholder="Numero de Respuestas" onfocus v-numeric-only />
                                    </div>
                                </div>
                                 <span  class="col-md-3 col-center col-sm-5 form-group" v-if="n_respuestas != null">
                                     <button class="fa fa-arrow-right btn btn-lg btn-dark"  @click="showRespuestas"></button>
                                     </span>
                               
                                <div class="col-md-12 col-sm-12 form-group has-feedback">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <button type="button" @click="$modal.hide('crear');"
                                        class="btn btn-danger">Cancelar</button>
                                </div>                           
                        </form>
                    </section>
                </div>
            </div>
             </modal>
             <modal name="respuestas" :clickToClose="false" :adaptive="true" :width="450" :height="600">
                 <Respuestas v-bind="{n_respuestas:  n_respuestas}" v-on:hideRespuestas="hideRespuestas"></Respuestas>

                      
             </modal>
            
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" @click="$modal.show('crear')">Generar Pregunta</button>
            </div>
         </nav>
    </div>
</template>
<script>
export default {
    data(){
        return{
            n_respuestas: null,
            tipo_respuesta: 'Seleccione...',
            pregunta: '',
            datos: {}
        }
    },
    mounted(){
        this.buscar()
    },
    methods:{
        buscar(){
            axios.get(`/api/gp/buscar/${this.$route.params.id}`)
            .then(res=>{
                
                this.datos = res.data
            })
        },
        crear(){
            const params= {
                cz5_categoria: this.tipo_respuesta,
                cz5_pregunta: this.pregunta,
                cz5_gp_id: this.$route.params.id
            }
         axios.post('/api/pregunta/guardar', params)
         .then(res=>{
             console.log(res.data)
         })

         
        },
        guardarPA(){
           axios.post('/api/respuestaA/guardar', params)
         .then(res=>{
             console.log(res.data)
         })
        },

        hideRespuestas(){

            this.$modal.hide('respuestas')
        },
        showRespuestas(){
            if(this.n_respuestas >= 10){
          swal('Advertencia', 'Ha superado el limite de preguntas', 'warning')
            }
            else if(this.n_respuestas == 0 || this.n_respuestas == null)
            {
                 swal('Advertencia', 'Ingrese un valor valido', 'warning')
            }
            else{
               
                this.$modal.show('respuestas')
            }
        }
        
    }
}
</script>
