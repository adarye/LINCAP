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
                
                token:'',
                cedula: null,
                cz1_cc: null,
                cz1_contrasena: "",
                parametros: {},
                user: "",
                password1:'',
                password2: ''
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
            enviarEmail(){
                axios.post('/api/usuario/email', {cedula: this.cedula})
                .then(res=>{
                    console.log(res.data)
                    if(res.data.error != ""){
                        
                    swal("Error", res.data.error, "error");
                    this.$modal.hide('password');
                    this.clear()
                    }
                    else if(res.data.mensaje != ""){
                        const mensaje = 'Se envio el token a tu correo '+ res.data.correo
                        swal("Mensaje", mensaje, "success");
                        this.$modal.hide('password');
                        this.$modal.show('token');
                    }
                })

            },
            enviarToken(){
                 axios.post('/api/usuario/token', {token: this.token})
                 .then(res=>{
                     console.log(res.data)
                     if(res.data.error != ''){
                         swal("Error", res.data.error, "error");
                         
                     }
                     else{
                          this.$modal.hide('token');
                          this.$modal.show('resetPassword');

                     }
                 }
                 )
            },
            cambiarPassword(){
                
                 if(this.password1 == '' || this.password2 == ''  ){
                   swal("Advertencia", 'La contraseña es obligatoria', "warning");
                }
                else if(this.password1.length < 8 || this.password2.length < 8){
                    swal("Advertencia", 'La contraseña tiene que tener mas de 8 caracteres', "warning");
                }
                else if(this.password1 != this.password2){
                   swal("Advertencia", 'Las contraseñas no coinciden', "warning");
                }
               else if(this.password1 == this.password2){
                 axios.post('/api/usuario/recuperar/password', {password: this.password1, cedula: this.cedula})
                 .then(res=>{
                     console.log(res.data)  
                     swal("Mensaje", 'La contraseña fue actualizada', "success"); 
                     this.$modal.hide('resetPassword');  
                     this.clear()     
                 }
                 )
                }
            },
            clear(){
                this.token = ''
                this.password1 = ''
                this.password2 = ''
                this.cedula = ''
                this.cz1_contrasena= ""
                this.cz1_cc= ""

            }
        }
    };

</script>
