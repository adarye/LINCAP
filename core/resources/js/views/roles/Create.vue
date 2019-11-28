<template>
    <div>
        <div
            class="modal fade"
            id="createModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Modal title
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <router-link
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                :to="{
                                    name: 'Roles'
                                }"
                            >
                                x
                            </router-link>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="crear">
                            <input
                                type="text"
                                class="form-control mb-2"
                                v-model="nombre"
                                placeholder="Nombre del Rol"
                            />
                            <input
                                type="text"
                                class="form-control mb-2"
                                v-model="descripcion"
                                placeholder="Descripcion del Rol"
                            />

                            <button class="btn btn-primary" type="submit">
                                Crear
                            </button>
                        </form>
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
    </div>
</template>
<script>
export default {
    data() {
        return {
            descripcion: "",
            nombre: "",
            rol: {}
        };
    },
    methods: {
        crear() {
            this.rol = { nombre: this.nombre, descripcion: this.descripcion };
            axios.post("api/roles/create", this.rol).then(res => {
                console.log(res.data);
                setTimeout(this.redireccionar(), 5000);
            });
        },
        redireccionar() {
            location.origin = "http://localhost:3000/#/roles/";
        }
    }
};
</script>
