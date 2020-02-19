<template>
    <div>
          <vue-headful
            title="Lincap | Ver encuesta"
        />
     <nav  aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><i class="fa fa-pencil"> <router-link v-bind:to="'/gestion/pruebas/1' + user"> Encuestas</router-link></i></li>
                 <li  class="breadcrumb-item"><i class="fa fa-users"> <router-link v-bind:to="'/gestion/pruebas/asignar/1/' + $route.params.id"> Asignar</router-link></i></li>
                <!-- <li class="breadcrumb-item"><i class="fa fa-gears"> {{datos.cz3_nombre}}</i></li> -->
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <center>
        <h1>{{titulo}}</h1>
        </center>
        <div class="alert alert-primary lead" role="alert" v-show="estado_prueba == 0">
         Esta encuesta no ha sido iniciada
         </div>
         <div class="alert alert-warning lead" role="alert" v-show="estado_prueba == 1">
         Esta encuesta ya ha sido iniciada
         </div>
          <div class="alert alert-success lead" role="alert" v-show="estado_prueba == 2">
         Esta encuesta ya esta finalizada
         </div>
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
                  
                    <textarea disabled v-model="respuestas_ra[i]" >
                    </textarea>
                </div>
            </div>
        </article>


        <h4 class="display-5 titulo my-3" v-show=" resSMUR.length">Preguntas de selección multiple con única respuestas</h4>
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
                       <div class="custom-control custom-radio">    
                        <input
                         disabled
                        :id="item2.cz7_id"
                        class="custom-control-input"
                         :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''"  
                          type="radio" :name="item.cz5_id" 
                         :value="item2.cz7_id">
                          <label class="custom-control-label" :for="item2.cz7_id">{{ item2.cz7_rta }}</label>
                       </div>
                    </article>
                    
                </div>
            </div>
        </article>


        <h4  class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple respuestas</h4>
         <article v-for="(item3, indice) in resSMMR" :key="`o-${indice}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>

            </div>
            <div class="col-md-12" v-if="inputs[indice]">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">

                    <div class="custom-control custom-checkbox">

                        <input
                            v-model="inputs[indice]" :id="item4.cz8_id"
                            disabled
                            class="custom-control-input" type="checkbox" :value="item4.cz8_id">
                        <label class="custom-control-label" :for="item4.cz8_id">{{ item4.cz8_rta }}</label>

                    </div>
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
                editar:true,
                id_creador: null,
                estado_prueba: null,
                user: "",
                titulo: "",
                inputs: []


            };
        },
       
        beforeMount() {
            this.id = this.$route.params.id
            this.user = user.id
            this.cargar();

        },
        methods: {
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
            contar() {
                this.contador = this.contador + 1
            },
           
            cargar() {
                  this.buscar()
                
            },
            
            buscarResmur(){
                axios.get(`/api/respuesta/smur/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                   console.log(res.data)
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_smur.push(res.data[i].cz11_rta)
                    }
                     console.log(this.respuestas_smur)
                   
                })
            },
            buscarResmmr(){
                axios.get(`/api/respuesta/smmr/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                   console.log(res.data)
                   for(var i = 0; i < this.resSMMR.length; i++){
                        this.inputs.push([])
                     for (var j = 0; j < res.data.length; j++) {
                        if (res.data[j].cz11_pp_id == this.resSMMR[i].cz5_id) {
                                    this.inputs[i].push(Number(res.data[j].cz11_rta))
                                }
                    }
                   }      
                })
            },
            buscarRa(){
             axios.get(`/api/respuesta/ra/buscar/${this.id}/${this.$route.params.empleado}`)
                .then(res=>{
                    // this.respuestas_ra = res.data
                   
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_ra.push( res.data[i].cz11_rta_ra)
                    }      
                    console.log(this.respuestas_ra)        
                })

            },
             buscar() {
            axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                this.id = res.data.cz3_id
                this.id_creador = res.data.cz3_id_creador
                this.titulo = res.data.cz3_nombre

               this.validar()
               
              
            });
        },
        validar(){
            axios.get(`/api/asignacion/estado/${this.$route.params.id}/${this.$route.params.empleado}`)
            .then(res=>{
               this.estado_prueba = res.data.cz4_estado
                if (user.id != this.id_creador) {
                            swal('Advertencia', 'Acceso denegado', 'warning')
                            this.$router.go(-1)
                        } else {
                            this.traerSMMR()
                            this.traerRa();
                            this.traerPregunta_SMUR();
                            this.buscarResmur()
                            this.buscarRa();

                        }
            })

        }
           
        },
        computed: {
           
        }
    };

</script>
