<template>
 
         
    <div v-show="id_creador == id_log">
        <vue-headful
            :title="$route.params.cat == 1 ?  'Lincap | Administrar encuesta':  'Lincap | Administrar evaluación'"
        />
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-show=" $route.params.cat == 1" class="breadcrumb-item"><i class="fa fa-pencil"> <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Encuestas</router-link></i></li>
                 <li v-show=" $route.params.cat == 2" class="breadcrumb-item"><i class="fa fa-file-text"> <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log" > Evaluaciones</router-link></i></li>
                <li class="breadcrumb-item">{{datos.cz3_nombre}}</li>
                <li class="breadcrumb-item"><i class="fa fa-gears"> Administrar</i></li>
                
            </ol>
        </nav>
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
                                    <select v-model="tipo_respuesta" class="form-control" >
                                        <option value="smur" >Seleccion multiple con unica respuesta</option>
                                        <option value="smmr"> Seleccion multiple con multiples respuesta</option>
                                        <option value="ra"> Respuesta Abierta</option>
                                    </select>
                                </div>
                                <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                                    <div v-if="tipo_respuesta == 'smur' ||tipo_respuesta == 'smmr'">
                                        <input v-max-length="300" v-autofocus class="form-control" v-model="n_respuestas" placeholder="Numero de Respuestas" onfocus v-numeric-only />
                                    </div>
                                </div>
                                <div class="col-md-10 col-center col-sm-7 form-group has-feedback">
                                    <div v-show="tipo_respuesta == 'smmr'">
                                        <input v-max-length="300" v-autofocus class="form-control" v-model="rtas_correctas" placeholder="Limite de seleccion" onfocus v-numeric-only />
                                    </div>
                                </div>

                                <button type="button" class="fa fa-arrow-right btn btn-lg btn-dark mt-1"
                                    @click="showRespuestas" v-if="n_respuestas != null   && tipo_respuesta != 'ra'">
                                    </button>

                                <div class="col-md-12 col-sm-12 form-group has-feedback">
                                    <button type="submit" class="btn btn-primary">
                                        Guardar
                                    </button>
                                    <button type="button" @click="$modal.hide('crear')" class="btn btn-danger" >
                                        Cancelar
                                    </button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </modal>
            <modal name="respuestas" :clickToClose="false" :adaptive="true" :width="450" :height="600">
                <MRespuestas
                    v-bind="{ n_respuestas: n_respuestas, res: res }"
                    v-on:hideRespuestas="hideRespuestas"
                ></MRespuestas>
            </modal>

            <div class="col-md-4">
                <button type="button" class="btn btn-success" @click="$modal.show('crear')">
                  Agregar  <li class="fa fa-plus"></li>
                </button>
                 <button type="button" class="btn btn-info" @click="$modal.show('pruebas')">
                  Copiar Prueba  <li class="fa fa-copy"></li>
                </button>
            </div>
        </nav>
        <Respuestas v-bind="{ id: $route.params.id }"></Respuestas>
         <modal name="pruebas" :clickToClose="false" :adaptive="true" :width="450" :height="370">
                <div class="table-responsive-md table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="texto">Prueba</th>
                        <th scope="col" class="texto">Descripcion</th>
                        <th scope="col" class="texto">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                     <tr v-for="(item, indice) in pruebas" :key="indice">


                        <th scope="row">{{ item.cz3_nombre }}</th>

                        <td>{{ item.cz3_descripcion}}</td>
                        <td>
                            <input v-show="item.cz3_id != $route.params.id" type="radio" name="eleccion" @click="prueba_seleccionada = item.cz3_id">
                        </td>
                        </tr>

                </tbody>
            </table>
                </div>
                 <button type="button" class="btn btn-info mt-3" @click="copiarPrueba">
                  Copiar   <li class="fa fa-copy"></li>
                </button>
                 <button type="button" class="btn btn-danger mt-3" @click="$modal.hide('pruebas')">
                  Cerrar 
                </button>
         </modal>
    </div>
