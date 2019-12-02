<template>
    <div>
        <modal name="create">
            <form @submit.prevent="crear">
                <input type="text" class="form-control mb-2" v-model="nombre" placeholder="Nombre del Rol" />
                <input type="text" class="form-control mb-2" v-model="descripcion" placeholder="Descripcion del Rol" />

                <button class="btn btn-primary" type="submit">Crear</button>
                <button class="btn btn-primary" @click="hide">Cerrar</button>
            </form>
        </modal>
        <button type="button" class="btn btn-round btn-success" @click="show" title="Nuevo">Nuevo</button>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in roles" :key="indice">
                    <th scope="row">{{ item.cz2_id }}</th>
                    <td>
                        {{ item.cz2_nombre }}
                    </td>
                    <td>
                        {{ item.cz2_descripcion }}
                    </td>
                    <td>
                        <a @click="eliminar(item.cz2_id, indice)">
                            <i class="material-icons">
                                edit
                            </i>
                        </a>

                        <router-link :to="{
                                name: 'ShowRol',
                                params: { id: item.cz2_id }
                            }" data-toggle="modal" data-target="#exampleModalLong">
                            <i class="material-icons">
                                search
                            </i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                roles: [],
                descripcion: "",
                nombre: "",
                rol: {},
            };
        },
        mounted() {
            axios.get("/api/roles").then(res => {
                this.roles = res.data;
            });
        },
        methods: {
            crear() {
                this.rol = {
                    nombre: this.nombre,
                    descripcion: this.descripcion
                };
                axios.post("api/roles/create", this.rol).then(res => {
                    const rolServidor = res.data;
                    console.log(res.data);
                    this.roles.push(rolServidor);
                    this.nombre = "";
                    this.descripcion = "";
                    this.hide();
                });
                
            },
            eliminar(id, indice) {
                axios.delete(`/api/roles/delete/${id}`).then(res => {
                    this.roles.splice(indice, 1);
                });
            },
            show() {
                this.$modal.show('create');

            },
            hide() {
                this.$modal.hide('create');
            }
        }
    };

</script>
