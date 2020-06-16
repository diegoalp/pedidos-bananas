<template>
<div>   
            <li class="nav-item"><a class="nav-link" href="#" @click="loadClientes();" data-toggle="modal" data-target="#modalPedido"><i class="fas fa-arrow-circle-right text-aqua"></i> <span>NOVO PEDIDO</span></a></li>
            <!-- Modal novo Pedido -->
                    <div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Novo pedido</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="form-horizontal" @submit.prevent="formPedido">
                                <div class="modal-body">

                                        <input type="hidden" id="id_usuario" class="form-control" :value="id_usuario">
                                            <label for="cliente">Cliente</label>
                                            <div class="form-group row">
                                                <v-select :options="clientes" :getOptionLabel="cliente => `${cliente.id} | ${cliente.nome}`" class="form-control" v-model="pedido.cliente" name="cliente" id="cliente">
                                                    
                                                </v-select>
                                            </div>

                                            <div class="form-group row">
                                                <label for="loja">Loja</label>
                                                <select name="loja" id="loja" class="form-control" v-model="pedido.loja" required>
                                                    <option value="Bananas 1">Bananas 1</option>
                                                    <option value="Bananas 2">Bananas 2</option>
                                                </select>
                                            </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">AVANÇAR</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <!-- Fim Formulário Pedido -->
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
            formPedido(){
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }

                axios.post('/pedido/novo', this.pedido, config)
                .then(function (response){
                        currentObj.success = response.data.success;
                        window.location.replace('/pedido/'+ response.data);
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