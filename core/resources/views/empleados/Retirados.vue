<template>
    <div>
        <vue-headful title=" Lincap | Empleados retirados " />

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
                                    @click="incluir(item.c0763_rowid, $event.target.checked); pagina = 1; ">
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
         <modal name="campos" :clickToClose="false" :adaptive="true" :width="250" :height="400">


            <Excel v-on:filtrar="filtrar"></Excel>

            <div class="col-md-12  col-sm-8 form-group has-feedback">
                <vue-excel-xlsx :sheetname="'Empleados retirados'" class="btn btn-sm btn-info mt-3" :data="mbuscar"
                    :columns="columns" :filename="moment().format('L') + '-retirados.xls' " title="Exportar">
                    <i class="fa fa-print"></i>
                </vue-excel-xlsx>

                <button type="button" title="Cerrar" class="btn btn-sm btn-danger mt-3"
                    @click="columns = []; $modal.hide('campos'); ">
                    <i class="fa fa-close"></i>
                </button>
            </div>

        </modal>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-folder-open"></i> Empleados</li>
                <li class="breadcrumb-item"><i class="fa fa-users"></i> Retirados</li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
        <nav class="navbar navbar-light bg-light my-2">

            <div class=" pull-right">
               <b> Ver</b>
            </div>
            <div class="col-md-1  mt-2">
                <input v-numeric-only v-on:keyup="constantes(); validarPagina();" class="form-control mt-2" v-model="numero" />
            </div>
            <div class=" pull-left">
                <b>Registro(s)</b>
            </div>

            <div class="col-md-4  mt-2 col-center col-sm-2  has-feedback">
                <select @change="constantes(); pagina = 1;" v-model="selectCO" class="form-control">
                    <option value="co">TODOS LOS CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-3  mt-2 col-center ">
                <input v-on:keyup="constantes(); validarPagina();" type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <div class="col-md-2  mt-2">
                <button title="Exportar" type="button" class=" btn btn-success" @click="$modal.show('campos')">
                    <i class="fa fa-file-excel-o"></i>
                </button>
                <button class="btn btn-primary" @click="$modal.show('cargos')" title="Filtrar por cargos">
                    <i class="fa fa-filter"></i>
                </button>
            </div>
            <div class="col-md-1" v-show="mostrar == 1"><input  v-on:keyup="constantes(); pagina = 1" class="form-control mt-2" v-model="numero" /></div>
        </nav>
        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">C. O</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Fecha de Ingreso</th>
                        <th scope="col">Contrato hasta</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, indice) in mbuscar" :key="indice" v-show="
                        (pagina - 1) * numero <= indice &&
                            pagina * numero > indice
                    ">
                        <th scope="row">{{ item.c0541_id }}</th>
                        <td>
                            {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                            {{ item.c0541_apellido2 }}
                        </td>
                        <td>{{ item.f285_descripcion }}</td>
                        <td>{{ item.c0763_descripcion }}</td>
                        <td>{{ moment(item.c0550_fecha_ingreso).format("L") }}</td>
                        <td v-if="item.c0550_fecha_contrato_hasta != null">
                            {{
                            moment(item.c0550_fecha_contrato_hasta).format("L")
                        }}
                        </td>
                        <td v-else>No definida</td>
                        <td>
                            <router-link :to="{
                                name: 'showEmpleado',
                                params: { id: item.c0550_rowid_tercero, ruta: 'Retirados' }
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
            <div  class="col-md-4 col-center">
                <button type="button" @click.prevent="pagina = Number(pagina) - 1; constantes()" :disabled="pagina == 1" class="btn btn-primary">
                    <li class="fa fa-long-arrow-left"></li>
                </button>
                <button type="button" @click.prevent="pagina = Number(pagina) + 1; constantes()" :disabled="(pagina * numero) / mbuscar.length >= 1"
                    class="btn btn-success">
                    <li class="fa fa-long-arrow-right"></li>
                </button>
            </div>

            <div class="pull-right mt-2"><b>Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</b></div>
        </div>
        <center>
            <div v-show="retirados.length == 0" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </center>
    </div>
</template>
<script>
    import moment from "moment";
    moment.locale("es");
    import router from '../../js/router';


    export default {
        data() {
            return {
                CO: [],
                retirados: [],
                selectPag: 10,
                selectCO: 'co',
                numero: 10,
                mostrar: 0,
                bempleado: "",
                pagina: 1,
                cargos: [],
                cargos_filtro: [],
                columns: [],
                moment: moment
            }
        },

        beforeMount() {
            if (window.user.rol == 1 || window.user.rol == 2 || window.user.rol == 3) {
                axios.get("/api/registros/retirados").then(res => {
                    console.log(res.data);
                    const x = res.data[0];
                    const y = res.data[1];

                    const re = y.filter(o => !x.find(o2 => o.c0541_id === o2.c0541_id));
                    console.log(re);

                    // const h = res.data;
                    this.retirados = re;
                    console.log(this.retirados);
                    this.getCO();
                    this.buscarCargos();
                    this.cache()
                    this.validarPagina()
                });
            } else {
                router.push('/');
            }

        },

        methods: {
            validarPagina(){
                if( Math.ceil(this.mbuscar.length / this.numero) < this.pagina){
                    console.log(Math.ceil(this.mbuscar.length / this.numero))
                    this.pagina =  1

                }
            },
             cache(){
                 if(localStorage.input_ret == undefined){
                          localStorage.setItem('input_ret', this.bempleado)
                     
                    } 
                    else{
                        this.bempleado = localStorage.input_ret;
                    }

                    if(localStorage.pagina_ret == undefined){
                       
                        localStorage.setItem('pagina_ret', this.pagina)

                    }
                    else{
                        
                         this.pagina = localStorage.pagina_ret
                     }

                     if(localStorage.selectCo_ret == undefined){
                        localStorage.setItem('selectCo_ret', this.selectCO)

                    }
                    else{
                          this.selectCO = localStorage.selectCo_ret;
                    }
                    if(localStorage.pag_ret == undefined){
                        localStorage.setItem('pag_ret', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_ret;
                    }
                     if(localStorage.numero_ret == undefined){
                        localStorage.setItem('numero_ret', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_ret;
                    }
                     

                     if(localStorage.cargos_ret == undefined){
                        localStorage.setItem('cargos_ret', this.cargos_filtro)

                    }
                    else{
                          if(localStorage.getItem("cargos_ret") != ""){
                         this.cargos_filtro = JSON.parse(localStorage.getItem("cargos_ret"));
                    }
                    }
            },
            constantes(){

                localStorage.setItem('input_ret', this.bempleado)
                localStorage.setItem('pagina_ret', this.pagina)
                localStorage.setItem('selectCo_ret', this.selectCO)
                 localStorage.setItem('pag_ret', this.selectPag)
                  localStorage.setItem('numero_ret', this.numero)
                    localStorage.setItem('cargos_ret', JSON.stringify( this.cargos_filtro))
            },
             fechaFormat(value) {
                // return  moment(value).format('YYYY') 

                if (value != null) {
                    var fechai = new Date(value)
                    var h = fechai.setDate(fechai.getDate() + 1);

                    console.log(new Date(h))
                    return new Date(h)
                } else {
                    return "Indefinida"
                }

            },
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1;
                } else {
                    this.mostrar = 0;
                    this.numero = this.selectPag;
                }
            },
            buscarCargos() {
                axios.get('/api/estadistica/cargar/cargos')
                    .then(res => {
                        this.cargos = res.data

                    })

            },
            getCO: function () {
                axios.get("/api/getCO").then(res => {
                    this.CO = res.data;
                    console.log(this.CO);
                });
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
                console.log(this.cargos_filtro)
            },
            
            filtrar(item, e, campo, nombre_tabla, isDate) {
                var index = -1
                if (e == true) {
                    if (item == 'Fecha de Ingreso' || item == 'Fecha de vencimiento del contrato' || item == 'Fecha de nacimiento' && campo !=
                        'empleado_info') {
                        console.log('entro')
                        this.columns.push({
                            'label': item,
                            'field': campo,
                            'dataFormat': this.fechaFormat
                        })
                    } else if (campo == 'empleado_info') {
                        console.log('entre2')
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
                                        console.log(campo[nombre_tabla])
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

                return this.retirados.filter(retirado => {
                    // this.pagina = 1
                    if (this.selectCO == null || this.selectCO == 'co' && this.cargos_filtro.length == 0) {
                        const nombre_completo =
                            retirado.c0541_nombres +
                            " " +
                            retirado.c0541_apellido1 +
                            " " +
                            retirado.c0541_apellido2;
                        return (
                            retirado.c0541_id
                            .toUpperCase()
                            .includes(this.bempleado.toUpperCase()) ||
                            nombre_completo
                            .toUpperCase()
                            .includes(this.bempleado.toUpperCase()) ||
                            retirado.c0763_descripcion
                            .toUpperCase()
                            .includes(this.bempleado.toUpperCase())
                        );
                    } else if (this.cargos_filtro.length > 0 && this.selectCO != 'co') {
                      
                        const nombre_completo =
                            retirado.c0541_nombres +
                            " " +
                            retirado.c0541_apellido1 +
                            " " +
                            retirado.c0541_apellido2;
                        return ((retirado.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == retirado.c0550_rowid_cargo) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (retirado.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == retirado.c0550_rowid_cargo) != '' &&
                                retirado.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (retirado.f285_id.includes(this.selectCO) && this.cargos_filtro.filter(a =>
                                    a == retirado.c0550_rowid_cargo) != '' &&
                                retirado.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        )

                    } else if (this.cargos_filtro.length > 0) {
                        const nombre_completo =
                            retirado.c0541_nombres +
                            " " +
                            retirado.c0541_apellido1 +
                            " " +
                            retirado.c0541_apellido2;
                        return ((this.cargos_filtro.filter(a => a == retirado
                                    .c0550_rowid_cargo) != '' &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (this.cargos_filtro.filter(a => a == retirado
                                    .c0550_rowid_cargo) != '' &&
                                retirado.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (this.cargos_filtro.filter(a => a == retirado
                                    .c0550_rowid_cargo) != '' &&
                                retirado.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        )

                    } else {
                        const nombre_completo =
                            retirado.c0541_nombres +
                            " " +
                            retirado.c0541_apellido1 +
                            " " +
                            retirado.c0541_apellido2;
                        return (
                            (retirado.f285_id.includes(this.selectCO) &&
                                nombre_completo
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (retirado.f285_id.includes(this.selectCO) &&
                                retirado.c0541_id
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase())) ||
                            (retirado.f285_id.includes(this.selectCO) &&
                                retirado.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))
                        );
                    }
                });
            }
        }
    };

</script>
