<template>
    <div>
        
        <modal name="password" :clickToClose="false" :adaptive="true" :width="521" :height="400">
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content "> 
            <form @submit.prevent="validarPassword">
                    <h1> Cambiar Password </h1>             
               <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                    <input v-autofocus type="text" class="form-control" placeholder="Password Anterior" v-model="passwords.password_anterior" />
               </div>
                     <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Nueva Password" v-model="passwords.password_nueva" />
                    </div>
                    <div class="col-md-12 col-center col-sm-8 form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Repite la nueva Password" v-model="password_nueva" />
                    </div>
                    <div class="col-md-12 col-sm-12 form-group has-feedback">
                    <button type="submit" class="btn btn-primary" title="Actualizar"><i class="fa fa-save"></i></button>
                    <button type="button" @click="cerrar"
                                      title="Cerrar"  class="btn btn-danger"> <i class="fa fa-close"></i></button>
                                
                    </div>
                                       
            </form>
                    </section>
                </div>
            </div>
  
</modal>
        </div>

</template>
<script>
import router from '../../js/router';
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
                        title: "Error",
                        text: "La contraseña actual no coincide, se cerrara la sesion para comprobar la cuenta",
                        icon: "error",
                        closeOnClickOutside: false,
                        closeOnEsc: false
                    }).then(select => {
                        location.reload();
                    });
                }
                else{
                     swal({
                        title: "Correcto",
                        text: "Contraseña actualizada, se cerrara la sesion para comprobar la cuenta",
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
        cerrar(){
            router.push('/');
       // window.location.href = "http:/amazon.com"
      }
    },
    computed:{
        
    }
}
</script>