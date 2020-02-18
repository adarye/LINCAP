<template>
    <div>


        <div class="row" style="display: inline-block;">
            <div class="tile_count">
                <div :class=" $route.params.cat == 1 ? 'col-md-4 tile_stats_count': 'col-md-2 col-sm-8 tile_stats_count'">
                    <span class="count_top"><i class="fa fa-user"></i> Total de participantes</span>
                    <div class="count">{{total_emp}}</div>
                    <span class="count_bottom"><i class="green"></i> </span>
                </div>
                <div  :class=" $route.params.cat == 1 ? 'col-md-4 tile_stats_count': 'col-md-2 col-sm-8 tile_stats_count'">
                    <span class="count_top"><i class="fa fa-check"></i> Pruebas Completadas</span>
                    <div class="count">{{total_eva_pre}}</div>
                    <span class="count_bottom"><i :class="(total_eva_pre * 100)/total_emp >= 50 ? 'green' : 'red'"><i class=""></i>{{Math.round((total_eva_pre * 100)/total_emp)}}  %</i></span>
                </div>
                <div :class=" $route.params.cat == 1 ? 'col-md-4 tile_stats_count': 'col-md-2 col-sm-8 tile_stats_count'">
                    <span class="count_top"><i class="fa fa-circle-o"></i> Pruebas Restantes</span>
                    <div class="count green">{{total_emp - total_eva_pre}}</div>
                    <span class="count_bottom"><i :class="((total_emp - total_eva_pre) * 100)/total_emp <= 50 ? 'green':'red'"><i class=""></i>{{Math.round(((total_emp - total_eva_pre) * 100)/total_emp)}}  % </i></span>
                </div>
                <div v-show="$route.params.cat == 2" class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-thumbs-down"></i>  Evaluaciones Perdidas</span>
                    <div class="count">{{total_eva_perd}}</div>
                    <span class="count_bottom"><i :class="(total_eva_perd  * 100)/total_emp >= 50 ? 'red':'green'"><i class="fa fa-sort-desc"></i>{{Math.round((total_eva_perd  * 100)/total_emp)}}  % </i></span>
                </div>
                <div v-show="$route.params.cat == 2" class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-thumbs-up"></i> Evaluaciones ganadas</span>
                    <div class="count">{{total_eva_gan}}</div>
                    <span class="count_bottom"><i :class="(total_eva_gan  * 100)/total_emp >= 50 ? 'green': 'red'"><i class="fa fa-sort-asc"></i>{{Math.round((total_eva_gan  * 100)/total_emp)}}  % </i></span>
                </div>
                <div v-show="$route.params.cat == 2" class="col-md-2 col-sm-4  tile_stats_count">
                    <span class="count_top"><i class="fa fa-hand-o-right"></i> Promedio general</span>
                    <div class="count">{{promedio}}</div>
                    <span class="count_bottom"><i :class="(promedio  * 100)/5 >= 3.5 ? 'green':'red'"><i class="fa fa-sort-asc"></i>{{Math.round((promedio  * 100)/5)}}  % </i></span>
                </div>
            </div>
        </div>


    </div>
</template>
<script>
    export default {
        data() {
            return {
                total_emp: "",
                total_eva_pre: "",
                total_eva_perd: "",
                total_eva_gan: "",
                promedio: 0


            }
        },
        mounted() {
            this.totalEmp();

        },
        methods: {
            totalEmp() {
                axios.get(`/api/estadistica/resultados/${this.$route.params.id}`)
                    .then(res => {
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
