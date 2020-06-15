/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue/dist/vue.js'
import axios from 'axios';
import VueMask from 'v-mask'
import Swal from 'sweetalert2'
import JwPagination from 'jw-vue-pagination'
import {VMoney} from 'v-money'
import Autocomplete from 'vuejs-auto-complete'



require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueMask);
Vue.use(require('vue-moment'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('clientes-component', require('./components/ClientesComponent.vue').default);
Vue.component('funcionarios-component', require('./components/FuncionariosComponent.vue').default);
Vue.component('produtos-component', require('./components/ProdutosComponent.vue').default);
Vue.component('novoproduto-component', require('./components/NovoProdutoComponent.vue').default);
Vue.component('novopedido-component', require('./components/CriarNovoPedidoComponent.vue').default);
Vue.component('jw-pagination', JwPagination);
Vue.component('autocomplete', Autocomplete);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        Autocomplete,
    },
});
