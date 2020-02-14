<template>
    <div>
        <center>
            <h1 class="titulo">{{titulo}}</h1>
        </center>
        
            <div class="alert alert-primary lead" role="alert" v-show="estado_prueba == 0">
                Esta evaluacion no ha sido iniciada
            </div>
            <div class="alert alert-warning lead" role="alert" v-show="estado_prueba == 1">
                Esta evaluacion ya ha sido iniciada
            </div>
            <div class="alert alert-success lead" role="alert" v-show="estado_prueba == 2">
                Esta evaluacion ya esta finalizada
            </div>
            <h4 class="display-5 titulo mb-3" v-show="calificacion_final">Calificacion Final: <span
                    class="badge badge-primary">{{calificacion_final}}</span></h4>

        <h4 class="display-5 titulo mb-3" v-show="resRA.length">Preguntas con respuesta abierta</h4>
        <article v-for="(dato, i) in resRA" :key="`A-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{dato.cz5_pregunta }}</p>
                </div>
                <div class="col-md-2">
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-md-9">
                    <!-- v-if="nota_ra.filter(nota => nota.cz11_pp_id == dato.cz5_id) != []" -->

                    <!-- {{  nota_ra.filter(nota => nota.cz11_pp_id == dato.cz5_id)}} -->

                    <textarea :disabled="editar ? false : true" v-model="respuestas_ra[i]"
                        
                        rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
                    </textarea>
                </div>
                <div class="col-md-3 p-3"
                    v-if="id_creador == id_log && nota_ra && nota_ra.length >= 1 && calificacion_final != null">
                    <div class="row">
                        <input type="radio" required :name="dato.cz5_id" value="3"
                            :checked="Math.round((5 /cantidad_preg*100))/100 == Math.round((nota_ra[i].cz11_nota*100))/100"
                            @click="calificarRA($event, dato.cz5_id)"> Excelente
                    </div>
                    <div class="row">
                        <input type="radio" :name="dato.cz5_id" value="2"
                            :checked="Math.round((5 /cantidad_preg*100)/2)/100 == Math.round((nota_ra[i].cz11_nota*100))/100"
                            @click="calificarRA($event, dato.cz5_id)"> Regular
                    </div>
                    <div class="row">
                        <input type="radio" :name="dato.cz5_id" value="1" :checked="nota_ra[i].cz11_nota == 0"
                            @click="calificarRA($event, dato.cz5_id)">Mal
                    </div>
                </div>
            </div>
        </article>


        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas
        </h4>
        <article v-for="(item, indice) in  resSMUR" :key="indice" class="my-3">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{ item.cz5_pregunta }}
                        <span v-show="notas_smur[indice] >0 && id_creador == id_log" class="badge badge-success">
                            Correcta</span>
                        <span v-show="notas_smur[indice] ==0 && id_creador == id_log" class="badge badge-danger">
                            Incorrecta</span>
                    </p>

                </div>
                <div class="col-md-2">

                </div>

                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <!-- {{respuestas.filter(cz7_id => cz7_id == item.cz7_id )}} -->

                        <input :disabled="editar ? false : true"
                
                            :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''" class="flat"
                            type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>

                </div>
            </div>
        </article>


         <h4 class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple
            respuestas</h4>
        <article v-for="(item3, indice) in resSMMR" :key="`o-${indice}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>

            </div>
            <div class="col-md-12" v-if="inputs[indice]" >
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                   
                    
                    <input 
                        @click="guardarSMMR(item3.cz5_id, item3.cz5_gp_id, item4.cz8_id, item3.cz5_categoria)"
                       v-model="inputs[indice]"  :disabled="inputs[indice].length >= item3.cz5_n_rtas_correctas && inputs[indice].indexOf(item4.cz8_id) === -1 && editar ? false : true"  
                         class="flat" type="checkbox" :value="item4.cz8_id"
                        >{{ item4.cz8_rta }}
                         


                    <span
                        v-show="inputs[indice].filter(cz8_id => cz8_id == item4.cz8_id ) != ''">
                        


                        <li class="badge badge-success"
                            v-show="notas_smmr.filter(el => el.cz11_rta == item4.cz8_id && el.cz11_nota > 0) != ''"><a
                                class="fa fa-check "></a></li>
                        <li class="badge badge-danger"
                            v-show="notas_smmr.filter(el => el.cz11_rta == item4.cz8_id && el.cz11_nota > 0) == ''"> <a
                                class="fa fa-close"></a> </li>
                    </span>
                    <!-- <span v-if="respuestas_smmr.filter(cz8_id => cz8_id == item4.cz8_id ) != ''" class="badge badge-danger">
                           <li class="fa fa-close " v-show="notas_smmr.filter(el => el.cz11_rta == item4.cz8_id && el.cz11_nota > 0) == ''"></li>
                            </span>  -->

                </article>
            </div>
        </article>



    </div>
