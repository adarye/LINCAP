<template>

    <div v-show="id_creador == id_log">
         <vue-headful
            :title="$route.params.cat == 1 ?  'Lincap | Asignar encuesta':  'Lincap | Asignar evaluación'"
        />

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li v-if=" $route.params.cat == 1" class="breadcrumb-item"><i class="fa fa-pencil">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Encuestas</router-link>
                    </i></li>
                <li v-if=" $route.params.cat == 2" class="breadcrumb-item"><i class="fa fa-file-text">
                        <router-link v-bind:to="'/gestion/pruebas/' + $route.params.cat + '/' + id_log"> Evaluaciones</router-link>
                    </i></li>
                <li class="breadcrumb-item" >{{titulo}}</li>
                 <li class="breadcrumb-item active"><i class="fa fa-users">Asignar</i></li>
               
            </ol>
        </nav>

        <nav class="navbar navbar-light bg-light my-2">
            <div class="col-md-2 col-center has-feedback">
                <button type="button" class="btn btn-primary" @click="guardarTodos(mbuscar)">Todos</button>
                <button type="button" class="btn btn-danger" @click="quitarTodos(mbuscar)">Quitar</button>
            </div>
            <div class="col-md-3 col-center col-sm-2  has-feedback">
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
                         <th scope="col" class="texto">Nota</th>
                        <th scope="col" class="texto">Acciones</th>
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
                         <td><h4><span v-if="item.nota.length >= 1 && item.nota[0].cz4_calificacion != null " :class="item.nota[0].cz4_calificacion < 3.5 ? 'badge badge-danger':'badge badge-success'">{{Math.round(item.nota[0].cz4_calificacion * 100) / 100}}</span></h4></td> 
                       
                        <td>
                            


                            <span
                                v-show="seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero == item.c0550_rowid_tercero ) != ''">
                                <button class=" btn btn-primary fa fa-check-square-o"
                                    @click="excluir(item.c0550_rowid_tercero)">
                                </button>
                                <button class="btn btn-success fa fa-search-plus"
                                    @click="buscarEncuesta(item.c0550_rowid_tercero)"></button>
                                <!-- {{ emp_calificacion.filter(emp => emp.cz4_ts_id == item.c0550_rowid_tercero && emp.cz4_calificacion != null)}} -->
                            </span>
                            <span
                                v-show="seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero == item.c0550_rowid_tercero ) == ''">
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

                <button type="button" @click.prevent="pagina=pagina-1" v-show="pagina!=1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(mbuscar.length) < 1"
                    class="btn btn-success">
                    <li class="fa fa-long-arrow-right"></li>
                </button>

            </div>
            <div class="col-md-4">

                <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                    {{ mbuscar.length }} Registros</div>
            </div>

            <!-- <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</div> -->

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
                id_log : null
            };
        },
        mounted() {
            this.id_log = user.id
            this.id_prueba = this.$route.params.id
            
            this.buscar()
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
            traerActivos() {
                axios.get(`/api/asignacion/traerNotas/${this.id_prueba}`).then(res => {
                    console.log(res.data)
                    this.activos = res.data;

                });
            },
            traerRelacion() {
                axios.get(`/api/asignacion/index/${this.id_prueba}`).then(res => {
                    this.emp_calificacion = res.data;
                    for (var i = 0; i < res.data.length; i++) {

                        this.seleccionados.push(res.data[i].cz4_ts_id)
                    }
                    console.log(this.seleccionados)

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
                this.seleccionados.push(c0550_rowid_tercero)
                axios.post("/api/asignacion/guardar", {
                        id: c0550_rowid_tercero,
                        id_prueba: this.id_prueba
                    })
                    .then(res => {
                        console.log(res.data)
                         swal('Correcto', res.data.mensaje, 'success')
                    });

            },
            excluir(item) {
                for (var i = 0; i < this.seleccionados.length; i++) {
                    if (this.seleccionados[i] === item) {
                        this.seleccionados.splice(i, 1);
                        axios.post("/api/asignacion/delete", {
                                id_ts: item,
                                id_prueba: this.id_prueba
                            })
                            .then(res => {
                                console.log(res.data)
                                this.traerRelacion()
                            });
                    }
                }
            },
            guardarTodos(filtrados) {
                var empleados = null
                if (filtrados.length == 0) {
                    empleados = this.activos
                } else {
                    empleados = filtrados
                }
                console.log(empleados)

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
                    console.log(res.data)
                    this.traerRelacion();
                    swal('Se han seleccionado todos', '', 'success')


                }).catch(res => {
                    swal('Ha sucedido un error inesperado', '', 'error')
                })
            },

            quitarTodos(filtrados) {
                var empleados = null
                if (filtrados.length == 0) {
                    empleados = this.activos
                } else {
                    empleados = filtrados
                }
                console.log(empleados)

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
                    console.log(res.data)
                    this.quitarRelacion();
                    swal('Se han quitado las asignaciones', '', 'success')


                }).catch(res => {
                    swal('Ha sucedido un error inesperado', '', 'error')
                })
            },
            buscarEncuesta(id) {
                axios.get(`/api/gp/buscar/${this.id_prueba}`)
                    .then(res => {
                        console.log(res.data)
                        if (res.data.cz3_categoria == 1) {
                            router.push('/administrar/encuesta/' + this.id_prueba + '/' + id +'/' + user.id)
                        } else if (res.data.cz3_categoria == 2) {
                            router.push('/administrar/evaluacion/' + this.id_prueba + '/' + id + '/' + user.id)
                        }
                    })

            },
            buscar() {
                axios.get(`/api/gp/buscar/${this.$route.params.id}`).then(res => {
                    this.titulo = res.data.cz3_nombre
                    this.id_creador = res.data.cz3_id_creador
                    if(this.id_creador != user.id){
                        window.location.href = '/'
                    }
                    else{
                        this.getCO();
            this.traerRelacion()
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
                            return this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                activo.c0550_rowid_tercero) != '' && activo.f285_id.includes(this
                                .selectCO)
                        }
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)

                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
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
                        return (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) != '' &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            )
                    } else if (this.selectCO != 'co' && this.selectEM == 'NO SELECCIONADOS') {
                        if (this.bempleado == "") {
                            return this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                activo.c0550_rowid_tercero) == '' && activo.f285_id.includes(this
                                .selectCO)
                        }
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return (
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)

                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()) &&
                                activo.f285_id.includes(this.selectCO)
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
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
                        return (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())
                            ) ||
                            (this.seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero ==
                                    activo.c0550_rowid_tercero) == '' &&
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
