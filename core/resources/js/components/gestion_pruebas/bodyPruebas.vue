<template>
    <div>
        <nav class="navbar navbar-light bg-light my-2">

            <div class=" pull-right">
               <b> Ver</b>
            </div>
            <div class="col-md-1">
                <input v-numeric-only v-on:keyup="constantes(); validarPagina();" class="form-control mt-2" v-model="numero" />
              
            </div>
            <div class=" pull-left">
               <b> Registro(s) </b>
            </div>
            <div  class="col-md-4 col-center col-sm-2  has-feedback">
                <select @change="constantes(); " v-model="select" class="form-control mt-2">
                    <option value="Todas">Todas las categorías</option>
                    <option value="Cerradas">Cerradas</option>
                    <option value="Abiertas">Abiertas</option>
                    <option value="Proximas">Proximas</option>

                </select>
            </div>
            <div class="col-md-5 col-center has-feedback mt-2">
                <input type="text" v-on:keyup="constantes(); validarPagina();" v-model="bprueba" class="form-control" v-autofocus placeholder="Buscar" />
            </div>

        </nav>
        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Key</th>
                        <th scope="col" v-if="estado">Autor </th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Fecha de Apertura</th>
                        <th scope="col">Fecha de Cierre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indice) in mbuscar" :key="indice"
                        v-show="(pagina-1) * numero <= indice && pagina*numero > indice">
                        <th>{{item.cz3_id}}</th>
                        <th v-if="estado">{{item.cz1_nombres}}</th>
                        <th scope="row">{{ item.cz3_nombre }}
                            <button class="badge badge-pill badge-success float-right p-1"
                                v-show=" moment().diff(item.cz3_fecha_cierre) < 0 &&  moment().diff(item.cz3_fecha_apertura) > 0"
                                @click="select = 'Abiertas'">Abierta</button>
                            <button class="badge badge-pill badge-warning float-right p-1"
                                v-show=" moment().diff(item.cz3_fecha_apertura) < 0"
                                @click="select = 'Proximas'">Proximamente</button>
                            <button class="badge badge-pill badge-danger float-right p-1"
                                v-show=" moment().diff(item.cz3_fecha_cierre) > 0"
                                @click="select = 'Cerradas'">Cerrada</button>
                        </th>
                        <td style="text-align: justify">
                            {{ item.cz3_descripcion }}
                        </td>
                        <td>
                            {{ moment(item.cz3_fecha_apertura).format('LLLL')  }}
                        </td>
                        <td>
                            {{ moment(item.cz3_fecha_cierre).format('LLLL') }}
                        </td>
                        <td>

                            <button type="button" class="btn btn-success btn-sm" title="Asignar"
                                @click="$emit('asignar',item.cz3_id)">
                                <li class="fa fa-users"></li>
                            </button>
                            <button v-show="item.cz3_id_creador == user" type="button" class="btn btn-primary btn-sm" title="Editar"
                                @click="$emit('editar',item)">
                                <li class="fa fa-edit"></li>
                            </button>
                            <button v-show="item.cz3_id_creador == user" type="button" class="btn btn-warning btn-sm" title="Cerrar"
                                @click="$emit('cerrar',item.cz3_id)">
                                <li class="fa fa-calendar"></li>
                            </button>
                            <button v-show="item.cz3_id_creador == user" type="button" class="btn btn-primary btn-sm" title="Administrar"
                                @click="$emit('preguntas',item.cz3_id)">
                                <li class="fa fa-gear"></li>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" title="Estadisticas"
                                @click="$emit('estadisticas',item.cz3_id)">

                                <li class="fa fa-bar-chart"></li>
                            </button>
                            <button v-show="item.cz3_id_creador == user" type="button" class="btn btn-danger btn-sm" title="Eliminar"
                                @click="$emit('eliminar',item.cz3_id, indice)">
                                <li class="fa fa-trash-o"></li>
                            </button>


                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
        <div class="row">
                <div class="col-md-4 "></div>
                <div class="col-md-4 ">
                  <center>
                    <button type="button" @click.prevent="pagina = Number(pagina) - 1; constantes()" :disabled="pagina == 1" class="btn btn-primary">
                        <li class="fa fa-long-arrow-left"></li>
                    </button>

                    <button type="button" @click.prevent="pagina = Number(pagina) + 1; constantes()" :disabled="(pagina * numero) / mbuscar.length >= 1"
                        class="btn btn-success">
                        <li class="fa fa-long-arrow-right"></li>
                    </button>
                  </center>
                </div>
                 <div class="col-md-4">

                <div class="pull-right">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                    {{ mbuscar.length }} Registros</div>
            </div>
            </div>
       

        <center> 
            <div v-show="carga  && pruebas.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
              <div v-show="carga == false  && pruebas.length == []">
               <!-- <p>No se encontraron resultados</p> -->
            </div>
        </center>
         
            
    </div>