</template>
<script>
import EventBus from "../../js/bus";
export default {
    data() {
        return {
            n_respuestas: null,
            tipo_respuesta: "Seleccione...",
            pregunta: "",
            datos: {},
            res: [],
            pruebas: [],
            prueba_seleccionada: "",
            rtas_correctas: null,
            id_log: null,
            id_creador: null
            
        };
    },
   
    mounted() {
        this.id_log = user.id
        this.buscar();
        this.buscarPruebas()
    },
    methods: {
        buscar() {
            axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                this.datos = res.data;
                this.id_creador = res.data.cz3_id_creador
                if(this.id_creador != user.id){
                      window.location.href = '/'
                }
            });
        },
        crear() {
           
           console.log(this.res)
            if (this.pregunta == "" || this.tipo_respuesta == "Seleccione...") {
                swal("Advertencia", "Llene todos los campos", "warning");
            } else if ( this.tipo_respuesta == "smmr" || this.tipo_respuesta == "smur" ) {
                 
                    if (this.res.length == 0 ) {
                        swal( "Advertencia","Escriba las posibles respuestas","warning");
                    }
                    else if(this.rtas_correctas == 0 || this.rtas_correctas == null && this.tipo_respuesta == "smmr"){
                        swal( "Advertencia","Escriba el numero de respuestas correctas","warning");

                    }
                     else if( this.tipo_respuesta == "smmr" && this.rtas_correctas > this.n_respuestas){
                        swal( "Advertencia","El numero de respuestas correctas debe ser menor o igual a las respuestas totales","warning");

                    }
                      else if (this.res.length != this.n_respuestas) {
                           console.log(this.res.length + " " + this.n_respuestas);
                            swal( "Advertencia", "Escriba las posibles respuestas","warning");
                    }
                    else {
                    this.guardarPregunta()
                }  
            }
            else{
                this.guardarPregunta()
            }
        },
        guardarPregunta(){
             const params = {
                cz5_categoria: this.tipo_respuesta,
                cz5_pregunta: this.pregunta,
                cz5_gp_id: this.$route.params.id,
                cz5_n_rtas: this.n_respuestas,
                cz5_n_rtas_correctas: this.rtas_correctas
            };
         axios.post("/api/pregunta/guardar", params).then(res => {
                        if (this.tipo_respuesta == "smur" || this.tipo_respuesta == "smmr") {
                            this.guardarPS(res.data.cz5_id);
                        } else {
                            EventBus.$emit("cargar", "o");
                           swal("Mensaje", "Pregunta creada exitosamente", "success");
                           this.limpiar();
                        }
                    });
        },

        guardarPS(id) {
            
                axios.post("/api/respuestaS/guardar", {
                        id: id,
                        respuestas: this.res,
                        categoria: this.tipo_respuesta
                    })
                    .then(res => {
                        console.log(res.data);
                        EventBus.$emit("cargar", this.tipo_respuesta);
                        swal(
                            "Mensaje",
                            "Pregunta creada exitosamente",
                            "success"
                        );
                        this.limpiar();
                    });
            
        },

        hideRespuestas() {
            this.$modal.hide("respuestas");
        },
        showRespuestas() {
            if (this.n_respuestas >= 10) {
                swal(
                    "Advertencia",
                    "Ha superado el limite de preguntas",
                    "warning"
                );
            } else if (this.n_respuestas == 0 || this.n_respuestas == null) {
                swal("Advertencia", "Ingrese un valor valido", "warning");
            } else {
                this.$modal.show("respuestas");
            }
        },
        limpiar() {
            this.tipo_respuesta = "Seleccione...";
            this.pregunta = "";
            this.rtas_correctas= null;
            (this.n_respuestas = null), (this.res = []);
        },

        copiarPrueba(){
           const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''> Copiando preguntas...</div> ";
                swal({
                   buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });
            axios.post('/api/gp/copiarPrueba', {id: this.prueba_seleccionada, prueba: this.$route.params.id})
            .then(res=>{
                 EventBus.$emit("cargar", "o");
                console.log(res.data)
                swal('Mensaje', 'Preguntas copiadas exitosamente', 'success')
            })

        },
        buscarPruebas(){
            axios.get(`/api/gp/${this.$route.params.cat}`)
            .then(res=>{
                this.pruebas = res.data
            })
        }
    }
};
</script>
