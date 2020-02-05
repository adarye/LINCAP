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
            <div class="col-md-4 col-center col-sm-2  has-feedback">
                <select v-model="select" class="form-control">
                    <option value="SELECCIONAR CATEGORIA">SELECCIONAR CATEGORIA</option>
                   <option value="1">NORMAL</option>
                           <option  value="2">IMPORTANTE</option>
                           <option  value="3">MUY IMPORTANTE</option>
                           <option  value="4">NECESARIA</option>

                </select>
            </div>
            <div class="col-md-6 col-center has-feedback">
                <input type="text" v-model="bnoticia" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>
        </nav>

        <div class="border border-primary jumbotron jumbotron-fluid shadow p-3 mb-5 bg-white rounded" v-for="(item, indice) in mbuscar"
            :key="indice" v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bnoticia != ''">
            <div class="media">
                <span class="col-md-4 pull-left" v-show="item.cz12_imagen">
                    <img class="media-object img p-3" :src="'/../theme/images/noticias/'+ item.cz12_imagen">
                </span>
                <div class="media-body">
                    <h4 class="col-md-5 media-heading noti-title">{{item.cz12_nombre}} <button v-show="rol != 4 && rol != 3 "
                            @click="eliminar(item.cz12_id)" class="btn-sm btn-danger fa fa-trash mb-2"></button>
                        <button v-show="rol != 4 && rol != 3 " @click="$emit('editar2', item)"
                            class="btn-sm btn-warning fa fa-edit mb-2"></button>
                    </h4>
                    <p class="text-right mb-2"> <img :src="'/../theme/images/profile/'+ item.cz1_avatar" alt="" class="img-profile-noti">By {{item.cz1_nombres}} </p>

                    <p class="lead noti-text shadow-lg">{{item.cz12_descripcion}}</p>
                    <ul class="list-inline list-unstyled">
                        <li class="mt-3"><span><i class="fa fa-clock-o"></i>
                               {{item.cz12_fecha_creacion}}
                               
                               </span></li>
                    </ul>
                    <a v-show="item.cz12_archivo != null" :href="'/../theme/files/noticias/'+ item.cz12_archivo"
                     target="_blank" ><li class="fa fa-file-archive-o"></li> Archivo adjunto</a>
                </div>
            </div>
            <span class="pull-right">
                <h4><span v-show="item.cz12_nivel_imp == 1" class="badge lead badge-success">Normal</span></h4>
                <h4><span v-show="item.cz12_nivel_imp == 2" class="badge lead badge-primary">Importante</span></h4>
                <h4><span v-show="item.cz12_nivel_imp == 3" class="badge lead badge-warning">Muy importante</span></h4>
                <h4><span v-show="item.cz12_nivel_imp == 4" class="badge lead badge-danger">Necesaria</span></h4>
            </span>
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
                selectPag: 5,
                numero: 5,
                mostrar: 0,
                pagina: 1,
                bnoticia: ''

            }
        },
        beforeMount() {
            this.rol = user.rol
            this.index()
            EventBus.$on('cargar', (item) => {
                this.index()
            });
        },
        methods: {
            index() {
                axios.get('/api/noticias/')
                    .then(res => {
                        this.noticias = res.data
                        console.log(this.noticias)
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
                                console.log(res.data)
                                this.index();
                                swal("Eliminado", {
                                    icon: "success"
                                });
                            });
                    }
                });


            },
            descargarFile(id){
                axios.get(`api/noticia/download-file/${id}`)
                .then(res =>{
                    console.log(res.data)
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
                        return noticia.cz12_nombre.toUpperCase().includes(this.bnoticia.toUpperCase()) ||
                            noticia.cz12_descripcion.toUpperCase().includes(this.bnoticia.toUpperCase())
                    }
                      else if(this.select == '4') {
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
                                
                            )
                        );
                    }
                    else if(this.select == '3') {
                        return (
                            (noticia.cz12_nivel_imp == 3 &&
                               noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())                              
                            )||
                            (noticia.cz12_nivel_imp == 3 &&
                               noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                                
                            )
                        );
                    }
                    else if(this.select == '2') {
                        return (
                            (noticia.cz12_nivel_imp == 2 &&
                               noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())  
                            )
                            ||
                            (noticia.cz12_nivel_imp == 2 &&
                               noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                                
                            )
                        );
                    }
                     else if(this.select == '1') {
                        return (
                            (noticia.cz12_nivel_imp == 1 &&
                               noticia.cz12_nombre
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase()) 
                            )||
                            (noticia.cz12_nivel_imp == 1 &&
                               noticia.cz12_descripcion
                                .toUpperCase()
                                .includes(this.bnoticia.toUpperCase())
                                
                            )
                        );
                    }
                    
                })
            }

        }

    }

</script>
