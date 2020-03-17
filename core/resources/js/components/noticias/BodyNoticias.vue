<template>
    <div>
        <nav class="navbar navbar-light bg-light my-2">

            <div class="pull-right">
                <b>
                Ver
                </b>
            </div>
            <div class="col-md-1">
                  <input v-numeric-only v-on:keyup="constantes(); validarPagina();" class="form-control mt-2" v-model="numero" />
            </div>
            <div class="pull-left">
                 <b>
                Noticia(s)
                </b>
            </div>
              
            <div class="col-md-5 mt-2">
                <select @change="constantes(); validarPagina();" v-model="select" class="form-control mt-2">
                    <option value="SELECCIONAR CATEGORIA">TODAS LAS CATEGORÍAS </option>
                    <option value="1">NORMAL</option>
                    <option value="2">IMPORTANTE</option>
                    <option value="3">MUY IMPORTANTE</option>
                    <option value="4">NECESARIA</option>

                </select>
            </div>
            
            <div class="col-md-5  has-feedback mt-2">
                <input type="text" v-on:keyup="constantes()" v-model="bnoticia" class="form-control mt-2" v-autofocus placeholder="Buscar noticia" />
            </div>
            
            <div class="col-md-1" v-if="mostrar == 1"></div>
        </nav>
       
        <div class="row mt-4">
            
            <div class="col-md-6 " v-for="(item, indice) in mbuscar" :key="indice"
                v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bnoticia != ''">
      
                <div class="x_panel">
                    <small>
                                 <h4 style="color: white !important;"><span v-show="item.cz12_nivel_imp == 1"
                                        class="badge lead badge-success">Normal</span></h4>
                                <h4><span v-show="item.cz12_nivel_imp == 2"
                                        class="badge lead badge-primary">Importante</span></h4>
                                <h4><span v-show="item.cz12_nivel_imp == 3" class="badge lead badge-warning">Muy
                                        importante</span></h4>
                                <h4><span v-show="item.cz12_nivel_imp == 4"
                                        class="badge lead badge-danger">Necesaria</span></h4>
                            </small>
                    <div class="x_title">
                        <h2>{{item.cz12_nombre}} 
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li v-show="rol != 4 && rol != 5 ">
                                <a @click="$emit('editar2', item)">
                                    <i class="fa fa-edit"> </i>
                                </a>

                            </li>
                            
                            <li v-show="rol != 4 && rol != 5 ">
                                <a @click="eliminar(item.cz12_id)">
                                    <i class="fa fa-close"> </i>
                                </a>

                            </li>
                            <li><a  class="collapse show" data-toggle="collapse"
                                    :data-target="'#collapse'+item.cz12_id"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="collapse" :id="'collapse'+item.cz12_id">
                        <article class="media event">
                            
                            <div class="media-body">
                                <div class="col-md-12">
                                   
                                    <p style="text-align: justify" class="">{{item.cz12_descripcion}}</p>

                                </div>
                                <div class="col-md-5 col-sm-6" v-show="item.cz12_imagen">
                                    <img class="media-object img p-3"
                                        :src="'/../theme/images/noticias/'+ item.cz12_imagen">
                                </div>
                                <div class="col-md-7 col-sm-6">
                                     <p class="mb-1 mt-4"> <i class="fa fa-clock-o"></i> Fecha de creación: {{item.cz12_fecha_creacion}}
                                    </p>
                                    <p class="mb-2"> <a v-show="item.cz12_archivo != null"
                                            :href="'/../theme/files/noticias/'+ item.cz12_archivo" target="_blank" style="text-decoration: underline;" title="Descargar">
                                            <li class="fa fa-download"></li>  Descargar archivo
                                        </a></p>
                                         <p class="mb-1 mt-2"> <i class="fa fa-key"></i> key: {{item.cz12_id}}
                                    </p>
                                       <p><b> By {{item.cz1_nombres}}</b> <img
                                        :src="'/../theme/images/profile/'+ item.cz1_avatar" alt=""
                                        class="img-profile-noti"></p>
                                       
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
           

        </div>
         


        <div class="row">
            <div class="col-md-5 col-float"></div>
            <div v-if="bnoticia == ''" class="col-md-4 col-center">
                <button type="button" @click.prevent="pagina = Number(pagina) - 1; constantes()" :disabled="pagina == 1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina = Number(pagina) + 1; constantes()"
                    class="btn btn-success" :disabled="(pagina * numero) / mbuscar.length >= 1">
                    <li class="fa fa-long-arrow-right"></li>
                </button>
            </div>
            <div class="col-md-3">
                <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                    {{ mbuscar.length }} noticias</div>
            </div>


            <!-- <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</div> -->
        </div>
        <center>

            <div v-show="carga  && noticias.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-show="carga == false  && noticias.length == []">
                <p>No se encontraron noticias</p>
            </div>
        </center>
       
    </div>
