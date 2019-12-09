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
        <div>
            <div class="dropdown">
                <button
                    class="btn btn-primary dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                >
                    {{ nombre_rol }} <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li v-for="(item, indice) in roles" :key="indice">
                        <a
                            @click="
                                seleccionarRol(item.cz2_nombre, item.cz2_id)
                            "
                            >{{ item.cz2_nombre }}</a
                        >
                    </li>
                </ul>
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
                    <span class="badge badge-primary float-right">
                        {{ item.cz1_cc }}
                    </span>
                    <p class="lead">
                        {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                        {{ item.c0541_apellido2 }}
                    </p>
                    <p>{{ item.cz2_nombre }}</p>
                    <h1>{{ item.cz1_estado }}</h1>
                    <button
                        class="btn btn-warning btn-sm"
                        v-on:click="editar(item)"
                    >
                        Editar
                    </button>
                    <button
                        class="btn btn-danger btn-sm"
                        v-on:click="eliminar(item.cz1_id, indice)"
                    >
                        Eliminar
                    </button>
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
                cz1_id: null,
                cz1_cc: null,
                cz1_password: "",
                cz1_id_rol: 0,
                cz1_id_empleado: 0,
                cz1_estado: null
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
                this.usuarios = res.data;
                console.log(this.usuarios)
            });
        },

        cargarRoles() {
            axios.get("/api/roles").then(res => {
                this.roles = res.data;
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
                axios.post("/api/usuarios/create", this.usuario).then(res => {
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
                   
                    this.usuario.cz1_id_empleado = res.data.c0540_rowid_tercero;
                    console.log(this.usuario)  
                    
                    if (this.usuario.cz1_id_empleado == null) {
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
        editar(item) {
            this.usuario.cz1_cc = item.cz1_cc;
            this.usuario.cz1_password = item.cz1_contrasena;
            this.usuario.cz1_id_rol = item.cz1_id_rol;
            this.usuario.cz1_ts_id = item.cz1_ts_id;
            this.usuario.cz1_estado = item.cz1_estado;
            this.cz1_id = item.cz1_id;
            this.modoEditar = true;

            console.log(this.cz1_id);
        },
        update() {
            const params = this.usuario;
            axios
                .put(`/api/usuarios/update/${this.cz1_id}`)
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
