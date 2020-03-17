<template>
    <div>
        <nav>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-user"></i> Perfil</li>
        <li class="breadcrumb-item"><i class="fa fa-newspaper-o"></i> Noticias</li>
         <li class="breadcrumb-item active" aria-current="page"></li>
    </ol>
</nav>
         <vue-headful
            :title="title"
        />
        <div v-show="rol != 4 && rol != 5 ">
        <button title="Nueva" class="btn-round btn btn-primary" type="button" v-show="mostrar == false"
            @click="mostrar = true,  title = 'Lincap | Crear noticia'"><i class="fa fa-plus"></i></button>
        <button class="btn btn-round btn-danger" title="Cerrar" type="button" v-show="mostrar" @click="mostrar = false, limpiar(), title='Lincap | Noticias'"><i class="fa fa-close"></i></button>
        </div>
        <form v-show="mostrar == true && editar == false" class="my-3" method="POST" @submit.prevent="validar">
             <div class="row">
             <div class="col-md-6">
             <div class="card" style="width:100%">
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
                        placeholder="Descripción de la noticia" onfocus v-model="descripcion" />
                    </div>
             </div>
              <div class="row">
                <div class="col-md-10 col-center col-sm-10 form-group has-feedback">
                    <select  class="form-control"  v-model="importancia">
                        <option value="Nivel de Importancia">Nivel de Importancia</option>
                           <option value="1">Normal</option>
                           <option  value="2">Importante</option>
                           <option  value="3">Muy Importante</option>
                           <option  value="4">Necesaria</option>
                            </select>
                    </div>
             </div>
             <div class="row">
                   <div class="col-md-12 col-center col-sm-12 form-group has-feedback">
                       <label for="imagen"  >Imagen...</label>
                       <input id="imagen" accept="image/*"  placeholder="Seleccionar Imagen" type="file" v-on:change="getImage($event)" />
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
                        placeholder="Descripción de la noticia" onfocus v-model="descripcion" />
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
            rol: null,
            title: 'Lincap | Noticias'
          
            
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

                     
                    axios({
                    method: 'post',
                    url: '/api/noticia/guardar',
                    data: formData,
                  
                })
                        .then(res => {
                            
                            swal('Correcto','Publicacion guardada','success')
                            .then(select => {
                                 EventBus.$emit("cargar", "o");
                                 this.limpiar()
                                // location.reload();
                            });
                        });
                } else {
                    swal(
                        "Advertencia",
                        "Haga una elección  diferente",
                        "error"
                    );
                }
        },
        editar2(item){
            this.title='Lincap | Editar noticia'
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
                   
            axios.post('/api/noticia/actualizar', formData)
            .then(res=>{
                EventBus.$emit("cargar", "o");
                this.limpiar();
                swal('Correcto', 'Noticia Actualizada', 'success')
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

                    if (file.size > 5000000) {
                        swal(
                            "Advertencia",
                            "El peso de la imagen no puede exceder los 4mb",
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
                        "El archivo a adjuntar no es una archivo",
                        "warning"
                    );
                    this.estado2 = 0
                } else {

                    if (file.size > 20000000) {
                        swal(
                            "Advertencia",
                            "El peso del archivo no puede exceder los 20mb",
                            "warning"
                        );
                        this.estado2 = 0
                    } else {
                        this.estado2 = 1
                    }
                }
            },
            limpiar(){
               this.title='Lincap | Noticias'
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