</template>
<script>
    import moment from "moment";
    moment.locale("es");
    import EventBus from '../../bus';
    export default {
        data() {
            return {
                noticias: [],
                moment: moment,
                rol: null,
                select: 'SELECCIONAR CATEGORIA',
                selectPag: 10,
                numero: 10,
                mostrar: 0,
                pagina: 1,
                bnoticia: '',
                carga: true

            }
        },
        beforeMount() {
            this.rol = user.rol
            this.index()
            EventBus.$on('cargar', (item) => {
                this.index()
            });
            this.cache();
            setTimeout(
                _ => this.carga = false,
                3000
            )
        },
        methods: {
            validarPagina(){
                localStorage.setItem('pagina_n', 1)
                this.pagina = 1; 
                

            },
            cache(){
                 if(localStorage.input_n == undefined){
                          localStorage.setItem('input_n', this.bnoticia)
                     
                    } 
                    else{
                        this.bnoticia = localStorage.input_n;
                    }
                    if(localStorage.pagina_n == undefined){
                        localStorage.setItem('pagina_n', this.pagina)

                    }
                    else{
                          this.pagina = localStorage.pagina_n;
                    }
                     if(localStorage.select_n == undefined){
                        localStorage.setItem('select_n', this.select)

                    }
                    else{
                          this.select = localStorage.select_n;
                    }
                    if(localStorage.pag_n == undefined){
                        localStorage.setItem('pag_n', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_n;
                    }
                     if(localStorage.numero_n == undefined){
                        localStorage.setItem('numero_n', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_n;
                    }
            },
            constantes(){
                localStorage.setItem('input_n', this.bnoticia)
                localStorage.setItem('pagina_n', this.pagina)
                localStorage.setItem('select_n', this.select)
                 localStorage.setItem('pag_n', this.selectPag)
                  localStorage.setItem('numero_n', this.numero)
            },
            index() {
                axios.get('/api/noticias/')
                    .then(res => {
                        this.noticias = res.data
                        
                    })
            },
            eliminar(id) {
                swal({
                    title: "Advertencia",
                    text: "¿Esta seguro de eliminar esta noticia?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios.delete(`/api/noticia/delete/${id}`)
                            .then(res => {
                            
                                this.index();
                                swal("Eliminado", {
                                    icon: "success"
                                });
                            });
                    }
                });


            },
            descargarFile(id) {
                axios.get(`api/noticia/download-file/${id}`)
                    .then(res => {
                      
                    })
            },
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1
                } else {
                    this.mostrar = 0
                    this.numero = this.selectPag
                }
            }

        },
        computed: {
            mbuscar: function () {
                return this.noticias.filter((noticia) => {
                    // this.pagina = 1
                    if (this.select == null || this.select == 'SELECCIONAR CATEGORIA') {
                        return String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())
                        || noticia.cz12_nombre.toUpperCase().includes(this.bnoticia.toUpperCase()) ||
                            noticia.cz12_descripcion.toUpperCase().includes(this.bnoticia.toUpperCase())
                    } else if (this.select == '4') {
                        return (
                            (noticia.cz12_nivel_imp == 4 &&
                                noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())

                            ) ||
                            (noticia.cz12_nivel_imp == 4 &&
                                noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())

                            )||
                            (noticia.cz12_nivel_imp == 4 &&
                               String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())

                            )
                        );
                    } else if (this.select == '3') {
                        return (
                            (noticia.cz12_nivel_imp == 3 &&
                                noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                            ) ||
                            (noticia.cz12_nivel_imp == 3 &&
                                noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())

                            )||
                            (noticia.cz12_nivel_imp == 3 &&
                               String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())

                            )
                        );
                    } else if (this.select == '2') {
                        return (
                            (noticia.cz12_nivel_imp == 2 &&
                                noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                            ) ||
                            (noticia.cz12_nivel_imp == 2 &&
                                noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())

                            )||
                            (noticia.cz12_nivel_imp == 2 &&
                               String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())

                            )
                        );
                    } else if (this.select == '1') {
                        return (
                            (noticia.cz12_nivel_imp == 1 &&
                                noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                            ) ||
                            (noticia.cz12_nivel_imp == 1 &&
                                noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())

                            )||
                            (noticia.cz12_nivel_imp == 1 &&
                               String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())

                            )
                        );
                    }

                })
            }

        }

    }

</script>
