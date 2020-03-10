<template>
    <div>
        <form class="my-4" method="POST" id="formulario-login" @submit.prevent="iniciarSesion">
            <div class="col-md-12 col-sm-12 form-group has-feedback">
                <input v-numeric-only v-max-length="16" v-autofocus type="text" class="form-control" v-model="cz1_cc"
                    placeholder="Número de cédula" onfocus />
                <span title="Número de cédula" class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
            </div>
            <div class="col-md-12 col-sm-12 form-group has-feedback">
                <input :type="passwordFieldType" class="form-control" v-model="cz1_contrasena"
                    placeholder="Contraseña" />
                <label title="Mostrar / Ocultar" @click="mostrarContrasena" :class="eyeFieltType"></label>
            </div>
            <div class="form-group has-feedback">
                <button type="submit" class="btn btn-primary btn-sm">
                    Ingresar
                </button>
            </div>
            <div class="form-group has-feedback">
                <label @click="modalShow">¿Olvido la contraseña?</label>
            </div>
        </form>

        <modal name="password" :clickToClose="false" :adaptive="true" :width="430">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                        <form @submit.prevent="enviarEmail">
                            <h1>Restablecer</h1>
                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input required v-numeric-only v-max-length="16" v-autofocus type="text" class="form-control"
                                    v-model="cedula" placeholder="Número de cédula" />
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true" title="Número de cédula"></span>
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-primary">Enviar Token</button>
                                <button type="button" @click="$modal.hide('password');"
                                    class="btn btn-danger">Cancelar</button>
                            </div>

                        </form>
                    </section>
                </div>
            </div>
        </modal>
        <modal name="token" :clickToClose="false" :adaptive="true" :width="430">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                        
                        <form @submit.prevent="enviarToken">
                            <h1>Validar Token</h1>

                            <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                <input v-max-length="50" v-autofocus type="text" class="form-control" v-model="token"
                                    placeholder="Token"/>
                            </div>
                            <div class="col-md-12 col-sm-12 form-group has-feedback">
                                <button type="submit" class="btn btn-warning">Enviar</button>
                            </div>

                        </form>
                    </section>
                </div>
            </div>
        </modal>
        <modal name="resetPassword" :clickToClose="false" :adaptive="true" :width="430">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">        
                        <form @submit.prevent="cambiarPassword">
                            <h1>Cambiar Contraseña</h1>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                    <input v-max-length="50" v-autofocus :type="passwordFieldType" class="form-control"
                                        v-model="password1" placeholder="Nueva contraseña" onfocus />
                                    <label title="Mostrar / Ocultar" @click="mostrarContrasena" :class="eyeFieltType"></label>
                                </div>
                                <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                                    <input v-max-length="50" :type="passwordFieldType" class="form-control"
                                        v-model="password2" placeholder="Confirmar contraseña"/>
                                </div>
                                <div class="col-md-12 col-sm-12 form-group has-feedback">
                                    <button type="submit" class="btn btn-primary">Restablecer</button>
                                    <button type="button" @click="$modal.hide('resetPassword');"
                                        class="btn btn-danger">Cancelar</button>
                                </div>                           
                        </form>
                    </section>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                token: '',
                cedula: null,
                cz1_cc: null,
                cz1_contrasena: "",
                passwordFieldType: 'password',
                eyeFieltType: 'fa fa-eye-slash form-control-feedback right',
                parametros: {},
                user: "",
                password1: '',
                password2: ''
            };
        },
        methods: {
            mostrarContrasena() {
                this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
                this.eyeFieltType = this.passwordFieldType === 'password' ? 'fa fa-eye-slash form-control-feedback right' : 'fa fa-eye form-control-feedback right'
            },
            iniciarSesion() {
                this.parametros = {
                    cz1_cc: this.cz1_cc,
                    cz1_contrasena: this.cz1_contrasena
                };
                //console.log(this.parametros)
                axios
                    .post("api/login/ingresar", this.parametros)
                    .then(res => {
                        this.user = res.data;
                        console.log(this.user);

                        if (res.data == "inactivo") {
                            swal("Error", "Tu contrato finalizó", "error");
                        } else {
                            swal({
                                title: "Bienvenido(a)",
                                text: this.user.cz1_nombres,
                                icon: "success",
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            }).then(select => {
                                if (select) {
                                    location.reload();
                                }
                            });
                        }
                    })
                    .catch(error => {
                        // console.log(error.response.data.errors);
                        let er = error.response.data.errors;
                        let mensaje = "Error no identificado";
                        if (er.hasOwnProperty("cz1_cc")) {
                            mensaje = er.cz1_cc[0];
                        } else if (er.hasOwnProperty("cz1_contrasena")) {
                            mensaje = er.cz1_contrasena[0];
                        } else {
                            mensaje = er.login[0];
                        }
                        swal("Error", mensaje, "error");
                    });
            },
            modalShow() {
                this.$modal.show('password');
            },
            enviarEmail() {
                swal({
  title: 'Auto close alert!',
  text: 'I will close in 2 seconds.',
  timer: 6000,
  showCancelButton: false,
  showConfirmButton: false
})
                // swal("Cargando...");
                axios.post('/api/usuario/email', {
                        cedula: this.cedula
                    })
                    .then(res => {
                        console.log(res.data)
                        if (res.data.error != "") {

                            swal("Error", res.data.error, "error");
                            this.$modal.hide('password');
                            this.clear()
                        } else if (res.data.mensaje != "") {
                            const mensaje = 'Se envió el token a su correo electrónico ' + res.data.correo
                            swal("Correcto", mensaje, "success");
                            this.$modal.hide('password');
                            this.$modal.show('token');
                        }
                    })
            },
            enviarToken() {
                axios.post('/api/usuario/token', {
                        token: this.token
                    })
                    .then(res => {
                        console.log(res.data)
                        if (res.data.error != '') {
                            swal("Error", res.data.error, "error");
                            this.token= ''

                        } else {
                            this.$modal.hide('token');
                            this.$modal.show('resetPassword');

                        }
                    })
            },
            cambiarPassword() {

                if (this.password1 == '' || this.password2 == '') {
                    swal("Advertencia", 'La contraseña es obligatoria', "warning");
                } else if (this.password1.length < 8 || this.password2.length < 8) {
                    swal("Advertencia", 'La contraseña debe tener más de 8 caracteres', "warning");
                } else if (this.password1 != this.password2) {
                    swal("Advertencia", 'Las contraseñas no coinciden', "warning");
                } else if (this.password1 == this.password2) {
                    axios.post('/api/usuario/recuperar/password', {
                            password: this.password1,
                            cedula: this.cedula
                        })
                        .then(res => {
                            console.log(res.data)
                            swal("Correcto", 'La contraseña fue actualizada', "success");
                            this.$modal.hide('resetPassword');
                            this.clear()
                        })
                }
            },
            clear() {
                this.token = ''
                this.password1 = ''
                this.password2 = ''
                this.cedula = ''
                this.cz1_contrasena = ""
                this.cz1_cc = ""

            }
        }
    };

</script>
