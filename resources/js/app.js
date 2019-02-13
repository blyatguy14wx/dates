import Vue from 'vue';
import VueRouter from 'vue-router';
import citasComponent from './components/citas/citasComponent';
import navbar from './components/mainNav/navbar';
import $ from 'jquery';
import VueSelect from 'vue-select';
import usersComponent from './components/users/usersComponent';
import especialidadesComponent from './components/especialialidades/especialidadesComponent';
import profileComponent from './components/profile/profileComponent'
import dashboardComponent from './components/dashboard/dashboardComponent.vue';


let path = require('path');
let pathDir = path.join(__dirname,'/../');
window.axios = require('axios');
window.$ = $;
window.Pusher = require('pusher-js');

Vue.component('espeOne',require('./components/especialialidades/especialidadOne').default);
Vue.component('citaComponent',require('./components/citas/citaComponent').default);
Vue.component('navlink',require('./components/mainNav/navlinkComponent').default);
Vue.component('citaone',require('./components/citas/citasOne').default);
Vue.component('userOne',require('./components/users/userOne').default);
Vue.component('userComponent',require('./components/users/userComponent').default);
Vue.component('v-select', require(`./components/vue-select`).default);
Vue.component("espcomponent",require("./components/especialialidades/espComponent").default);
Vue.use(axios);
Vue.use(VueRouter);
const router = new VueRouter({
    mode:"history",
    routes:[{
        name:'/home/dashboard',
        path:'/home/dashboard/',
        component:dashboardComponent
    },{
        path:"/citas/:id",
        name:"citas",
        component:citasComponent
    },{
        path:"/profile",
        name:"profile",
        component:profileComponent
    }
    ,{
        path:"/users",
        "name":"users",
        component:usersComponent
    },
    {
        name:"especialidades",
        path:"/especialidades",
        component:especialidadesComponent
    }]
});

const app = new Vue({
    el:"#app",
    router,
    components:{ navbar },
    beforeMount(){
        if(!localStorage.getItem('accessToken')){
            window.location.href="/";
        }
    }
});