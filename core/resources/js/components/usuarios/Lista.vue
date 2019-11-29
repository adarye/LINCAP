<template>
    <div>
        <span class="badge badge-primary float-right">
            {{ item.cz1_cc }}
        </span>
        <p class="lead">
            {{ item.c0541_nombres }} {{ item.c0541_apellido1 }}
            {{ item.c0541_apellido2 }}
        </p>
        <p>{{ item.cz2_nombre }}</p>
        <h1>{{ item.cz1_estado }}</h1>

        
            <button class="btn btn-warning btn-sm" v-on:click="$emit('editar')">
                Editar
            </button>
            <button
                class="btn btn-danger btn-sm"
                v-on:click="$emit('eliminar')"
            >
                Eliminar
            </button>
        
    </div>
</template>
<script>
export default {
    props: ["item"]
};
</script>
