<template>
    <div>
        <article v-for="(item, indice) in respuestas" :key="indice">
            <div class="row mt-2">
                <div class="col-md-12">
                    <p class="lead">{{ item.cz5_pregunta }}</p>
                </div>
                <div class="col-md-12">
                    <span v-if="item.cz5_categoria == 'ra'">
                        <textarea rows="4" cols="50" v-max-length="300" v-autofocus class="form-control"
                            placeholder="Pregunta Abierta" onfocus />
                        </span>
                    <span v-else-if="item.cz5_categoria == 'smur'">
                        <div class="form-check" >
                            {{ cargar(item.cz5_id)}}
                            <span v-for="(h, indice) in rs" :key="indice">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    value=""
                                />
                                <p>{{ h.cz7_rta }}</p>
                            </span>
                        </div>
                    </span>
                </div>
                <p></p>
            </div>
        </article>
    </div>
</template>
<script>
export default {
    props: ["respuestas"],
    data() {
        return {
            rs: []
        };
    },
    methods: {
        cargar(id) {
            axios.get(`/api/respuestaS/buscar/${id}`).then(res => {
                this.rs = res.data;
                console.log(res.data);
            });
        }
    },
    computed:{
        
    }
};
</script>