</template>
<script>
    import moment from "moment";
    moment.locale("es");
     import EventBus from '../../bus';
    export default {
        props: ['pruebas', 'estado'],
        data() {
            return {
                selectPag: 10,
                numero: 10,
                mostrar: 0,
                pagina: 1,
                bprueba: '',
                select: 'Todas',
                moment: moment,
                id: null,
                carga: true,
                user: null

            }

        },
      
        created() {
          
           
            
        },
        beforeMount(){
              this.user = user.id
            setTimeout(
                _ => this.carga = false, 
                3000 
            )
            this.cache()
              EventBus.$on('validarPagina', (item) => {
            this.pagina = 1;
        });
            

        },
        methods: {
               cache(){
                 if(localStorage.input_prueba == undefined){
                          localStorage.setItem('input_prueba', this.bprueba)
                     
                    } 
                    else{
                        this.bprueba = localStorage.input_prueba;
                    }
                    if(localStorage.pagina_prueba == undefined){
                        localStorage.setItem('pagina_prueba', this.pagina)

                    }
                    else{
                          this.pagina = localStorage.pagina_prueba;
                    }
                    
                    if(localStorage.pag_prueba == undefined){
                        localStorage.setItem('pag_prueba', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_prueba;
                    }
                     if(localStorage.numero_prueba == undefined){
                        localStorage.setItem('numero_prueba', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_prueba;
                    }
                    if(localStorage.select_prueba == undefined){
                        localStorage.setItem('select_prueba', this.select)

                    }
                    else{
                          this.select = localStorage.select_prueba;
                    }

            },
            validarPagina(){
                localStorage.setItem('pagina_prueba', 1)
                this.pagina = 1; 
                

            },
            constantes(){

                localStorage.setItem('input_prueba', this.bprueba)
                localStorage.setItem('pagina_prueba', this.pagina)
                localStorage.setItem('select_prueba', this.select)
                 localStorage.setItem('pag_prueba', this.selectPag)
                  localStorage.setItem('numero_prueba', this.numero)
            },
            mostrarCaja: function () {
                
                if (this.selectPag == 0) {
                    this.mostrar = 1
                } else {
                    this.mostrar = 0
                    this.numero = this.selectPag
                }
            }
             

        },
        computed: {


            mbuscar: function () {
               
                return this.pruebas.filter((prueba) => {
                    if (this.select == null || this.select == 'Todas') {
                        return String(prueba.cz3_id).toUpperCase().includes(this.bprueba.toUpperCase()) ||
                        prueba.cz3_nombre.toUpperCase().includes(this.bprueba.toUpperCase()) ||
                            prueba.cz3_descripcion.toUpperCase().includes(this.bprueba.toUpperCase()) 
                            ||
                             prueba.cz1_nombres.toUpperCase().includes(this.bprueba.toUpperCase())
                            
                    } else if (this.select == 'Cerradas') {
                        return (
                            (moment().diff(prueba.cz3_fecha_cierre) > 0 &&
                                prueba.cz3_nombre.toUpperCase().includes(this.bprueba.toUpperCase())
                            )||(moment().diff(prueba.cz3_fecha_cierre) > 0 &&
                                prueba.cz3_descripcion.toUpperCase().includes(this.bprueba.toUpperCase())
                            )||(moment().diff(prueba.cz3_fecha_cierre) > 0 &&
                               String(prueba.cz3_id).toUpperCase().includes(this.bprueba.toUpperCase())
                            )
                            ||(moment().diff(prueba.cz3_fecha_cierre) > 0 &&
                              prueba.cz1_nombres.toUpperCase().includes(this.bprueba.toUpperCase())
                            )
                        );
                    } else if (this.select == 'Abiertas') {
                        return (
                            (moment().diff(prueba.cz3_fecha_cierre) < 0 && moment().diff(prueba
                                    .cz3_fecha_apertura) > 0 &&
                                prueba.cz3_nombre
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
                            )
                            ||(moment().diff(prueba.cz3_fecha_cierre) < 0 && moment().diff(prueba
                                    .cz3_fecha_apertura) > 0 &&
                                prueba.cz3_descripcion
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
                            )||(moment().diff(prueba.cz3_fecha_cierre) < 0 && moment().diff(prueba
                                    .cz3_fecha_apertura) > 0 &&
                                 String(prueba.cz3_id).toUpperCase().includes(this.bprueba.toUpperCase())
                            )||(moment().diff(prueba.cz3_fecha_cierre) < 0 && moment().diff(prueba
                                    .cz3_fecha_apertura) > 0 &&
                                prueba.cz1_nombres.toUpperCase().includes(this.bprueba.toUpperCase())
                            )
                        );
                    } else if (this.select == 'Proximas') {
                        return (
                            (moment().diff(prueba.cz3_fecha_apertura) < 0 &&
                                prueba.cz3_nombre
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
                            )
                            || (moment().diff(prueba.cz3_fecha_apertura) < 0 &&
                                prueba.cz3_descripcion
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
                            )|| (moment().diff(prueba.cz3_fecha_apertura) < 0 &&
                               String(prueba.cz3_id).toUpperCase().includes(this.bprueba.toUpperCase())
                            )|| (moment().diff(prueba.cz3_fecha_apertura) < 0 &&
                              prueba.cz1_nombres.toUpperCase().includes(this.bprueba.toUpperCase())
                            )
                        );
                    }
                })
            }

        }

    }

</script>
