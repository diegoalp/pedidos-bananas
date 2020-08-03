<template>
<div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Valor Unitário</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="p in pedidoprodutos" :key="p.id">
                        <td>{{ p.produto.nome_produto }}</td>
                        <td>R${{ formatMoeda(p.valor) }}</td>
                        <td><a v-if="pedido_status == 0" class="badge badge-info" href="#" @click="subtrair(p.id,p.quantidade)"><i class="fas fa-angle-left"></i></a>  {{ p.quantidade }}  <a v-if="pedido_status == 0" class="badge badge-info" href="#" @click="adicionar(p.id,p.quantidade)"><i class="fas fa-angle-right"></i></a></td>
                        <td>R${{ formatMoeda(p.total) }}</td>
                        <td><a class="badge badge-info" v-if="pedido_status == 0" href="#" @click="removerProduto(p.id)"><i class="fas fa-times"></i> REMOVER</a></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="table-info">
                        <td colspan="3"><b>TOTAL</b></td>
                        <td colspan="2"><b>R$ {{ formatMoeda(valortotal) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>  
        <div class="card-footer" v-if="pedido_status == 0">
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addProduto">ADICIONAR PRODUTO</button> |
            <button class="btn btn-success btn-sm" @click="finalizarPedido()">FINALIZAR PEDIDO</button>
        </div>
        <!-- Modal add produto -->
        <div class="modal fade" id="addProduto" tabindex="-1" role="dialog" aria-labelledby="addProdutoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProdutolLabel">ADICIONAR PRODUTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formProduto">
                        <div class="row">
                            <input type="hidden" id="pedido_id" class="form-control" :value="pedido_id">
                            <div class="form-group col-md-8">
                                <label for="produto">Produto</label>
                                <v-select :options="produtos" :getOptionLabel="produto => `${produto.id} | ${produto.nome_produto}`" class="form-control"  v-model="produto.produto" name="produto" id="produto" required>  
                                </v-select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="quantidade">Quantidade</label>
                                <input type="number" class="form-control" name="quantidade" v-model="produto.quantidade" required>
                            </div>
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-sm btn-info">ADICIONAR</button>
                            </div>
                        </div>    
                    </form>
                </div>
                </div>
            </div>
        </div>
        <!-- Fim modal add produto -->
</div>

</template>
<script>
import "vue-select/dist/vue-select.css";
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/src/sweetalert2.scss'
export default {
        name: "addproduto-component",
        props: ['pedido_id','pedido_status'],
        data(){
            return{
                pedidoprodutos: [],
                produtos: [],
                valortotal: '',
                produto: {
                    produto: '',
                    quantidade: '',
                }
            }
        },
        methods:{
            subtrair(id,qtd){
                let currentObj = this;
                let quantidade = qtd - 1;
                const config = {
                    headers:{'content-type':'application/json'}
                }
                axios.post('/pedido/attproduto/' + id, quantidade, config)
                .then(function (response){
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                    });
                    this.loadProdutosPedido();
            },
            adicionar(id,qtd){
                let currentObj = this;
                let quantidade = qtd + 1;
                const config = {
                    headers:{'content-type':'application/json'}
                }
                axios.post('/pedido/attproduto/' + id, quantidade, config)
                .then(function (response){
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                    });
                    this.loadProdutosPedido();
            },
            finalizarPedido(){
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }

                axios.post('/pedido/' + this.pedido_id, this.valortotal, config)
                .then(function (response){
                        currentObj.success = response.data.success;
                        window.location.replace("/pedidos");
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Ocorreu um erro ao finalizar este pedido.',
                            icon: 'error',
                            })
                    });
            },
            formatMoeda(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            loadProdutosPedido(){
                axios.get('/pedido/produtos/' + this.pedido_id)
                    .then(response => {
                        this.pedidoprodutos = response.data;
                        var produtospedido = response.data

                        var produtospedido = produtospedido.map(p => p.total);
                        var total = 0;
                        for(var i = 0; i < produtospedido.length; i++){
                            total += parseFloat(produtospedido[i]);
                        }
                        this.valortotal = total;
                });
            },
            loadProdutos(){
                axios.get('/listaprodutos')
                    .then(response => {
                        this.produtos = response.data;
                });
            },
            formProduto(){
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }
                axios.post('/pedido/addproduto/' + this.pedido_id, this.produto, config)
                
                .then(function (response){
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Ocorreu um erro ao adicionar produto.',
                            icon: 'error',
                            })
                    });
                    this.loadProdutosPedido();
            },
            removerProduto(id){
                let currentObj = this;
                axios.delete('/pedido/produtos/' + id)
                this.loadProdutosPedido();
            },
        },
        
        mounted(){
            this.loadProdutos();
            this.loadProdutosPedido();
        }
    }
</script>