<template>
    <div>
        <center>
            <h1>Actualizar datos</h1>
        </center>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Inf. Personal</a></li>
            <li><a data-toggle="tab" href="#menu1">Inf. Corporativa</a></li>
            <li><a data-toggle="tab" href="#menu2">Inf. SST</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            <infPersonal v-bind="{'informacion': informacion, 'usuario': usuario, 
            'apellidos':apellidos, 'ciudades':ciudades, 'barrios':barrios, 'validated': validated, 
            'empleado_info': empleado_info, 'sexo': sexo, 'permiso_admin':permiso_admin}" v-on:cargarBarrios="cargarBarrios"
            v-on:cambiarBarrio="cambiarBarrio" v-on:getImage="getImage"></infPersonal>
          </div>
            
            
            <div id="menu1" class="tab-pane fade">
                <InfCorporativa v-bind="{'informacion': informacion, 'usuario': usuario 
                ,'empleado_info': empleado_info, 'validated': validated}"></InfCorporativa>
            </div>


            <div id="menu2" class="tab-pane fade">
                <InfSST v-bind="{'empleado_info': empleado_info}"></InfSST>
            </div>
        </div>
        <div class="form-row">
            <span v-if="!validated">
                <div class="form-group col-md-6">
                    <button @click="habilitarFormulario" class="btn btn-primary my-2">
                        Editar
                    </button>
                </div>
            </span>
            <span v-else>
                <div class="form-group col-md-6">
                    <button @click="validarCampos" class="btn btn-primary">
                        Actualizar
                    </button>
                <button @click="updateAvatar" class="btn btn-primary">
                        Actualizar avatar
                    </button>
                    <button @click="desabilitarFormulario" class="btn btn-danger">
                        Cancelar
                    </button>
                </div>
            </span>
            
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    moment.locale('es');
    export default {

        data() {
            return {
                ciudad_seleccionada: "",
                apellidos: "",
                informacion: {},
                validated: false,
                permiso_admin: false,
                ubicacion: "",
                id_ciudad: 0,
                ciudades: [],
                barrios: [],
                usuario: '',
                empleado_info: {},
                sexo:'',
                moment: moment,
                imagen: ''
            };
        },
        mounted() {
            
            console.log(this.$route.params.id)
            axios.get(`/api/empleado/show/${this.$route.params.id}`).then(res => {
                this.informacion = res.data[0];
                console.log(this.informacion);
                this.apellidos =
                    this.informacion.c0541_apellido1 +
                    " " +
                    this.informacion.c0541_apellido2;
                     this.validarSexo();
            });
            this.cargarContrato();
            this.cargarCiudades();
            this.traerEmpleadoInfo();    
           
           
        },
        
        methods: {
            habilitarFormulario() {
                this.validated = true
                
            },
            desabilitarFormulario() {
                this.validated = false;
                console.log(this.ciudad_seleccionada);
            },
            traerEmpleadoInfo(){
                 axios.get(`/api/empleado/informacion/${this.$route.params.id}`)
                 .then(res => {
                if(res.data == ''){
                    this.empleado_info = {cz9_nombre_familiar: '', cz9_nombre_contacto: '',
                     cz9_tel_contacto: '', cz9_talla_uniforme: '', 
                     cz9_talla_calzado: '', cz9_mail_corp: '', 
                     cz9_tel_corp: '', cz9_cel_corp: '', 
                     cz9_fecha_tpprueba: '', cz9_fecha_tpprueba:'',
                     cz9_fecha_vacuna:'', cz9_lugar_vacuna:'', cz9_fecha_vacuna_tifoidea:'',
                     cz9_lugar_vacuna_tifoidea:'', cz9_fecha_vacuna_toxoide:'',cz9_lugar_vacuna_toxoide:'',
                     cz9_reentrenamiento:''
                     }
                }else{
                    this.empleado_info = res.data
                console.log(this.empleado_info)   
                }
                            
            });
            },
            actualizar() {
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
                    fecha_tpprueba:this.empleado_info.cz9_fecha_tpprueba,
                    fecha_vacuna:this.empleado_info.cz9_fecha_vacuna,
                    lugar_vacuna:this.empleado_info.cz9_lugar_vacuna,
                    fecha_vacuna_tifoidea: this.empleado_info.cz9_fecha_vacuna_tifoidea,
                    lugar_vacuna_tifoidea:this.empleado_info.cz9_lugar_vacuna_tifoidea,
                    fecha_vacuna_toxoide: this.empleado_info.cz9_fecha_vacuna_toxoide,
                    lugar_vacuna_toxoide:this.empleado_info.cz9_lugar_vacuna_toxoide,
                    reentrenamiento: this.empleado_info.cz9_reentrenamiento



                };
                console.log(params);
                console.log(this.informacion.c0540_rowid_tercero);
                axios
                    .put(
                        `/api/empleado/update/${this.informacion.c0540_rowid_tercero}`,
                        params
                    )
                    .then(res => {
                        console.log(res.data);
                        this.validated = false;
                        swal("Registro actualizado", "Datos Correctos", "success");
                    });
            },
             validarSexo(){
                if(this.informacion.c0540_ind_sexo == 1){
                    this.sexo = 'Femenino'
                }
                else if(this.informacion.c0540_ind_sexo == 0){
                    this.sexo = 'Masculino'
                }
                },
           
            cargarCiudades(event) {
                axios.get("/api/ciudad").then(res => {
                    this.ciudades = res.data;

                });
            },
            cargarBarrios(event) {
                axios.get(`/api/barrios/${event.target.value}`)
                    .then(res => {
                        this.barrios = res.data;
                        

                        this.informacion.f015_id_ciudad = event.target.value

                    })

            },
             getImage(event){
                //Asignamos la imagen a  nuestra data
                let files = event.target.files || event.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
                console.log(this.imagen)
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.imagen = e.target.result;
                };
                reader.readAsDataURL(file);
                console.log(this.imagen)
            },
            updateAvatar(){
                
                axios.put(`/api/usuario/avatar/${this.$route.params.id}`,{imagen: this.imagen})
                .then(res => {
                    console.log(res.data)

                })
            },
         
            cambiarBarrio(event) {
                this.informacion.f015_id_barrio = event.target.value
                console.log(this.informacion)
            },
            cargarContrato() {
                axios.get(`/api/empleado/${this.$route.params.id}`)
                    .then(res => {
                        this.usuario = res.data
                        console.log(res.data)
                    })
            },
            validarCampos(){
                console.log(this.informacion.f015_email)
                if(this.informacion.f015_email == ''){
                    swal('Alerta', 'El email es obligatorio', 'warning')
                }
                else if(this.informacion.f015_telefono == ''){
                    swal('Alerta', 'El numero de telefono es obligatorio', 'warning')
                }
                else if(this.informacion.f015_celular == ''){
                    swal('Alerta', 'El numero de celular es obligatorio', 'warning')

                }else if(this.informacion.f015_direccion1 == ''){
                    swal('Alerta', 'La direccion es obligatoria', 'warning')

                }else if(this.informacion.f015_id_barrio == ''){
                    swal('Alerta', 'El barrio es obligatorio', 'warning')

                }else if(this.informacion.f015_id_ciudad == ''){
                    swal('Alerta', 'La ciudad es obligatoria', 'warning')
                }
                
                 else if(this.empleado_info.cz9_tel_contacto == ''){
                    swal('Alerta', 'El numero del familiar es obligatorio', 'warning')
                }
                else if(this.empleado_info.cz9_nombre_contacto == ''){
                    swal('Alerta', 'El contacto familiar es obligatorio', 'warning')
                }
                
                else{
                    this.actualizar()
                }
            }
        },
        
        

        computed: {
           
        }
    };

</script>
