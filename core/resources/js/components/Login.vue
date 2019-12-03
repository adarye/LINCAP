<template>
 <div class="col-md-6 col-md-offset-4">
                <h1 class="my-3">Iniciar Sesion</h1>
                <div class="card">
                    <div class="card-body">
                        <form class="my-4" method="POST" id="formulario-login">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input class="form-control" v-model="cz1_cc" placeholder="Numero de Cedula">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" v-model="cz1_contrasena"
                                        placeholder="Ingrese la contraseña">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-primary" @click="iniciarSesion">Ingresar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</template>
<script>
export default {
    data(){
        return{
            cz1_cc: null,
            cz1_contrasena: '',
            parametros:{},
            user:''

        }
    },
    methods:{
        iniciarSesion(){
            this.parametros = {
                cz1_cc: this.cz1_cc,
                cz1_contrasena: this.cz1_contrasena

            } 
            //console.log(this.parametros)
            axios.post("api/login/ingresar", this.parametros)
            .then(res=>{
               this.user = res.data;
                swal({
                    title:'Has iniciado sesion',
                    text:'Datos Correctos', 
                    icon: 'success',
                    closeOnClickOutside: false,
                    closeOnEsc: false
                    }).then(select => {
                        if(select){
                            location.reload();
                        }
                    })
            })
            .catch(error=>{
                console.log(error.response.data.errors)
                let er = error.response.data.errors
                let mensaje = 'Error no identificado'
                if(er.hasOwnProperty('cz1_cc')){
                mensaje = er.cz1_cc[0];
                }
                else if(er.hasOwnProperty('cz1_contrasena')){
                    mensaje = er.cz1_contrasena[0];
                }
                else{
                    
                 mensaje = er.login[0];
    
                }
                swal('Error', mensaje, 'error')
            })
            
        }

    }
}
</script>