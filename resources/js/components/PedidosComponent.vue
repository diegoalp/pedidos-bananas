<template>
    <div>
        <!-- Listar pedidos -->
        <div class="col-xs-12">
            <div>
                            <!-- <div  class="col-md-4" style="margin-bottom: 10px;">
    
                                <div class="input-group">
                                    <input class="form-control" type="search" name="busca" placeholder="Buscar" v-model="buscador">
                                </div>

                            </div>   -->
            </div>
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('id')">Código</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('nome')">Cliente</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('celular')">Valor total</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('data')">Data</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('vencimento')">Vencimento</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('status')">Status</th>
                            <th></th>
                        </tr>
                        <tr v-for="p in paginaDePedidos" :key="p.id">
                            <td><a :href="'/pedido/' + p.codigo">{{p.codigo}}</a></td>
                            <td>{{p.cliente.nome}}</td>
                            <td>R$ {{formatMoeda(p.valorTotal)}}</td>
                            <td>{{ p.created_at | moment("DD/MM/YYYY")}}</td>
                            <td>{{ p.created_at | moment('add', '1 month',"DD/MM/YYYY")}}</td>
                            <td>
                                <span class="badge badge-warning" v-if="p.status == 1">EM ABERTO</span>
                                <span v-if="p.status == 2" class="badge badge-success">PAGO</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                        <jw-pagination v-bind:items="lista" @changePage="onChangePage" :labels="customLabels" :styles="customStyles"></jw-pagination>
                </div>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- Fim da lista de pedidos -->
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
    

    export default {
        name: "pedidos-component",
        components: {TheMask},
        data(){
            return{
                buscador: '',
                ordemCol: '',
                ordem: '',
                pedidos:[],
                paginaDePedidos: [],
                customLabels,
                customStyles
            }
        },
        methods:{
            formatMoeda(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            loadPedidos(){
                axios.get('/listapedidos')
                    .then(response => {
                        this.pedidos = response.data;
                });
            },
            onChangePage(paginaDePedidos) {
            // update page of items
            this.paginaDePedidos = paginaDePedidos;
            },
            ordemColuna(coluna){
                this.ordemCol = coluna;
                if(this.ordem.toLowerCase() == "asc"){
                    this.ordem = "desc";
                }else{
                    this.ordem = "asc";
                }
            },
        },
        computed:{
            lista: function(){
                
                let ordem = this.ordem || "desc";
                let coluna = this.ordemCol || "id";
                coluna = coluna.toLowerCase();
                    if(ordem == "asc"){
                        this.pedidos.sort(function(a,b){
                        if (a[coluna] > b[coluna]) {return 1;}
                        if (a[coluna] < b[coluna]) {return -1;}
                        return 0;
                    });
                    }else{
                    this.pedidos.sort(function(a,b){
                    if (a[coluna] < b[coluna]) {return 1;}
                    if (a[coluna] > b[coluna]) {return -1;}
                    return 0;
                    });
                }
                
                const search = this.buscador;
                if (!search) return this.pedidos;
                return this.pedidos.filter(c => p.codigo.toLowerCase().indexOf(search.toLowerCase().trim()) > -1);
            }
        },
        mounted(){
            this.loadPedidos();
        }
    }
</script>