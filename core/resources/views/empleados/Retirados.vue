<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-folder-open"> Empleados</i></li>
                <li class="breadcrumb-item"><i class="fa fa-users"> Retirados</i></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </nav>
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
                <select v-model="selectCO" class="form-control">
                    <option value="co">CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-6 col-center has-feedback mt-2">
                <input type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>
            <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>
        </nav>
        <div class="table-responsive-md table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Cedula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">C. O</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Fecha de Ingreso</th>
                        <th scope="col">Contrato hasta</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr  v-for="(item, indice) in mbuscar" :key="indice" v-show="
                        (pagina - 1) * numero <= indice &&
                            pagina * numero > indice || bempleado != ''
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
                            }"><li class="fa fa-search icon">

                                </li></router-link>
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

            <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</div>
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
                selectPag: 25,
                selectCO: 'co',
                numero: 25,
                mostrar: 0,
                bempleado: "",
                pagina: 1,
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

                    this.retirados = re;
                    console.log(this.retirados);
                    this.getCO();
                });
            } else {
                router.push('/');
            }

        },

        methods: {
            mostrarCaja: function () {
                if (this.selectPag == 0) {
                    this.mostrar = 1;
                } else {
                    this.mostrar = 0;
                    this.numero = this.selectPag;
                }
            },
            getCO: function () {
                axios.get("/api/getCO").then(res => {
                    this.CO = res.data;
                    console.log(this.CO);
                });
            }
        },
        computed: {
            mbuscar: function () {

                return this.retirados.filter(retirado => {
                    this.pagina = 1
                    if (this.selectCO == null || this.selectCO == 'co') {
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
