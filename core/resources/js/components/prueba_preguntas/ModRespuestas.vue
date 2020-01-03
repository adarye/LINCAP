<template>
    <div>
        <div class="login_wrapper">
            <div class=" animate form login_form">
                <section class="login_content">
                    <form @submit.prevent="crear">
                        <h1>Respuestas</h1>
                        <div class="col-md-12 col-center col-sm-8 form-group has-feedback"
                            v-for="i in n_respuestas-start" :key="i">
                    
                    
                            <input v-show="res.length == 0" v-max-length="50" v-autofocus class="form-control" :placeholder="'Respuesta ' +  i "
                                onfocus v-model="res[i - 1]"/>
                        <input v-show="res.length != 0" v-max-length="50"  class="form-control" :placeholder="'Respuesta ' +  i "
                                onfocus v-model="res.respuestas[i - 1].cz7_rta"/>
                               

                        </div>
                        <div class="col-md-12 col-sm-12 form-group has-feedback">
                            <button type="button" @click="$emit('hideRespuestas')"
                                class="btn btn-danger">Volver</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['n_respuestas','res'],
        data() {
            return {
                start: 0,
                end: 10,
                
            }
        },
        created(){
            
        //   console.log(this.res.respuestas[0].cz7_rta)
        },

        methods: {
            crear() {   
                 console.log(this.res)
             
            }

        }
    }

</script>
