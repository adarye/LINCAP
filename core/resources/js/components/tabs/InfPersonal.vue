<template>
    <div>
        <form enctype="multipart/form-data" class="my-2">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" class="form-control"  v-model="informacion.c0541_nombres"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Apellidos</label>
                    <input type="text" class="form-control"  v-model="apellidos" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cédula</label>
                    <input type="text" class="form-control" v-model="informacion.c0541_id"
                        disabled />
                </div>

                <div class="form-group col-md-6">
                    <label>Fecha de Expedición</label>
                    <input  type="text" class="form-control"
                        v-model="usuario.c0540_fecha_exp_identif" disabled />
                </div>


            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Departamento de Expedición</label>
                    <input type="text" class="form-control" 
                        v-model="usuario.f012_descripcion" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Ciudad de Expedición</label>
                    <input type="text" class="form-control" 
                        v-model="usuario.f013_descripcion" disabled />
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label>Fecha de Nacimiento</label>
                    <input type="text" class="form-control" 
                        v-model="usuario.c0540_fecha_nacimiento" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>País de Nacimiento</label>
                    <input type="text" class="form-control"  disabled v-model="informacion.f011_descripcion"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Departamento de Nacimiento</label>
                    <input type="text" class="form-control"  disabled
                        v-uppercase-only v-max-length="55" v-model="informacion.f012_descripcion" />
                </div>
                <div class="form-group col-md-6">
                    <label>Ciudad de Nacimiento</label>
                    <input type="text" class="form-control"  disabled v-uppercase-only
                        v-numeric-only v-max-length="16" v-model="informacion.f013_descripcion" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Edad</label>
                    <input :value="moment().diff(informacion.c0540_fecha_nacimiento, 'years')" type="text" class="form-control"  disabled v-uppercase-only v-max-length="55" />
                </div>
                <div class="form-group col-md-6">
                    <label>Estrato</label>
                    <input v-model="empleado_info.c0780_descripcion" type="text" class="form-control" disabled v-uppercase-only v-numeric-only
                        v-max-length="16" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nivel de Escolaridad</label>
                    <input type="text" class="form-control" v-model="informacion.c0702_descripcion"  disabled v-uppercase-only
                        v-max-length="55" />
                </div>
                <div class="form-group col-md-6">
                    <label>Tipo de Vivienda</label>
                    <select v-model="empleado_info.cz9_id_vivienda" class="form-control" :disabled="validated ? false : true">
                        <option :value="item.c0706_rowid" v-for="(item, indice) in viviendas" :key="indice">{{item.c0706_descripcion}}</option>
                        
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Estado Civil</label>
                    <input type="text" class="form-control" v-model="estado_civil"  disabled v-uppercase-only
                        v-max-length="55" />
                </div>
                <div class="form-group col-md-6">
                    <label>Celular</label>
                    <input type="text" class="form-control"  v-model="informacion.f015_celular"
                        :disabled="validated ? false : true" v-numeric-only v-max-length="16" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control"  v-model="informacion.f015_email"
                        :disabled="validated ? false : true" v-uppercase-only v-max-length="55" />
                </div>
                <div class="form-group col-md-6">
                    <label>Teléfono</label>
                    <input type="text" class="form-control" 
                        v-model="informacion.f015_telefono" :disabled="validated ? false : true" v-uppercase-only
                        v-numeric-only v-max-length="16" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Dirección</label>
                    <input type="text" class="form-control" v-model="informacion.f015_direccion1"
                        :disabled="validated ? false : true" v-uppercase-only v-max-length="55"  />
                </div>
                <div class="form-group col-md-6">
                    <label>Barrio</label>
                    <input type="text" class="form-control" v-model="informacion.f015_id_barrio" disabled v-uppercase-only
                        v-alphabetic-only />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Ciudad</label>
                    <select class="form-control" :disabled="validated ? false : true"
                        v-on:change="$emit('cargarBarrios', $event)">
                        <option>...</option>
                        <option v-for="(item, indice) in ciudades" :key="indice" v-bind:value="item.f013_id">
                            {{ item.f013_descripcion }}</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Barrio</label>
                    <select class="form-control" :disabled="validated ? false : true"
                        @change="$emit('cambiarBarrio', $event)">
                        <option>...</option>
                        <option v-for="(item, indice) in barrios" :key="indice" v-bind:value="item.f014_id">
                            {{ item.f014_descripcion }}</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre de un Familiar en Linco</label>
                    <input type="text" class="form-control" placeholder="opcional" :disabled="validated ? false : true"
                        v-model="empleado_info.cz9_nombre_familiar" v-max-length="75" v-uppercase-only />
                </div>
                <div class="form-group col-md-6">
                    <label>Nombre de un Familiar en caso de Emergencia</label>
                    <input type="text" class="form-control" v-model="empleado_info.cz9_nombre_contacto"
                        :disabled="validated ? false : true" v-max-length="55" v-uppercase-only />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label v-if="!empleado_info.cz9_nombre_contacto"> Numero de Teléfono del Familiar en caso de Emergencia</label>
                    <label v-if="empleado_info.cz9_nombre_contacto"> Numero de Teléfono de
                        {{ empleado_info.cz9_nombre_contacto.toUpperCase() }}</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true"
                        v-model="empleado_info.cz9_tel_contacto" v-max-length="25" v-numeric-only />
                </div>
                <div class="form-group col-md-6">
                    <label>Genero</label>
                    <input type="text" class="form-control" disabled v-model="sexo" v-uppercase-only />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Talla de Uniforme</label>
                    <input type="text" class="form-control" :disabled="validated_admin ? false : true"
                        v-model="empleado_info.cz9_talla_uniforme" v-max-length="6" v-uppercase-only required />
                </div>
                <div class="form-group col-md-6">
                    <label>Talla de Calzado</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true"
                        v-model="empleado_info.cz9_talla_calzado" v-max-length="2" v-uppercase-only v-numeric-only />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Terminación del Periodo de Prueba</label>
                    <input type="date" class="form-control" :disabled="validated_admin ? false : true"
                        v-model="empleado_info.cz9_fecha_tpprueba" />
                </div>
                <div class="form-group col-md-6">
                    <label>Re-entrenamiento</label>
                    <textarea rows="4" cols="50" type="text" class="form-control"
                        :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_reentrenamiento"
                        v-uppercase-only v-max-length="200">
                    </textarea>

                </div>
            </div>


        </form>

    </div>
</template>
<script>
import moment from "moment";
    moment.locale("es");
    export default {
        props: ['informacion', 'usuario', 'apellidos', 'ciudades', 'barrios', 'validated', 'empleado_info', 'sexo',
            'validated_admin', 'getImage', 'estado_civil', 'viviendas', 'vivienda'
        ],

        data() {
            return {
                 moment: moment


            }
        }
    }

</script>