</template>
<script>
    import EventBus from '../../bus';
    import router from '../../router'

    export default {
        data() {
            return {
                inputs: [],
                resSMUR: [],
                resRA: [],
                resSMMR: [],
                id: null,
                rta_ra: '',
                respuestas_smur: [],
                respuestas_smmr: [],
                respuestas_ra: [],
                editar: false,
                id_creador: null,
                estado_prueba: null,
                notas_smur: [],
                notas_smmr: [],
                id_empleado: '',
                id_log: null,
                calificacion_final: 0,
                nota_ra: "",
                cantidad_preg: 0,
                titulo: ""


            };
        },

        created() {


        },
        beforeMount() {
           this.id_log = user.id
            console.log('evaluacion')
            this.id = this.$route.params.id
            this.id_empleado = this.$route.params.empleado

            this.cargar();
           
            


            EventBus.$on('cargar', (item) => {
                this.cargar()
            });
            //  router.onReady(this.advertir)
            axios.get(`/api/preguntas/contar/${this.id}`)
                .then(res => {
                    console.log(res.data)
                    this.cantidad_preg = res.data

                })
        },
        ready(){
             
        },
        beforeDestroy() {
                       
        },

        methods: {
            calificarRA(event, pregunta) {

                let params = {
                    empleado: this.id_empleado,
                    prueba: this.id,
                    pregunta: pregunta,
                    cal: event.target.value


                }
                axios.put('/api/evaluacion/calificar/RA', params)
                    .then(res => {
                        console.log(res.data)
                        this.calificacion_final = Math.round(res.data.cz4_calificacion * 100) / 100
                    })

            },

            validar() {

                this.conseguirEstado()
                 if (this.id_creador != user.id){
                 router.go(-1)  
             }


            },
            traerRa() {
                console.log(this.id)
                axios.get(`/api/respuestaA/buscar/${this.id}`)
                    .then(res => {
                        this.resRA = res.data
                        const wrapper = document.createElement('div');
                        wrapper.innerHTML =
                            "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Cargando estadisticas...</div> ";

                        if (this.estado_prueba != 2 && this.id_empleado == this.id_log) {
                            swal({
                                buttons: false,
                                html: true,
                                content: wrapper,
                                closeOnClickOutside: false
                            });
                            for (let i = 0; i < this.resRA.length; i++) {
                                axios.post('/api/respuesta/ra/guardar', {
                                        id_gp: this.resRA[i].cz5_gp_id,
                                        id_pp: this.resRA[i].cz5_id,
                                        categoria: 'ra',
                                        rta_ra: null
                                    })
                                    .then(res => {
                                        console.log(res.data)
                                    })
                            }
                            swal('', '', '')
                        }

                        console.log(this.resRA)
                    })
            },
            traerSMMR() {
                console.log(this.id)
                axios.get(`/api/respuestaM/buscar/${this.id}`)
                    .then(res => {
                        this.resSMMR = res.data
                        console.log(this.resSMMR)
                        this.buscarResmmr()
                    })
            },
            traerPregunta_SMUR() {
                axios.get(`/api/pregunta/index/${this.id}`)
                    .then(res => {
                        this.resSMUR = res.data
                        console.log(this.resSMUR)
                    })

            },

            cargar() {
                this.buscar()
                
                this.traerSMMR()
                this.traerRa();
                this.traerPregunta_SMUR();
                this.buscarResmur()

                this.buscarRa();
            },
            buscarResmur() {
                axios.get(`/api/respuesta/smur/buscar/${this.id}/${this.id_empleado}`)
                    .then(res => {


                        for (var i = 0; i < res.data.length; i++) {
                            this.respuestas_smur.push(res.data[i].cz11_rta)
                            this.notas_smur.push(res.data[i].cz11_nota)
                        }


                    })
            },
            buscarResmmr() {
               axios.get(`/api/respuesta/smmr/buscar/${this.id}/${this.$route.params.empleado}`)
                    .then(res => {
                        this.notas_smmr = res.data
                       
                        for(var i = 0; i < this.resSMMR.length; i++ ){
                            this.inputs.push([])
                               for(var j = 0; j < this.notas_smmr.length; j++ ){
                                   
                                   if(this.notas_smmr[j].cz11_pp_id == this.resSMMR[i].cz5_id){
                                       this.inputs[i].push(this.notas_smmr[j].cz11_rta)
                                   }

                              }
                           
                        }
                        console.log(this.inputs)

                })
            },
            buscarRa() {
                axios.get(`/api/respuesta/ra/buscar/${this.id}/${this.$route.params.empleado}`)
                    .then(res => {
                        // this.respuestas_ra = res.data
                        this.nota_ra = res.data

                        for (var i = 0; i < res.data.length; i++) {
                            this.respuestas_ra.push(res.data[i].cz11_rta_ra)
                        }
                        console.log(this.respuestas_ra)
                    })

            },
            buscar() {
                axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                    this.id = res.data.cz3_id
                    this.id_creador = res.data.cz3_id_creador
                    this.titulo = res.data.cz3_nombre
                    //AQUI SABEMOS SI TIENE PERMISOS PARA VER LAS PRUEBAS DE OTROS USUARIOS
                    this.validar()


                });
            },
            conseguirEstado() {
                axios.get(`/api/asignacion/estado/${this.$route.params.id}/${this.$route.params.empleado}`)
                    .then(res => {
                        this.calificacion_final = Math.round(res.data.cz4_calificacion * 100) / 100

                        this.estado_prueba = res.data.cz4_estado
                        console.log(this.estado_prueba)
                        if (this.estado_prueba == 2 && user.id != this.id_creador) {
                            swal('Advertencia', 'Esta prueba ya finalizo', 'warning')
                            console.log('Estado')
                            this.$router.go(-1)


                        }
                    })

            }

        },
        computed: {


        }


    };

</script>
