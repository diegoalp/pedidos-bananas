<template>
<div>

    <!-- Início Formulário -->
    <form id="formProduto" @submit="formProduto">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group col-md-12">
                    <label>Nome:</label>
                    <input type="text" class="form-control text-uppercase" name="nome" id="nome" v-model="produto.nome_produto" required />
                </div>
                <div class="form-group col-md-12">
                    <label>Descrição:</label>
                    <textarea class="form-control text-uppercase" name="descricao" id="descricao" v-model="produto.descricao" rows='5' required ></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group col-md-12">
                    <label>Código de Barra:</label>
                    <input type="text" class="form-control" name="codigo_barra" id="codigo_barra" v-model="produto.codigo_barras" />
                </div>
                <div class="form-group col-md-12">
                    <label>Valor:</label>
                    <input type="text" class="form-control" name="valor" id="valor" v-money="moeda" v-model="produto.valor" required />
                </div>
                <div class="form-group  col-md-10">
                    <label>Categoria:</label>
                    <select id="categoria" name="categoria" class="form-control text-uppercase" v-model="produto.categoria_id" required> 
                        <option v-for="c in listaCategorias" :key="c.id" :value="c.id">{{ c.nome }}</option>
                    </select>
                    <a href="#" class="badge badge-info" data-toggle="modal" data-target="#modalNovaCategoria"><i class="fas fa-plus-circle"></i> adicionar</a>
                </div>
            </div>
            <div class="col-md-12 button" align="center">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
                <button type="reset" class="btn btn-primary">Limpar</button>
            </div>
        </div>
    </form>
    <!-- Fim Formulário -->
    <!-- Modal -->
        <div class="modal fade" id="modalNovaCategoria" tabindex="-1" role="dialog" aria-labelledby="modalNovaCategoriaCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalNovaCategoriaCenterTitle">Novo cliente</h3>
                </div>
                <div class="modal-body">
                    <form @submit="formCategoria">
                        <div class="row">
                            <div class="form-group col-md-12">
                            <label>Nome:</label> 
                            <input type="text" class="form-control text-uppercase" name="nome" v-model="categoria.nome" id="nome" required/>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary" >Enviar</button>
                            <button type="reset" class="btn btn-primary">Limpar</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div> 
</div>
</template>
<script>

    import {VMoney} from 'v-money'
    import {TheMask} from 'vue-the-mask'
    import Swal from 'sweetalert2/dist/sweetalert2.js'
    import 'sweetalert2/src/sweetalert2.scss'

    export default {
        name: "novoproduto-component",
        components: {TheMask},
        data(){
            return{
                produto:{
                    nome_produto: '',
                    descricao: '',
                    valor: '',
                    codigo_barras: '',
                    categoria_id: '',
                },
                categoria:{
                    nome: '',
                },
                listaCategorias: [],
                moeda: {
                    decimal: ',',
                    thousands: '.',
                    prefix: 'R$ ',
                    suffix: '',
                    precision: 2,
                    masked: true
                },
            }
        },
        directives: {money: VMoney},
        methods:{
            loadCategorias(){
                axios.get('/listacategorias')
                    .then(response => {
                        this.listaCategorias = response.data;
                });
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
                            title: 'Sucesso.',
                            text: 'Deseja cadastrar outro produto?',
                            showCancelButton: true,
                            cancelButtonText: 'Não',
                            showConfirmButton: true,
                            confirmButtonText: 'Sim',
                        })
                        .then((res) => {
                            if(res.value){
                                this.produto = "";
                            }else{
                                window.location.replace("/produtos");
                            }
                        });
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Não foi possível cadastrar este produto. Tente novamente!',
                            icon: 'error',
                            })
                    });
            },
            formCategoria(e){
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }
                axios.post('/categoria/nova', this.categoria, config)
                    .then(function (response){
                        currentObj.success = response.data.success;
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Categoria cadastrado com sucesso.',
                            showConfirmButton: false,
                            timer: 1500
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
                    $('#modalNovaCategoria').removeClass('in');
                    $('#modalNovaCategoria').attr("aria-hidden","true");
                    $('#modalNovaCategoria').css("display", "none");
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    this.loadCategorias();
                    this.categoria = "";
            },
        },
        mounted(){
            this.loadCategorias();
        }
    }
</script>