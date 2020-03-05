<template>
    <div>
        <vue-headful title="Lincap | Actualizar datos" />

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" v-show="this.$route.params.ruta != null"><i class="fa fa-folder"> Empleados
                    </i></li>
                <li class="breadcrumb-item" v-show="this.$route.params.ruta == null"><i class="fa fa-male"> Perfil </i>
                </li>

                <li class="breadcrumb-item" v-show="this.$route.params.ruta != null"> <i class="fa fa-user">
                        <router-link :to="{ name: this.$route.params.ruta }"> {{ this.$route.params.ruta  }}
                        </router-link>
                    </i></li>

                <li class="breadcrumb-item"><i class="fa fa-edit"> Actualizar</i></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Inf. Personal</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab"
                    aria-controls="nav-profile" aria-selected="false">Inf. Corporativa</a>
                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab"
                    aria-controls="nav-contact" aria-selected="false">Inf. SST</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <infPersonal v-bind="{
                        informacion: informacion,
                        usuario: usuario,
                        apellidos: apellidos,
                        ciudades: ciudades,
                        barrios: barrios,
                        validated: validated,
                        empleado_info: empleado_info,
                        sexo: sexo,
                        estado_civil: estado_civil,
                        validated_admin: validated_admin,
                        viviendas: viviendas,
                        vivienda: vivienda
                    }" v-on:cargarBarrios="cargarBarrios" v-on:changeVivienda="changeVivienda" v-on:cambiarBarrio="cambiarBarrio" v-on:getImage="getImage">
                </infPersonal>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <InfCorporativa v-bind="{
                        informacion: informacion,
                        usuario: usuario,
                        empleado_info: empleado_info,
                        validated: validated,
                        tipo_contrato: tipo_contrato,
                        validated_admin: validated_admin
                    }"></InfCorporativa>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                <InfSST
                    v-bind="{ empleado_info: empleado_info, validated:validated, validated_admin: validated_admin, tipo_sangre : tipo_sangre, rol: rol }"
                    v-on:getFileTitulacion="getFileTitulacion" v-on:getFileVacunacion="getFileVacunacion">
                </InfSST>
            </div>
        </div>

        <modal name="hello-world" :clickToClose="false" :adaptive="true" :width="430" :height="430">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <form @submit.prevent="updateAvatar" anctype="multipart/form-data">
                            <h1>Actualizar avatar</h1>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input type="file" @change="getImage($event)" />
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">
                                    subir
                                </button>
                                <button type="button" @click="$modal.hide('hello-world');"
                                    class="btn btn-danger">Cancelar</button>
                            </div>
                            <figure>
                                <img width="200" height="200" alt="profile" :src="imagen_miniatura" />
                            </figure>
                        </form>
                    </section>
                </div>
            </div>
        </modal>


        <span v-if="!validated">
            <div class="col-md-6">
                <button @click="habilitarFormulario" class="btn btn-primary my-2">
                    Editar
                </button>
            </div>
        </span>
        <span v-else>

            <div class="col-md-4 col-center">
                <button @click="validarCampos" class="btn btn-primary">
                    Actualizar
                </button>
                <button @click="showModal()" class="btn btn-primary">
                    Subir Imagen
                </button>
                <button @click="desabilitarFormulario" class="btn btn-danger">
                    Cancelar
                </button>
            </div>

        </span>
    </div>

