<template>
    <div>
        <div v-show="rol != 4 && rol != 3 ">
        <button class="btn btn-outline-primary" type="button" v-show="mostrar == false"
            @click="mostrar = true">Publicar</button>
        <button class="btn btn-primary" type="button" v-show="mostrar" @click="mostrar = false, limpiar()">Cerrar</button>
        </div>
        <form v-show="mostrar == true && editar == false" class="my-3" method="POST" @submit.prevent="validar">
             <div class="card" style="width:500px">
            <div class="card-header">Agregar noticia</div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-12 col-sm-12 col-center form-group">
                    <input v-max-length="100" v-autofocus type="text" class="form-control" v-model="nombre"
                        placeholder="Titulo de la noticia" onfocus />
                    <span title="Titulo de la noticia" class="fa fa-pencil form-control-feedback right"
                        aria-hidden="true"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                    <textarea rows="4" cols="50" v-max-length="300" v-autofocus class="form-control"
                        placeholder="Descripcion de la noticia" onfocus v-model="descripcion" />
                    </div>
             </div>
              <div class="row">
                <div class="col-md-10 col-center col-sm-10 form-group has-feedback">
                    <select  class="form-control"  v-model="importancia">
                           <option value="1">NORMAL</option>
                           <option  value="2">IMPORTANTE</option>
                           <option  value="3">MUY IMPORTANTE</option>
                           <option  value="4">NECESARIA</option>
                            </select>
                    </div>
             </div>
             <div class="row">
                   <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                       <label for="imagen" >Imagen...</label>
                       <input id="imagen"  placeholder="Seleccionar Imagen" type="file" v-on:change="getImage($event)" />
                    </div>
             </div>
             <div class="row">
                   <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                       <label for="archivo">Archivo...</label>
                       <input id="archivo" placeholder="" type="file" v-on:change="getFile($event)" />
                    </div>
             </div>
              
              </div>
               <div class="row">
            <div class="col-md-12 col-center form-group has-feedback ">
                <center>
                    <button type="submit" class="btn btn-primary ">
                    Publicar
                    </button>
                </center>
                
            </div>
                
            </div>
             </div>
        </form>

        <form v-show="mostrar == true &&  editar == true" class="my-3" method="POST" @submit.prevent="validar">
             <div class="card" style="width:500px">
            <div class="card-header">Editar noticia</div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-12 col-sm-12 col-center form-group">
                    <input v-max-length="100" v-autofocus type="text" class="form-control" v-model="nombre"
                        placeholder="Titulo de la noticia" onfocus />
                    <span title="Titulo de la noticia" class="fa fa-pencil form-control-feedback right"
                        aria-hidden="true"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                    <textarea rows="4" cols="50" v-max-length="300" v-autofocus class="form-control"
                        placeholder="Descripcion de la noticia" onfocus v-model="descripcion" />
                    </div>
             </div>
              <div class="row">
                <div class="col-md-10 col-center col-sm-10 form-group has-feedback">
                    <select  class="form-control"  v-model="importancia">
                           <option value="1">NORMAL</option>
                           <option  value="2">IMPORTANTE</option>
                           <option  value="3">MUY IMPORTANTE</option>
                           <option  value="4">NECESARIA</option>
                            </select>
                    </div>
             </div>
             <div class="row">
                   <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                       <label for="imagen2" >Imagen...</label>
                       <input id="imagen2"  placeholder="Seleccionar Imagen" type="file" v-on:change="getImage($event)" />
                    </div>
             </div>
             <div class="row">
                   <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                       <label for="archivo2">Archivo...</label>
                       <input id="archivo2" placeholder="" type="file" v-on:change="getFile($event)" />
                    </div>
             </div>
              
              </div>
               <div class="row">
            <div class="col-md-12 col-center form-group has-feedback ">
                <center>
                    <button type="submit" class="btn btn-primary ">
                    Actualizar
                    </button>
                </center>
                
            </div>
                
            </div>
             </div>
        </form>
    
        <BodyNoticias v-on:editar2="editar2"></BodyNoticias>

    </div>
