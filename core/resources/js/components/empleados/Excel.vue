<template>
    <div>
        <div class="col-md-12 my-2 col-sm-8 form-group has-feedback"><b>Los campos de la tabla aparecerán en el orden
                que los seleccione aquí.</b></div>
        <div >
            <ul class="anyClass">
                <div class="col-md-12 my-2 col-sm-8 form-group has-feedback"><b>INFORMACIÓN PERSONAL </b></div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" value="Cedula" class="custom-control-input"
                        @change="$emit('filtrar','Cedula', $event.target.checked, 'c0541_id', '', '')" id="Cedula" />
                    <label class="custom-control-label" for="Cedula">Cedula</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" value="Cedula" class="custom-control-input" id="Nombre"
                        @change="$emit('filtrar','Nombres', $event.target.checked, 'c0541_nombres', '', '')" />
                    <label class="custom-control-label" for="Nombre">Nombre</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Apellido1" class="custom-control-input"
                        @change="$emit('filtrar','Apellido 1', $event.target.checked, 'c0541_apellido1', '', '')" />
                    <label class="custom-control-label" for="Apellido1">Apellido 1</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Apellido2" class="custom-control-input"
                        @change="$emit('filtrar','Apellido 2', $event.target.checked, 'c0541_apellido2', '', '')" />
                    <label class="custom-control-label" for="Apellido2">Apellido 2</label>
                </div>
                  <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="f_nac" class="custom-control-input"
                        @change="$emit('filtrar','Fecha de nacimiento', $event.target.checked, 'c0540_fecha_nacimiento', '', '')" />
                    <label class="custom-control-label" for="f_nac">Fecha de nacimiento</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="c0702_descripcion" class="custom-control-input"
                        @change="$emit('filtrar','Nivel Academico', $event.target.checked, 'c0702_descripcion', '', '')" />
                    <label class="custom-control-label" for="c0702_descripcion">Nivel Académico</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="c0780_descripcion" class="custom-control-input"
                        @change="$emit('filtrar','Estrato', $event.target.checked, 'c0780_descripcion', '', '')" />
                    <label class="custom-control-label" for="c0780_descripcion">Estrato</label>
                </div>

                
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Contacto"
                        @change="$emit('filtrar','Contacto de emergencia', $event.target.checked, 'empleado_info', 'cz9_nombre_contacto', '')" />
                    <label class="custom-control-label" for="Contacto">Contacto de emergencia</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Telefono_c"
                        @change="$emit('filtrar','Telefono del contacto de emergencia', $event.target.checked, 'empleado_info', 'cz9_tel_contacto', '')" />
                    <label class="custom-control-label" for="Telefono_c">Telefono del contacto de emergencia</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Familiar"
                        @change="$emit('filtrar','Familiar en Linco', $event.target.checked, 'empleado_info', 'cz9_nombre_familiar', '')" />
                    <label class="custom-control-label" for="Familiar">Familiar en Linco</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="calzado"
                        @change="$emit('filtrar','Talla calzado', $event.target.checked, 'empleado_info', 'cz9_talla_calzado', '')" />
                    <label class="custom-control-label" for="calzado">Talla calzado</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="uniforme"
                        @change="$emit('filtrar','Talla uniforme', $event.target.checked, 'empleado_info', 'cz9_talla_uniforme', '')" />
                    <label class="custom-control-label" for="uniforme">Talla uniforme</label>
                </div>
                <div class="col-md-12 my-2 col-sm-8 form-group has-feedback"><b>INFORMACIÓN CORPORATIVA</b></div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Cargo" class="custom-control-input"
                        @change="$emit('filtrar','Cargo', $event.target.checked, 'c0763_descripcion', '', '')" />
                    <label class="custom-control-label" for="Cargo">Cargo</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input class="custom-control-input" id="Sede" type="checkbox"
                        @change="$emit('filtrar','Sede', $event.target.checked, 'f285_descripcion', '', '')" />
                    <label class="custom-control-label" for="Sede">Sede</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Centro"
                        @change="$emit('filtrar', 'Centro de Costo', $event.target.checked, 'f284_descripcion', '', '')" />
                    <label class="custom-control-label" for="Centro">Centro de Costo</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_i"
                        @change="$emit('filtrar','Fecha de Ingreso', $event.target.checked, 'c0550_fecha_ingreso', '', '')" />
                    <label class="custom-control-label" for="Fecha_i">Fecha de Ingreso</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Fecha de vencimiento del contrato', $event.target.checked, 'c0550_fecha_contrato_hasta', '', '')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de vencimiento del contrato</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_tpp"
                        @change="$emit('filtrar','Fecha de terminacion del periodo de prueba', $event.target.checked, 'empleado_info', 'cz9_fecha_tpprueba', 'fecha')" />
                    <label class="custom-control-label" for="Fecha_tpp">Fecha de terminación del periodo de prueba</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="FV_TA"
                        @change="$emit('filtrar','FV de Trabajo en alturas', $event.target.checked, 'empleado_info', 'cz9_fv_ta', 'fecha')" />
                    <label class="custom-control-label" for="FV_TA">FV de Trabajo en alturas</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_bpm"
                        @change="$emit('filtrar','FV de BPM', $event.target.checked, 'empleado_info', 'cz9_fv_bpm', 'fecha')" />
                    <label class="custom-control-label" for="Fecha_bpm">FV de BPM</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="cz9_fv_md"
                        @change="$emit('filtrar','FV de manejo defensivo', $event.target.checked, 'empleado_info', 'cz9_fv_md', 'fecha')" />
                    <label class="custom-control-label" for="cz9_fv_md">FV de manejo defensivo</label>
                </div>

                <div class="col-md-12 my-2 col-sm-8 form-group has-feedback"><b>INFORMACIÓN SST </b></div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_hb"
                        @change="$emit('filtrar','Fecha de vacuna HB', $event.target.checked, 'empleado_info','cz9_fecha_vacuna', 'fecha')" />
                    <label class="custom-control-label" for="Fecha_hb">Fecha de vacuna HB</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_ti"
                        @change="$emit('filtrar','Fecha de vacuna tifoidea', $event.target.checked, 'empleado_info', 'cz9_fecha_vacuna_tifoidea', 'fecha')" />
                    <label class="custom-control-label" for="Fecha_ti">Fecha de vacuna tifoidea</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_to"
                        @change="$emit('filtrar','Fecha de vacuna toxoide', $event.target.checked, 'empleado_info', 'cz9_fecha_vacuna_toxoide', 'fecha')" />
                    <label class="custom-control-label" for="Fecha_to">Fecha de vacuna toxoide</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="FV_CA"
                        @change="$emit('filtrar','FV carnét de vacunación', $event.target.checked, 'empleado_info', 'cz9_fv_carne_vacunacion', 'fecha')" />
                    <label class="custom-control-label" for="FV_CA">FV carnét de vacunación</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="FV_AL"
                        @change="$emit('filtrar','FV carnét de alimentos', $event.target.checked, 'empleado_info', 'cz9_fv_carne_alimentos', 'fecha')" />
                    <label class="custom-control-label" for="FV_AL">FV carnét de alimentos</label>
                </div>
               

            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        props: []
    }

</script>
