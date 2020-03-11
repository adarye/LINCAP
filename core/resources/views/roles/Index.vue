<template>
    <div>
          <vue-headful
            :title="title"
           
        />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="fa fa-gears"> Configuración</i>
                </li>
                <li class="breadcrumb-item">
                    <i class="fa fa-user">
                        <router-link :to="{ name: 'Roles' }">
                            Roles</router-link>
                    </i>
                </li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <modal name="create" :clickToClose="false" :adaptive="true" :width="430">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                        <form @submit.prevent="crear">
                            <h1>Crear Rol</h1>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input v-uppercase  v-max-length="70"   v-autofocus type="text" class="form-control"
                                    v-model="nombre" placeholder="Nombre del rol"   />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input v-uppercase v-max-length="80"   type="text" class="form-control"
                                    v-model="descripcion" placeholder="Descripcion del rol"/>
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" @click="hide"
                                    class="btn btn-danger">Cancelar</button>
                            </div>

                        </form>
                    </section>
                </div>
            </div>
        </modal>
        
        <button type="button" class="btn btn-round btn-success" @click="show" title="Nuevo">Nuevo</button>
         <div class="table-responsive-md table-responsive-sm">
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
                        <button type="button" class="btn btn-danger btn-sm" @click="eliminar(item.cz2_id, indice)">
                            <li class="fa fa-trash-o"> Eliminar </li>
                                                          
                        </button>

                    </td>
                </tr>
            </tbody>
        </table>
         </div>
    </div>
</template>
<script>
import router from '../../js/router';
    export default {
        data() {
            return {
                roles: [],
                descripcion: "",
                nombre: "",
                rol: {},
                title: ""
            };
        },
        beforeMount() {
             if(window.user.rol == 1){
            axios.get("/api/roles").then(res => {
                this.roles = res.data;
                 this.title = "Lincap | Admin roles"
            });
             }else{
                   router.push('/');
             }
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
                swal({
                    title: "Advertencia",
                    text: "¿Esta seguro de eliminar este rol?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        
                    axios.delete(`/api/roles/delete/${id}`).then(res => {
                    this.roles.splice(indice, 1);
                        swal("Eliminado", {
                            icon: "success"
                        });
                    });
                    }
                });
                
            
                
            },
            show() {
                this.$modal.show('create');
                 this.title = "Lincap | Crear rol"

            },
            hide() {
                this.title = "Lincap | Admin roles"
                this.$modal.hide('create');
            }
        }
    };

</script>
