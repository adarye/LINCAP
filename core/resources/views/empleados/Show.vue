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
            'apellidos':apellidos, 'ciudades':ciudades, 'barrios':barrios, 'validated': validated}" v-on:cargarBarrios="cargarBarrios"
            v-on:cambiarBarrio="cambiarBarrio"></infPersonal>
          </div>
            
            
            <div id="menu1" class="tab-pane fade">
                <InfCorporativa v-bind="{'informacion': informacion, 'usuario': usuario, 'validated': validated}"></InfCorporativa>
            </div>


            <div id="menu2" class="tab-pane fade">
                <InfSST></InfSST>
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
                    <button @click="actualizar" class="btn btn-primary">
                        Actualizar
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
                ubicacion: "",
                id_ciudad: 0,
                ciudades: [],
                barrios: [],
                usuario: '',
                moment: moment
            };
        },
        mounted() {
            this.cargarContrato();
            axios.get("/api/empleado/show").then(res => {
                this.informacion = res.data[0];
                console.log(this.informacion);
                this.apellidos =
                    this.informacion.c0541_apellido1 +
                    " " +
                    this.informacion.c0541_apellido2;
            });
            this.cargarCiudades();
        },
        methods: {
            habilitarFormulario() {
                this.validated = true
            },
            desabilitarFormulario() {
                this.validated = false;
                console.log(this.ciudad_seleccionada);
            },
            actualizar() {
                const params = {
                    email: this.informacion.f015_email,
                    telefono: this.informacion.f015_telefono,
                    celular: this.informacion.f015_celular,
                    direccion: this.informacion.f015_direccion1,
                    barrio: this.informacion.f015_id_barrio,
                    ciudad: this.informacion.f015_id_ciudad
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
            cargarCiudades(event) {
                axios.get("/api/ciudad").then(res => {
                    this.ciudades = res.data;

                });
            },
            cargarBarrios(event) {
              console.log('gol')
                axios.get(`/api/barrios/${event.target.value}`)
                    .then(res => {
                        this.barrios = res.data;
                        

                        this.informacion.f015_id_ciudad = event.target.value

                    })

            },
            cambiarBarrio(event) {
                this.informacion.f015_id_barrio = event.target.value
                console.log(this.informacion)
            },
            cargarContrato() {
                axios.get('/api/empleado')
                    .then(res => {
                        this.usuario = res.data
                        console.log(res.data)
                    })
            }
        },

        computed: {}
    };

</script>
