<template>
    <div>
        <vue-headful
            :title="title"
        />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <i class="fa fa-gears"></i> Configuración
                </li>
                <li class="breadcrumb-item">
                    <i class="fa fa-users"> </i>  
                            Usuarios
                   
                </li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <nav class="navbar navbar-light bg-light my-2">
           <div class=" pull-right">
               <b> Ver</b>
            </div>
            <div class="col-md-1  mt-2">
                <input v-numeric-only v-on:keyup="constantes(); validarPagina(); " class="form-control mt-2" v-model="numero" />
            </div>
            <div class=" pull-left">
                <b>Registro(s)</b>
            </div>

            <div class="col-md-4 mt-2 col-center col-sm-2  has-feedback">
                <select @change="constantes(); pagina = 1" v-model="selectRol" class="form-control">
                    <option value="Roles">TODOS LOS ROLES</option>
                    <option v-for="(item, indice) in roles" :key="indice" v-bind:value="item.cz2_id">
                        {{ item.cz2_nombre }}
                    </option>
                </select>
            </div>
            <div class="col-md-5 mt-2 col-center has-feedback">
                <input type="text" v-model="bempleado" class="form-control" v-autofocus v-uppercase
                   v-on:keyup="constantes(); validarPagina();" placeholder="Buscar empleado" />
            </div>
            
            <div class="col-md-1" v-if="mostrar == 1"><input class="form-control mt-2"  v-on:keyup="constantes(); pagina = 1"  v-model="numero" /></div>
        </nav>
        <button type="button" class="btn btn-round btn-success" @click="show" title="Nuevo"><i class="fa fa-plus"></i>
        </button>
        <button type="button" class="btn btn-round btn-primary" @click="agregarTodos" title="Sincronizar usuarios"><i class="fa fa-rotate-left"></i>
        </button>
        <modal name="create" :clickToClose="false" :adaptive="true" :width="430" :height="430">            
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                        <form @submit.prevent="buscarTercero()">
                            <h1>Nuevo Usuario</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input class="form-control" placeholder="Número de cédula" v-model="usuario.cz1_cc"
                                    v-numeric-only v-max-length="16" v-autofocus />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input type="password" class="form-control mb-2" placeholder="Contraseña"
                                    v-model="usuario.cz1_password" />
                            </div>
                            <select v-model="usuario.cz1_id_rol" class="form-control">
                                <option value="Roles">ROLES</option>
                                <option class="mb-2" v-for="(item, indice) in roles" :key="indice"
                                    v-bind:value="item.cz2_id">
                                    {{ item.cz2_nombre }}</option>
                            </select>

                            <div class="col-md-12 col-sm-12 form-group has-feedback my-2">
                                <button class="btn btn-primary" type="submit">
                                    Agregar
                                </button>
                                <button type="button" class="btn btn-danger" @click="closeCreate()">
                                    Cerrar
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </modal>
        <modal name="editar" :clickToClose="false" :adaptive="true" :width="430" :height="430">             
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                        <form @submit.prevent="update()">
                            <h1>Actualizar Usuario</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input class="form-control" placeholder="Numero de cedula" v-model="usuario.cz1_cc"
                                    v-numeric-only v-max-length="16" v-autofocus disabled />
                            </div>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input type="password" class="form-control mb-2" placeholder="Contraseña"
                                    v-model="usuario.cz1_password" v-autofocus />
                            </div>
                            <select v-model="usuario.cz1_id_rol" class="form-control">
                                <option value="Roles">ROLES</option>
                                <option class="mb-2" v-for="(item, indice) in roles" :key="indice"
                                    v-bind:value="item.cz2_id">
                                    {{ item.cz2_nombre }}</option>
                            </select>

                            <div class="col-md-12 col-sm-12 form-group has-feedback my-2">
                                <button class="btn btn-primary" type="submit">
                                    Actualizar
                                </button>
                                <button type="button" class="btn btn-danger" @click="closeEditar()">
                                    Cerrar
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </modal>
        <br><br>
 <div class="table-responsive-md table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cedula</th>
                    <th>Nombres</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in mbuscar" :key="indice" v-show="
                        ((pagina - 1) * numero <= indice &&
                            pagina * numero > indice)
                    ">
                    <th scope="row">{{ item.cz1_cc }}</th>
                    <td>{{ item.cz1_nombres }}</td>
                    <td>{{ item.cz2_nombre }}</td>
                    <td>
                        <button title="Editar" class="btn btn-warning btn-sm" v-on:click="
                                editar(item);
                                showEditar();
                            ">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button title="Eliminar" class="btn btn-danger btn-sm"
                            v-on:click="eliminar(item.cz1_id, indice, item.cz1_nombres)">
                            <li class="fa fa-trash-o">
                            </li>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
 </div>
        <div class="row">
            <div class="col-md-4 col-float"></div>
            <div  class="col-md-4 col-center">
                <button type="button" @click.prevent="pagina = Number(pagina) - 1; constantes()" :disabled="pagina == 1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina = Number(pagina) + 1; constantes();"
                   :disabled="(pagina * numero) / mbuscar.length >= 1" class="btn btn-success">
                    <li class="fa fa-long-arrow-right"></li>
                </button>
            </div>

            <div class="pull-right mt-2">
                Página {{ pagina }} /
                {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros
            </div>
        </div>
         <center>
            
            <div v-show="carga  && usuarios.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
              <div v-show="carga == false  && usuarios.length == []">
               <p>No se encontraron resultados</p>
            </div>
        </center>
    </div>
</template>
<script>
import router from '../../js/router';
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
                    cz1_id_rol: "Roles",
                    cz1_id_empleado: 0,
                    cz1_nombres: null
                },
                cz1_id: 0,
                selectRol: "Roles",
                selectPag: 10,
                numero: 10,
                mostrar: 0,
                bempleado: "",
                pagina: 1,
                carga: true,
                title: ""
            };
        },
        beforeMount() {
              if(window.user.rol == 1){
            this.cargarRoles();
            this.created();
             this.title = "Lincap | Admin usuarios"
              }
              else{
                  router.push('/');

              }
                setTimeout(
                _ => this.carga = false, 
                10000 
            )
        },
        methods: {
            created() {
                axios.get("/api/usuarios").then(res => {
                    this.usuarios = res.data;
                   this.cache()
                   this.validarPagina()
                });
            },
             validarPagina(){
                if( Math.ceil(this.mbuscar.length / this.numero) < this.pagina){
                    console.log(Math.ceil(this.mbuscar.length / this.numero))
                    this.pagina =  1

                }
             },
            cache(){
                 if(localStorage.input_u == undefined){
                          localStorage.setItem('input_u', this.bempleado)
                     
                    } 
                    else{
                        this.bempleado = localStorage.input_u;
                    }
                    if(localStorage.pagina_u == undefined){
                        localStorage.setItem('pagina_u', this.pagina)

                    }
                    else{
                          this.pagina = localStorage.pagina_u;
                    }
                     if(localStorage.rol_u == undefined){
                        localStorage.setItem('rol_u', this.selectRol)

                    }
                    else{
                          this.selectRol = localStorage.rol_u;
                    }
                    if(localStorage.pag_u == undefined){
                        localStorage.setItem('pag_u', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_u;
                    }
                     if(localStorage.numero_u == undefined){
                        localStorage.setItem('numero_u', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_u;
                    }
            },
            constantes(){
                console.log('localStorage')
                localStorage.setItem('input_u', this.bempleado)
                localStorage.setItem('pagina_u', this.pagina)
                localStorage.setItem('rol_u', this.selectRol)
                 localStorage.setItem('pag_u', this.selectPag)
                  localStorage.setItem('numero_u', this.numero)
            },
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1;
                } else {
                    this.mostrar = 0;
                    this.numero = this.selectPag;
                }
            },

            cargarRoles() {
                axios.get("/api/roles").then(res => {
                    this.roles = res.data;
                });
            },
            agregarUsuario() {
                if (
                    this.usuario.cz1_id_rol != null &&
                    this.usuario.cz1_id_rol != "Roles"
                ) {
                    console.log("paso");
                    const params = this.usuario;
                    console.log(this.usuario);
                    axios.post("/api/usuarios/create", this.usuario).then(res => {
                        this.created();
                        this.limpiar();
                        swal("Correcto", "Usuario creado con éxito", "success");
                        this.closeCreate();
                    });
                } else {
                    swal("Advertencia", "Seleccione un rol", "warning");
                }
            },
            buscarTercero() {
                axios(`/api/usuarios/verificar/${this.usuario.cz1_cc}`).then(
                    res => {
                        this.usuario.cz1_id_empleado = res.data.c0540_rowid_tercero;
                        const nombre =
                            res.data.c0541_nombres +
                            " " +
                            res.data.c0541_apellido1 +
                            " " +
                            res.data.c0541_apellido2;
                        this.usuario.cz1_nombres = nombre;
                        console.log(this.usuario);

                        if (this.usuario.cz1_id_empleado == null) {
                            swal("Advertencia", "El empleado no existe", "warning");
                            this.created()
                        } else {
                            this.validarCCExistente();
                            this.created();
                        }
                    }
                );
            },
            eliminar(id, indice, nombres) {
                swal({
                    title: "Advertencia",
                    text: "Esta seguro de eliminar a " + nombres + " ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true
                }).then(willDelete => {
                    if (willDelete) {
                        axios.delete(`/api/usuarios/delete/${id}`).then(res => {
                            this.usuarios.splice(indice, 1);
                            this.limpiar();
                            
                        });
                        this.bempleado = ""

                        swal("Eliminado", {
                            icon: "success"
                        });
                    }
                });

            },
            editar(item) {
                this.usuario.cz1_cc = item.cz1_cc;
                this.usuario.cz1_password = item.cz1_contrasena;
                this.usuario.cz1_id_rol = item.cz1_id_rol;
                this.usuario.cz1_ts_id = item.cz1_ts_id;
                this.cz1_id = item.cz1_id;
                this.modoEditar = true;

                console.log(this.cz1_id);
            },
            update() {
                if (
                    this.usuario.cz1_id_rol != "" &&
                    this.usuario.cz1_id_rol != "Roles"
                ) {
                    axios
                        .put(`/api/usuarios/update/${this.cz1_id}`, this.usuario)
                        .then(res => {
                            console.log(res);
                            this.created();
                            this.limpiar();
                            this.closeEditar();
                            swal(
                                "Correcto",
                                "Usuario actualizado con éxito",
                                "success"
                            );
                        });
                } else {
                    swal("Advertencia", "Seleccione un rol", "warning");
                }
            },
            cancelar() {
                this.limpiar();
            },
            limpiar() {
                this.modoEditar = false;
                this.usuario.cz1_password = "";
                this.usuario.cz1_cc = "";
                this.usuario.cz1_id_rol = "Roles";
            },
            validarCCExistente() {
                var i = 0;
                var estado = 0;
                for (i = 0; this.usuarios.length > i; i++) {
                    if (this.usuarios[i].cz1_cc === this.usuario.cz1_cc) {
                        this.estado = 1;
                    }
                }
                if (this.estado === 1) {
                    swal("Error", "Ya se encuentra en el sistema", "error");
                    this.estado = 0;
                } else {
                    this.agregarUsuario();
                }
                console.log(this.estado);
            },
            show() {
                this.title = "Lincap | Crear usuarios"
                this.$modal.show("create");
            },
            showEditar() {
                this.title = "Lincap | Editar usuario"
                this.$modal.show("editar");
            },
            closeEditar() {
                this.title = "Lincap | Admin usuarios"
                this.$modal.hide("editar");
                this.limpiar();
            },
            closeCreate() {
                this.title = "Lincap | Admin usuarios"
                this.$modal.hide("create");
                this.limpiar();
            },
            agregarTodos(){
                 const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Esto puede tomar varios minutos</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });
                axios.post('/api/usuario/agregar-todos', this.usuarios )
                .then(res=>{
                    swal('Corrrecto','Se han agregado '+ res.data +' empleado(s) nuevos', '', 'success')
                    this.created()
                }).catch(res => {
                    swal('Error','Ha sucedido un error inesperado', 'error')
                    this.created()
                })
            }
        },

        computed: {
            mbuscar: function () {

                return this.usuarios.filter(usuario => {
                    if (this.selectRol == null || this.selectRol == "Roles") {
                        return (
                            usuario.cz1_cc
                            .toUpperCase()
                            .includes(this.bempleado.toUpperCase()) ||
                            usuario.cz1_nombres
                            .toUpperCase()
                            .includes(this.bempleado.toUpperCase())
                        );
                    } else {
                        return (
                            (usuario.cz1_id_rol.includes(this.selectRol) &&
                                usuario.cz1_nombres
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (usuario.cz1_id_rol.includes(this.selectRol) &&
                                usuario.cz1_cc
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        );
                    }
                });
            }
        }
    };

</script>
