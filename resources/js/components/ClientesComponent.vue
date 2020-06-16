<template>
    <div>
        <!-- Listar clientes -->
        <div class="col-xs-12">
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
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('id')">Código</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('nome')">Nome</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('celular')">Celular</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('email')">E-mail</th>
                            <th style="cursor: pointer;" v-on:click="ordemColuna('status')">Status</th>
                            <th></th>
                        </tr>
                        <tr v-for="c in paginaDeClientes" :key="c.id">
                            <td>{{c.id}}</td>
                            <td>{{c.nome}}</td>
                            <td>{{ c.celular }}</td>
                            <td>{{ c.email }}</td>
                            <td>
                                <span class="badge badge-success" v-if="c.status == 1">Ativo</span>
                                <span v-if="c.status == 0" class="badge badge-danger">Inativo</span>
                            </td>
                            <td><a class="badge badge-info" href="#"><i class="fas fa-eye"></i> VER</a> | <a class="badge badge-info" href="#" @click="removerCliente(c.id)"><i class="fas fa-user-times"></i> REMOVER</a></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                        <jw-pagination v-bind:items="lista" @changePage="onChangePage" :labels="customLabels" :styles="customStyles"></jw-pagination>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalNovoCliente">Novo</button>
            </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- Fim da lista de clientes -->

        <!-- Modal -->
        <div class="modal fade" id="modalNovoCliente" tabindex="-1" role="dialog" aria-labelledby="modalNovoClienteCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalNovoClienteCenterTitle">Novo cliente</h3>
            </div>
            <div class="modal-body">
                <form @submit="formCliente" name="formularioCliente">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label>Nome:</label> <input type="text" class="form-control text-uppercase"
                                name="nome" v-model="cliente.nome" id="nome" required/>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Apelido:</label> <input type="text" class="form-control text-uppercase"
                                name="apelido" v-model="cliente.apelido" id="apelido" />
                        </div>

                        <div class="form-group col-md-4">
                            <label>CPF:</label> 
                                        <input type="text" name="cpf" v-model="cliente.cpf" v-mask="'###.###.###-##'" class="form-control" id="cpf" required />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Celular*:</label> <input type="text" class="form-control"
                                name="celular" id="celular" v-model="cliente.celular" v-mask="'(##) #####-####'"
                                required />
                        </div>

                        <div class="form-group col-md-4">
                            <label>E-mail:</label> <input type="text" class="form-control text-uppercase"
                                name="email" id="email" v-model="cliente.email" required />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Função:</label> <input type="text" class="form-control text-uppercase"
                                name="funcao" id="funcao" v-model="cliente.funcao" required />
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label>Local de trabalho:</label> <input type="text" class="form-control text-uppercase"
                                name="trabalho" id="trabalho" v-model="cliente.trabalho" />
                        </div>

                        <div class="col-md-4 form-check">
                                    <label>Sexo:</label><br>
                                        
                                        <input type="radio" name="sexo" v-model="cliente.sexo" id="sexom" value="Masculino" checked>
                                        <label class="form-check-label" for="sexom">
                                        Masculino
                                        </label>
                                        <input type="radio" name="sexo" v-model="cliente.sexo" id="sexof" value="Feminino">
                                        <label class="form-check-label" for="sexof">
                                        Feminino
                                        </label>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Endereço:</label> <input type="text" class="form-control text-uppercase"
                                name="endereco" id="endereco" v-model="cliente.endereco" required />
                        </div>

                        <div class="form-group col-md-4">
                            <label>Bairro:</label> <input type="text" class="form-control text-uppercase"
                                name="bairro" id="bairro" v-model="cliente.bairro" required />
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label>Cidade:</label> <input type="text" class="form-control text-uppercase"
                                name="cidade" id="cidade" v-model="cliente.cidade" required />
                        </div>

                        <div class="form-group  col-md-4">
                            <label>Estado:</label> <select id="estado" v-model="cliente.estado" name="estado"
                                class="form-control">
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                                <option value="EST">Estrangeiro</option>
                            </select>
                        </div>

                        <div class="col-md-12 button" align="center">
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
        name: "clientes-component",
        components: {TheMask},
        data(){
            return{
                buscador: '',
                ordemCol: '',
                ordem: '',
                clientes:[],
                cliente:{
                    nome: '',
                    apelido: '',
                    sexo: '',
                    cpf: '',
                    endereco: '',
                    bairro: '',
                    cidade: '',
                    estado: '',
                    trabalho: '',
                    funcao: '',
                    celular: '',
                    telefone: '',
                    email: '',
                },
                paginaDeClientes: [],
                customLabels,
                customStyles
            }
        },
        methods:{
            formCliente(e){
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers:{'content-type':'application/json'}
                }

                axios.post('/cliente/novo', this.cliente, config)
                    .then(function (response){
                        currentObj.success = response.data.success;
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Novo cliente cadastrado com sucesso.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    })
                    .catch(function (error) {

                        currentObj.output = error;
                        Swal.fire({
                            title: 'Ops!',
                            text: 'Erro ao cadastrar cliente. CPF já cadastrado!',
                            icon: 'error',
                            })
                    });
                            $('#modalNovoCliente').removeClass('in');
                            $('#modalNovoCliente').attr("aria-hidden","true");
                            $('#modalNovoCliente').css("display", "none");
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            this.loadClientes();
                            // this.cliente = "";
            },
            loadClientes(){
                axios.get('/listaclientes')
                    .then(response => {
                        this.clientes = response.data;
                });
            },
            onChangePage(paginaDeClientes) {
            // update page of items
            this.paginaDeClientes = paginaDeClientes;
            },
            removerCliente(id){
                let currentObj = this;
                Swal.fire({
                    title: 'REMOVER CLIENTE',
                    text: 'Deseja realmente remover este cliente?',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'cancelar',
                    showConfirmButton: true,
                    confirmButtonText: 'confirmar',
                    })
                    .then((res) => {
                    if(res.value){
                        axios.delete('/cliente/' + id)
                        .then((response) => { 
                            currentObj.success = response.data;
                        },
                        (error) => {
                            Swal.fire({
                                            title: 'Ops!',
                                            text: 'Não foi possível remover este cliente.',
                                            icon: 'error',
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                        })
                        });
                    }
                    this.loadClientes();
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
                        this.clientes.sort(function(a,b){
                        if (a[coluna] > b[coluna]) {return 1;}
                        if (a[coluna] < b[coluna]) {return -1;}
                        return 0;
                    });
                    }else{
                    this.clientes.sort(function(a,b){
                    if (a[coluna] < b[coluna]) {return 1;}
                    if (a[coluna] > b[coluna]) {return -1;}
                    return 0;
                    });
                }
                
                const search = this.buscador;
                if (!search) return this.clientes;
                return this.clientes.filter(c => c.nome.toLowerCase().indexOf(search.toLowerCase().trim()) > -1);
                console.log(this.buscador);
            }
        },
        mounted(){
            this.loadClientes();
        }
    }
</script>