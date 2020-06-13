<template>
    <div>
        <!-- Listar clientes -->
        <div class="col-md-12">
            <div>
                <div  class="col-md-4" style="margin-bottom: 10px;">
                    <div class="input-group">
                        <input class="form-control" type="search" name="busca" placeholder="Buscar" v-model="buscador">
                    </div>
                </div>  
            </div>
            <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <div class="row">
                    <div v-for="p in paginaDeProdutos" :key="p.id" class="col-md-3 col-sm-12">
                        <div class="info-box">
                            <span class="float-right">
                                <button type="button" class="close" @click="removerProduto(p.id)" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </span>
                            <div class="info-box-content">
                                <a style="cursor: pointer;" data-toggle="modal" :data-target="'#produtoModal' + p.id" class="info-box-text text-center">{{ p.nome_produto }}</a>
                                <span class="info-box-number text-center">R${{ formatMoeda(p.valor) }}</span>
                                <span v-if="p.codigo_barras" class="info-box-text text-center"><b>COD:</b>{{ p.codigo_barras }}</span>
                                <span v-else><br/></span>
                            </div>
                        </div>
                        <!-- Modal -->
                            <div class="modal fade" :id="'produtoModal' + p.id" tabindex="-1" role="dialog" aria-labelledby="produtoModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="produtoModalLabel">{{ p.nome_produto }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>Descrição:</b> {{ p.descricao }}</p>
                                        <p><b>Código de barras:</b> {{ p.codigo_barras }}</span>
                                        <p><b>Valor:</b> R${{ formatMoeda(p.valor) }}
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <label>Atualizar valor:</label>
                                        <form @submit.prevent="attValor(p.id)">
                                            <input type="text" v-model="valor" v-money="moeda">
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        <!-- Fim do modal -->
                    </div>
                </div>
                    <div class="text-center">
                        <jw-pagination v-bind:items="lista" @changePage="onChangePage" :labels="customLabels" :styles="customStyles"></jw-pagination>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a href="/produto/novo" class="btn btn-success">Novo</a>
            </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- Fim da lista de produtos -->
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
    import {VMoney} from 'v-money'
    export default {
        name: "produtos-component",
        components: {TheMask},
        data(){
            return{
                buscador: '',
                ordemCol: '',
                ordem: '',
                produtos:[],
                produto:{
                    nome_produto: '',
                },
                valor: '',
                moeda: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: '',
                    precision: 2,
                    masked: true
                },
                paginaDeProdutos: [],
                customLabels,
                customStyles
            }
        },
        directives: {money: VMoney},
        methods:{
            formatMoeda(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            formProduto(e){
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }

                axios.post('/produto/novo', this.produto, config)
                    .then(function (response){
                        currentObj.success = response.data.success;
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Novo produto cadastrado com sucesso.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Não foi possível cadastrar este produto. Tente novamente!',
                            icon: 'error',
                            })
                    });
                    this.produto = "";
                            $('#modalNovoProduto').removeClass('in');
                            $('#modalNovoProduto').attr("aria-hidden","true");
                            $('#modalNovoProduto').css("display", "none");
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                    this.loadProdutos();
            },
            loadProdutos(){
                axios.get('/listaprodutos')
                    .then(response => {
                        this.produtos = response.data;
                });
            },
            attValor(id){
                let currentObj = this;
                var valor = this.valor.replace(".","");
                var valor = valor.replace("R$","");
                var valor = valor.replace(",",".");
                var valor = parseFloat(valor);
                let formData = new FormData();
                formData.append('valor', valor);
                axios.post('/attproduto/' + id, formData)
                    .then(function (response){
                        currentObj.success = response.data.success;
                        Swal.fire({
                                    title: 'Sucesso',
                                    text: 'Valor atualizado com sucesso!',
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                        })
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                                    title: 'Ops!',
                                    text: 'Erro ao atualizar valor.',
                                    icon: 'error',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                })

                    });
                    this.loadProdutos();
            },
            removerProduto(id){
                let currentObj = this;
                Swal.fire({
                    title: 'REMOVER PRODUTO',
                    text: 'Deseja realmente remover este produto?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'cancelar',
                    showConfirmButton: true,
                    confirmButtonText: 'confirmar',
                    })
                    .then((res) => {
                    if(res.value){
                        axios.delete('/produto/' + id)
                        .then((response) => { 
                            currentObj.success = response.data;
                        },
                        (error) => {
                            Swal.fire({
                                            title: 'Ops!',
                                            text: 'Não foi possível remover este produto.',
                                            icon: 'error',
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                        })
                        });
                    }
                    this.loadProdutos();
                });
            },
            onChangePage(paginaDeProdutos) {
            // update page of items
            this.paginaDeProdutos = paginaDeProdutos;
            },
            removerProduto(id){
                let currentObj = this;
                Swal.fire({
                    title: 'REMOVER PRODUTO',
                    text: 'Deseja realmente remover este produto?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'cancelar',
                    showConfirmButton: true,
                    confirmButtonText: 'confirmar',
                    })
                    .then((res) => {
                    if(res.value){
                        axios.delete('/produto/' + id)
                        .then((response) => { 
                            currentObj.success = response.data;
                        },
                        (error) => {
                            Swal.fire({
                                            title: 'Ops!',
                                            text: 'Não foi possível remover este produto.',
                                            icon: 'error',
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                        })
                        });
                    }
                    this.loadProdutos();
                });
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
                        this.produtos.sort(function(a,b){
                        if (a[coluna] > b[coluna]) {return 1;}
                        if (a[coluna] < b[coluna]) {return -1;}
                        return 0;
                    });
                    }else{
                    this.produtos.sort(function(a,b){
                    if (a[coluna] < b[coluna]) {return 1;}
                    if (a[coluna] > b[coluna]) {return -1;}
                    return 0;
                    });
                }
                
                const search = this.buscador;
                if (!search) return this.produtos;
                return this.produtos.filter(p => p.nome_produto.toLowerCase().indexOf(search.toLowerCase().trim()) > -1);
                console.log(this.buscador);
            }
        },
        mounted(){
            this.loadProdutos();
        }
    }
</script>