<template>
    <div>
        <nav class="navbar navbar-light bg-light my-2">
            <div class="col-md-2 col-center col-sm-2  has-feedback">
                <button class="btn btn-primary" @click="guardar">Guardar</button>
            </div>
            <div class="col-md-4 col-center col-sm-2  has-feedback">
                <select v-model="selectCO" class="form-control">
                    <option value="co">CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-6 col-center has-feedback">
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
                        <td>
                            <span v-if="seleccionados.filter(c0550_rowid_tercero => c0550_rowid_tercero == item.c0550_rowid_tercero ) != ''">
                                <button @click="excluir(item.c0550_rowid_tercero)">
                                    <li class="fa fa-check-square-o">
                                    </li>
                                </button>
                            </span>
                            <span v-else><button @click="incluir(item.c0550_rowid_tercero)">
                                    <li class="fa fa-square-o">
                                    </li>
                                </button></span>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-4 col-float"></div>
            <!-- <div v-show="bempleado == ''" class="col-md-4 col-center"> -->
            <button type="button" @click.prevent="pagina=pagina-1" v-show="pagina!=1" class="btn btn-primary">
                <li class="fa fa-long-arrow-left"></li>
            </button>
            <button type="button" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(mbuscar.length) < 1"
                class="btn btn-success">
                <li class="fa fa-long-arrow-right"></li>
            </button>
            <!-- </div> -->

            <!-- <div class="pull-right mt-2">Página {{ pagina }} / {{ Math.ceil(mbuscar.length / numero) }} de
                {{ mbuscar.length }} Registros</div> -->
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    moment.locale('es');
    export default {
        props: ['id_prueba'],

        data() {
            return {
                seleccionados: [],
                seleccionados2:[],
                CO: [],
                activos: [],
                selectPag: 4,
                selectCO: 'co',
                numero: 4,
                mostrar: 0,
                bempleado: '',
                pagina: 1,
                moment: moment
            };
        },
        beforeMount() {
            this.getCO();
            this.traerRelacion()
            axios.get("/api/registros").then(res => {
                this.activos = res.data;         
            });
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
            traerRelacion(){
                axios.get(`/api/asignacion/index/${this.id_prueba}`).then(res => {
                     for (var i = 0; i<res.data.length; i++) {
                    this.seleccionados.push(res.data[i].cz4_ts_id)       
                    }
                      
            });
            },
            getCO: function () {
                axios.get("/api/getCO").then(res => {
                    this.CO = res.data;
                    
                });
            },
            incluir(c0550_rowid_tercero) {
                this.seleccionados.push(c0550_rowid_tercero)
                 this.seleccionados2.push(c0550_rowid_tercero)
                console.log( this.seleccionados)
            },
            excluir(item) {
                //  console.log(this.seleccionados[0] + 'dff' + item)
                for (var i = 0; i<this.seleccionados.length; i++) {
                    if (this.seleccionados[i] === item){
                    this.seleccionados.splice(i, 1);
                    }
                }
            },
            guardar() {
                axios.post("/api/asignacion/guardar",{seleccionados: this.seleccionados2, id_prueba:this.id_prueba})
                .then(res => {
                    swal('Guardado', 'Las asignaciones se han guardado', 'success')
                    console.log(res.data)
                });

            }


        },
        computed: {

            mbuscar: function () {
                return this.activos.filter((activo) => {
                    if (this.selectCO == null || this.selectCO == 'co') {
                        const nombre_completo = activo.c0541_nombres + ' ' + activo.c0541_apellido1 + ' ' +
                            activo.c0541_apellido2

                        return activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            nombre_completo.toUpperCase().includes(this.bempleado.toUpperCase()) ||
                            activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())

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
