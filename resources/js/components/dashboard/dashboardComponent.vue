<template>
<div>
    <div class="card" style="padding:10px">
        <div class="card-header">
            <div class="card-title"><h4>Citas de ahora {{todayComputed}} </h4></div>
        </div>
        <div class="card-body">
            <div style="overflow-y: auto; height:300px; " class="content table-responsive table-full-width">
<table class="table table-hover" v-if="showCard">
    <thead>
        <th class="text-center">ID</th>
        <th class="text-center">Foto</th>
        <th class="text-center">cita</th>
        <th class="text-center">Estado</th>
        <th class="text-center">Accion</th>
    </thead>
    <tbody>
<citaComponent  v-for="(citaIncoming) in citas" :showButton=true :citaV="citaIncoming" :key="citaIncoming.id" ></citaComponent>
    </tbody>
</table>
<div v-else>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="/img/temsys/loading.gif" alt="" width="100pc">
                    </div>
                </div>
            </div>
</div>
    </div>
        </div>
    </div>

    </div>
</template>


<script>
export default{
    data(){
        return{
            showCard:false,
            citas:null
        }
    },
    methods:{
        loadInfo(){

        axios.get('/api/api/citasearch',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:{fccd:`${new Date().getFullYear()}-${parseInt(new Date().getMonth())+1}-${new Date().getDate()}`,statuslook:1}}).then((resolve)=>{

            this.showCard=true;
            this.citas = JSON.parse(JSON.stringify(resolve.data));
        this.citas.pop();
        
        }).catch((rej)=>{console.log(rej);
        });
        }
    },
    computed:{
        todayComputed(){
            moment.locale("es");
            return moment().format('dddd DD MMMM YYYY');
        }
    },
    created(){
        this.loadInfo();
    }
}



</script>