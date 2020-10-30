<template>
<div>   
            
</div>
</template>
<script>
import "vue-select/dist/vue-select.css";
export default {
        name: "novopedido-component",
        props: ['id_usuario'],
        data(){
            return{
                clientes: [],
                pedido: {
                    cliente: '',
                    loja: '',
                    usuario: this.id_usuario,
                }
            }
        },
        methods:{
            loadClientes(){
                axios.get('/listaclientes')
                    .then(response => {
                        this.clientes = response.data;
                });
            },
            formPagamento(){
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }

                axios.post('/pagamento/', this.pedido, config)
                .then(function (response){
                        currentObj.success = response.data.success;
                        window.location.replace('/pagamento/'+ response.data);
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Ocorreu um erro ao tentar criar o pedido.',
                            icon: 'error',
                            })
                    });
            },
        },
        
        mounted(){
        }
    }
</script>