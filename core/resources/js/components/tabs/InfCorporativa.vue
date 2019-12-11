<template>
    <div>
        <form class="my-2">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cargo</label>
                    <input type="email" class="form-control" placeholder="Nombres" v-model="usuario.c0763_descripcion"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de Ingreso</label>
                    <input type="text" class="form-control" placeholder="Apellidos"
                        v-model="usuario.c0550_fecha_ingreso" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Fecha de finalizacion</label>
                    <input type="email" class="form-control" v-model="usuario.c0550_fecha_contrato_hasta" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Lugar de Trabajo</label>
                    <input type="text" class="form-control" placeholder="Apellidos" v-model="usuario.f284_descripcion"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tipo de Nomina </label>
                    <input type="email" class="form-control" v-model="usuario.c0504_descripcion" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Entidad Prestadora de Salud</label>
                    <input type="text" class="form-control" placeholder="Apellidos" v-model="usuario.c0515_id"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Administradora del Fondo de Pensiones </label>
                    <input type="email" class="form-control" v-model="usuario.c0516_id" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Administradora de Riesgos Laborales</label>
                    <input type="text" class="form-control" placeholder="Apellidos" v-model=" usuario.c0517_id"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Salario Actual</label>
                    <input type="email" class="form-control" v-model="usuario.c0550_salario" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Email Corporativo</label>
                    <input type="email" class="form-control" :disabled="validated ? false : true" />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Telefono Corporativo con extension</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" />
                </div>
                <div class="form-group col-md-6">
                    <label>Celular Corporativo</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" />
                </div>
                
            </div>
            <!-- <p>Fecha de Ingreso: {{  moment(usuario.c0550_fecha_ingreso, "YYYY-MM-DD").format("ll")  }}</p> -->
        </form>
    </div>
</template>
<script>
    export default {
        props: ['informacion', 'usuario', 'validated']
    }

</script>
