<template>
    <div>
        <form enctype="multipart/form-data" class="my-2">
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
                        :disabled="validated ? false : true" v-numeric-only  v-max-length="16"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" class="form-control" placeholder="Fecha de Nacimiento"
                        v-model="usuario.c0540_fecha_nacimiento" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de expedicion</label>
                    <input placeholder="Fecha de expedicion" type="text" class="form-control" v-model="usuario.c0540_fecha_exp_identif" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Departamento de Expedicion</label>
                    <input type="text" class="form-control" placeholder="Departamento de Expedicion" v-model="usuario.f012_descripcion"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Ciudad de expedicion</label>
                    <input type="text" class="form-control" placeholder="Ciudad de expedicion" v-model="usuario.f013_descripcion" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Email" v-model="informacion.f015_email"
                        :disabled="validated ? false : true" v-uppercase v-max-length="55"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Telefono</label>
                    <input type="text" class="form-control" placeholder="Numero de telefono"
                        v-model="informacion.f015_telefono" :disabled="validated ? false : true" v-uppercase v-numeric-only v-max-length="16" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Direccion</label>
                    <input type="text" class="form-control" v-model="informacion.f015_direccion1"
                        :disabled="validated ? false : true" v-uppercase v-max-length="55"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Barrio</label>
                    <input type="text" class="form-control" v-model="informacion.f015_id_barrio"
                        disabled v-uppercase v-alphabetic-only  />
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
                        :disabled="validated ? false : true" v-model="empleado_info.cz9_nombre_familiar" v-max-length="75"   v-uppercase/>
                </div>
                <div class="form-group col-md-6">
                    <label>Nombre de un familiar</label>
                    <input type="text" class="form-control" v-model="empleado_info.cz9_nombre_contacto" :disabled="validated ? false : true" v-max-length="55" v-uppercase/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                       <label  v-if="!empleado_info.cz9_nombre_contacto"> Numero de telefono  de</label>
                    <label  v-if="empleado_info.cz9_nombre_contacto"> Numero de telefono  de {{ empleado_info.cz9_nombre_contacto.toUpperCase() }}</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_tel_contacto" v-max-length="25" v-numeric-only/>
                </div>
                <div class="form-group col-md-6">
                    <label>Sexo</label>
                    <input type="text" class="form-control" disabled v-model="sexo" v-uppercase />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Talla del uniforme</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_talla_uniforme" v-max-length="2" v-uppercase required/>
                </div>
                <div class="form-group col-md-6">
                    <label>Talla de calzado</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_talla_calzado" v-max-length="2" v-uppercase v-numeric-only/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Finalizacion del periodo de prueba</label>
                    <input type="date" class="form-control" :disabled="validated_admin ? false : true"  v-model="empleado_info.cz9_fecha_tpprueba"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Reentrenamiento</label>
                    <textarea rows="4" cols="50" type="text" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_reentrenamiento" v-uppercase v-max-length="200">
                    </textarea>
                   
                </div>
            </div>
            
            
        </form>
        
    </div>
</template>
<script>
    export default {
        props: ['informacion', 'usuario', 'apellidos', 'ciudades', 'barrios', 'validated', 'empleado_info','sexo', 'validated_admin', 'getImage'],

        data() {
        return {
       

        }
    }
    }
    

</script>
