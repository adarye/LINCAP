<template>
    <div>
        <center>
            <h1>Informacion Personal</h1>
        </center>
        <form class="my-2">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Nombres"
                        v-model="informacion.c0541_nombres"
                        disabled
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Apellidos"
                        v-model="apellidos"
                        disabled
                    />
                </div>
            </div>
             <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cedula</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Cedula"
                        v-model="informacion.c0541_id"
                        disabled
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Cargo</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Apellidos"
                        v-model="informacion.c0763_descripcion"
                        disabled
                    />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        v-model="informacion.c0541_correo"
                        :disabled="validated ? false : true"
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Telefono</label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Numero de telefono"
                        v-model="informacion.c0541_telefono_1"
                        :disabled="validated ? false : true"
                    />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Direccion</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="informacion.c0541_direccion_1"
                        :disabled="validated ? false : true"
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Barrio</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="informacion.c0541_barrio"
                        :disabled="validated ? false : true"
                    />
                </div>
            </div>
            <div class="form-row">
                
                <div class="form-group col-md-6">
                    <label>Ubicacion</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="ubicacion"
                        disabled
                    />
                </div>
                <div class="form-group col-md-6">
                    <label>Selecciona tu ciudad:</label>
                    <select
                        class="form-control"
                        :disabled="validated ? false : true"
                        @change="cambioCiudad"
                    >
                        <option value="1" data-foo="...">...</option>
                        <option value="276" data-foo="FLORIDABLANCA"
                            >FLORIDABLANCA</option
                        >
                        <option value="307" data-foo="GIRON">GIRON</option>
                        <option value="001" data-foo="BUCARAMANGA"
                            >BUCARAMANGA</option
                        >
                        <option value="547" data-foo="PIEDECUESTA"
                            >PIEDECUESTA</option
                        >
                    </select>
                </div>
            </div>
        </form>
        <div class="form-row">
            <span v-if="!validated">
                <div class="form-group col-md-6">
                    <button
                        @click="habilitarFormulario"
                        class="btn btn-primary"
                    >
                        Editar
                    </button>
                </div>
            </span>
            <span v-else>
                <div class="form-group col-md-6">
                    <button @click="actualizar" class="btn btn-primary">
                        Actualizar
                    </button>

                    <button
                        @click="desabilitarFormulario"
                        class="btn btn-danger"
                    >
                        Cancelar
                    </button>
                </div>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            ciudad_seleccionada: "",
            apellidos: "",
            informacion: {},
            validated: false,
            ubicacion: "",
            id_ciudad: 0
        };
    },
    mounted() {
        axios.get("/api/empleado/show").then(res => {
            this.informacion = res.data[0];
            this.apellidos =
                this.informacion.c0541_apellido1 +
                " " +
                this.informacion.c0541_apellido2;
            this.ciudad_seleccionada = this.informacion.f013_descripcion;
            this.ubicacion =
                "COLOMBIA - SANTANDER - " + this.ciudad_seleccionada;
            this.id_ciudad = this.informacion.f013_id;
            console.log(this.id_ciudad);
        });
    },
    methods: {
        habilitarFormulario() {
            this.validated = true;
        },
        desabilitarFormulario() {
            this.validated = false;
            console.log(this.ciudad_seleccionada);
        },
        actualizar() {
            const params = {
                email: this.informacion.c0541_correo,
                telefono: this.informacion.c0541_telefono_1,
                direccion: this.informacion.c0541_direccion_1,
                barrio: this.informacion.c0541_barrio,
                ciudad: this.id_ciudad
            };
            console.log(params);
            axios
                .put(
                    `/api/empleado/update/${this.informacion.c0541_rowid}`,
                    params
                )
                .then(res => {
                    console.log(res.data);
                     this.validated = false;
                      swal('Registro actualizado', 'Datos Correctos', 'success')
                });
        },
        cambioCiudad(e) {
            if (e.target.options.selectedIndex > -1) {
                this.ciudad_seleccionada =
                    e.target.options[
                        e.target.options.selectedIndex
                    ].dataset.foo;
                this.ubicacion =
                    "COLOMBIA - SANTANDER - " + this.ciudad_seleccionada;
                this.id_ciudad =
                    e.target.options[e.target.options.selectedIndex].value;
                console.log(this.id_ciudad);
            }
        }
    },

    computed: {}
};
</script>
