<template>
    <div>
        <nav class="navbar navbar-light bg-light my-2">

            <div class=" pull-right">
                Ver
            </div>
            <div class="col-md-1">
                <select v-model="selectPag" @click.prevent="mostrarCaja()" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="0">Personalizado </option>
                </select>
            </div>
            <div class=" pull-left">
                Registros
            </div>
            <div class="col-md-4 col-center col-sm-2  has-feedback">
                <select v-model="select" class="form-control">
                    <option value="Todas">Todas</option>
                    <option value="Cerradas">Cerradas</option>
                    <option value="Abiertas">Abiertas</option>
                    <option value="Proximas">Proximas</option>

                </select>
            </div>
            <div class="col-md-6 col-center has-feedback mt-2">
                <input type="text" v-model="bprueba" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>
        </nav>
        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Fecha de Apertura</th>
                        <th scope="col">Fecha de Cierre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indice) in mbuscar" :key="indice"
                        v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bprueba != ''">
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
                        <td>
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
                            <button type="button" class="btn btn-primary btn-sm" title="Editar"
                                @click="$emit('editar',item)">
                                <li class="fa fa-edit"></li>
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" title="Cerrar"
                                @click="$emit('cerrar',item.cz3_id)">
                                <li class="fa fa-calendar"></li>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" title="Administrar"
                                @click="$emit('preguntas',item.cz3_id)">
                                <li class="fa fa-gear"></li>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" title="Estadisticas"
                                @click="$emit('estadisticas',item.cz3_id)">

                                <li class="fa fa-bar-chart"></li>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" title="Eliminar"
                                @click="$emit('eliminar',item.cz3_id, indice)">
                                <li class="fa fa-trash-o"></li>
                            </button>


                        </td>
                    </tr>
                </tbody>

            </table>

            <div class="row">
                <div class="col-md-4 col-float"></div>
                <div v-show="bprueba == ''" class="col-md-6 col-center">
                    <button type="button" @click.prevent="pagina=pagina-1" v-show="pagina!=1" class="btn btn-primary">
                        <li class="fa fa-long-arrow-left"></li>
                    </button>

                    <button type="button" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(mbuscar.length) < 1"
                        class="btn btn-success">
                        <li class="fa fa-long-arrow-right"></li>
                    </button>
                </div>
            </div>
        </div>
        <center>
            
            <div v-show="carga  && pruebas.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
              <div v-show="carga == false  && pruebas.length == []">
               <p>No se encontraron resultados</p>
            </div>
        </center>
    </div>
</template>
<script>
    import moment from "moment";
    moment.locale("es");
    export default {
        props: ['pruebas'],
        data() {
            return {
                selectPag: 5,
                numero: 5,
                mostrar: 0,
                pagina: 1,
                bprueba: '',
                select: 'Todas',
                moment: moment,
                id: null,
                carga: true
            }

        },
      
        mounted() {
            setTimeout(
                _ => this.carga = false, 
                10000 
            )
        },
        methods: {
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1
                } else {
                    this.mostrar = 0
                    this.numero = this.selectPag
                }
            },
            calcularTiempo() {


            }

            //     },
            //      asignados(){
            //       axios.get(`/api/asignacion/contar/${this.id}`)
            //       .then(res=>{

            //       })
            //   }
        },
        computed: {


            mbuscar: function () {
                return this.pruebas.filter((prueba) => {
                    if (this.select == null || this.select == 'Todas') {
                        return prueba.cz3_nombre.toUpperCase().includes(this.bprueba.toUpperCase()) ||
                            prueba.cz3_descripcion.toUpperCase().includes(this.bprueba.toUpperCase())
                    } else if (this.select == 'Cerradas') {
                        return (
                            (moment().diff(prueba.cz3_fecha_cierre) > 0 &&
                                prueba.cz3_nombre
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
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
                        );
                    } else if (this.select == 'Proximas') {
                        return (
                            (moment().diff(prueba.cz3_fecha_apertura) < 0 &&
                                prueba.cz3_nombre
                                .toUpperCase()
                                .includes(this.bprueba.toUpperCase())
                            )
                        );
                    }
                })
            }

        }

    }

</script>
