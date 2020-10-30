<template>
<div>
        <!-- Listar pagamentos -->
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding" v-show="listarpedidos == true">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('id')">#</th>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('cliente_id')">Cliente</th>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('valor')">Valor</th>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('data')">Data</th>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('usuario_id')">Funcionário</th>
                                <th style="cursor: pointer;" v-on:click="ordemColuna('forma_pagamento')">Forma de pagamento</th>
                                <th></th>
                            </tr>
                            <tr v-for="p in paginaDePagamentos" :key="p.id">
                                <td>{{ p.id }}</td>
                                <td>{{ p.cliente.nome }}</td>
                                <td>R$ {{formatMoeda(p.valor)}}</td>
                                <td>{{ p.created_at | moment("DD/MM/YYYY")}}</td>
                                <td>{{ p.usuario.name }}</td>
                                <td>{{ p.forma_pagamento }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                            <jw-pagination v-bind:items="lista" @changePage="onChangePage" :labels="customLabels" :styles="customStyles"></jw-pagination>
                    </div>
                    <button class="btn btn-primary" @click="listarpedidos = false"><i class="fas fa-arrow-circle-right text-aqua"></i> <span>NOVO PAGAMENTO</span></button>
                </div>
                
                <div class="box-body" v-show="listarpedidos == false">
                    <div class="row">
                        <div class="col-md-4 offset-md-4">
                            <span>Selecione um cliente</span>
                            <v-select :options="clientes" :getOptionLabel="cliente => `${cliente.id} | ${cliente.nome}`" class="form-control" v-model="pagamento.cliente" name="cliente" id="cliente" v-on:input="loadPedidos"></v-select>
                        </div>
                        <div class="col-12">
                            <table v-if="pagamento.cliente" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="50"><input type="checkbox" @click="selecionarTudo" v-model="selecionartodos"></th>
                                        <th width="200">Nº Pedido</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="pedido in pedidosCliente" :key="pedido.id">
                                        <td><input type="checkbox" class="form-check-input" :id="'pagar' + pedido.id" v-model="pagamento.pedidos" :value="pedido" @click="selecionar"></td>
                                        <td><a :href="'/pedido/' + pedido.codigo">{{ pedido.codigo }}</a></td>
                                        <td>R$ {{formatMoeda(pedido.valorTotal)}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" width="200"><strong>Total:</strong> </td>
                                        <td><strong>R${{ formatMoeda(valorTotal) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-4 form-group" v-if="pagamento.pedidos.length > 0">
                            <label>Forma de pagamento: </label>
                            <select class="form-control" v-model="pagamento.forma_pagamento">
                                <option value="dinheido">Dinheiro</option>
                                <option value="cartão de débito">Cartão de Débito</option>
                                <option value="cartão de crédito">Cartão de Crédito</option>
                            </select>
                        </div>
                        <div class="col-12" v-if="pagamento.pedidos.length > 0">
                            <button class="btn btn-success" @click="confirmarPagamento">CONFIRMAR PAGAMENTO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
const customLabels = {
    first: '<< Primeira',
    last: 'Última >>',
    previous: '<',
    next: '>'
};
const customStyles = {
    ul: {
        margin: '0 auto',
    },
};
    import {TheMask} from 'vue-the-mask'
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'
    import "vue-select/dist/vue-select.css";
    

    export default {
        name: "pagamentos-component",
        components: {TheMask},
        data(){
            return{
                pagamento:{
                    pedidos: [],
                    valor_total: '',
                    forma_pagamento: '',
                    cliente: '',
                },
                selecionartodos: false,
                listarpedidos: true,
                buscador: '',
                ordemCol: '',
                ordem: '',
                clientes: [],
                pagamentos:[],
                paginaDePagamentos: [],
                pedidosCliente: [],
                customLabels,
                customStyles
            }
        },
        methods:{
            selecionarTudo: function() {
            this.pagamento.pedidos = [];
                if (this.selecionartodos == false) {
                    for(var i = 0; i < this.pedidosCliente.length; i++){    
                        this.pagamento.pedidos.push(this.pedidosCliente[i]);
                    }
                }
            },
            selecionar: function() {
                this.selecionartodos = false;
            },
            formatMoeda(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            loadPagamentos(){
                axios.get('/listapagamentos')
                    .then(response => {
                        this.pagamentos = response.data;
                });
            },
            loadPedidos(){
                axios.get('/pedidos/cliente/' + this.pagamento.cliente.id)
                    .then(response => {
                        this.pedidosCliente = response.data;
                });
            },
            onChangePage(paginaDePagamentos) {
            // update page of items
            this.paginaDePagamentos = paginaDePagamentos;
            },
            ordemColuna(coluna){
                this.ordemCol = coluna;
                if(this.ordem.toLowerCase() == "asc"){
                    this.ordem = "desc";
                }else{
                    this.ordem = "asc";
                }
            },
            loadClientes(){
                axios.get('/listaclientes')
                    .then(response => {
                        this.clientes = response.data;
                });
            },
            confirmarPagamento(){
                const config = {
                    headers:{'content-type':'application/json'}
                }
                var _this = this;

                if(this.pagamento.forma_pagamento != ''){

                    axios.post('/pagamento/novo', this.pagamento, config)
                        .then(function (response){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Pagamento feito com sucesso!.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                _this.listarpedidos = true;
                                _this.pagamento.cliente = '';
                                _this.pedidosCliente = '';
                                _this.pagamento.valor_total = '';
                                _this.loadPagamentos();
                            })
                        })
                        .catch(function (error) {

                            currentObj.output = error;
                            Swal.fire({
                                title: 'Ops!',
                                text: 'Esta categoria já existe!',
                                icon: 'error',
                                })
                        });
                }else{
                    Swal.fire({
                        title: 'Ops!',
                        text: 'Por favor, informe a forma de pagamento',
                        icon: 'warning',
                    })
                }
            }
        },
        computed:{
            lista: function(){
                
                let ordem = this.ordem || "desc";
                let coluna = this.ordemCol || "id";
                coluna = coluna.toLowerCase();
                    if(ordem == "asc"){
                        this.pagamentos.sort(function(a,b){
                        if (a[coluna] > b[coluna]) {return 1;}
                        if (a[coluna] < b[coluna]) {return -1;}
                        return 0;
                    });
                    }else{
                    this.pagamentos.sort(function(a,b){
                    if (a[coluna] < b[coluna]) {return 1;}
                    if (a[coluna] > b[coluna]) {return -1;}
                    return 0;
                    });
                }
                
                const search = this.buscador;
                if (!search) return this.pagamentos;
                return this.pagamentos.filter(c => p.codigo.toLowerCase().indexOf(search.toLowerCase().trim()) > -1);
            },
            valorTotal: function(){
                var pedidos = this.pagamento.pedidos.map(p => p.valorTotal);
                var total = 0;

                for(var i = 0; i < pedidos.length; i++){    
                    total += parseFloat(pedidos[i])
                }
                this.pagamento.valor_total = total;

                return this.pagamento.valor_total;
            }
        },
        mounted(){
            this.loadPagamentos();
            this.loadClientes();
        }
    }
</script>