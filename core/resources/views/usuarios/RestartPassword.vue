<template>
    <div>
        
        <modal name="password">
            <form @submit.prevent="validarPassword"  v-click-outside="onClickOutside">
                <center>
                    <h3>Cambiar Contrasena</h3>
                </center>

                <div class="col-md-8 col-md-offset-2">
                    <label>Contrasena Anterior</label>
                    <input type="text" class="form-control mb-2" v-model="passwords.password_anterior" />
                    <label>Nueva Contrasena</label>
                    <input type="password" class="form-control mb-2" v-model="passwords.password_nueva" />
                    <label>Repite la nueva contrasena</label>
                    <input type="password" class="form-control mb-2" v-model="password_nueva" />
                    <button type="submit" class="btn btn-primary">Cambiar</button>
                </div>
                
                
            </form>
  
</modal>
        </div>

</template>
<script>
export default {
    data(){
        return{ 
            password_nueva:'',
          passwords: {
              password_anterior:'',
               password_nueva:''
                

          }
        }
    },
    mounted(){
        this.$modal.show('password');
        

    },
    methods:{
        updatePassword(){
            axios.put('/api/usuario/password', this.passwords)
            .then(res=>{
                if(res.data == 0){
                    swal({
                        title: "la contrasena actual no coincide",
                        text: "Se cerrara la sesion para comprobar la cuenta",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then(select => {
                        location.reload();
                    });
                }
                else{
                     swal({
                        title: "Contraseña Actualizada",
                        text: "Se cerrara la sesion para comprobar la cuenta",
                        icon: "success",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then(select => {
                        location.reload();
                    });
                    
                }
            })
        },
        validarPassword(){
            if(this.passwords.password_nueva == this.password_nueva ){
                if(this.password_nueva.length < 8){
                    swal('Advertencia', 'Las contrasena debe tener un minimo de 8 caracteres', 'warning')
                }else{
                    this.updatePassword();
                }
            }
            else{
                swal('Advertencia', 'Las nuevas contrasenas no coinciden', 'warning')
            }
        },
        onClickOutside (event) {
        console.log('Clicked outside. Event: ', event)
      }
    },
    computed:{
        
    }
}
</script>