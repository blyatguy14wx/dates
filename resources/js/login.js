import Vue from 'vue';


Vue.component('login-component',require('./components/loginComponent').default);

require('./bootstrap');


const app = new Vue({
    el:"#loginId"

});
