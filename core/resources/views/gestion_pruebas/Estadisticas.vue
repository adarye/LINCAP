<template>
    <div class="small">
       <div class="row">
        <div class="col-md-4  col-sm-2  has-feedback">
                <select v-model="selectSede" @change="filtrar()" class="form-control">
                    <option value="SEDES">SEDES</option>
                    <option v-for="(item, indice) in sedes" :key="indice"  v-bind:value="item.f285_id">
                         {{ item.f285_descripcion }}
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary" @click="$modal.show('cargos')">Filtrar por cargos</button>
            </div>
            </div>
            
        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas
        </h4>
        <div v-for="(item, indice) in  resSMUR" :key="indice" class="my-5">
            <div class="my-4" v-show="chartData != '[]'">
                <div class="row mt-2">
                    <div class="col-md-12 col-center">
                        <center class="alert alert-color">
                            <h2 class="lead title-pregunta">{{ item.cz5_pregunta }}
                            </h2>
                        </center>
                    </div>

                </div>
                <div class="col-md-12">
                    <GChart type="ColumnChart" :data="chartData[indice]" :options="chartOptions" style="width: 100%; height: 100%;"/>

                </div>
                <div class="col-md-12">
                    <GChart class="mb-5" type="PieChart" :data="chartData[indice]" :options="chartOptions" style="width: 100%; height: 100%;" />

                </div>
            </div>
        </div>

        <h4 class="display-5 titulo mt-5" v-show=" resSMMR.length">Preguntas de selección multiple con multiple
            respuestas
        </h4>
        <article v-for="(item, i) in  resSMMR" :key="`o-${i}`" class="my-5">

            <div class="row">
                <div class="col-md-12 col-center">
                     <center class="alert alert-color">
                            <h2 class="lead title-pregunta">{{ item.cz5_pregunta }}
                            </h2>
                        </center>
                </div>

            </div>
            <div class="col-md-12">

                <GChart type="ColumnChart" :data="chartData2[i]" :options="chartOptions" style="width: 100%; height: 100%;" />
                

            </div>
            <div class="col-md-12">
                <GChart type="PieChart" :data="chartData2[i]" :options="chartOptions" style="width: 900px; height: 450px;" />
            </div>
        </article>
         <modal name="cargos" :clickToClose="false" :adaptive="true" :width="525" :height="425">
                <div class="table-responsive-md table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="texto">Cargo</th>
                       
                        <th scope="col" class="texto">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                     <tr v-for="(item, i) in cargos" :key="`o-${i}`">


                        <th scope="row">{{ item.c0763_descripcion }}</th>

            
                        <td>
                            <input    v-show="cargos_filtro.filter(e => e.id == item.item.c0763_id ) == ''" type="checkbox" name="eleccion" @click="cargos.push(item.c0763_id)">
                        </td>
                        </tr>

                </tbody>
            </table>
                </div>
                 <button type="button" class="btn btn-info mt-3" @click="filtrar">
                  Filtrar   <li class="fa fa-filter"></li>
                </button>
                 <button type="button" class="btn btn-danger mt-3" @click="$modal.hide('cargos')">
                  Cerrar 
                </button>
         </modal>


    </div>
    </template>
    <script>
        import {
            GChart
        } from 'vue-google-charts'


        export default {
            components: {
                GChart
            },
            data() {
                return {
                    id: null,
                    resSMMR: [],
                    resRA: [],
                    resSMUR: [],
                    prueba: [],
                    datacollection: null,
                    chartData: [],
                    chartData2: [],
                    chartOptions: {

                        chart: {
                            title: 'Encuesta LINCO',
                            subtitle: '',
                             is3D: true
                        }
                    },
                    pregunta: 0,
                    sedes: "",
                    selectSede:"SEDES",
                    cargos:[],
                    cargos_filtro:[]
                }
            },
            created() {
                this.id = this.$route.params.id
                this.traerSMMR()
                this.traerPregunta_SMUR()
                this.buscar()
                this.buscarSedes()
                this.buscarCargos()
            },
            methods: {
                traerSMMR() {
                    axios.get(`/api/respuestaM/buscar/${this.id}`)
                        .then(res => {
                            this.resSMMR = res.data
                            for (var j = 0; j < this.resSMMR.length; j++) {
                                this.chartData2.push([
                                    ['Respuestas', 'Trabajadores']
                                ])

                                for (var i = 0; i < res.data[j]['smmr'].length; i++) {
                                    this.buscarRes2(res.data[j]['smmr'][i].cz8_id, j, res.data[j]['smmr']
                                        [i].cz8_rta)

                                }

                            }
                        })
                },
                traerPregunta_SMUR() {

                    axios.get(`/api/pregunta/index/${this.id}`)
                        .then(res => {
                            this.resSMUR = res.data

                            for (var j = 0; j < this.resSMUR.length; j++) {
                                this.chartData.push([
                                    ['Respuestas', 'Trabajadores']
                                ])

                                for (var i = 0; i < res.data[j]['respuestas'].length; i++) {
                                    this.buscarRes(res.data[j]['respuestas'][i].cz7_id, j, res.data[j]['respuestas']
                                        [i].cz7_rta)

                                }

                            }
                        })
                },
                buscar() {
                    axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {

                    });
                },
                buscarRes(id, j, rta) {
                    console.log(this.selectSede)
                    axios.post('/api/estadistica/buscar/smur', {id: id, co: this.selectSede}).then(res => {
                        //  this.chartData.push([rta])
                        this.chartData[j].push([rta, res.data])
                    });
                },
                buscarRes2(id, j, rta) {
                    axios.get(`/api/estadistica/buscar/smmr/${id}`).then(res => {
                        
                        this.chartData2[j].push([rta, res.data])
                    });
                },
                buscarSedes(){
                    axios.get('/api/getCO')
                    .then(res=>{
                        this.sedes = res.data
                        console.log(res.data)
                    })
                },
                buscarCargos(){
                    axios.get('/api/estadistica/cargar/cargos')
                    .then(res=>{
                        this.cargos = res.data
                    })

                },
                filtrar(){
                    this.chartData= []
                    this.chartData2 = []
                    this.traerPregunta_SMUR()
                    this.traerSMMR()
                }
            }
        }

    </script>
