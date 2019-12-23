<template>
    <div>
        <form class="my-2">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cargo</label>
                    <input type="email" class="form-control" placeholder="Cargo" v-model="usuario.c0763_descripcion"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de Ingreso</label>
                    <input type="text" class="form-control" placeholder="Fecha de ingreso"
                        v-model="usuario.c0550_fecha_ingreso" disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Fecha de finalizacion</label>
                    <input  placeholder="Fecha de finalizacion" type="email" class="form-control" v-model="usuario.c0550_fecha_contrato_hasta" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Lugar de Trabajo</label>
                    <input placeholder="Lugar de Trabajo" type="text" class="form-control" v-model="usuario.f284_descripcion"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tipo de Nomina </label>
                    <input placeholder="Tipo de Nomina" type="email" class="form-control" v-model="usuario.c0504_descripcion" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Entidad Prestadora de Salud</label>
                    <input type="text" class="form-control" placeholder="EPS" v-model="usuario.c0515_id"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Administradora del Fondo de Pensiones </label>
                    <input type="email" class="form-control" placeholder="AFP" v-model="usuario.c0516_id" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Administradora de Riesgos Laborales</label>
                    <input type="text" class="form-control" placeholder="ARL" v-model=" usuario.c0517_id"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Salario Actual</label>
                    <input type="email" class="form-control" placeholder="Salario Actual" v-model="usuario.c0550_salario" disabled  />
                </div>
                <div class="form-group col-md-6">
                    <label>Email Corporativo</label>
                    <input type="email" class="form-control" placeholder="Email Corporativo" :disabled="validated ? false : true" v-model="empleado_info.cz9_mail_corp" v-uppercase v-max-length="55"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Telefono Corporativo con extension</label>
                    <input type="text" class="form-control" placeholder="Telefono Corporativo" :disabled="validated ? false : true" v-model="empleado_info.cz9_tel_corp" v-uppercase  v-max-length="25"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Celular Corporativo</label>
                    <input type="text" class="form-control" placeholder="Celular Corporativo" :disabled="validated ? false : true" v-model="empleado_info.cz9_cel_corp" v-uppercase v-numeric-only v-max-length="25"/>
                </div>
                
            </div>
            <!-- <p>Fecha de Ingreso: {{  moment(usuario.c0550_fecha_ingreso, "YYYY-MM-DD").format("ll")  }}</p> -->
        </form>
    </div>
</template>
<script>
    export default {
        props: ['informacion', 'usuario', 'validated', 'empleado_info']
    }

</script>
