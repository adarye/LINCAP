<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="fa fa-edit"> Encuestas</i>
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

        <modal name="create" :clickToClose="false" :adaptive="true" :width="400" :height="500">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">

                        <form @submit.prevent="crear">

                            <h1>Crear</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">

                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input v-max-length="70" v-autofocus type="text" class="form-control"
                                    v-model="datos.cz3_nombre" placeholder="Nombre" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <textarea rows="4" cols="50" type="text" class="form-control"
                                    v-model="datos.cz3_descripcion" placeholder="Descripcion" />
                                </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                               <!-- <date-picker  v-model="datos.cz3_fecha_apertura"  :config="options"></date-picker>     -->
                               <datetime  v-model="datos.cz3_fecha_apertura" type="datetime" format="yyyy-dd-LL HH:mm"  placeholder="Fecha de Apertura"></datetime>
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                    <!-- <date-picker  v-model="datos.cz3_fecha_cierre"  :config="options"></date-picker>  -->
                                    <Datetime  v-model="datos.cz3_fecha_cierre" type="datetime" format="yyyy-dd-LL HH:mm" placeholder="Fecha de Cierre"></Datetime>
                                  
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
        <modal name="editar" :clickToClose="false" :adaptive="true" :width="500" :height="500">
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
                                <textarea rows="4" cols="50" type="text" class="form-control"
                                    v-model="datos.cz3_descripcion" placeholder="Descripcion" />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                     <Datetime  v-model="datos.cz3_fecha_apertura" type="datetime" format="yyyy-dd-LL HH:mm" :placeholder="[[datos.cz3_fecha_apertura]]"  ></Datetime>
                                     
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <Datetime v-model="datos.cz3_fecha_cierre" type="datetime" format="yyyy-dd-LL HH:mm" :placeholder="datos.cz3_fecha_cierre"></Datetime>
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
        <modal name="asignar" :adaptive="true" :width="800" :height="450">
          <Activos v-bind="{
              id_prueba : id_prueba
          }"></Activos>
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
                <tr v-for="(item, indice) in pruebas" :key="indice" v-show="(pagina-1) * numero <= indice && pagina*numero > indice">
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
                        
                         <button type="button" class="btn btn-success btn-sm" title="Asignar" @click="asignar(item.cz3_id)">
                            <li class="fa fa-users"></li>                               
                        </button>
                         <button type="button" class="btn btn-primary btn-sm" title="Editar" @click="editar(item)">
                            <li class="fa fa-edit"></li>                          
                        </button>
                         <button type="button" class="btn btn-warning btn-sm" title="Cerrar" @click="cerrar(item.cz3_id)">
                            <li class="fa fa-calendar"></li>                              
                        </button>
                         <button type="button" class="btn btn-primary btn-sm" title="Administrar" @click="preguntas(item.cz3_id)">
                            <li class="fa fa-gear"></li>                                         
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" title="Eliminar" @click="eliminar(item.cz3_id, indice)">
                            <li class="fa fa-trash-o"></li>                               
                        </button>


                    </td>
                </tr>
            </tbody>
            
        </table>
         <div class="row">
            <div class="col-md-4 col-float"></div>
        <div class="col-md-6 col-center">
             <button type="button" @click.prevent="pagina=pagina-1" v-show="pagina!=1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                
                <button type="button" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(pruebas.length) < 1"
                    class="btn btn-success">
                    <li class="fa fa-long-arrow-right"></li>
                </button>
                </div>
                </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
    moment.locale("es");
    import router from '../../js/router'
    import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.min.css'
    
 
   
    export default {
        components: {
            Datetime
     
    },
        data() {
            return {
               
                pruebas: [],
                datos: {
                    cz3_id:null,
                    cz3_nombre: null,
                    cz3_descripcion: null,
                    cz3_fecha_apertura: null,
                    cz3_fecha_cierre:  null
                },
                
                titulo: 'Crear Encuesta',
                fecha_actual:  '',
                id_prueba: '',
                moment: moment,

                selectPag: 3,
                numero: 3,
                mostrar: 0,
                pagina: 1
            }       
        },
        beforeMount(){    
              
                this.traerPruebas();
                 
             
            },
        methods: {
            traerPruebas(){
                axios.get(`/api/gp/${this.$route.params.categoria}`)
                .then(res=>{
                    this.pruebas = res.data;
                console.log(res.data)


                })
            },
            crear() {
                 
                 if(this.datos.cz3_nombre == null || this.datos.cz3_descripcion == null ||
                this.datos.cz3_fecha_apertura == '' || this.datos.cz3_fecha_cierre == ''){
                      swal('Advertencia', 'Todos los campos son necesarios', 'warning')
                }
                else{
                console.log(this.datos)
                axios.post('/api/gp/crear', { datos: this.datos, categoria: this.$route.params.categoria})
                .then(res=>{
                   
                    console.log(res.data)
                  this.traerPruebas();
                   swal('Guardado', 'El registro se guardo correctamente', 'success')
                   this.$modal.hide('create')
                   this.limpiar();
                })   
                
                }    
            },
            editar(item){
                
             this.titulo = 'Editar Encuesta'
             this.datos.cz3_fecha_apertura = item.cz3_fecha_apertura
             
             this.datos.cz3_fecha_cierre = item.cz3_fecha_cierre
             this.datos.cz3_id = item.cz3_id
             this.datos.cz3_nombre = item.cz3_nombre
             this.datos.cz3_descripcion = item.cz3_descripcion
            
             console.log(this.datos.cz3_fecha_apertura)
              console.log(this.datos)
             this.$modal.show('editar')

            },

            limpiar(){
                this.datos.cz3_nombre = ''
                this.datos.cz3_descripcion = ''
                this.datos.cz3_fecha_apertura = ''
                this.datos.cz3_fecha_cierre = ''
            },

            actualizar(){
            //       this.fecha_actual =  moment().format("YYYY/DD/MM h:mm:ss");
            //   var i = diff(this.datos.cz3_fecha_apertura, 'days')
            //   console.log(i)
                 if(this.datos.cz3_nombre == '' || this.datos.cz3_descripcion == ''){
                      swal('Advertencia', 'Todos los campos son necesarios', 'warning')
                }
                else{
                axios.put('/api/gp/update', this.datos)
                .then(res=>{
                    this.traerPruebas();
                    swal('Prueba Actualizada', '', 'success')
                    this.$modal.hide('editar')
                    this.limpiar();
                })
                }
            },
             cerrar(id){
                swal({
                    title: "Advertencia",
                    text: "¿Quiere cerrar esta prueba?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                this.fecha_actual = moment().format("YYYY/DD/MM h:mm:ss");
                axios.put('/api/gp/cerrar',{fecha_actual: this.fecha_actual, id: id})
                .then(res=>{
                    console.log(res.data)
                    this.traerPruebas();
                })
                    }
                })
        },
        eliminar(id, indice){
            swal({
                    title: "Advertencia",
                    text: "¿Esta seguro de eliminar esta prueba?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
             axios.delete(`/api/gp/delete/${id}`)
                .then(res=>{
                       this.traerPruebas();
                })
                    }
                })
        },
        asignar(id){
            this.id_prueba = id;
             this.$modal.show('asignar')
        },
        preguntas(id){
                    router.push('/prueba/pregunta/' + id);
        }
        }
    }

</script>
