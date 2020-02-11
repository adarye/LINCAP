<template>
    <div>
     <nav v-show="id_creador == user" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li  class="breadcrumb-item"><i class="fa fa-pencil"> <router-link v-bind:to="'/gestion/pruebas/' + 1"> Encuestas</router-link></i></li>
                 <li  class="breadcrumb-item"><i class="fa fa-users"> <router-link v-bind:to="'/gestion/pruebas/asignar/1/' + $route.params.id"> Asignar</router-link></i></li>
                <!-- <li class="breadcrumb-item"><i class="fa fa-gears"> {{datos.cz3_nombre}}</i></li> -->
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
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
                  
                    <textarea :disabled="editar ? false : true" v-model="respuestas_ra[i]"  @change="guardarRA(dato.cz5_id, dato.cz5_gp_id,  dato.cz5_categoria, respuestas_ra[i] )" rows="4" cols="50" type="text" class="form-control" v-uppercase v-max-length="200">
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
                        <!-- {{respuestas.filter(cz7_id => cz7_id == item.cz7_id )}} -->
                        
                        <input :disabled="editar ? false : true"
                         @click="guardarSMUR(item.cz5_id, item.cz5_gp_id, item2.cz7_id, item.cz5_categoria)" 
                         :checked="respuestas_smur.filter(cz7_id => cz7_id == item2.cz7_id ) != ''"  class="flat" type="radio" :name="item.cz5_id" :value="item2.cz7_id"> {{ item2.cz7_rta }}                 
                    </article>
                    
                </div>
            </div>
        </article>


        <h4  class="display-5 titulo my-3" v-show="resSMMR.length">Preguntas de selección multiple con multiple respuestas</h4>
        <article v-for="(item3, i) in resSMMR" :key="`o-${i}`">
            <div class="row mt-2">
                <div class="col-md-6">
                    <p class="lead">{{  item3.cz5_pregunta }}</p>
                </div>
                
            </div>
            <div class="col-md-12">
                <article v-for="(item4, i) in item3.smmr" :key="`s-${i}`">
                    <input 
                    :disabled="editar ? false : true"
                     @click="guardarSMMR(item3.cz5_id, item3.cz5_gp_id, item4.cz8_id, item3.cz5_categoria)" 
                    class="flat" type="checkbox" :checked="respuestas_smmr.filter(cz8_id => cz8_id == item4.cz8_id ) != ''" :value="item4.cz8_id">{{ item4.cz8_rta }}
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
                fecha_cierre: null,
                fecha_apertura:null,
                estado_prueba: null,
                user: ""


            };
        },
       
        beforeMount() {
            this.id = this.$route.params.id
            this.user = user.id
            this.cargar();
            EventBus.$on('cargar', (item) => {
                this.cargar()
            });
           

            

        },
        methods: {
            validar(){
                
               this.conseguirEstado()
               console.log('ddd' + this.id_creador)
                 if( (this.fecha_cierre < new Date() || this.fecha_apertura > new Date()) && this.id_creador != user.id){
                    this.$router.go(-1)
                 }
                if(this.$route.params.empleado != user.id){
                 this.editar = false
                swal('Modo observador', 'No podra editar la prueba', 'warning')
                if(this.id_creador != user.id){
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
            guardarRA(id_pp, id_gp, categoria, ra){
                console.log(ra)
                 axios.post('/api/respuesta/ra/guardar', {id_gp: id_gp, id_pp: id_pp,  categoria: categoria, rta_ra: ra })
                .then(res =>{
                    console.log(res.data)
                })
            },
            guardarSMUR(id_pp, id_gp, id_rta, categoria){
                axios.post('/api/respuesta/smur/guardar', {id_gp: id_gp, id_pp: id_pp, id_rta:id_rta, categoria: categoria })
                .then(res =>{
                    console.log(res.data)
                })
            },
               guardarSMMR(id_pp, id_gp, id_rta, categoria){
                axios.post('/api/respuesta/smmr/guardar', {id_gp: id_gp, id_pp: id_pp, id_rta:id_rta, categoria: categoria })
                .then(res =>{
                    console.log(res.data)
                })
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
                   
                     for (var i = 0; i < res.data.length; i++) {
                        this.respuestas_smmr.push(res.data[i].cz11_rta)
                    }
                     console.log(this.respuestas_smmr)
                   
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

                this.fecha_cierre = new Date(res.data.cz3_fecha_cierre);
                this.fecha_apertura = new Date(res.data.cz3_fecha_apertura);
                
                //AQUI SABEMOS SI TIENE PERMISOS PARA VER LAS PRUEBAS DE OTROS USUARIOS
               this.validar()
               
              
            });
        },
        finalizar(){
            axios.put(`/api/pruebas/finalizar/${this.$route.params.id}`)
            .then(res=>{
                swal('Prueba Finalizada', 'Ya no podras modificarla', 'success')
                  this.$router.go(-1)
            })
        },
        conseguirEstado(){
            axios.get(`/api/asignacion/estado/${this.$route.params.id}/${this.$route.params.empleado}`)
            .then(res=>{
               this.estado_prueba = res.data.cz4_estado
               console.log(this.estado_prueba)
               if(this.estado_prueba == 2 && user.id != this.id_creador){
                    swal('Advertencia', 'Esta prueba ya finalizo', 'warning')
                   this.$router.go(-1)
                   
                   
               }
            })

        }
           
        },
        computed: {
           
        }
    };

</script>
