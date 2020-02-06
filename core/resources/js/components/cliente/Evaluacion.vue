<template>
    <div>
        <center> <h1 class="titulo">{{titulo}}</h1></center>
        <div class="alert alert-warning lead" role="alert" v-show="estado_prueba == 1">
            Esta evaluacion ya ha sido iniciada
        </div>
        <div class="alert alert-success lead" role="alert" v-show="estado_prueba == 2">
            Esta evaluacion ya esta finalizada
        </div>
         <h4 class="display-5 titulo mb-3" v-show="calificacion_final">Calificacion Final: <span class="badge badge-primary">{{calificacion_final}}</span></h4>

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

                    <textarea :disabled="editar ? false : true" v-model="respuestas_ra[i]"
                        @change="guardarRA(dato.cz5_id, dato.cz5_gp_id,  dato.cz5_categoria, respuestas_ra[i] )"
                        rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
                    </textarea>
                </div>
                <div class="col-md-3 p-3"  v-if="id_creador == id_log && nota_ra">
                    <div class="row">
                        <input type="radio"  required :name="dato.cz5_id" value="3" :checked="Math.round((5 /cantidad_preg*100))/100 == Math.round((nota_ra[i].cz11_nota*100))/100" @click="calificarRA($event, dato.cz5_id)"> Excelente
                    </div>
                    <div class="row">
                        <input type="radio"  :name="dato.cz5_id" value="2" :checked="Math.round((5 /cantidad_preg*100)/2)/100 == Math.round((nota_ra[i].cz11_nota*100))/100" @click="calificarRA($event, dato.cz5_id)" > Regular
                    </div>
                    <div class="row">
                        <input type="radio"  :name="dato.cz5_id" value="1" :checked="nota_ra[i].cz11_nota == 0" @click="calificarRA($event, dato.cz5_id)">Mal
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
                            @click="guardarSMUR(item.cz5_id, item.cz5_gp_id, item2.cz7_id, item.cz5_categoria)"
                            :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''" class="flat"
                            type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}
                    </article>

                </div>
            </div>
        </article>


        <h4 class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple
            respuestas</h4>
        <article v-for="(item3, i) in resSMMR" :key="`o-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>

            </div>
            <div class="col-md-12">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                    <input :disabled="editar ? false : true"
                        @click="guardarSMMR(item3.cz5_id, item3.cz5_gp_id, item4.cz8_id, item3.cz5_categoria)"
                        class="flat" type="checkbox"
                        :checked="respuestas_smmr.filter(cz8_id => cz8_id == item4.cz8_id ) != ''"
                        :value="item4.cz8_id">{{ item4.cz8_rta }}


                    <span
                        v-if="respuestas_smmr.filter(cz8_id => cz8_id == item4.cz8_id ) != '' && id_creador == id_log">
                        <!-- {{id_rta = item4.cz8_id }} -->


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

        <button v-show="editar" @click="finalizar" class="btn btn-danger mt-4" type="button">Finalizar</button>


    </div>
