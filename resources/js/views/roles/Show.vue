<template>
    <div>
        <div
            class="modal fade"
            id="exampleModalLong"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLongTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            Editar
                        </h5>
                    </div>
                    <div
                        class="modal-body"
                    >
                        <form @submit.prevent="actualizar">
                            <div v-if="modoEditar">
                                <h1 >Editar  </h1>
                                <label v-bind:value="nombre" class="my-2"> {{ nombre }}  </label>
                                <label v-bind:value="descripcion"> {{ descripcion }}  </label>
                               
                            </div>
                            <div v-else>
                                <input
                                    type="text"
                                    class="form-control mb-2"
                                    v-model="nombre"
                                />
                                <input
                                    type="text"
                                    class="form-control mb-2"
                                    v-model="descripcion"
                                />
                            </div>

                            
                        </form>
                        <button class="btn btn-warning" type="submit"  @click="editar()">
                                Editar
                            </button>
                    </div>

                    <div class="modal-footer">
                        <router-link
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            :to="{
                                name: 'Roles'
                            }"
                        >
                            Close
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            rol: [],
            modoEditar: true,
            nombre: '',
            descripcion: ''
            
        };
    },
    mounted() {
        axios.get(`/api/roles/show/${this.$route.params.id}`).then(res => {
            this.rol = res.data;
            this.nombre = this.rol[0].cz2_nombre;
            this.descripcion = this.rol[0].cz2_descripcion;
            console.log(this.rol[0].cz2_nombre);

        });
    },
    methods: {
        editar() {
            this.modoEditar = false;
            console.log(this.modoEditar)

        }
    }
};
</script>
