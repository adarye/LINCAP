<template>
    <div>
        <div class="col-md-12 my-2 col-sm-8 form-group has-feedback"><b>Los campos de la tabla aparecerán en el orden
                que los seleccione aquí.</b></div>
        <div >
            <ul class="anyClass">

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" value="Cedula" class="custom-control-input"
                        @change="$emit('filtrar','Cedula', $event.target.checked, 'c0541_id')" id="Cedula" />
                    <label class="custom-control-label" for="Cedula">Cedula</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" value="Cedula" class="custom-control-input" id="Nombre"
                        @change="$emit('filtrar','Nombres', $event.target.checked, 'c0541_nombres')" />
                    <label class="custom-control-label" for="Nombre">Nombre</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Apellido1" class="custom-control-input"
                        @change="$emit('filtrar','Apellido 1', $event.target.checked, 'c0541_apellido1')" />
                    <label class="custom-control-label" for="Apellido1">Apellido 1</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Apellido2" class="custom-control-input"
                        @change="$emit('filtrar','Apellido 2', $event.target.checked, 'c0541_apellido2')" />
                    <label class="custom-control-label" for="Apellido2">Apellido 2</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" id="Cargo" class="custom-control-input"
                        @change="$emit('filtrar','Cargo', $event.target.checked, 'c0763_descripcion')" />
                    <label class="custom-control-label" for="Cargo">Cargo</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input class="custom-control-input" id="Sede" type="checkbox"
                        @change="$emit('filtrar','Sede', $event.target.checked, 'f285_descripcion')" />
                    <label class="custom-control-label" for="Sede">Sede</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Centro"
                        @change="$emit('filtrar', 'Centro de Costo', $event.target.checked, 'f284_descripcion')" />
                    <label class="custom-control-label" for="Centro">Centro de Costo</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_i"
                        @change="$emit('filtrar','Fecha de Ingreso', $event.target.checked, 'c0550_fecha_ingreso')" />
                    <label class="custom-control-label" for="Fecha_i">Fecha de Ingreso</label>
                </div>

                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Fecha de vencimiento del contrato', $event.target.checked, 'c0550_fecha_contrato_hasta')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de vencimiento del contrato</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_tpp"
                        @change="$emit('filtrar','Fecha de terminacion del periodo de prueba', $event.target.checked, 'cz9_fecha_tpprueba')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de terminacion del periodo de prueba</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Fecha de vacuna HB', $event.target.checked, 'cz9_fecha_vacuna')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de vacuna HB</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Fecha de vacuna tifoidea', $event.target.checked, 'cz9_fecha_vacuna_tifoidea')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de vacuna tifoidea</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Fecha de vacuna toxoide', $event.target.checked, 'cz9_fecha_vacuna_toxoide')" />
                    <label class="custom-control-label" for="Fecha_h">Fecha de vacuna toxoide</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Contacto de emergencia', $event.target.checked, 'empleado_info')" />
                    <label class="custom-control-label" for="Fecha_h">Contacto de emergencia</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Telefono del contacto de emergencia', $event.target.checked, 'empleado_info')" />
                    <label class="custom-control-label" for="Fecha_h">Telefono del contacto de emergencia</label>
                </div>
                 <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Familiar en Linco', $event.target.checked, 'empleado_info')" />
                    <label class="custom-control-label" for="Fecha_h">Familiar en Linco</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Talla calzado', $event.target.checked, 'empleado_info')" />
                    <label class="custom-control-label" for="Fecha_h">Talla calzado</label>
                </div>
                <div class="custom-control custom-checkbox col-md-12  col-sm-8 form-group has-feedback">
                    <input type="checkbox" class="custom-control-input" id="Fecha_h"
                        @change="$emit('filtrar','Talla uniforme', $event.target.checked, 'empleado_info')" />
                    <label class="custom-control-label" for="Fecha_h">Talla uniforme</label>
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
