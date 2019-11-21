<template>
    <div>
        <center>
            <h1>Listado de empleados</h1>
        </center>
        Buscar : <input type="text" v-model="bempleado" /> 
        Paginador :
        <select v-model="selectPag" @click.prevent="mostrarCaja">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="0">Personalizado</option>
        </select>
        <span v-if="mostrar == 1"><input type="text" v-model="numero"/></span> 
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Fecha de Ingreso</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in mbuscar" :key="indice" v-show="(pagina-1) * numero <= indice && pagina*numero > indice">
                    <th scope="row">{{ item.c0541_id }}</th>
                    <td>
                        {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                        {{ item.c0541_apellido2 }}
                    </td>
                    <td>{{ item.c0550_fecha_ingreso }}</td>
                    <td>{{ item.c0763_descripcion }}</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'Show',
                                params: { id: item.c0541_id }
                            }"
                        >
                            <i class="material-icons">
                                edit
                            </i>
                        </router-link>
                        <router-link to="/mostrar">
                            <i class="material-icons">
                                search
                            </i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="anterior" @click.prevent="pagina=pagina-1" v-show="pagina!=1">Anterior</a>
		<a href="siguiente" @click.prevent="pagina=pagina+1" v-show="(pagina*numero)/(mbuscar.length) < 1">Siguiente</a>
    </div>
</template>
<script>
export default {
    data() {
        return {
            registros: [],
            msg: "hola",
            selectPag: 25,
            numero: 25,
            mostrar: 0,
            bempleado: '',
            pagina: 1

        };
    },
    mounted() {
        axios.get("/api/registros").then(res => {
            this.registros = res.data;
            console.log(this.registros);
        });
    },
    methods:{
        mostrarCaja: function() {
			if(this.selectPag == 0) {
				this.mostrar = 1
			} else {
				this.mostrar = 0
				this.numero = this.selectPag
			}
		}
    },    
    computed: {
        mbuscar: function(){
            return this.registros.filter((registro) => {
                return registro.c0541_nombres.toUpperCase().includes(this.bempleado.toUpperCase())
                ||                
                registro.c0541_apellido1.toUpperCase().includes(this.bempleado.toUpperCase())
                ||
                registro.c0541_apellido2.toUpperCase().includes(this.bempleado.toUpperCase())
                ||
                registro.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase())                
            })
        }
    }    
};
</script>
