<template>
    <div>
        <nav class="navbar navbar-light bg-light my-2">

            <div class=" pull-right">
                Ver
            </div>
            <div class="col-md-1">
                <select v-model="selectPag" @click.prevent="mostrarCaja()" class="form-control">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="0">Personalizado </option>
                </select>
            </div>
            <div class=" pull-left">
                Noticias
            </div>
              <div class="col-md-1"> <span class="icon pull-right"><i class="fa fa-building"></i></span></div>
            <div class="col-md-3 col-sm-2">
                <select v-model="select" class="form-control pull-left">
                    <option value="SELECCIONAR CATEGORIA">SELECCIONAR CATEGORIA</option>
                    <option value="1">NORMAL</option>
                    <option value="2">IMPORTANTE</option>
                    <option value="3">MUY IMPORTANTE</option>
                    <option value="4">NECESARIA</option>

                </select>
            </div>
            <div class="col-md-1"> <span class="icon pull-right"><i class="fa fa-search"></i></span></div>
            <div class="col-md-4  has-feedback mt-2">
                <input type="text" v-model="bnoticia" class="form-control pull-left" v-autofocus placeholder="Buscar noticia" />
            </div>
            
            <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>
        </nav>
       
        <div class="row mt-4">
            
            <div class="col-md-8 " v-for="(item, indice) in mbuscar" :key="indice"
                v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bnoticia != ''">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{item.cz12_nombre}} <small>
                                <span v-show="item.cz12_nivel_imp == 1">Normal</span>
                                <span v-show="item.cz12_nivel_imp == 2">Importante</span>
                                <span v-show="item.cz12_nivel_imp == 3">Muy importante</span>
                                <span v-show="item.cz12_nivel_imp == 4">Necesaria</span>
                            </small>
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
                            <li><a class="collapse-link" data-toggle="collapse"
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
                                     <p class="mb-1 mt-4"> <i class="fa fa-clock-o"></i> {{item.cz12_fecha_creacion}}
                                    </p>
                                    <p class="mb-2"> <a v-show="item.cz12_archivo != null"
                                            :href="'/../theme/files/noticias/'+ item.cz12_archivo" target="_blank">
                                            <li class="fa fa-file-archive-o"></li> Archivo adjunto
                                        </a></p>
                                         <p class="mb-1 mt-2"> <i class="fa fa-key"></i> {{item.cz12_id}}
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
            <div v-show="bnoticia == ''" class="col-md-4 col-center">
                <button type="button" @click.prevent="pagina=pagina-1" v-show="pagina!=1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(mbuscar.length) < 1"
                    class="btn btn-success">
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
            setTimeout(
                _ => this.carga = false,
                3000
            )
        },
        methods: {
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
                    this.pagina = 1
                    if (this.select == null || this.select == 'SELECCIONAR CATEGORIA') {
                        return String(noticia.cz12_id).toUpperCase().includes(this.bnoticia.toUpperCase())
                         noticia.cz12_nombre.toUpperCase().includes(this.bnoticia.toUpperCase()) ||
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
