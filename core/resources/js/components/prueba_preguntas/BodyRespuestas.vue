<template>
    <div>
        <!-- {{ this.cargar() }} -->
    <button @click="cargar"> fkf</button>
        <article v-for="(item, indice) in preguntas" :key="indice">
            <div class="row mt-2">
                <div class="col-md-12">
                    <p class="lead">{{ item.cz5_pregunta }}</p>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                                     
                    </div>
                </div>
            </div>
              
            
        </article>

    </div>
</template>
<script>
    export default {
        props: ["preguntas"],
        data() {
            return {
                d: null,
                id: null,
                respuestas: [],
                g: []

            };
        },
        beforeMount(){
            console.log(this.preguntas.length)
              for (var i in this.preguntas) {
                  axios.get(`/api/respuestaS/buscar/${this.preguntas[i].cz5_id}`).then(res => {
                     console.log(res.data);
                    this.respuestas.push(res.data)
                 });              
                }  
               
                
        },
        methods: {      
            cargar() {  
                for (var i in this.preguntas) {
                   
                  axios.get(`/api/respuestaS/buscar/${this.preguntas[i].cz5_id}`).then(res => {
                     console.log(res.data);
                    this.respuestas.push(res.data)
                 });              
                }  
                
            },
            mostrar(){
                // console.log(this.respuestas[0])
            }
        },
        computed: {}
    };

</script>
