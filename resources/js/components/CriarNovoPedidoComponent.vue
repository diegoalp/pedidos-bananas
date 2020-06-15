<template>
<div>   
            <li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#modalPedido"><i class="fas fa-arrow-circle-right text-aqua"></i> <span>NOVO PEDIDO</span></a></li>
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
                                <div class="modal-body">
                                    <form class="form-horizontal" method="POST">

                                        <input type="hidden" id="id" class="form-control">
                                            <div class="form-group row">
                                                <label for="cliente">Cliente</label>
                                                <autocomplete
                                                :source="clientes"
                                                :results-display="nome">
                                                </autocomplete>
                                            </div>

                                            <div class="form-group row">
                                                <label for="cliente">Loja</label>
                                                <select name="loja" id="loja" class="form-control" required>
                                                    <option value="1">Bananas 1</option>
                                                    <option value="2">Bananas 2</option>
                                                </select>
                                            </div>

                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">AVANÇAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- Fim Formulário Pedido -->
</div>
</template>
<script>
export default {
        name: "novopedido-component",
        data(){
            return{
                clientes: [],
            }
        },
        methods:{
            loadClientes(){
                axios.get('/listaclientes')
                    .then(response => {
                        this.clientes = response.data;
                });
            },
        },
        mounted(){
            this.loadClientes();
        }
    }
</script>