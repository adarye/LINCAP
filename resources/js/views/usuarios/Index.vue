<template>
    <div>
        <div class="card-header">LINCAP</div>
        <form @submit.prevent="update()" v-if="modoEditar">
            <h3>Editar Usuario</h3>
            <input
                type="text"
                class="form-control mb-2"
                readonly="readonly"
                v-model="usuario.cz1_cc"
            />
            <input
                type="text"
                class="form-control mb-2"
                v-model="usuario.cz1_password"
            />

            <button class="btn btn-warning" type="submit">Actualizar</button>
            <button class="btn btn-danger" @click="cancelar()">
                Cancelar
            </button>
        </form>

        <form @submit.prevent="buscarTercero()" v-else>
            <h3>Agregar Usuario</h3>
            <input
                type="text"
                class="form-control mb-2"
                placeholder="Numero de cedula"
                v-model="usuario.cz1_cc"
            />
            <input
                type="password"
                class="form-control mb-2"
                placeholder="Contraseña"
                v-model="usuario.cz1_password"
            />

            <button class="btn btn-primary" type="submit">Agregar</button>
        </form>
        <div class="dropdown mb-2">
            <button
                class="btn btn-secondary dropdown-toggle"
                type="button"
                id="dropdownMenuButton"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <label>{{ this.nombre_rol }}</label>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li v-for="(item, indice) in roles" :key="indice">
                    <a
                        class="dropdown-item"
                        @click="seleccionarRol(item.cz2_nombre, item.cz2_id)"
                        >{{ item.cz2_nombre }}</a
                    >
                </li>
            </div>
        </div>
        <hr />

        <div class="card-body">
            <h3>Lista de Usuarios:</h3>
            <ul class="list-group">
                <li
                    class="list-group-item"
                    v-for="(item, indice) in usuarios"
                    :key="indice"
                >
                    <Usuarios
                        :item="item"
                        v-on:eliminar="eliminar(item.cz1_id, indice)"
                        v-on:editar="editar(item.cz1_id)"
                    ></Usuarios>
                    
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            usuarios: [],
            modoEditar: false,
            roles: [],
            nombre_rol: "Rol",
            rowid: {},
            usuario: {
                cz1_cc: null,
                cz1_password: "",
                cz1_id_rol: 0,
                cz1_ts_id: 0
            },
            cz1_id: 0
        };
    },
    mounted() {
        this.created();
        this.cargarRoles();
    },
    methods: {
        created() {
            axios.get("/api/usuarios").then(res => {
                console.log(res.data);
                this.usuarios = res.data;
            });
        },

        cargarRoles() {
            axios.get("/api/roles").then(res => {
                this.roles = res.data;
                console.log(this.roles);
            });
        },
        seleccionarRol(nombre, id_rol) {
            this.nombre_rol = nombre;
            this.usuario.cz1_id_rol = id_rol;
        },
        agregarUsuario() {
            if (this.nombre_rol != "Rol") {
                const params = this.usuario;
                console.log(this.usuario);
                axios.post("/api/usuarios/create", params).then(res => {
                    this.created();
                    this.limpiar();
                });
            } else {
                console.log("Seleccione un Rol");
            }
        },
        buscarTercero() {
            axios(`/api/usuarios/verificar/${this.usuario.cz1_cc}`).then(
                res => {
                    this.rowid = res.data;
                    this.usuario.cz1_ts_id = this.rowid.c0541_rowid;

                    if (this.usuario.cz1_ts_id == null) {
                        console.log("el Usuario no existe");
                    } else {
                        this.validarCCExistente();
                    }
                }
            );
        },
        eliminar(id, indice) {
            axios.delete(`/api/usuarios/delete/${id}`).then(res => {
                this.usuarios.splice(indice, 1);
                this.limpiar();
            });
        },
        editar(id) {
            this.modoEditar = true;
            axios.get(`/api/usuarios/show/${id}`).then(res => {
                const usuarioService = res.data;
                this.usuario.cz1_password = usuarioService.cz1_contrasena;
                this.usuario.cz1_cc = usuarioService.cz1_cc;
                this.usuario.cz1_id_rol = usuarioService.cz1_id_rol;
                this.usuario.cz1_ts_id = usuarioService.cz1_ts_id;
                this.cz1_id = usuarioService.cz1_id;
                console.log(this.usuario);
            });
        },
        update() {
            const params = this.usuario;
            axios
                .put(`/api/usuarios/update/${this.cz1_id}`, params)
                .then(res => {
                    console.log(res);
                    this.created();
                    this.limpiar();
                });
        },
        cancelar() {
            this.limpiar();
        },
        limpiar() {
            this.modoEditar = false;
            this.usuario.cz1_password = "";
            this.usuario.cz1_cc = "";
            this.nombre_rol = "Rol";
        },
        validarCCExistente() {
            var i = 0;
            var estado = 0;
            for (i = 0; this.usuarios.length > i; i++) {
                console.log(this.usuarios[i].cz1_cc);
                console.log(this.usuario.cz1_cc);
                if (this.usuarios[i].cz1_cc === this.usuario.cz1_cc) {
                    this.estado = 1;
                }
            }
            if (this.estado === 1) {
                console.log("ya se encuentra en el sistema");
            } else {
                this.agregarUsuario();
            }
            console.log(this.estado);
        }
    },

    computed: {}
};
</script>
