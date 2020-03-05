<template>
    <div>
        <form class="my-2">
            <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tipo de sangres</label>
                            <input type="text" class="form-control" disabled v-model="tipo_sangre"  />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Archivo de titulación de carné de vacunación <a v-show="empleado_info.cz9_archivo_titulacion != '' && empleado_info.cz9_archivo_titulacion != null  "
                                            :href="'/../theme/files/sst/'+ empleado_info.cz9_archivo_titulacion" target="_blank">|| 
                                               click para descargar
                                        </a></label>
                            <input type="file" class="form-control" :disabled="validated_admin ? false : true"   v-on:change="$emit('getFileTitulacion', $event)"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna HB</label>
                            <input type="date" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_fecha_vacuna" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de la vacuna HB</label>
                            <input type="text" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_lugar_vacuna" v-uppercase   v-max-length="55" />
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna tifoidea </label>
                            <input type="date" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_fecha_vacuna_tifoidea" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de la vacuna tifoidea</label>
                            <input type="text" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_lugar_vacuna_tifoidea" v-uppercase   v-max-length="55" />
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna toxoide </label>
                            <input type="date" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_fecha_vacuna_toxoide"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de la vacuna toxoide</label>
                            <input type="text" class="form-control" :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_lugar_vacuna_toxoide" v-uppercase   v-max-length="55"/>
                        </div>
                    </div>
                    <div class="form-row">                      
                        <div class="form-group col-md-6">
                            <label>Fecha de vencimiento del carné de vacunación</label>
                            <input v-model="empleado_info.cz9_fv_carne_vacunacion" type="date" class="form-control" :disabled="validated_admin ? false : true" v-uppercase   v-max-length="55"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Archivo escaneado 
                                del carné de vacunación <a v-show="empleado_info.cz9_archivo_vacunacion != '' && empleado_info.cz9_archivo_vacunacion != null  "
                                            :href="'/../theme/files/sst/'+ empleado_info.cz9_archivo_vacunacion" target="_blank">|| 
                                               click para descargar
                                        </a></label>
                            <input type="file" class="form-control" :disabled="validated ? false : true"  v-on:change="$emit('getFileVacunacion', $event)"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de vencimiento del carné de alimentos</label>
                            <input v-model="empleado_info.cz9_fv_carne_alimentos" type="date" class="form-control" :disabled="validated_admin ? false : true" v-uppercase   v-max-length="55"/>
                        </div>
                    </div>
                </form>
                </div>
</template>
<script>
export default {
    props:['empleado_info','validated_admin', 'tipo_sangre', 'validated','rol'],
    data(){
        return {
         
        }

    },
    methods: {
        mounted(){
            
        }

    },
}
</script>