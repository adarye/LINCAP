<template>
    <div>
         <vue-headful
            :title="title"
        />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                  <li v-show=" $route.params.categoria == 1" class="breadcrumb-item"><i class="fa fa-pencil"> <router-link v-bind:to="'/gestion/pruebas/' + $route.params.categoria"> Encuestas</router-link></i></li>
                 <li v-show=" $route.params.categoria == 2" class="breadcrumb-item"><i class="fa fa-file-text"> <router-link v-bind:to="'/gestion/pruebas/' + $route.params.categoria"> Evaluaciones</router-link></i></li>
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
                               <datePicker placeholder="Fecha de Apertura"  v-model="datos.cz3_fecha_apertura" :config="options"></datePicker>
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                      <datePicker  placeholder="Fecha de Cierre"  v-model="datos.cz3_fecha_cierre" :config="options"></datePicker>        
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" @click="$modal.hide('create');  $route.params.categoria == 1 ? title= 'Lincap | Admin encuestas': title= 'Lincap | Admin evaluaciones' "
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
                                    <datePicker disabled v-model="datos.cz3_fecha_apertura" :config="options2" :placeholder="datos.cz3_fecha_apertura"></datePicker>
                                     
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <datePicker v-model="datos.cz3_fecha_cierre" :config="options2" :placeholder="datos.cz3_fecha_cierre"></datePicker>
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="button" @click="$modal.hide('editar');  limpiar();  $route.params.categoria == 1 ? title= 'Lincap | Admin encuestas': title= 'Lincap | Admin evaluaciones'"
                                    class="btn btn-danger">Cancelar</button>
                            </div>
                             
                        </form>
                        
                    </section>
                </div>
            </div>
        </modal>
        <modal name="asignar" :adaptive="true" :width="810" :height="450">
          <Activos v-bind="{
              id_prueba : id_prueba
          }"></Activos>
        </modal>

        <button type="button" class="btn btn-round btn-success" @click="$modal.show('create'); $route.params.categoria == 1 ? title= 'Lincap | Crear encuesta': title= 'Lincap | Crear evaluación'"
            title="Nuevo">Nuevo</button>
             
      <Pruebas v-bind="{pruebas: pruebas}" v-on:asignar="asignar" v-on:eliminar="eliminar"
      v-on:editar="editar" v-on:cerrar="cerrar" v-on:preguntas="preguntas" v-on:estadisticas="estadisticas">
      </Pruebas>
    </div>
</template>
<script>
import moment from "moment";
    moment.locale("es");
    import router from '../../js/router'
    import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.min.css'

