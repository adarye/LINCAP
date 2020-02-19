<template>
    <div>
        <vue-headful :title=" 'Presentar evaluación | ' + titulo" />
        <center>
            <h1 class="titulo">{{titulo}}</h1>
            {{estado_prueba}}
        </center>

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
                        @change="guardarRA(dato.cz5_id, dato.cz5_gp_id,  dato.cz5_categoria, respuestas_ra[i] )"
                        rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
                    </textarea>
                </div>
            </div>
        </article>


        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas
        </h4>
        <article v-for="(item, indice) in  resSMUR" :key="indice" class="my-3">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{ item.cz5_pregunta }}
                    </p>

                </div>
                <div class="col-md-2">

                </div>

                <div class="col-md-12">
                    <article v-for="(item2, i) in item.respuestas" :key="i">
                        <!-- {{respuestas.filter(cz7_id => cz7_id == item.cz7_id )}} -->
                        <div class="custom-control custom-radio">
                            <input :disabled="editar ? false : true"
                                @click="guardarSMUR(item.cz5_id, item.cz5_gp_id, item2.cz7_id, item.cz5_categoria)"
                                :id="item2.cz7_id"
                                :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''"
                                class="custom-control-input" type="radio" :name="item.cz5_id" :value="item2.cz7_id">
                            <label class="custom-control-label" :for="item2.cz7_id">{{ item2.cz7_rta }}</label>
                        </div>
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
            <div class="col-md-12" v-if="inputs[indice]">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">

                    <div class="custom-control custom-checkbox">

                        <input @click="guardarSMMR(item3.cz5_id, item3.cz5_gp_id, item4.cz8_id, item3.cz5_categoria)"
                            v-model="inputs[indice]" :id="item4.cz8_id"
                            :disabled="inputs[indice].length >= item3.cz5_n_rtas_correctas && inputs[indice].indexOf(Number(item4.cz8_id)) === -1"
                            class="custom-control-input" type="checkbox" :value="item4.cz8_id">
                        <label class="custom-control-label" :for="item4.cz8_id">{{ item4.cz8_rta }}</label>

                    </div>
                </article>
            </div>
        </article>

        <button v-show="estado_prueba != 2" @click="$router.go(-1)" class="btn btn-danger mt-4"
            type="button">Finalizar</button>


    </div>
</template>
<script>
    import EventBus from '../../bus';
    import router from '../../router'

    export default {
        data() {
            return {
                inputs: [],
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
                titulo: "",
                index: 0


            };
        },
        created() {
            window.addEventListener('beforeunload', this.calificar)
        },
        beforeMount() {
            this.id_log = user.id
            this.id = this.$route.params.id
            this.id_empleado = user.id

            this.cargar();
            this.contar();


        },

        methods: {
            contar() {
                axios.get(`/api/preguntas/contar/${this.id}`)
                    .then(res => {
                        console.log(res.data)
                        this.cantidad_preg = res.data
                    })
            },

            validar() {

                this.conseguirEstado()
                if ((this.fecha_cierre < new Date() || this.fecha_apertura > new Date())) {
                    console.log('cierre')
                    window.location.href = '/pruebas/pendientes/2'
                }

            },
            conseguirEstado() {
                axios.get(`/api/asignacion/estado/${this.$route.params.id}/${user.id}`)
                    .then(res => {

                        this.estado_prueba = res.data.cz4_estado

                        if (this.estado_prueba == 2 || this.estado_prueba == 1) {
                            swal('Advertencia', 'Esta prueba ya finalizo', 'warning')
                            console.log('Estado')
                            window.location.href = '/pruebas/pendientes/2'
                        } else {
                            this.traerSMMR()
                            this.traerRa();
                            this.traerPregunta_SMUR();
                            this.buscarResmur()
                            this.buscarRa();
                        }
                    })

            },
            traerRa() {
                console.log(this.id)
                axios.get(`/api/respuestaA/buscar/${this.id}`)
                    .then(res => {
                        this.resRA = res.data
                        if (this.estado_prueba != 2 && this.id_empleado == this.id_log) {
                            for (let i = 0; i < this.resRA.length; i++) {
                                axios.post('/api/respuesta/ra/guardar', {
                                        id_gp: this.resRA[i].cz5_gp_id,
                                        id_pp: this.resRA[i].cz5_id,
                                        categoria: 'ra',
                                        rta_ra: null
                                    })
                                    .then(res => {

                                    })
                            }
                        }
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
                axios.get(`/api/respuesta/smmr/buscar/${this.id}/${user.id}`)
                    .then(res => {
                        this.notas_smmr = res.data

                        for (var i = 0; i < this.resSMMR.length; i++) {
                            this.inputs.push([])
                            for (var j = 0; j < this.notas_smmr.length; j++) {

                                if (this.notas_smmr[j].cz11_pp_id == this.resSMMR[i].cz5_id) {
                                    this.inputs[i].push(Number(this.notas_smmr[j].cz11_rta))
                                }

                            }

                        }
                        console.log(this.inputs)

                    })
            },
            buscarRa() {
                axios.get(`/api/respuesta/ra/buscar/${this.id}/${user.id}`)
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

                axios.put(`/api/pruebas/finalizar/${this.id}`)
                    .then(res => {
                        
                        // window.location.href = '/pruebas/pendientes/2'
                        

                    })
            },

            calificar() {
                console.log('ENTRE')

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
                this.finalizar()
            }


        },
        beforeRouteLeave(to, from, next) {

            const answer = window.confirm('¿Esta seguro de finalizar la evaluacion?')
            if (answer) {
                window.location.href = '/pruebas/completadas/2'
            } else {
                next(false)
            }

        },
        computed: {


        }


    };

</script>