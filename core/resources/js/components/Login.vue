<template>
    <form class="my-4" method="POST" id="formulario-login">
        <div>
            <input class="form-control" v-model="cz1_cc" placeholder="Número de cédula" />
        </div><br>
        <div>
            <input type="password" class="form-control" v-model="cz1_contrasena" placeholder="Contraseña" />
        </div>
        <button type="button" class="btn btn-primary" @click="iniciarSesion">
            Ingresar
        </button>
    </form>
</template>
<script>
    export default {
        data() {
            return {
                cedula: null,
                cz1_cc: null,
                cz1_contrasena: "",
                parametros: {},
                user: ""
            };
        },
        methods: {
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
                            swal("Error", "Tu contrato finalizo", "error");
                        } else {
                            swal({
                                title: "Has iniciado sesion",
                                text: "Datos Correctos",
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
                        console.log(error.response.data.errors);
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
                axios.post('/api/usuario/email', {
                        cedula: this.cedula
                    })
                    .then(res => {
                        console.log(res.data)
                    })

            }
        }
    };

</script>