</template>
<script>
    import moment from "moment";
    moment.locale("es");
    import router from '../../js/router';
    export default {
        data() {
            return {
                ciudad_seleccionada: "",
                apellidos: "",
                informacion: {},
                validated: false,
                validated_admin: false,
                permiso_admin: false,
                ubicacion: "",
                id_ciudad: 0,
                ciudades: [],
                barrios: [],
                usuario: "",
                empleado_info: {},
                sexo: "",
                moment: moment,
                imagen: "",
                imagen_miniatura: "",
                estado: 0,
                actualizando: false,
                perfiles: [],
                i: 0,
                tipo_contrato: "",
                estado_civil: "",
                tipo_sangre: "",
                file_titulacion: "",
                file_vacunacion: "",
                estado2: "",
                viviendas: [],
                vivienda: "",
                rol: ""
            };
        },
        beforeMount() {
            this.rol = window.user.rol
            if (window.user.rol == 1 || window.user.rol == 2 || window.user.rol == 3) {
               
            } else {
                router.push('/empleado/' + window.user.id);
            }
            axios.get(`/api/empleado/show/${this.$route.params.id}`).then(res => {
                this.informacion = res.data[0];
               
                this.apellidos =
                    this.informacion.c0541_apellido1 +
                    " " +
                    this.informacion.c0541_apellido2;
                this.validarSexo();
                this.validarEstadoCivil();
                this.validarSangre()
            });
            this.cargarContrato();
            this.cargarCiudades();
            this.traerEmpleadoInfo()
            this.cargarViviendas()

        },

        methods: {
            cargarViviendas(){
                axios.get('/api/viviendas')
                .then(res=>{
                    this.viviendas = res.data
                    
                })

            },
            changeVivienda(vivienda){
                this.vivienda = vivienda
            },

            habilitarFormulario() {
                this.validated = true;
                
                if (window.user.rol == 1 || window.user.rol == 2 || window.user.rol == 3) {
                    this.validated_admin = true;
                }

            },
            getFileTitulacion(event) {
                let file = event.target.files[0];


                if (!/\.(pdf)$/i.test(file.name)) {
                    swal(
                        "Advertencia",
                        "El archivo a adjuntar tiene que ser un PDF",
                        "warning"
                    );
                    this.estado2 = 0
                } else {

                    if (file.size >  5000000) {
                        swal(
                            "Advertencia",
                            "El peso del archivo no puede exceder los 5mb",
                            "warning"
                        );
                        this.estado2 = 0
                    } else {
                        this.estado2 = 1
                        this.file_titulacion = file;
                    }
                }

            },
            getFileVacunacion(event) {
                let file = event.target.files[0];
                
                if (!/\.(pdf)$/i.test(file.name)) {
                    swal(
                        "Advertencia",
                        "El archivo a adjuntar tiene que ser un PDF",
                        "warning"
                    );
                    this.estado2 = 0
                } else {

                    if (file.size > 5000000) {
                        swal(
                            "Advertencia",
                            "El peso del archivo no puede exceder los 4mb",
                            "warning"
                        );
                        this.estado2 = 0
                    } else {
                        this.estado2 = 1
                        this.file_vacunacion = file;
                    }
                }

            },
            desabilitarFormulario() {
                this.validated = false;
                this.validated_admin = false;
               
            },
            traerEmpleadoInfo() {
                axios
                    .get(`/api/empleado/informacion/${this.$route.params.id}`)
                    .then(res => {
                        console.log(res.data)
                        if (res.data == "") {
                            console.log("entre aqui ayudame bro")
                            this.empleado_info = {
                                cz9_nombre_familiar: "",
                                cz9_nombre_contacto: "",
                                cz9_tel_contacto: "",
                                cz9_talla_uniforme: "",
                                cz9_talla_calzado: "",
                                cz9_mail_corp: "",
                                cz9_tel_corp: "",
                                cz9_cel_corp: "",
                                cz9_fecha_tpprueba: "",
                                cz9_fecha_tpprueba: "",
                                cz9_fecha_vacuna: "",
                                cz9_lugar_vacuna: "",
                                cz9_fecha_vacuna_tifoidea: "",
                                cz9_lugar_vacuna_tifoidea: "",
                                cz9_fecha_vacuna_toxoide: "",
                                cz9_lugar_vacuna_toxoide: "",
                                cz9_reentrenamiento: "",
                                cz9_premios: "",
                                cz9_fv_ta: "",
                                cz9_fv_bpm: "",
                                cz9_fv_md: "",
                                cz9_fv_carne_vacunacion: "",
                                cz9_fv_carne_alimentos: "",
                                cz9_archivo_titulacion: "",
                                cz9_archivo_vacunacion: "",
                                cz9_id_vivienda: "",
                                c0780_descripcion: ""
                            };
                        } else {
                            this.empleado_info = res.data;
                            console.log(this.empleado_info);
                        }
                    });
            },
            actualizar() {
                let formData = new FormData();
                formData.append("email", this.informacion.f015_email ?  this.informacion.f015_email.toUpperCase() : "");
                formData.append("telefono", this.informacion.f015_telefono ?  this.informacion.f015_telefono : "");
                formData.append("celular", this.informacion.f015_celular ?  this.informacion.f015_celular : "");
                formData.append("direccion", this.informacion.f015_direccion1 ?  this.informacion.f015_direccion1 : "");
                formData.append("barrio", this.informacion.f015_id_barrio  ? this.informacion.f015_id_barrio : "");
                formData.append("ciudad", this.informacion.f015_id_ciudad ? this.informacion.f015_id_ciudad : "");
                formData.append("familiar_linco", this.empleado_info.cz9_nombre_familiar ? this.empleado_info.cz9_nombre_familiar.toUpperCase() : "");
                formData.append("contacto", this.empleado_info.cz9_nombre_contacto  ? this.empleado_info.cz9_nombre_contacto.toUpperCase() : "");
                formData.append("con_num", this.empleado_info.cz9_tel_contacto ? this.empleado_info.cz9_tel_contacto : "");
                formData.append("file_titulacion", this.file_titulacion ? this.file_titulacion : "");
                formData.append("file_vacunacion", this.file_vacunacion ? this.file_vacunacion : "" );
                formData.append("talla_uni", this.empleado_info.cz9_talla_uniforme ? this.empleado_info.cz9_talla_uniforme : "" );
                formData.append("talla_cal", this.empleado_info.cz9_talla_calzado ? this.empleado_info.cz9_talla_calzado : "");
                formData.append("email_corp", this.empleado_info.cz9_mail_corp ? this.empleado_info.cz9_mail_corp.toUpperCase() : "");
                formData.append("tel_corp", this.empleado_info.cz9_tel_corp ? this.empleado_info.cz9_tel_corp : "");
                formData.append("cel_corp", this.empleado_info.cz9_cel_corp ? this.empleado_info.cz9_cel_corp : "");
                formData.append("fecha_tpprueba", this.empleado_info.cz9_fecha_tpprueba ? this.empleado_info.cz9_fecha_tpprueba : "");
                formData.append("fecha_vacuna", this.empleado_info.cz9_fecha_vacuna ? this.empleado_info.cz9_fecha_vacuna : "");
                formData.append("lugar_vacuna", this.empleado_info.cz9_lugar_vacuna ? this.empleado_info.cz9_lugar_vacuna.toUpperCase() : "");
                formData.append("fecha_vacuna_tifoidea", this.empleado_info.cz9_fecha_vacuna_tifoidea ? this.empleado_info.cz9_fecha_vacuna_tifoidea : "");
                formData.append("lugar_vacuna_tifoidea", this.empleado_info.cz9_lugar_vacuna_tifoidea ? this.empleado_info.cz9_lugar_vacuna_tifoidea.toUpperCase() : "");
                formData.append("fecha_vacuna_toxoide", this.empleado_info.cz9_fecha_vacuna_toxoide ? this.empleado_info.cz9_fecha_vacuna_toxoide: "");
                formData.append("lugar_vacuna_toxoide", this.empleado_info.cz9_lugar_vacuna_toxoide ? this.empleado_info.cz9_lugar_vacuna_toxoide.toUpperCase(): "");
                formData.append("reentrenamiento", this.empleado_info.cz9_reentrenamiento ? this.empleado_info.cz9_reentrenamiento: "");
                formData.append("cz9_premios", this.empleado_info.cz9_premios ? this.empleado_info.cz9_premios.toUpperCase(): "");
                formData.append("cz9_fv_ta", this.empleado_info.cz9_fv_ta ? this.empleado_info.cz9_fv_ta: "");
                 formData.append("cz9_fv_bpm", this.empleado_info.cz9_fv_bpm ? this.empleado_info.cz9_fv_bpm: "");
                  formData.append("cz9_fv_md", this.empleado_info.cz9_fv_md ? this.empleado_info.cz9_fv_md: "");
                   formData.append("cz9_fv_carne_vacunacion", this.empleado_info.cz9_fv_carne_vacunacion ? this.empleado_info.cz9_fv_carne_vacunacion: "");
                   formData.append("cz9_fv_carne_alimentos", this.empleado_info.cz9_fv_carne_alimentos ? this.empleado_info.cz9_fv_carne_alimentos: "");
                   formData.append("cz9_archivo_titulacion", this.empleado_info.cz9_archivo_titulacion ? this.empleado_info.cz9_archivo_titulacion: "");
                   formData.append("cz9_archivo_vacunacion", this.empleado_info.cz9_archivo_vacunacion ? this.empleado_info.cz9_archivo_vacunacion: "");
                   formData.append("cz9_id_vivienda", this.empleado_info.cz9_id_vivienda ? this.empleado_info.cz9_id_vivienda: "");



                const params = {

                    email: this.informacion.f015_email,
                    telefono: this.informacion.f015_telefono,
                    celular: this.informacion.f015_celular,
                    direccion: this.informacion.f015_direccion1,
                    barrio: this.informacion.f015_id_barrio,
                    ciudad: this.informacion.f015_id_ciudad,
                    familiar_linco: this.empleado_info.cz9_nombre_familiar,
                    contacto: this.empleado_info.cz9_nombre_contacto,
                    con_num: this.empleado_info.cz9_tel_contacto,
                    talla_uni: this.empleado_info.cz9_talla_uniforme,
                    talla_cal: this.empleado_info.cz9_talla_calzado,
                    email_corp: this.empleado_info.cz9_mail_corp,
                    tel_corp: this.empleado_info.cz9_tel_corp,
                    cel_corp: this.empleado_info.cz9_cel_corp,
                    fecha_tpprueba: this.empleado_info.cz9_fecha_tpprueba,
                    fecha_vacuna: this.empleado_info.cz9_fecha_vacuna,
                    lugar_vacuna: this.empleado_info.cz9_lugar_vacuna,
                    fecha_vacuna_tifoidea: this.empleado_info
                        .cz9_fecha_vacuna_tifoidea,
                    lugar_vacuna_tifoidea: this.empleado_info
                        .cz9_lugar_vacuna_tifoidea,
                    fecha_vacuna_toxoide: this.empleado_info
                        .cz9_fecha_vacuna_toxoide,
                    lugar_vacuna_toxoide: this.empleado_info
                        .cz9_lugar_vacuna_toxoide,
                    reentrenamiento: this.empleado_info.cz9_reentrenamiento,
                    cz9_premios: this.empleado_info.cz9_premios,
                    cz9_fv_ta: this.empleado_info.cz9_fv_ta,
                    cz9_fv_bpm: this.empleado_info.cz9_fv_bpm,
                    cz9_fv_md: this.empleado_info.cz9_fv_md,
                    cz9_fv_carne_vacunacion: this.empleado_info.cz9_fv_carne_vacunacion,
                    cz9_fv_carne_alimentos: this.empleado_info.cz9_fv_carne_alimentos,
                    cz9_archivo_titulacion: this.empleado_info.cz9_archivo_titulacion,
                    cz9_archivo_vacunacion: this.empleado_info.cz9_archivo_vacunacion
                };
               
               
                axios.post(
                        `/api/empleado/update/${this.informacion.c0540_rowid_tercero}`,
                        formData
                    )
                    .then(res => {
                       
                        this.validated = false;
                        this.validated_admin = false;
                        swal("Registro actualizado", "Datos Correctos", "success");
                         this.traerEmpleadoInfo()
                    });

            },
            validarSangre() {
                if (this.informacion.c0541_ind_grupo_sanguineo == 0) {
                    this.tipo_sangre = "Por definir"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 1) {
                    this.tipo_sangre = "O-"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 2) {
                    this.tipo_sangre = "O+"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 3) {
                    this.tipo_sangre = "A-"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 4) {
                    this.tipo_sangre = "A+"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 5) {
                    this.tipo_sangre = "B-"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 6) {
                    this.tipo_sangre = "B+"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 7) {
                    this.tipo_sangre = "AB-"
                } else if (this.informacion.c0541_ind_grupo_sanguineo == 8) {
                    this.tipo_sangre = "AB+"
                }

            },
            validarSexo() {
                if (this.informacion.c0540_ind_sexo == 1) {
                    this.sexo = "Femenino";
                } else if (this.informacion.c0540_ind_sexo == 0) {
                    this.sexo = "Masculino";
                }
            },
            validarEstadoCivil() {
                if (this.informacion.c0540_ind_estado_civil == 0) {
                    this.estado_civil = "Ninguno"
                } else if (this.informacion.c0540_ind_estado_civil == 1) {
                    this.estado_civil = "Soltero(a)"
                } else if (this.informacion.c0540_ind_estado_civil == 2) {
                    this.estado_civil = "Casado(a)"
                } else if (this.informacion.c0540_ind_estado_civil == 3) {
                    this.estado_civil = "Viudo(a)"
                } else if (this.informacion.c0540_ind_estado_civil == 4) {
                    this.estado_civil = "Divorciado(a)"
                } else if (this.informacion.c0540_ind_estado_civil == 5) {
                    this.estado_civil = "Unión libre"
                }

            },

            cargarCiudades(event) {
                axios.get("/api/ciudad").then(res => {
                    this.ciudades = res.data;
                });
            },
            cargarBarrios(event) {
                axios.get(`/api/barrios/${event.target.value}`).then(res => {
                    this.barrios = res.data;
                    if (this.barrios.length == 0) {
                        this.informacion.f015_id_barrio = ""
                        swal(
                            "No se encontraron barrios",
                            "Comuníquese con los proveedores de LINCAP para agregar mas barrios",
                            "warning"
                        );
                    }
                    this.informacion.f015_id_ciudad = event.target.value;
                });
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

                    if (file.size > 8000000) {
                        swal(
                            "Advertencia",
                            "El peso de la imagen no puede exceder las 7mb",
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

            updateAvatar(event) {
                if (this.estado != 0) {
                    let formData = new FormData();
                    formData.append("imagen", this.imagen);
                   

                    axios
                        .post(`/api/usuario/avatar/${this.$route.params.id}`, formData)
                        .then(res => {
                            swal({
                                title: "Mensaje",
                                text: "La foto ha sido actualizada",
                                icon: "success"
                            }).then(select => {
                                location.reload();
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

            cambiarBarrio(event) {
                this.informacion.f015_id_barrio = event.target.value;
                
            },
            cargarContrato() {
                axios.get(`/api/empleado/${this.$route.params.id}`).then(res => {
                    // this.perfiles = res.data
                    this.usuario = res.data;

                  
                    this.usuario.c0540_fecha_nacimiento = moment(this.usuario.c0540_fecha_nacimiento).format(
                        'll');
                    this.usuario.c0540_fecha_exp_identif = moment(this.usuario.c0540_fecha_exp_identif).format(
                        'll');
                    this.usuario.c0550_fecha_ingreso = moment(this.usuario.c0550_fecha_ingreso).format('ll');
                    if (this.usuario.c0550_fecha_contrato_hasta != null) {
                        this.usuario.c0550_fecha_contrato_hasta = moment(this.usuario
                            .c0550_fecha_contrato_hasta).format('ll');
                    } else {
                        this.usuario.c0550_fecha_contrato_hasta = 'Fecha Indefinida'
                    }
                    if (this.usuario.c0550_ind_termino_contrato == 1) {
                        this.tipo_contrato = "CONTRATO TEMPORAL"
                    } else {
                        this.tipo_contrato = "CONTRATO INDEFINIDO"

                    }




                });
            },
            cambiar() {
                this.i++
                this.usuario = this.perfiles[this.i]
                this.usuario.c0540_fecha_nacimiento = moment(this.usuario.c0540_fecha_nacimiento).format('ll');
                this.usuario.c0540_fecha_exp_identif = moment(this.usuario.c0540_fecha_exp_identif).format('ll');
                this.usuario.c0550_fecha_ingreso = moment(this.usuario.c0550_fecha_ingreso).format('ll');
                if (this.usuario.c0550_fecha_contrato_hasta != null) {
                    this.usuario.c0550_fecha_contrato_hasta = moment(this.usuario.c0550_fecha_contrato_hasta).format(
                        'll');
                } else {
                    this.usuario.c0550_fecha_contrato_hasta = 'Fecha Indefinida'
                }
            },
            validarCampos() {

               
                if (this.informacion.f015_email == "") {
                    swal("Alerta", "El email es obligatorio", "warning");
                } else if (this.informacion.f015_telefono == "") {
                    swal(
                        "Alerta",
                        "El numero de telefono es obligatorio",
                        "warning"
                    );
                } else if (this.informacion.f015_id_barrio == "") {
                    swal(
                        "Alerta",
                        "El barrio es obligatorio",
                        "warning"
                    );
                } else if (this.informacion.f015_id_ciudad == "") {
                    swal(
                        "Alerta",
                        "La ciudad es obligatoria",
                        "warning"
                    );
                } else if (this.informacion.f015_celular == "") {
                    swal(
                        "Alerta",
                        "El numero de celular es obligatorio",
                        "warning"
                    );
                } else if (this.informacion.f015_direccion1 == "") {
                    swal("Alerta", "La direccion es obligatoria", "warning");
                } else if (this.informacion.f015_id_barrio == "") {
                    swal("Alerta", "El barrio es obligatorio", "warning");
                } else if (this.informacion.f015_id_ciudad == "") {
                    swal("Alerta", "La ciudad es obligatoria", "warning");

                } else if (this.empleado_info.cz9_nombre_contacto == "") {
                    swal(
                        "Alerta",
                        "El nombre del familiar es obligatorio",
                        "warning"
                    );
                } else if (this.empleado_info.cz9_tel_contacto == "") {
                    swal(
                        "Alerta",
                        "El numero del familiar es obligatorio",
                        "warning"
                    );
                } else {
                    this.validated = false;
                    this.validated_admin = false
                    this.actualizar();
                }
            },
            showModal() {
                this.$modal.show("hello-world");
            },
            hide() {
                this.$modal.hide("hello-world");
            }
        },

        computed: {
            imagen2() {
                return this.imagen_miniatura;
            }
        }
    };

</script>