</template>
<script>
import EventBus from '../../js/bus';
export default {
    data(){
        return{
        editar: false,
            nombre: null,
            descripcion: null,
            importancia: 'Nivel de Importancia',
            estado: null,
            imagen: null,
            imagen_miniatura: null,
            mostrar: false,
            file: null,
            estado2: null,
            id: null,
            rol: null
          
            
        }
    },
    mounted(){
        this.rol = user.rol
    },
    methods:{
        guardar(){
             if (this.estado != 0 && this.estado2 != 0) {
                    let formData = new FormData();
                    formData.append("imagen", this.imagen);
                    formData.append('descripcion', this.descripcion);
                    formData.append('nombre', this.nombre);
                    formData.append('importancia', this.importancia);
                    formData.append('archivo', this.file);

                     console.log(formData)
                    axios({
                    method: 'post',
                    url: '/api/noticia/guardar',
                    data: formData,
                  
                })
                        .then(res => {
                            console.log(res.data)
                            swal('Publicacion guardada','','success')
                            .then(select => {
                                 EventBus.$emit("cargar", "o");
                                 this.limpiar()
                                // location.reload();
                            });
                        });
                } else {
                    swal(
                        "Advertencia",
                        "Haga una eleccion diferente",
                        "error"
                    );
                }
        },
        editar2(item){
            this.mostrar = true
            this.editar = true
            this.nombre = item.cz12_nombre
            this.descripcion = item.cz12_descripcion
            this.importancia = item.cz12_nivel_imp
            this.id = item.cz12_id
           
        },
        actualizar(){
               if (this.estado != 0 && this.estado2 != 0 ) {
             let formData = new FormData();
                    formData.append("imagen", this.imagen);
                    formData.append('descripcion', this.descripcion);
                    formData.append('nombre', this.nombre);
                    formData.append('importancia', this.importancia);
                    formData.append('archivo', this.file);
                    formData.append('id', this.id);
                    console.log(formData)
            axios.post('/api/noticia/actualizar', formData)
            .then(res=>{
                EventBus.$emit("cargar", "o");
                this.limpiar();
                swal('Noticia Actualizada', '', 'success')
            })
               }

        },
        getImage(event) {
                //Asignamos la imagen a  nuestra data
                let file = event.target.files[0];
                this.imagen = file;

                if (!/\.(jepg|jpg|png|gif)$/i.test(file.name)) {
                    swal(
                        "Advertencia",
                        "El archivo a adjuntar no es una imagen",
                        "warning"
                    );
                    this.estado = 0
                } else {

                    if (file.size > 3000000) {
                        swal(
                            "Advertencia",
                            "El peso de la imagen no puede exceder los 200kb",
                            "warning"
                        );
                        this.estado = 0
                    } else {
                        this.estado = 1
                        this.cargarImagen(file);
                    }
                }
            },
            cargarImagen(file) {
                let reader = new FileReader();

                reader.onload = e => {
                    this.imagen_miniatura = e.target.result;
                };
                reader.readAsDataURL(file);

            },


           getFile(){
             let file = event.target.files[0];
                this.file = file;

                if (!/\.(txt|doc|docx|pdf|pptx|xlsx|ppt)$/i.test(file.name)) {
                    swal(
                        "Advertencia",
                        "El archivo a adjuntar no es una imagen",
                        "warning"
                    );
                    this.estado2 = 0
                } else {

                    if (file.size > 30000000) {
                        swal(
                            "Advertencia",
                            "El peso del archivo no puede exceder los 30mb",
                            "warning"
                        );
                        this.estado2 = 0
                    } else {
                        this.estado2 = 1
                    }
                }
            },
            limpiar(){
                 this.mostrar = false
            this.editar = false
            this.nombre = null
            this.descripcion = null
            this.importancia = null
            this.id = null,
            this.imagen = null,
            this.file = null
            },
            validar(){
                if(this.nombre == null || this.descripcion == null || this.nombre == "" || this.descripcion == "" || this.importancia == 'Nivel de Importancia'){
                    swal('Advertencia', 'Los campos informativos son necesarios', 'warning')
                }else if(this.editar==false){
                    this.guardar()
                }
                else if(this.editar==true){
                    this.actualizar()
                }
            }
           
            
    }
}
</script>
