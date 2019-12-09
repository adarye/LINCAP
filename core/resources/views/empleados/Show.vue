<template>
  <div>
    <center>
      <h1>Informacion Personal</h1>
    </center>
    <form class="my-2">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Nombre</label>
          <input
            type="email"
            class="form-control"
            placeholder="Nombres"
            v-model="informacion.c0541_nombres"
            disabled
          />
        </div>
        <div class="form-group col-md-6">
          <label>Apellidos</label>
          <input
            type="text"
            class="form-control"
            placeholder="Apellidos"
            v-model="apellidos"
            disabled
          />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Cedula</label>
          <input
            type="text"
            class="form-control"
            placeholder="Cedula"
            v-model="informacion.c0541_id"
            disabled
          />
        </div>
        <div class="form-group col-md-6">
          <label>Celular</label>
          <input
            type="text"
            class="form-control"
            placeholder="Celular"
            v-model="informacion.f015_celular"
            :disabled="validated ? false : true"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Email</label>
          <input
            type="email"
            class="form-control"
            placeholder="Email"
            v-model="informacion.f015_email"
            :disabled="validated ? false : true"
          />
        </div>
        <div class="form-group col-md-6">
          <label>Telefono</label>
          <input
            type="text"
            class="form-control"
            placeholder="Numero de telefono"
            v-model="informacion.f015_telefono"
            :disabled="validated ? false : true"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Direccion</label>
          <input
            type="text"
            class="form-control"
            v-model="informacion.f015_direccion1"
            :disabled="validated ? false : true"
          />
        </div>
        <div class="form-group col-md-6">
          <label>Barrio</label>
          <input
            type="text"
            class="form-control"
            v-model="informacion.f015_id_barrio"
            :disabled="validated ? false : true"
          />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Selecciona tu ciudad:</label>
          <select
            class="form-control"
            :disabled="validated ? false : true"
            @change="cambioCiudad($event)"
          >
            <option>...</option>
            <option v-for="(item, indice) in ciudades" :key="indice" 
            v-bind:value="item.f013_id">
            {{ item.f013_descripcion }}</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label>Selecciona tu barrio:</label>
          <select class="form-control" :disabled="validated ? false : true" @change="cambioCiudad">
            <option value="1" data-foo="...">...</option>
            <option value="276" data-foo="FLORIDABLANCA">FLORIDABLANCA</option>
            <option value="307" data-foo="GIRON">GIRON</option>
            <option value="001" data-foo="BUCARAMANGA">BUCARAMANGA</option>
            <option value="547" data-foo="PIEDECUESTA">PIEDECUESTA</option>
          </select>
        </div>
      </div>
    </form>
    <div class="form-row">
      <span v-if="!validated">
        <div class="form-group col-md-6">
          <button @click="habilitarFormulario" class="btn btn-primary">Editar</button>
        </div>
      </span>
      <span v-else>
        <div class="form-group col-md-6">
          <button @click="actualizar" class="btn btn-primary">Actualizar</button>

          <button @click="desabilitarFormulario" class="btn btn-danger">Cancelar</button>
        </div>
      </span>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      ciudad_seleccionada: "",
      apellidos: "",
      informacion: {},
      validated: false,
      ubicacion: "",
      id_ciudad: 0,
      ciudades: []
    };
  },
  mounted() {
    axios.get("/api/empleado/show").then(res => {
      this.informacion = res.data[0];
      console.log(this.informacion);
      this.apellidos =
        this.informacion.c0541_apellido1 +
        " " +
        this.informacion.c0541_apellido2;
    });
    this.cargarCiudades();
  },
  methods: {
    habilitarFormulario() {
      this.validated = true;
    },
    desabilitarFormulario() {
      this.validated = false;
      console.log(this.ciudad_seleccionada);
    },
    actualizar() {
      const params = {
        email: this.informacion.f015_email,
        telefono: this.informacion.f015_telefono,
        celular: this.informacion.f015_celular,
        direccion: this.informacion.f015_direccion1,
        barrio: this.f015_id_barrio,
        ciudad: this.f015_id_barrio
      };
      console.log(params);
      console.log(this.informacion.c0540_rowid_tercero);
      axios
        .put(
          `/api/empleado/update/${this.informacion.c0540_rowid_tercero}`,
          params
        )
        .then(res => {
          console.log(res.data);
          this.validated = false;
          swal("Registro actualizado", "Datos Correctos", "success");
        });
    },
    cargarCiudades() {
      axios.get("/api/ciudad").then(res => {
        this.ciudades = res.data;
      });
    },
    cambioCiudad(event) {
          axios.get(`/api/barrios/${event.target.value}`)
          .then(res=>{
              console.log(res.data)
          })
      
    }
  },

  computed: {}
};
</script>
