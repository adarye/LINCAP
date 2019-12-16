<template>
    <div>
        <center>
            <h1>Listado de retirados</h1>
        </center>
        Buscar :
        <input type="text" v-model="bempleado" />
        Paginador :
        <select v-model="selectPag" @click.prevent="mostrarCaja()">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="0">Personalizado</option>
        </select>
        <select v-model="selectCO">
            <option value="TODOS" selected="true">TODOS</option> 
            <option
                v-for="(item, indice) in CO"
                :key="indice"
                v-bind:value="item.f285_id"
                >{{ item.f285_descripcion }}
            </option>
        </select>
        <span v-if="mostrar == 1">
            <input type="text" v-model="numero" />
        </span>
        <table class="table">
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
                <tr
                    v-for="(item, indice) in mbuscar"
                    :key="indice"
                    v-show="
                        (pagina - 1) * numero <= indice &&
                            pagina * numero > indice
                    "
                >
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
                        <router-link
                            :to="{
                                name: 'showEmpleado',
                                params: { id: item.c0550_rowid_tercero }
                            }"
                            >Ver</router-link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
        <a
            href="anterior"
            @click.prevent="pagina = pagina - 1"
            v-show="pagina != 1"
            >Anterior</a
        >
        <a
            href="siguiente"
            @click.prevent="pagina = pagina + 1"
            v-show="(pagina * numero) / mbuscar.length < 1"
            >Siguiente</a
        >
    </div>
</template>
<script>
import moment from "moment";
moment.locale("es");
export default {
    data() {
        return {
            CO: [],
            retirados: [],
            selectPag: 25,
            selectCO: null,
            numero: 25,
            mostrar: 0,
            bempleado: "",
            pagina: 1,
            moment: moment
        };
    },
    mounted() {
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
    },

    methods: {
        mostrarCaja: function() {
            if (this.selectPag == 0) {
                this.mostrar = 1;
            } else {
                this.mostrar = 0;
                this.numero = this.selectPag;
            }
        },
        getCO: function() {
            axios.get("/api/getCO").then(res => {
                this.CO = res.data;
                console.log(this.CO);
            });
        }
    },
    computed: {
        mbuscar: function() {
            return this.retirados.filter(retirado => {
                if (this.selectCO == null || this.selectCO == 'TODOS') {
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
