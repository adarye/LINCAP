<template>
    <div>
        <form class="my-2">
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
                </form>
                </div>
</template>
<script>
export default {
    props:['empleado_info','validated_admin']
}
</script>