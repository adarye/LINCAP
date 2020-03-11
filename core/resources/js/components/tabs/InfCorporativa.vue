<template>
    <div>
        <form class="my-2">
            <div class="form-row">
                 <div class="form-group col-md-6">
                    <label>Centro de Operación</label>
                    <input placeholder="Centro de Operación" type="text" class="form-control" v-model="usuario.f285_descripcion"
                        disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Centro de Costo</label>
                    <input placeholder="Centro de costo" type="text" class="form-control" v-model="usuario.f284_descripcion"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Tipo de Contrato </label>
                    <input placeholder="Tipo de Contrato" type="text" class="form-control" v-model="tipo_contrato" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>Fecha de Terminación del Contrato </label>
                    <input  placeholder="Fecha de Terminación" type="text" class="form-control" v-model="usuario.c0550_fecha_contrato_hasta" disabled />
                </div>
               
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Cargo</label>
                    <input type="text" class="form-control" placeholder="Cargo" v-model="usuario.c0763_descripcion"
                        disabled />
                </div>
                  <div class="form-group col-md-6">
                    <label>Salario Actual</label>
                    <input type="text" class="form-control" placeholder="Salario Actual" v-model="usuario.c0550_salario" disabled  />
                </div>   
            </div>
            <div class="form-row">
               <div class="form-group col-md-6">
                    <label>Fecha de Ingreso</label>
                    <input type="text" class="form-control"
                        v-model="usuario.c0550_fecha_ingreso" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>ARL</label>
                    <input type="text" class="form-control" v-model=" usuario.c0517_id"
                        disabled />
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>AFP</label>
                    <input type="text" class="form-control"  v-model="usuario.c0516_id" disabled />
                </div>
                <div class="form-group col-md-6">
                    <label>EPS</label>
                    <input type="text" class="form-control"  v-model="usuario.c0515_id"
                        disabled />
                </div>
                
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>FV Curso de Alturas</label>
                    <input v-model="empleado_info.cz9_fv_ta" type="date" class="form-control" placeholder="Fecha de Vencimiento" :disabled="validated_admin ? false : true"  v-uppercase-only  v-max-length="25"/>
                </div>
                <div class="form-group col-md-6">
                    <label>FV de BPM</label>
                    <input v-model="empleado_info.cz9_fv_bpm" type="date" class="form-control" placeholder="Fecha de Vencimiento" :disabled="validated_admin ? false : true"  v-uppercase-only  v-max-length="25"/>
                </div>
                
            </div>
             <div class="form-row">
                <div class="form-group col-md-6">
                    <label>FV Curso sobre Manejo Defensivo</label>
                    <input v-model="empleado_info.cz9_fv_md" type="date" class="form-control"  :disabled="validated_admin ? false : true"  v-uppercase-only  v-max-length="25"/>
                </div>
               <div class="form-group col-md-6">
                    <label>Email Corporativo</label>
                    <input type="text" class="form-control" :disabled="validated ? false : true" v-model="empleado_info.cz9_mail_corp" v-uppercase-only v-max-length="55"/>
                </div>
                
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Teléfono Corporativo con Extensión</label>
                    <input type="text" class="form-control"  :disabled="validated ? false : true" v-model="empleado_info.cz9_tel_corp" v-uppercase-only  v-max-length="25"/>
                </div>
                <div class="form-group col-md-6">
                    <label>Celular Corporativo</label>
                    <input type="text" class="form-control"  :disabled="validated ? false : true" v-model="empleado_info.cz9_cel_corp"  v-uppercase-only v-numeric-only v-max-length="25"/>
                </div>
                
            </div>
             <div class="form-row col-md-6">
                   <label>Premios</label>
                 <textarea rows="4" cols="50" type="text" class="form-control"
                        :disabled="validated_admin ? false : true" v-model="empleado_info.cz9_premios"
                        v-uppercase-only v-max-length="4500">
                    </textarea>
                
                
            </div>
            <!-- <p>Fecha de Ingreso: {{  moment(usuario.c0550_fecha_ingreso, "YYYY-MM-DD").format("ll")  }}</p> -->
        </form>
    </div>
</template>
<script>
    export default {
        props: ['informacion', 'usuario', 'validated', 'empleado_info', 'tipo_contrato', 'validated_admin'],
        data(){
            return{
               

            }
        },
        methods:{
         
        }
    }

</script>
