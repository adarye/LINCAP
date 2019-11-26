<template>
    <div>
        <div class="card-header">LINCAP</div>
        <form @submit.prevent="update(indice)" v-if="modoEditar">
            <h3>Editar Usuario</h3>
            <input
                type="text"
                class="form-control mb-2"
                placeholder="Nombre de la nota"
            />
            <input
                type="text"
                class="form-control mb-2"
                placeholder="Descripción de la nota"
            />
            <button class="btn btn-warning" type="submit">Editar</button>
            <button
                class="btn btn-danger"
                type="submit"
                @click="cancelarEdicion"
            >
                Cancelar
            </button>
        </form>
        <form @submit.prevent="agregar" v-else>
            <h3>Agregar Usuario</h3>
            <input
                type="text"
                class="form-control mb-2"
                placeholder="Numero de cedula"
            />
            <input
                type="password"
                class="form-control mb-2"
                placeholder="Contraseña"
            />
            <div class="dropdown mb-2">
                <button
                    class="btn btn-secondary dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    Dropdown button
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Agregar</button>
        </form>
        <hr />

        <div class="card-body">
            <h3>Lista de Usuarios:</h3>
            <ul class="list-group">
                <li
                    class="list-group-item"
                    v-for="(item, index) in usuarios"
                    :key="index"
                >
                    <span class="badge badge-primary float-right">
                        {{ item.cz1_cc }}
                    </span>
                    <p class="lead">
                        {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                        {{ item.c0541_apellido2 }}
                    </p>
                    <p>{{ item.cz2_nombre }}</p>
                    <p>
                        <button
                            class="btn btn-warning btn-sm"
                            @click="editarFormulario(item)"
                        >
                            Editar
                        </button>
                        <button
                            class="btn btn-danger btn-sm"
                            @click="eliminarNota(item, index)"
                        >
                            Eliminar
                        </button>
                    </p>
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
            modoEditar: false
        };
    },
    mounted() {
        this.created();
    },
    methods: {
        created() {
            axios.get("/api/usuarios").then(res => {
                console.log(res.data);
                this.usuarios = res.data;
            });
        },
        cargarRoles(){
            
        }
    }
};
</script>
