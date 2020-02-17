<template>
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-folder-open"> Empleados</i></li>
                <li class="breadcrumb-item"><i class="fa fa-book"> Informacion Corporativa</i></li>
                
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
            <div class="col-md-6 mt-2 col-center has-feedback">
                <input type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>  
             <span v-if="mostrar == 1"><input class="select mt-2" v-model="numero" /></span>          
        </nav> 
        <div class="table-responsive-md table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    
                    <th scope="col" class="texto">Nombre</th>
                    <th scope="col" class="texto">C. O</th>
                    <th scope="col" class="texto">Cargo</th>                    
                    <th scope="col" class="texto">Email</th>
                    <th scope="col" class="texto">Telefono</th>
                    <th scope="col" class="texto">Celular</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in mbuscar" :key="indice" v-show="(pagina-1) * numero <= indice && pagina*numero > indice || bempleado != '' ">
                    <th scope="row">{{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
                        {{ item.c0541_apellido2 }}  </th>
             
                    <td>{{ item.f285_descripcion }}</td>
                    <td>{{ item.c0763_descripcion }}</td>
                    <td>{{ item.cz9_mail_corp}}</td>  
                    <td>{{ item.cz9_tel_corp}}</td>
                   
                    <td>  {{ item.cz9_cel_corp }}   
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
            
            <div v-show="carga  && activos.length == []" class="spinner-border text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
              <div v-show="carga == false  && activos.length == []">
               <p>No se encontraron resultados</p>
            </div>
        </center>
        
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
            selectCO: 'co',
            numero: 25,
            mostrar: 0,
            bempleado: '',
            pagina: 1,
            moment:moment,
            carga: true
        };
    },
    mounted() {
        axios.get("/api/registros/InfCorp").then(res => {
            this.activos = res.data;
            console.log(this.activos);
            this.getCO();
        });
         setTimeout(
                _ => this.carga = false, 
                10000 
            )

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
                this.pagina = 1        
                if(this.selectCO == null || this.selectCO == 'co'){
                    const nombre_completo =
                        activo.c0541_nombres +
                        " " +
                        activo.c0541_apellido1 +
                        " " +
                        activo.c0541_apellido2;
                    return (
                 activo.c0541_id.toUpperCase().includes(this.bempleado.toUpperCase())  
                ||
                nombre_completo.toUpperCase().includes(this.bempleado.toUpperCase())
                ||                        
                activo.c0763_descripcion.toUpperCase().includes(this.bempleado.toUpperCase())
                    )}else{
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
                                .includes(this.bempleado.toUpperCase())) ||
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
