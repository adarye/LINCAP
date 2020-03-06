<template>

    <div v-show="id_creador == id_log || rol == 2 || rol == 1">
        <vue-headful :title="$route.params.cat == 1 ?  'Lincap | Asignar encuesta':  'Lincap | Asignar evaluación'" />

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-if=" $route.params.cat == 1" class="breadcrumb-item"><i class="fa fa-pencil">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Encuestas
                        </router-link>
                    </i></li>
                <li v-if=" $route.params.cat == 2" class="breadcrumb-item"><i class="fa fa-file-text">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Evaluaciones
                        </router-link>
                    </i></li>
                <li class="breadcrumb-item">{{titulo}}</li>
                <li class="breadcrumb-item active"><i class="fa fa-users">Asignar</i></li>

            </ol>
        </nav>
        <modal name="cargos" :clickToClose="false" :adaptive="true" :width="525" :height="380">
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

                                <input type="checkbox" name="eleccion"
                                    :checked="cargos_filtro.filter(id => id == item.c0763_rowid ) != ''"
                                    @click="incluirCargo(item.c0763_rowid, $event.target.checked)">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <button type="button" class="btn btn-danger mt-3" @click="cargos_filtro = [];">
                    <i class=" fa fa-refresh" title="Quitar filtro"></i>
                </button>
                <button type="button" class="btn btn-warning mt-3" @click="$modal.hide('cargos');">
                    <i class="fa fa-close" title="Cerrar"></i>
                </button>
            </div>
        </modal>

        <nav class="navbar navbar-light bg-light my-2">
            <div v-if="id_creador == id_log" class="col-md-1 col-center has-feedback">
                <button type="button" class="btn btn-primary" @click="guardarTodos(mbuscar)" title="Asignar a todos"><i
                        class="fa fa-users"></i></button>
                <button type="button" class="btn btn-danger" @click="quitarTodos(mbuscar)" title="Quitar a todos"><i
                        class="fa fa-users"></i></button>
            </div>
            <div class="col-md-2 col-center col-sm-2  has-feedback">
                <select v-model="selectEM" class="form-control">
                    <option value="MOSTRAR TODOS">MOSTRAR TODOS</option>
                    <option value="SELECCIONADOS">SELECCIONADOS</option>
                    <option value="NO SELECCIONADOS">NO SELECCIONADOS</option>
                </select>
            </div>
            <div class="col-md-3 col-center col-sm-2  has-feedback">
                <select v-model="selectCO" class="form-control">
                    <option value="co">CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-3 col-center has-feedback">
                <input type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <div class="col-md-2  col-sm-1 form-group has-feedback">
                <vue-excel-xlsx :sheetname="'sheetname'" class="btn btn-sm btn-info mt-1" :data="mbuscar"
                    :columns="columns" :filename="titulo + '-resultados.xls' " title="Exportar">
                    <i class="fa fa-print"></i>
                </vue-excel-xlsx>
                <button class="btn btn-primary mt-1" @click="$modal.show('cargos')" title="Filtrar por cargos">
                    <i class="fa fa-filter"></i>
                </button>
            </div>
            <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>
        </nav>

        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="texto">Cedula</th>
                        <th scope="col" class="texto">Nombre</th>
                        <th scope="col" class="texto">C. O</th>
                        <th scope="col" class="texto">Cargo</th>
                        <th scope="col" class="texto">Fecha de realizacion</th>
                        <th scope="col" class="texto" v-show="$route.params.cat == 2">Nota</th>
                        <th scope="col" class="texto" v-if="id_creador == id_log">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indice) in mbuscar" :key="indice"
                        v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bempleado != ''">


                        <th scope="row">{{ item.c0541_id }} </th>

                        <td>
                            {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                            {{ item.c0541_apellido2 }}
                        </td>
                        <td>{{ item.f285_descripcion }}</td>
                        <td>{{ item.c0763_descripcion }}</td>
                        <td v-if=" item.nota.length >= 1 && item.nota[0].cz4_calificacion != null">
                            {{ moment(item.nota[0].cz4_fecha_finalizacion).format('LLLL')}}</td>
                        <td
                            v-else-if="$route.params.cat == 1 && item.nota.length >= 1 && item.nota[0].cz4_fecha_finalizacion != null">
                            {{ moment(item.nota[0].cz4_fecha_finalizacion).format('LLLL')}}</td>
                        <td v-else></td>
                        <td v-show="$route.params.cat == 2">
                            <h4><span v-if="item.nota.length >= 1 && item.nota[0].cz4_calificacion != null "
                                    :class="item.nota[0].cz4_calificacion < 3.5 ? 'badge badge-danger':'badge badge-success'">{{Math.round(item.nota[0].cz4_calificacion * 100) / 100}}</span>
                            </h4>
                        </td>

                        <td v-if="id_creador == id_log">



                            <span v-show="item.nota.length >= 1">
                                <button class=" btn btn-primary fa fa-check-square-o"
                                    @click="excluir(item.c0550_rowid_tercero)">
                                </button>
                                <button class="btn btn-success fa fa-search-plus"
                                    @click="buscarEncuesta(item.c0550_rowid_tercero)"></button>
                                <!-- {{ emp_calificacion.filter(emp => emp.cz4_ts_id == item.c0550_rowid_tercero && emp.cz4_calificacion != null)}} -->
                            </span>
                            <span v-show="item.nota.length == 0">
                                <button class="btn btn-outline-primary fa fa-square-o"
                                    @click="incluir(item.c0550_rowid_tercero)">
                                </button>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-4 col-float"></div>
            <div v-show="bempleado == ''" class="col-md-4 col-center">

                <button type="button" @click.prevent="pagina=pagina-1" :disabled="pagina == 1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina=pagina+1"
                    :disabled="(pagina * numero) / mbuscar.length >= 1" class="btn btn-success">
                    <li class="fa fa-long-arrow-right"></li>
                </button>

            </div>


            <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</div>



        </div>
        <center>
            <div v-show="activos.length == 0" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </center>
    </div>

</template>
<script>
    import moment from 'moment';
    moment.locale('es');
    import router from '../../router'
    export default {


        data() {
            return {

                emp_calificacion: [],

                seleccionados: [],
                CO: [],
                activos: [],
                selectPag: 15,
                selectCO: 'co',
                numero: 15,
                mostrar: 0,
                bempleado: '',
                pagina: 1,
                moment: moment,
                id_prueba: null,
                selectEM: 'MOSTRAR TODOS',
                titulo: "",
                id_creador: null,
                id_log: null,
                rol: null,
                cargos: [],
                cargos_filtro: [],
                columns: [{
                        label: "Cedula",
                        field: "c0541_id"
                    },
                    {
                        label: "Nombre(s)",
                        field: "c0541_nombres"
                    },
                    {
                        label: "Apellido 1",
                        field: "c0541_apellido1"
                    },
                    {
                        label: "Apellido 2",
                        field: "c0541_apellido2"
                    },
                    {
                        label: "Cargo",
                        field: "c0763_descripcion"
                    },

                    {
                        label: "Centro de operacion",
                        field: "f285_descripcion"
                    },
                    {
                        label: "Fecha de ingreso",
                        field: "c0550_fecha_ingreso",
                        dataFormat: this.fechaFormat2
                    },
                    {
                        label: "Fecha de terminacion del contrato",
                        field: "c0550_fecha_contrato_hasta",
                        dataFormat: this.fechaFormat2
                    },
                    {
                        label: "Fecha de realizacion",
                        field: "nota",
                        dataFormat: this.fechaFormat
                    },
                    {
                        label: "Nota",
                        field: "nota",
                        dataFormat: this.notaFormat
                    }
                ]
            };
        },
        mounted() {
            this.rol = user.rol
            this.id_log = user.id
            this.id_prueba = this.$route.params.id

            this.buscar()
            this.buscarCargos()
        },
        methods: {
            incluirCargo(id, event) {
                if (event == true) {
                    this.cargos_filtro.push(id)
                } else if (event == false) {

                    for (var i = 0; i < this.cargos_filtro.length; i++) {
                        if (this.cargos_filtro[i] === id) {
                            this.cargos_filtro.splice(i, 1);
                        }
                    }

                }
                console.log(this.cargos_filtro)
            },
            buscarCargos() {
                axios.get('/api/estadistica/cargar/cargos')
                    .then(res => {
                        this.cargos = res.data

                    })

            },
            notaFormat(value) {
                if (value.length > 0 && value[0].cz4_calificacion != null) {
                    return Math.round(value[0].cz4_calificacion * 100) / 100
                } else {
                    return ""
                }
            },
            fechaFormat2(value) {
                if (value != null) {
                    var fecha = new Date(value)
                    var fecha_format = fecha.setDate(fecha.getDate() + 1);

                    return new Date(fecha_format)
                } else {
                    return "Indefinida"
                }

            },
            fechaFormat(value) {
                if (value.length > 0 && value[0].cz4_fecha_finalizacion != null) {
                    return new Date(value[0].cz4_fecha_finalizacion)
                } else {
                    return ""
                }


            },
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1
                } else {
                    this.mostrar = 0
                    this.numero = this.selectPag
                }
            },
            traerActivos() {
                axios.get(`/api/asignacion/traerNotas/${this.id_prueba}`).then(res => {

                    this.activos = res.data;

                });
            },

            quitarRelacion() {
                this.seleccionados = []
                axios.get(`/api/asignacion/index/${this.id_prueba}`).then(res => {
                    for (var i = 0; i < res.data.length; i++) {
                        this.seleccionados.push(res.data[i].cz4_ts_id)
                        this.traerActivos()
                    }

                });
            },
            getCO: function () {
                axios.get("/api/getCO").then(res => {
                    this.CO = res.data;

                });
            },
            incluir(c0550_rowid_tercero) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Enviando...</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });
                axios.post("/api/asignacion/guardar", {
                        id: c0550_rowid_tercero,
                        id_prueba: this.id_prueba
                    })
                    .then(res => {
                        this.traerActivos()
                        swal('Correcto', res.data.mensaje, 'success')
                    });

            },
            excluir(item) {
                const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-danger row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Eliminando...</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });

                axios.post("/api/asignacion/delete", {
                        id_ts: item,
                        id_prueba: this.id_prueba
                    })
                    .then(res => {
                        this.traerActivos()
                        swal('Correcto', 'Se ha eliminado la asignación ', 'success')
                    });


            },
            guardarTodos(filtrados) {
                var empleados = null
                if (filtrados.length == 0) {
                    empleados = this.activos
                } else {
                    empleados = filtrados
                }

                const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div>  <div class=''>Esto puede tomar varios minutos</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });
                axios.post("/api/asignacion/guardarTodos", {
                    id_prueba: this.id_prueba,
                    activos: empleados,
                    seleccionados: this.seleccionados
                }).then(res => {
                    swal('Se han seleccionado todos', '', 'success')
                    this.traerActivos()


                }).catch(res => {
                    swal('Ha sucedido un error inesperado', '', 'error')
                    this.traerActivos()
                })
            },

            quitarTodos(filtrados) {
                var empleados = null
                if (filtrados.length == 0) {
                    empleados = this.activos
                } else {
                    empleados = filtrados
                }


                const wrapper = document.createElement('div');
                wrapper.innerHTML =
                    "<div class='spinner-border text-primary row' role='status'> <span class='sr-only'>Loading...</span> </div> <div >Esto puede tomar varios minutos</div> ";
                swal({
                    buttons: false,
                    html: true,
                    content: wrapper,
                    closeOnClickOutside: false
                });
                axios.post("/api/asignacion/quitarTodos", {
                    id_prueba: this.id_prueba,
                    activos: empleados,
                    seleccionados: this.seleccionados
                }).then(res => {
                    this.quitarRelacion();
                    swal('Se han quitado las asignaciones', '', 'success')
                    this.traerActivos()


                }).catch(res => {
                    swal('Ha sucedido un error inesperado', '', 'error')
                    this.traerActivos()
                })
            },
            buscarEncuesta(id) {
                axios.get(`/api/gp/buscar/${this.id_prueba}`)
                    .then(res => {
                        if (res.data.cz3_categoria == 1) {
                            router.push('/administrar/encuesta/' + this.id_prueba + '/' + id + '/' + user.id)
                        } else if (res.data.cz3_categoria == 2) {
                            router.push('/administrar/evaluacion/' + this.id_prueba + '/' + id + '/' + user.id)
                        }
                    })

            },
            buscar() {
                axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                    this.titulo = res.data.cz3_nombre
                    this.id_creador = res.data.cz3_id_creador
                    if (this.id_creador != user.id && user.rol != 2 && user.rol != 1) {
                        window.location.href = '/'
                    } else {
                        if (this.id_creador != this.id_log) {
                            this.selectEM = "SELECCIONADOS"
                        }
                        this.getCO();
                        this.traerActivos();

                    }

                });
            }

        },
        computed: {

            mbuscar: function () {

                // return this.activos.filter((activo) => activo.c0550_rowid_tercero == this.seleccionados ) 

                return this.activos.filter((activo) => {
                    this.pagina = 1
                    if (this.selectCO == null || this.selectCO == 'co' && this.selectEM ==
                        'MOSTRAR TODOS') {
                        const nombre_completo = activo.c0541_nombres + ' ' + activo.c0541_apellido1 + ' ' +
                            activo.c0541_apellido2


                        return activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            nombre_completo.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())



                    } else if (this.selectEM == "MOSTRAR TODOS" && this.selectCO != 'co') {
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (
                            (activo.f285_id.includes(this.selectCO) &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (activo.f285_id.includes(this.selectCO) &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (activo.f285_id.includes(this.selectCO) &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        );
                    } else if (this.selectCO != 'co' && this.selectEM == 'SELECCIONADOS') {
                        if (this.bempleado == "") {
                            return activo.nota.length >= 1 && activo.f285_id.includes(this
                                .selectCO)
                        }
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (
                            (activo.nota.length >= 1 &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)

                            ) ||
                            (activo.nota.length >= 1 &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            ) ||
                            (activo.nota.length >= 1 &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            )
                        );

                    } else if (this.selectEM == "SELECCIONADOS") {
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return ( activo.nota.length >= 1 &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (activo.nota.length >= 1 &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (activo.nota.length >= 1 &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            )
                    } else if (this.selectCO != 'co' && this.selectEM == 'NO SELECCIONADOS') {
                        if (this.bempleado == "") {
                            return activo.nota.length == 0 && activo.f285_id.includes(this
                                .selectCO)
                        }
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (
                            (activo.nota.length == 0 &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)

                            ) ||
                            (activo.nota.length == 0 &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            ) ||
                            (activo.nota.length == 0 &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            )
                        );

                    } else if (this.selectEM == "NO SELECCIONADOS") {
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (activo.nota.length == 0 &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (activo.nota.length == 0 &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (activo.nota.length == 0 &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            )
                    }

                })
            }



        }
    };

</script>
