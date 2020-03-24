<template>
    <div>
        <vue-headful
            title=" Lincap | Información corporativa "
        />
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-folder-open"></i> Empleados</li>
                <li class="breadcrumb-item"><i class="fa fa-book"></i> Informacion Corporativa</li>
                
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

            <div class="col-md-4 col-center  mt-2 col-sm-2  has-feedback">
                <select @change="constantes(); pagina = 1" v-model="selectCO" class="form-control">
                    <option value="co">TODOS LOS CENTRO DE OPERACIÓN</option>
                    <option v-for="(item, indice) in CO" :key="indice" v-bind:value="item.f285_id">
                        {{ item.f285_descripcion }}</option>
                </select>
            </div>
            <div class="col-md-5 mt-2  mt-2 col-center has-feedback">
                <input v-on:keyup="constantes(); validarPagina();" type="text" v-model="bempleado" class="form-control" v-autofocus placeholder="Buscar" />
            </div>  
             <div class="col-md-1" v-if="mostrar == 1"><input v-on:keyup="constantes(); pagina = 1" class="form-control mt-2" v-model="numero" /></div>          
        </nav> 
        <div class="table-responsive-md table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="texto">Key</th>
                    <th scope="col" class="texto">Nombre</th>
                    <th scope="col" class="texto">C. O</th>
                    <th scope="col" class="texto">Cargo</th>                    
                    <th scope="col" class="texto">Email</th>
                    <th scope="col" class="texto">Teléfono</th>
                    <th scope="col" class="texto">Celular</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, indice) in mbuscar" :key="indice" v-show="(pagina-1) * numero <= indice && pagina*numero > indice">
                    <th>{{ item.cz9_id }}</th>
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
            selectPag: 10,
            selectCO: 'co',
            numero: 10,
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
            this.cache()
            this.validarPagina()
        });
         setTimeout(
                _ => this.carga = false, 
                10000 
            )

    },
    methods:{
         validarPagina(){
                if( Math.ceil(this.mbuscar.length / this.numero) < this.pagina){
                    console.log(Math.ceil(this.mbuscar.length / this.numero))
                    this.pagina =  1

                }
         },
         cache(){
                 if(localStorage.input_cor == undefined){
                          localStorage.setItem('input_cor', this.bempleado)
                     
                    } 
                    else{
                        this.bempleado = localStorage.input_cor;
                    }
                    if(localStorage.pagina_cor == undefined){
                        localStorage.setItem('pagina_cor', this.pagina)

                    }
                    else{
                          this.pagina = localStorage.pagina_cor;
                    }
                    
                    if(localStorage.pag_cor == undefined){
                        localStorage.setItem('pag_cor', this.selectPag)

                    }
                    else{
                          this.selectPag = localStorage.pag_cor;
                    }
                     if(localStorage.numero_cor == undefined){
                        localStorage.setItem('numero_cor', this.numero)

                    }
                    else{
                          this.numero = localStorage.numero_cor;
                    }
                    if(localStorage.selectCo_cor == undefined){
                        localStorage.setItem('selectCo_cor', this.selectCO)

                    }
                    else{
                          this.selectCO = localStorage.selectCo_cor;
                    }
            },
            constantes(){
                console.log('localStorage')
                localStorage.setItem('input_cor', this.bempleado)
                localStorage.setItem('pagina_cor', this.pagina)
                localStorage.setItem('selectCo_cor', this.selectCO)
                 localStorage.setItem('pag_cor', this.selectPag)
                  localStorage.setItem('numero_cor', this.numero)
            },
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
                // this.pagina = 1        
                if(this.selectCO == null || this.selectCO == 'co'){
                    const nombre_completo =
                        activo.c0541_nombres +
                        " " +
                        activo.c0541_apellido1 +
                        " " +
                        activo.c0541_apellido2;
                    return (String(activo.cz9_id).toUpperCase().includes(this.bempleado.toUpperCase()) ||
                
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
                            activo.c0763_descripcion
                                .toUpperCase()
                                .includes(this.bempleado.toUpperCase()))||
                                 (activo.f285_id.includes(this.selectCO) &&
                           String(activo.cz9_id).toUpperCase().includes(this.bempleado.toUpperCase()))
                    );
                }  
            })
        }
    }    
};
</script>
