<template>
    <div>
        <center>
            <h1 class="my-3">Roles</h1>
            <router-link
                :to="{
                    name: 'CreateRol'
                }"
                data-toggle="modal"
                data-target="#createModal"
                >Nuevo</router-link
            >
        </center>

        <table class="table">
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

                        <router-link
                            :to="{
                                name: 'ShowRol',
                                params: { id: item.cz2_id }
                            }"
                            data-toggle="modal"
                            data-target="#exampleModalLong"
                        >
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
            roles: []
        };
    },
    mounted() {
        axios.get("/api/roles").then(res => {
            this.roles = res.data;
        });
    },
    methods: {
        eliminar(id, indice) {
            axios.delete(`/api/roles/delete/${id}`).then(res => {
                this.roles.splice(indice, 1);
            });
        }
    }
};
</script>
