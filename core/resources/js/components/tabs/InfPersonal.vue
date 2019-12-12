<template>
    <div>
        <form class="my-2">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="email" class="form-control" placeholder="Nombres" v-model="informacion.c0541_nombres"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos</label>
                    <input type="text" class="form-control" placeholder="Apellidos" v-model="apellidos" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cedula</label>
                    <input type="text" class="form-control" placeholder="Cedula" v-model="informacion.c0541_id"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Celular</label>
                    <input type="text" class="form-control" placeholder="Celular" v-model="informacion.f015_celular"
                        :disabled="validated ? false : true" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" class="form-control" placeholder="Cedula"
                        v-model="usuario.c0540_fecha_nacimiento" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de expedicion</label>
                    <input type="text" class="form-control" v-model="usuario.c0540_fecha_exp_identif" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Departamento de Expedicion</label>
                    <input type="text" class="form-control" placeholder="Cedula" v-model="usuario.f012_descripcion"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Ciudad de expedicion</label>
                    <input type="text" class="form-control" v-model="usuario.f013_descripcion" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Email" v-model="informacion.f015_email"
                        :disabled="validated ? false : true" />
                </div>
                <div class="form-group col-md-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" placeholder="Numero de telefono"
                        v-model="informacion.f015_telefono" :disabled="validated ? false : true" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Direccion</label>
                    <input type="text" class="form-control" v-model="informacion.f015_direccion1"
                        :disabled="validated ? false : true" />
                </div>
                <div class="form-group col-md-6">
                    <label>Barrio</label>
                    <input type="text" class="form-control" v-model="informacion.f015_id_barrio"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Selecciona tu ciudad:</label>
                    <select class="form-control" :disabled="validated ? false : true"  v-on:change="$emit('cargarBarrios', $event)">
                        <option>...</option>
                        <option v-for="(item, indice) in ciudades" :key="indice" v-bind:value="item.f013_id">
                            {{ item.f013_descripcion }}</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Selecciona tu barrio:</label>
                    <select class="form-control" :disabled="validated ? false : true" @change="$emit('cambiarBarrio', $event)">
                        <option>...</option>
                        <option v-for="(item, indice) in barrios" :key="indice" v-bind:value="item.f014_id">
                            {{ item.f014_descripcion }}</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre de un familiar en Linco</label>
                    <input type="text" class="form-control" placeholder="opcional"
                        :disabled="validated ? false : true" v-model="empleado_info.cz9_nombre_familiar"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Nombre de un familiar</label>
                    <input type="text" class="form-control" v-model="empleado_info.cz9_nombre_contacto" :disabled="validated ? false : true" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Numero de telefono del familiar</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_tel_contacto" />
                </div>
                <div class="form-group col-md-6">
                    <label>Sexo</label>
                    <input type="text" class="form-control" disabled v-model="sexo" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Talla del uniforme</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_talla_uniforme" />
                </div>
                <div class="form-group col-md-6">
                    <label>Talla de calzado</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_talla_calzado" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Finalizacion del periodo de prueba</label>
                    <input type="text" class="form-control" :disabled="permiso_admin ? false : true"  v-model="empleado_info.cz9_fecha_tpprueba"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Reentrenamiento</label>
                    <input type="text" class="form-control" :disabled="permiso_admin ? false : true" v-model="empleado_info.cz9_reentrenamiento" />
                </div>
            </div>
        </form>
        
    </div>
</template>
<script>
    export default {
        props: ['informacion', 'usuario', 'apellidos', 'ciudades', 'barrios', 'validated', 'empleado_info','sexo', 'permiso_admin'],

        data() {
        return {
       

        }
    }
    }
    

</script>
