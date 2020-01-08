<template>
   <div>
        <div class="login_wrapper">
                    <div class="animate form login_form">
                        <section class="login_content">
                            <form @submit.prevent="actualizar">
                                <h1>Pregunta</h1>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                    <textarea rows="4" cols="50" v-max-length="300" v-autofocus class="form-control"
                                        placeholder="Nueva Pregunta" onfocus v-model="params.cz5_pregunta" />

                                    </div>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                 <select  class="form-control" v-model="tipo_respuesta" disabled>
                           <option value="smur">Seleccion multiple con unica respuesta</option>
                           <option  value="smmr"> Seleccion multiple con multiples respuesta</option>
                           <option  value="ra"> Respuesta Abierta</option>
                            </select>
                                </div>
                                <div class="col-md-8 col-center col-sm-7 form-group has-feedback">
                                    <div v-if="tipo_respuesta == 'smur' || tipo_respuesta == 'smmr' ">
                                        <input v-max-length="300" v-autofocus  class="form-control"
                                        placeholder="Numero de Respuestas" onfocus v-numeric-only v-model="numero" disabled />
                                    </div>
                                </div>
                                 
                                     <button type="button" class="fa fa-arrow-right btn btn-lg btn-dark mt-1" v-show="tipo_respuesta == 'smur' || tipo_respuesta == 'smmr'" @click="$modal.show('respuestas')"></button>
                                     
                               
                                <div class="col-md-12 col-sm-12 form-group has-feedback">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                    <button type="button" v-on:click="$emit('hide')"
                                        class="btn btn-danger">Cancelar</button>
                                </div>                           
                        </form>
                    </section>
                </div>
            </div>
             <modal name="respuestas" :clickToClose="false" :adaptive="true" :width="450" :height="600">
                 <MRespuestas v-bind="{n_respuestas:  numero, res:params}" v-on:hideRespuestas="hideRespuestas"></MRespuestas>
      
             </modal>
   </div>
</template>
<script>
export default {
     props: ["params"],
    data(){
        return{
          tipo_respuesta: '',
          numero: null,
          res: [],
          size: null
        }
    },
    mounted(){
        this.tipo_respuesta = this.params.cz5_categoria
        if( this.tipo_respuesta == 'smur'   ){
        this.numero = this.params.respuestas.length
        }
        else if(this.tipo_respuesta == 'smmr'){
            this.numero = this.params.smmr.length
        }
        
    },
   
    methods:{
        actualizar(){
            axios.put('/api/respuestaA/update',this.params)
            .then(res=>{
            swal('Mensaje', 'Pregunta Actualizada', 'success')
            this.actualizarRS()
            })
           
        },
        hideRespuestas(){
            this.$modal.hide('respuestas')
        },
        actualizarRS(){

            if( this.tipo_respuesta == 'smur'){
            axios.put('/api/respuestaS/update',{size:  this.params.respuestas.length, respuestas:this.params.respuestas})
            .then(res=>{
                console.log(res.data)
            })
            }
             else if( this.tipo_respuesta == 'smmr'){
                 axios.put('/api/respuestaS/updateSMMR',{size:  this.params.smmr.length, smmr:this.params.smmr})
            .then(res=>{
                console.log(res.data)
            })
            }


        }
    }
}
</script>