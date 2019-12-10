<template>
    <div>
        <h1>Datos del Contrato</h1>
        <div class="jumbotron">
            <h3 class="display-4">{{ usuario.f200_nombres }} {{ usuario.f200_apellido1 }} {{ usuario.f200_apellido2 }}</h3>
            <p class="lead">Fecha de Nacimiento: {{ moment(usuario.c0540_fecha_nacimiento, "YYYY-MM-DD").format("ll")}}</p>
             <p class="lead">Numero de Cedula: {{ usuario.f200_id }}</p>
            <p class="lead">Fecha de expedicion: {{  moment(usuario.c0540_fecha_exp_identif, "YYYY-MM-DD").format("ll") }}</p>
            <p class="lead">Pais de expedicion: {{ usuario.f011_descripcion }}</p>
            <p class="lead">Departamento de expedicion: {{ usuario.f012_descripcion }}</p>
            <p class="lead">Ciudad de expedicion: {{ usuario.f013_descripcion }}</p>
            <hr class="my-4">
            <p>Cargo: {{ usuario.c0763_descripcion }}</p>
            <p>Fecha de Ingreso: {{  moment(usuario.c0550_fecha_ingreso, "YYYY-MM-DD").format("ll")  }}</p>
            <p>Fecha de Finalizacion: {{ moment(usuario.c0550_fecha_contrato_hasta, "YYYY-MM-DD").format("ll") }}</p>
            <p>Lugar de trabajo: {{ usuario.f284_descripcion }}</p>
            <p>Tipo de Nomina: {{ usuario.c0504_descripcion }}</p>
            <p>Entidad Prestadora de Salud: {{ usuario.c0515_id }}</p>
            <p>Fondo de Pensiones: {{ usuario.c0516_id }}</p>
            <p>Agencia de Riesgos Laborales: {{ usuario.c0517_id }}</p>



            <a class="btn btn-primary btn-lg" href="#" role="button">Certificado Laboral</a>
        </div>
    </div>
</template>
<script>
  import moment from 'moment';
  moment.locale('es');
    export default {
      
        data() {
            return {
                usuario: '',
                moment: moment
            }
        },
        mounted() {
            axios.get('/api/empleado')
                .then(res => {
                    this.usuario = res.data
                    console.log(res.data)
                })
        }
    }

</script>
