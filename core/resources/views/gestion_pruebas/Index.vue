<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="fa fa-file-text"> Evaluaciones</i>
                </li>
                <li class="breadcrumb-item">
                    <i class="fa fa-gear">
                        <router-link :to="{ name: 'IndexGP' }">
                            Administrar</router-link>
                    </i>
                </li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>

        <modal name="create" :clickToClose="false" :adaptive="true" :width="500" :height="450">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">              
                          
                        <form  @submit.prevent="crear">
                              
                            <h1>Crear</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">

                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input  v-max-length="70" v-autofocus type="text" class="form-control"
                                    v-model="datos.cz3_nombre" placeholder="Nombre" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_descripcion" placeholder="Descripcion" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                               <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_fecha_apertura" placeholder="Fecha de Apertura" />    
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                               <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_fecha_cierre" placeholder="Fecha de cierre" />    
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" @click="$modal.hide('create');"
                                    class="btn btn-danger">Cancelar</button>
                            </div>

                        </form>
                        
                    </section>
                </div>
            </div>
        </modal>
        <modal name="editar" :clickToClose="false" :adaptive="true" :width="500" :height="450">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">              
                          
                        <form  @submit.prevent="actualizar()">
                              
                            <h1>Editar</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">

                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input  v-max-length="70" v-autofocus type="text" class="form-control"
                                    v-model="datos.cz3_nombre" placeholder="Nombre" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_descripcion" placeholder="Descripcion" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                               <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_fecha_apertura" placeholder="Fecha de Apertura" />    
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                               <input  v-max-length="80" type="text" class="form-control"
                                    v-model="datos.cz3_fecha_cierre" placeholder="Fecha de cierre" />    
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" @click="$modal.hide('editar'); limpiar();"
                                    class="btn btn-danger">Cancelar</button>
                            </div>

                        </form>
                        
                    </section>
                </div>
            </div>
        </modal>

        <button type="button" class="btn btn-round btn-success" @click="$modal.show('create');"
            title="Nuevo">Nuevo</button>
       <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Fecha de Apertura</th>
                    <th scope="col">Fecha de Cierre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in pruebas" :key="indice" :class="{'table-danger': estado }">
                    <th scope="row">{{ item.cz3_nombre }}</th>
                    <td>
                        {{ item.cz3_descripcion }}
                    </td>
                    <td>
                        {{ item.cz3_fecha_apertura }}
                    </td>
                     <td>
                        {{ item.cz3_fecha_cierre }}
                    </td>
                    <td>
                        
                         <button type="button" class="btn btn-success btn-sm" @click="eliminar(item.cz2_id, indice)">
                            <li class="fa fa-users"> Asignar </li>                               
                        </button>
                         <button type="button" class="btn btn-primary btn-sm" @click="editar(item)">
                            <li class="fa fa-edit"> Editar </li>                          
                        </button>
                         <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item.cz2_id, indice)">
                            <li class="fa fa-trash-o"> Cerrar </li>                               
                        </button>


                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>
<script>
import moment from "moment";
    moment.locale("es");
    export default {
        data() {
            return {
                datos: {
                    cz3_id:null,
                    cz3_nombre: null,
                    cz3_descripcion: null,
                    cz3_fecha_apertura: '12/11/2019 12:09:00',
                    cz3_fecha_cierre:  '12/11/2019 12:09:00'
                },
                pruebas: {},
                titulo: 'Crear Encuesta',
                estado: false,
                fecha_actual:  ''
                


            }
            
        },
        beforeMount(){    
              
                this.traerPruebas();
                 this.fecha_actual = moment().format("DD/MM/YYYY, h:mm:ss");
                console.log(this.fecha_actual)
             
            },
        methods: {
            traerPruebas(){
                axios.get('/api/gp')
                .then(res=>{
                    this.pruebas = res.data;
                console.log(res.data)


                })
            },
            crear() {
                
                 if(this.datos.cz3_nombre == null || this.datos.cz3_descripcion == null ||
                this.datos.cz3_fecha_apertura == null){
                      swal('Advertencia', 'Todos los campos son necesarios', 'warning')
                }
                else{
                console.log(this.datos)
                axios.post('/api/gp/crear', this.datos)
                .then(res=>{
                    const pruebaServidor = res.data;
                  this.traerPruebas();
                   swal('Guardado', 'El registro se guardo correctamente', 'success')
                   this.$modal.hide('create')
                   this.limpiar();
                })   
                
                }    
            },
            editar(item){
             this.titulo = 'Editar Encuesta'
             this.datos.cz3_id = item.cz3_id
             this.datos.cz3_nombre = item.cz3_nombre
             this.datos.cz3_descripcion = item.cz3_descripcion
             this.datos.cz3_fecha_apertura = item.cz3_fecha_apertura
             this.datos.cz3_fecha_cierre = item.cz3_fecha_cierre
             this.$modal.show('editar')

            },

            limpiar(){
                this.datos.cz3_nombre = ''
                this.datos.cz3_descripcion = ''
                this.datos.cz3_fecha_apertura = ''
                this.datos.cz3_fecha_cierre = ''
            },

            actualizar(){
                axios.put('/api/gp/update', this.datos)
                .then(res=>{
                    this.traerPruebas();
                    swal('Prueba Actualizada', '', 'success')
                    this.$modal.hide('editar')
                    this.limpiar();
                })
            }

           

        }
    }

</script>
