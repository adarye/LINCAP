<template>
    <div>
        <center>
            <h1>Informacion Corporativa</h1>
        </center>
        Buscar : <input type="text" v-model="bempleado" /> 
        Paginador :
        <select v-model="selectPag" @click.prevent="mostrarCaja()">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="0">Personalizado</option>
        </select>
        <select v-model="selectCO">            
            <option v-for="(item, indice) in CO" :key = "indice" v-bind:value="item.f285_id">{{ item.f285_descripcion }}</option>
        </select>
        <span v-if="mostrar == 1"><input type="text" v-model="numero"/></span> 
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Cedula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">C. O</th>
                    <th scope="col">Cargo</th>                    
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
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
                    <td>{{ item.f285_descripcion }}</td>
                    <td>{{ item.c0763_descripcion }}</td>
                    <td>{{ item.cz9_mail_corp}}</td>  
                    <td>{{ item.cz9_tel_corp}}</td>
                   
                    <td>
                        <router-link
                            :to="{
                                name: 'showEmpleado',
                                params: { id: item.c0550_rowid_tercero }
                            }"
                        >
                            Ver
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
import moment from 'moment';
    moment.locale('es');
export default {
    
    data() {
        return {
            CO: [],
            activos: [],
            selectPag: 25,
            selectCO: null,
            numero: 25,
            mostrar: 0,
            bempleado: '',
            pagina: 1,
            moment:moment
        };
    },
    mounted() {
        axios.get("/api/registros/InfCorp").then(res => {
            this.activos = res.data;
            console.log(this.activos);
            this.getCO();
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
        },
        getCO: function(){
            axios.get("/api/getCO").then(res => {
            this.CO = res.data;
            console.log(this.CO);
        });
        }
    },    
    computed: {
        mbuscar: function(){
            return this.activos.filter((activo) => {         
                if(this.selectCO == null){
                return activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase())  
                ||
                activo.c0541_nombres.toUpperCase().includes(this.bempleado.toUpperCase())
                ||                
                activo.c0541_apellido1.toUpperCase().includes(this.bempleado.toUpperCase())
                ||
                activo.c0541_apellido2.toUpperCase().includes(this.bempleado.toUpperCase())                
                ||          
                activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())
                }else{
                return activo.f285_id.includes(this.selectCO)
                &&
                activo.c0541_nombres.toUpperCase().includes(this.bempleado.toUpperCase())  
                ||
                 activo.f285_id.includes(this.selectCO)
                &&
                activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase())
                ||
                activo.f285_id.includes(this.selectCO)
                &&
                activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())
                }  
            })
        }
    }    
};
</script>
