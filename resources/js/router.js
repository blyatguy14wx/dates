import axios from 'axios';
import Vue from 'vue';

Vue.use(axios);

Vue.component('routerc',require('./components/routerComponent').default);

const app = new Vue({
    el:"#showUp",
    beforeCreate(){
        if(localStorage.getItem('accessToken')){
            axios.get('/api/api/user',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:{email:localStorage.getItem('email')}}).then((resolve)=>{
                location.href="/home/dashboard";
            }).catch((reject)=>{
                location.href="/login";
            });
            
        }else{
            location.href="/login";
        };
    }
})