</template>
<script>
    import EventBus from '../../bus';
    import router from '../../router'

    export default {
        data() {
            return {
                id_rta: null,
                resSMUR: [],
                resRA: [],
                resSMMR: [],
                contador: 1,
                params: null,
                id: null,
                rta_ra: '',
                respuestas_smur: [],
                respuestas_smmr: [],
                respuestas_ra: [],
                editar: true,
                id_creador: null,
                fecha_cierre: null,
                fecha_apertura: null,
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
          
            this.id_log = user.id
            console.log('evaluacion')
            this.id = this.$route.params.id
            this.id_empleado = this.$route.params.empleado

            this.cargar();
        
             
            EventBus.$on('cargar', (item) => {
                this.cargar()
            });
              

        },
        mounted() {
            //  router.onReady(this.advertir)
            axios.get(`/api/preguntas/contar/${this.id}`)
            .then(res =>{
                console.log(res.data)
                this.cantidad_preg = res.data

            })
           
            window.addEventListener('beforeunload', this.cancelar)

        },
        beforeDestroy() {
            window.onbeforeunload = this.cancelar()

        },
        methods: {
            calificarRA(event, pregunta){
                
              let params= {
                  empleado: this.id_empleado,
                  prueba: this.id,
                  pregunta: pregunta,
                  cal: event.target.value


                }
                axios.put('/api/evaluacion/calificar/RA', params)
                .then(res =>{
                    console.log(res.data)
                     this.calificacion_final =Math.round(res.data.cz4_calificacion*100)/100
                })

            },

            validar() {

                this.conseguirEstado()
                if ((this.fecha_cierre < new Date() || this.fecha_apertura > new Date()) && this.id_creador != user
                    .id) {
                    this.$router.go(-1)
                }
                if (this.$route.params.empleado != user.id) {
                    this.editar = false
                    swal('Modo observador', 'No podra editar la prueba', 'warning')
                    if (this.id_creador != user.id) {
                        swal('Acceso denegado', '', 'warning')
                        this.$router.go(-1)
                    }
                }


            },
            traerRa() {
                console.log(this.id)
                axios.get(`/api/respuestaA/buscar/${this.id}`)
                    .then(res => {
                        this.resRA = res.data
                        console.log(this.resRA)
                    })
            },
            traerSMMR() {
                console.log(this.id)
                axios.get(`/api/respuestaM/buscar/${this.id}`)
                    .then(res => {
                        this.resSMMR = res.data
                        console.log(this.resSMMR)
                    })
            },
            traerPregunta_SMUR() {
                axios.get(`/api/pregunta/index/${this.id}`)
                    .then(res => {
                        this.resSMUR = res.data
                        console.log(this.resSMUR)
                    })

            },
            contar() {
                this.contador = this.contador + 1
            },

            cargar() {
                this.buscar()
                this.traerSMMR()
                this.traerRa();
                this.traerPregunta_SMUR();
                this.buscarResmur()
                this.buscarResmmr()
                this.buscarRa();
            },
            guardarRA(id_pp, id_gp, categoria, ra) {
                console.log(ra)
                axios.post('/api/respuesta/ra/guardar', {
                        id_gp: id_gp,
                        id_pp: id_pp,
                        categoria: categoria,
                        rta_ra: ra
                    })
                    .then(res => {
                        console.log(res.data)
                    })
            },
            guardarSMUR(id_pp, id_gp, id_rta, categoria) {
                axios.post('/api/respuesta/smur/guardar', {
                        id_gp: id_gp,
                        id_pp: id_pp,
                        id_rta: id_rta,
                        categoria: categoria
                    })
                    .then(res => {
                        console.log(res.data)
                    })
            },
            guardarSMMR(id_pp, id_gp, id_rta, categoria) {
                axios.post('/api/respuesta/smmr/guardar', {
                        id_gp: id_gp,
                        id_pp: id_pp,
                        id_rta: id_rta,
                        categoria: categoria
                    })
                    .then(res => {
                        console.log(res.data)
                    })
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
                        console.log(this.notas_smmr)

                        for (var i = 0; i < res.data.length; i++) {
                            this.respuestas_smmr.push(res.data[i].cz11_rta)
                            // this.notas_smmr.push(res.data[i].cz11_nota)
                        }
                        console.log(this.respuestas_smmr)


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

                    this.fecha_cierre = new Date(res.data.cz3_fecha_cierre);
                    this.fecha_apertura = new Date(res.data.cz3_fecha_apertura);
                    //AQUI SABEMOS SI TIENE PERMISOS PARA VER LAS PRUEBAS DE OTROS USUARIOS
                    this.validar()


                });
            },
            finalizar() {
                this.calificar()
                axios.put(`/api/pruebas/finalizar/${this.id}`)
                    .then(res => {
                        router.go(-1)

                    })
            },
            conseguirEstado() {
                axios.get(`/api/asignacion/estado/${this.$route.params.id}/${this.$route.params.empleado}`)
                    .then(res => {
                        this.calificacion_final =Math.round(res.data.cz4_calificacion*100)/100

                        this.estado_prueba = res.data.cz4_estado
                        console.log(this.estado_prueba)
                        if (this.estado_prueba == 2 && user.id != this.id_creador) {
                            swal('Advertencia', 'Esta prueba ya finalizo', 'warning')
                            this.$router.go(-1)


                        }
                    })

            },
            calificar() {
                axios.get(`/api/evaluacion/calificar/${user.id} / ${this.id}`)
                    .then(res => {
                        console.log(res.data)
                        if (!this.resRA.length) {
                            if (res.data >= 3.5) {
                                swal('Excelente', 'Tu nota final fue de ' + Number(res.data.toFixed(2)), 'success')
                            } else {
                                swal('Nota', 'Tu nota fue de ' + Number(res.data.toFixed(2)), 'warning')
                            }

                        } else {
                            swal('Informacion',
                                'Esta prueba consta de preguntas abiertas, por esto sera calificada después.',
                                'success')
                        }
                    })

            },
            cancelar() {
                
                if (this.id_creador != user.id) {
                    this.calificar()
                    axios.put(`/api/pruebas/finalizar/${this.id}`)
                        .then(res => {
                            swal('Prueba Finalizada', 'Ya no podras modificarla', 'success')

                        })
                }

            }

        },
        computed: {
            smmr() {
                // this.notas_smmr.filter(function(nota){
                // if(typeof(this.id_rta) != 'undefined'){
                return 'hola'
                // }
                //  return nota.cz11_rta == this.id_rta;         
                // });

            }

        }

    };

</script>
