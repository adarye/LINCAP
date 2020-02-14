<template>
    <div>
             <div class="row">
            <div class="col-md-6 ">
                <div class="card pull-right" style="width:80%">
                    <div class="card-header">Datos</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p class="lead">Total de participantes
                                    <span class="badge badge-info pull-right">{{total_emp}}
                                    </span>
                                </p>
                            </li>
                             <li class="list-group-item">
                                <p class="lead">Evaluaciones completadas
                                    <span class="badge badge-info pull-right">{{total_eva_pre}}
                                    </span>
                                </p>
                            </li>
                             <li class="list-group-item">
                                <p class="lead">Evaluaciones Restantes
                                    <span class="badge badge-info pull-right">{{total_emp - total_eva_pre}}
                                    </span>
                                </p>
                            </li>
                            
                            
                           
                        </ul>
                    </div>
                </div>


            </div>
            <div class="col-md-6 pull-left">
                <div class="card" style="width:80%">
                    <div class="card-header">Datos</div>
                    <div class="card-body">
                        <ul class="list-group">
                            
                            <li class="list-group-item">
                                <p class="lead">Evaluaciones Perdidas
                                    <span class="badge badge-info pull-right">{{total_eva_perd}}
                                    </span>
                                </p>
                            </li>
                            <li class="list-group-item">
                                <p class="lead">Evaluaciones ganadas
                                    <span class="badge badge-info pull-right">{{total_eva_gan}}
                                    </span>
                                </p>
                            </li>
                            <li class="list-group-item">
                                <p class="lead">Promedio general
                                    <span class="badge badge-info pull-right">{{promedio}}
                                    </span>
                                </p>
                            </li>
                            
                           
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            total_emp: "",
            total_eva_pre: "",
            total_eva_perd: "",
            total_eva_gan: "",
            promedio: 0


        }
    },
    mounted(){
        this.totalEmp();
        
    },
    methods:{
        totalEmp(){
            axios.get(`/api/estadistica/resultados/${this.$route.params.id}`)
            .then(res=>{
                this.total_emp = res.data[0]
                this.total_eva_pre = res.data[1]
                this.total_eva_perd = res.data[2]
                 this.total_eva_gan = res.data[3]
                 this.promedio = Math.round(res.data[4] * 100) / 100
            })
        },
        
    }
}
</script>