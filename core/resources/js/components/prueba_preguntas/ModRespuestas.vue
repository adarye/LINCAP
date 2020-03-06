<template>
    <div>
        <div class="login_wrapper">
            <div class=" animate form login_form">
                <section class="login_content">
                    <form @submit.prevent="crear">
                        <h1>Respuestas</h1>
                        <div class="col-md-12 col-center col-sm-8 form-group has-feedback"
                            v-for="i in n_respuestas-start" :key="i">
                    
                    
                            <input v-show="typeof(res.respuestas) === 'undefined' && typeof(res.smmr) === 'undefined' "  v-max-length="50"  class="form-control" :placeholder="'Respuesta ' +  i "
                                 v-model="res[i - 1]"/>
                                <div v-if="typeof(res.respuestas) != 'undefined'">
                        <input  v-max-length="50"  class="form-control" :placeholder="'Respuesta ' +  i "
                                onfocus v-model="res.respuestas[i - 1].cz7_rta"/>
                                </div>
                                <div v-if="typeof(res.smmr) != 'undefined'">
                                    
                        <input  v-max-length="50"  class="form-control" :placeholder="'Respuesta ' +  i "
                                onfocus v-model="res.smmr[i - 1].cz8_rta"/>
                                </div>
                               

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
        props: ['n_respuestas','res', 'res_correctas'],
        data() {
            return {
                start: 0,
                end: 10
                
                
            }
        },
        created(){
        },

        methods: {
            crear() {   
                 console.log(this.res)
             
            }
        }
    }

</script>
