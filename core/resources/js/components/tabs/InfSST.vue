<template>
    <div>
        <form class="my-2">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna</label>
                            <input type="email" class="form-control" disabled v-model="empleado_info.cz9_fecha_vacuna" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de las vacuna</label>
                            <input type="text" class="form-control" disabled v-model="empleado_info.cz9_lugar_vacuna"/>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna tifoidea </label>
                            <input type="email" class="form-control" disabled v-model="empleado_info.cz9_fecha_vacuna_tifoidea"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de las vacuna tifoidea</label>
                            <input type="text" class="form-control" disabled v-model="empleado_info.cz9_lugar_vacuna_tifoidea" />
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de la vacuna toxoide </label>
                            <input type="email" class="form-control" disabled v-model="empleado_info.cz9_fecha_vacuna_toxoide"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lugar de las vacuna toxoide</label>
                            <input type="text" class="form-control" disabled v-model="empleado_info.cz9_lugar_vacuna_tifoidea"/>
                        </div>
                    </div>
                </form>
                </div>
</template>
<script>
export default {
    props:['empleado_info']
}
</script>