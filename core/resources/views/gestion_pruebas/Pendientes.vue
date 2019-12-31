<template>
<div>
    <div v-if="pruebas == '' " class="jumbotron shadow-lg p-3 mb-5 bg-white rounded"><h1>No tienes encuestas en este momento</h1></div>
<div v-for="(item, indice) in pruebas" :key="indice">
    <div class="jumbotron shadow-lg p-3 mb-5 bg-white rounded">
        <h1>{{ item.cz3_nombre }}</h1>
        <p class="lead">Fecha de Apertura: {{ item.cz3_fecha_apertura }} || Fecha de Cierre: {{ item.cz3_fecha_cierre }}</p>
          <p class="lead">Elaborado(a) por: {{ item.f200_nombres }} {{ item.f200_apellido1 }} {{ item.f200_apellido2 }}</p>
        <hr class="my-4">
        <p>{{ item.cz3_descripcion }}</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Presentar</a>
        </p>
    </div>
</div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                pruebas: []

            }

        },

        mounted() {
            axios.get(`/api/pruebas/pendientes/${this.$route.params.categoria}`)
                .then(res => {
                    this.pruebas = res.data
                })
        },
    }

</script>