import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
 import datePicker from 'vue-bootstrap-datetimepicker';

    
 
   
    export default {
        components: {
            Datetime, datePicker
     
    },
        data() {
            return {
                options: {
                     format: 'YYYY-DD-MM LT',
                      
                }, 
                options2: {
                    format: 'YYYY-DD-MM LT',
                     useCurrent: false
                },
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
                title: ""

                
            }       
        },
        beforeMount(){    
              
                this.traerPruebas();
                if( this.$route.params.categoria == 1){
                 this.title = 'Lincap | Admin encuestas'}
                 else {
                this.title= 'Lincap | Admin evaluaciones'
                 }
             
            },
        methods: {
            traerPruebas(){

                axios.get(`/api/gp/${this.$route.params.categoria}`)
                .then(res=>{                    
                    this.pruebas = res.data
                    
                })
            },
            crear() {
                console.log(this.datos.cz3_fecha_apertura + ' ' + this.datos.cz3_fecha_cierre)
               
             
               var fechaC =  this.datos.cz3_fecha_cierre.split('-');
               var mes_hora = fechaC[2].split(' ')
               var mesC =  mes_hora[0]
               var horaC = mes_hora[1]

                var fechaCierre = fechaC[0] +'/'+ mesC + '/'+ fechaC[1] + ' ' + horaC
                  fechaCierre = new Date(fechaCierre)

                   var fechaA =  this.datos.cz3_fecha_apertura.split('-');
               var mes_hora_a = fechaA[2].split(' ')
               var mesA =  mes_hora_a[0]
               var horaA = mes_hora_a[1]

                var fechaApertura = fechaA[0] +'/'+ mesA + '/'+ fechaA[1] + ' ' + horaA
                  fechaApertura = new Date(fechaApertura)
                 console.log(fechaCierre +' ' + fechaApertura)
              

                 if(this.datos.cz3_nombre == null || this.datos.cz3_descripcion == null ||
                this.datos.cz3_fecha_apertura == null || this.datos.cz3_fecha_cierre == null){
                      swal('Advertencia', 'Todos los campos son necesarios', 'warning')
                }
                else if(fechaApertura > fechaCierre || fechaApertura <= new Date()
                 ){
                     swal('Advertencia', 'Las fechas deben tener un rango en vigencia', 'warning')
                }
                else{
                axios.post('/api/gp/crear', { datos: this.datos, categoria: this.$route.params.categoria})
                .then(res=>{
                   
                  this.traerPruebas();
                   swal('Guardado', 'El registro se guardo correctamente', 'success')
                   this.$modal.hide('create')
                   this.limpiar();
                })   
                
                }   
                 if( this.$route.params.categoria == 1){
                 this.title = 'Lincap | Admin encuestas'}
                 else {
                this.title= 'Lincap | Admin evaluaciones'
                 } 
            },
            editar(item){
                if( this.$route.params.categoria == 1){
                 this.title = 'Lincap | Editar encuesta'}
                 else {
                this.title= 'Lincap | Editar evaluación'
                 }
                
             this.titulo = 'Editar Encuesta'
             this.datos.cz3_fecha_apertura = moment(item.cz3_fecha_apertura).format('YYYY-DD-MM LT');
             this.datos.cz3_fecha_cierre = moment(item.cz3_fecha_cierre).format('YYYY-DD-MM LT');
             this.datos.cz3_id = item.cz3_id
             this.datos.cz3_nombre = item.cz3_nombre
             this.datos.cz3_descripcion = item.cz3_descripcion
            
             this.$modal.show('editar')


            },

            limpiar(){
                this.datos.cz3_nombre = ''
                this.datos.cz3_descripcion = ''
                this.datos.cz3_fecha_apertura = ''
                this.datos.cz3_fecha_cierre = ''
            },

            actualizar(){
               var fechaC =  this.datos.cz3_fecha_cierre.split('-');
               var mes_hora = fechaC[2].split(' ')
               var mesC =  mes_hora[0]
               var horaC = mes_hora[1]

                var fechaCierre = fechaC[0] +'/'+ mesC + '/'+ fechaC[1] + ' ' + horaC
                  fechaCierre = new Date(fechaCierre)

                  var fechaA =  this.datos.cz3_fecha_apertura.split('-');
               var mes_hora_a = fechaA[2].split(' ')
               var mesA =  mes_hora_a[0]
               var horaA = mes_hora_a[1]

                var fechaApertura = fechaA[0] +'/'+ mesA + '/'+ fechaA[1] + ' ' + horaA
                  fechaApertura = new Date(fechaApertura)

                 
                 if(this.datos.cz3_nombre == '' || this.datos.cz3_descripcion == ''){
                      swal('Advertencia', 'Todos los campos son necesarios', 'warning')
                }
                else if(fechaCierre <= fechaApertura){
                    swal('Advertencia', 'Las fechas deben tener un rango en vigencia', 'warning')

                }
                else{
                axios.put('/api/gp/update', this.datos)
                .then(res=>{
                    this.traerPruebas();
                    swal('Prueba Actualizada', '', 'success')
                    this.$modal.hide('editar')
                    //  this.options2.format = 'YYYY-MM-DD LT'
                    this.limpiar();
                })
                }
                if( this.$route.params.categoria == 1){
                 this.title = 'Lincap | Admin encuestas'}
                 else {
                this.title= 'Lincap | Admin evaluaciones'
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
             router.push('/gestion/pruebas/asignar/'+this.$route.params.categoria + '/' + id);
            //  this.$modal.show('asignar')
        },

        preguntas(id){
                axios.get(`/api/prueba/inicio/${id}`)
                .then(res=>{
                    if(res.data == ""){
                        router.push('/prueba/preguntas/'+this.$route.params.categoria + '/' + id);
                    }
                    else{
                    swal('Advertencia', 'No se pueden editar las preguntas porque alguien ya la contesto.', 'warning')
                    }
                })
                
            
                    
        },
        estadisticas(id){
             router.push('/gestion/prueba/estadistica/'+this.$route.params.categoria + '/' + id);
        }
        }
    }

</script>
