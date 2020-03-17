<template>
    <div>

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
                                    @click="incluir(item.c0763_rowid, $event.target.checked);  pagina = 1">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
          <div class="col-md-12">
               <button type="button" class="btn btn-danger mt-3" @click="cargos_filtro = []; constantes();">
                <i class=" fa fa-refresh" title="Quitar filtro"></i>
            </button>
            <button type="button" class="btn btn-warning mt-3" @click="$modal.hide('cargos');">
                <i class="fa fa-close" title="Cerrar"></i>
            </button>
          </div>
        </modal>

        <modal name="campos" :clickToClose="false" :adaptive="true" :width="285" :height="400">


            <Excel v-on:filtrar="filtrar"></Excel>

            <div class="col-md-12  col-sm-8 form-group has-feedback">
                <vue-excel-xlsx :sheetname="'Empleados Activos'" class="btn btn-sm btn-info mt-3" :data="mbuscar"
                    :columns="columns" :filename="moment().format('L') + '-activos.xls' " title="Exportar">
                    <i class="fa fa-print"></i>
                </vue-excel-xlsx>

                <button type="button" title="Cerrar" class="btn btn-sm btn-danger mt-3"
                    @click="columns = []; $modal.hide('campos'); ">
                    <i class="fa fa-close"></i>
                </button>
            </div>

        </modal>



        <vue-headful title=" Lincap | Empleados activos " />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-folder-open"> Empleados</i></li>
                <li class="breadcrumb-item"><i class="fa fa-user"> Activos</i></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>

        <nav class="navbar navbar-light bg-light my-2">

            <div class=" pull-right">
                <b>Ver</b>
            </div>
            <div class="col-md-1  mt-2">
                <input v-numeric-only v-on:keyup="constantes(); validarPagina();" class="form-control mt-2" v-model="numero" />
            </div>
            <div class=" pull-left">
                <b>Registros</b>
            </div>

            <div class="col-md-4  mt-2 col-center col-sm-2  has-feedback">
                <select @change="constantes(); pagina = 1;" v-model="selectCO" class="form-control">
                    <option value="co">TODOS LOS CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-4 mt-2 col-center has-feedback">
                <input v-on:keyup="constantes" type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <div class="col-md-2 mt-2">
                <button title="Exportar" type="button" class=" btn btn-success" @click="$modal.show('campos')">
                    <i class="fa fa-file-excel-o"></i>
                </button>
                <button class="btn btn-primary" @click="$modal.show('cargos')" title="Filtrar por cargos">
                    <i class="fa fa-filter"></i>
                </button>
            </div>
           
           
            <div class="col-md-1" v-if="mostrar == 1"></div>
        </nav>

        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="texto">Cedula</th>
                        <th scope="col" class="texto">Nombre</th>
                        <th scope="col" class="texto">C. O</th>
                        <th scope="col" class="texto">Cargo</th>
                        <th scope="col" class="texto">Fecha de Ingreso</th>
                        <th scope="col" class="texto">Contrato hasta</th>
                        <th scope="col" class="texto">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indice) in mbuscar" :key="indice"
                        v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bempleado != ''">

                        <th scope="row">{{ item.c0541_id }}</th>
                        <td>
                            {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                            {{ item.c0541_apellido2 }}
                        </td>
                        <td>{{ item.f285_descripcion }}</td>
                        <td>{{ item.c0763_descripcion }}</td>
                        <td>{{ moment(item.c0550_fecha_ingreso).format('L') }}</td>
                        <td v-if="item.c0550_fecha_contrato_hasta != null">
                            {{ moment(item.c0550_fecha_contrato_hasta).format('L') }}</td>
                        <td v-else>No definida</td>
                        <td>
                            <router-link :to="{
                                name: 'showEmpleado',
                                params: { id: item.c0550_rowid_tercero, ruta: 'Activos' }
                            }">
                                <li class="fa fa-search icon">

                                </li>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-4 col-float"></div>
            <div v-show="bempleado == ''" class="col-md-4 col-center">
                <button type="button" @click.prevent="pagina = Number(pagina) - 1; constantes()" :disabled="pagina == 1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina = Number(pagina) + 1; constantes()" :disabled="(pagina * numero) / mbuscar.length >= 1"
                    class="btn btn-success">
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
    import router from '../../js/router';
    export default {

        data() {
            return {
                sortKey: ['c0763_descripcion'],
                sortOrder: ['asc'],
                CO: [],
                activos: [],
                selectPag: 10,
                selectCO: 'co',
                numero: 10,
                mostrar: 0,
                bempleado: "",
                pagina: 1,
                moment: moment,
                columns: [],
                cargos: [],
                cargos_filtro: [],
                index: 0
            };
        },
        created() {
            if (window.user.rol == 1 || window.user.rol == 2 || window.user.rol == 3) {

                this.getCO();
                this.buscarCargos();
                this.traerActivos()     
            } else {
                router.push('/');

            }
        },
        methods: {
            
            
             validarPagina(){
                if( Math.ceil(this.mbuscar.length / this.numero) < this.pagina){
                    this.pagina =  1

                }
            },
            traerActivos(){
                axios.get("/api/registros").then(res => {
                    this.activos = res.data;
                    this.cache()
                    this.validarPagina()
                    
                });

            },
             cache(){
                 if(localStorage.input_act == undefined){
                          localStorage.setItem('input_act', this.bempleado)
                     
                    } 
                    else{
                        this.bempleado = localStorage.input_act;
                    }

                    if(localStorage.pagina_act == undefined){
                       
                        localStorage.setItem('pagina_act', this.pagina)

                    }
                    else{
                        
                         this.pagina = localStorage.pagina_act
                     }

                     if(localStorage.selectCo_act == undefined){
                        localStorage.setItem('selectCo_act', this.selectCO)

                    }
                    else{
                          this.selectCO = localStorage.selectCo_act;
                    }
                    if(localStorage.pag_act == undefined){
                        localStorage.setItem('pag_act', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_act;
                    }
                     if(localStorage.numero_act == undefined){
                        localStorage.setItem('numero_act', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_act;
                    }
                     

                     if(localStorage.cargos_act == undefined){
                        localStorage.setItem('cargos_act', this.cargos_filtro)

                    }
                    else{
                        if(localStorage.getItem("cargos_act") != ""){
                         this.cargos_filtro = JSON.parse(localStorage.getItem("cargos_act"));
                        }
                    }
            },
            constantes(){

                localStorage.setItem('input_act', this.bempleado)
                localStorage.setItem('pagina_act', this.pagina)
                localStorage.setItem('selectCo_act', this.selectCO)
                 localStorage.setItem('pag_act', this.selectPag)
                  localStorage.setItem('numero_act', this.numero)
                    localStorage.setItem('cargos_act', JSON.stringify( this.cargos_filtro))
            },
            fechaFormat(value) {
                // return  moment(value).format('YYYY') 

                if (value != null) {
                    var fechai = new Date(value)
                    var h = fechai.setDate(fechai.getDate() + 1);
                    return new Date(h)
                } else {
                    return "Indefinida"
                }

            },
            buscarCargos() {
                axios.get('/api/estadistica/cargar/cargos')
                    .then(res => {
                        this.cargos = res.data

                    })

            },
            incluir(id, event) {
                if (event == true) {
                    this.cargos_filtro.push(id)
                } else if (event == false) {

                    for (var i = 0; i < this.cargos_filtro.length; i++) {
                        if (this.cargos_filtro[i] === id) {
                            this.cargos_filtro.splice(i, 1);
                        }
                    }

                }
                this.constantes()
            },
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1
                } else {
                    this.mostrar = 0
                    this.numero = this.selectPag
                }
            },
            getCO: function () {
                axios.get("/api/getCO").then(res => {
                    this.CO = res.data;
                });
            },

            filtrar(item, e, campo, nombre_tabla, isDate) {
                var index = -1
                if (e == true) {
                    if (item == 'Fecha de Ingreso' || item == 'Fecha de vencimiento del contrato'
                     || item=='Fecha de nacimiento' && campo !='empleado_info') {
                        this.columns.push({
                            'label': item,
                            'field': campo,
                            'dataFormat': this.fechaFormat
                        })
                    } else if (campo == 'empleado_info') {
                        this.columns.push({
                            'label': item,
                            'field': campo,
                            'dataFormat': function (campo) {
                                if (campo != null) {
                                    if (isDate != '') {
                                        if(campo[nombre_tabla] != null){
                                        var fecha = new Date(campo[nombre_tabla])
                                        var fecha_c = fecha.setDate(fecha.getDate() + 1);

                                        return new Date(fecha_c)
                                        }
                                    } else {
                                        return campo[nombre_tabla];
                                    }

                                }
                            }

                        })

                    } else {
                        this.columns.push({
                            'label': item,
                            'field': campo
                        })
                    }
                } else {
                    this.columns.find(function (o, i) {
                        if (item === o.label) {
                            index = i

                        }

                    })
                    this.columns.splice(index, 1)
                }

            }



        },
        computed: {

            mbuscar: function () {

                return this.activos.filter((activo) => {
                    // this.pagina = 1
                    if (this.selectCO == null || this.selectCO == 'co' && this.cargos_filtro.length == 0) {
                        const nombre_completo = activo.c0541_nombres + ' ' + activo.c0541_apellido1 + ' ' +
                            activo.c0541_apellido2

                        return activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            nombre_completo.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())

                    } else if (this.cargos_filtro.length > 0 && this.selectCO != 'co') {
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return ((activo.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == activo
                                    .c0550_rowid_cargo) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (activo.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == activo
                                    .c0550_rowid_cargo) != '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (activo.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == activo
                                    .c0550_rowid_cargo) != '' &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        )

                    } else if (this.cargos_filtro.length > 0) {
                        const nombre_completo =
                            activo.c0541_nombres +
                            " " +
                            activo.c0541_apellido1 +
                            " " +
                            activo.c0541_apellido2;
                        return ((this.cargos_filtro.filter(a => a == activo
                                    .c0550_rowid_cargo) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (this.cargos_filtro.filter(a => a == activo
                                    .c0550_rowid_cargo) != '' &&
                                activo.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (this.cargos_filtro.filter(a => a == activo
                                    .c0550_rowid_cargo) != '' &&
                                activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        )

                    } else {
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
                    }
                })
            }

        }
    };

</script>
