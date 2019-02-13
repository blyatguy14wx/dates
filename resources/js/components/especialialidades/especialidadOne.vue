<template>
    <div>
       <div class="container-fluid">
           <div class="row">
               <div class="col-md-12">
                   <div class="card" style="padding:10px">
                       <div class="card-header">
                           <h4 class="card-title">Especialidad #{{this.espV.id}}</h4>
                            <div
                    style="padding:10px; border-radius:10px; color:white;"
                    :style="styleToAdd"
                    class="animated"
                    v-if="showMsg"
                    :class="classToAdd"
                  >{{msgmsg}}</div>
                       </div>
                       <div class="card-body">
                           
                           <div class="container-fluid">
                               <div class="row">
                                   <div class="col-md-4">
                                       <form @submit.prevent="error" action="" class="form">
                               <h4 for="">Especialidad</h4>
                             <input type="text" class="form-control" :class="classToAdd" v-model="espV.name">
                           </form>
                                   </div>
                                   <div class="col-md-4">
                               <h4 for="">Creado</h4>
                           <div>{{ momentCreatedAt }}</div>
                                   </div>
                                   <div class="col-md-4">
                                       <button class="btn-primary btn" @click.prevent="error">Actualizar</button>
                                       <button class="btn-danger btn" @click.prevent="deleteThis">Eliminar</button>
                                       <br><input type="checkbox" name="" v-model="deleteAgree" id="">Estoy de acuerdo en borrar este dato
                                       </div>
                               </div>
                           <br>
                           <br>
                           <div class="row">
                               <div class="col-md-12">
                                   <h2 class="text-left">
                                       Citas
                                   </h2>
                               </div>
                           </div>
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="alert alert-info" style="color:white">
                               <h4>Citas Activas</h4> <div class="text-right">{{citas==null ? "not loaded yet":citas[0].active}}</div>
                           </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="alert alert-warning" style="color:white">
                               <h4>Citas Pendientes</h4>  <div class="text-right">{{citas==null ? "not loaded yet":citas[0].pendient}}</div>
                           </div>
                           <div class="ct-chart"></div>
                           <h4 class="text-center alert alert-success">
                             Total de citas: {{ citas == null ? '':total }}
                           </h4>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="alert alert-danger" style="color:white">
                               <h4>Citas Desactivadas</h4>  <div class="text-right">{{citas==null ? "not loaded yet":citas[0].deactive}}</div>
                           </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <br>
                   <br>
                   <div class="card" style="border:1px.solid black">
                       <div class="card-header">
                           <div class="card-title" style="padding:10px">
                               <h2>Informacion General</h2>
                           </div>
                       </div>
                       <div class="body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-info">
                                        <h4>Doctores con esta especialidad</h4>
                                        <h3>{{ citas == null ? "loading" : citas[1][0].doctors}}</h3>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <h4>Pacientes atendidos</h4>
                                        <h3>{{ citas == null ? "loading" : citas[1][0].pacientes}}</h3>
                                    </div>
                                </div>
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
import Chartist from 'chartist';
export default {
    
    props:["espV"],
    data(){
        return{
            showInfo:false,
            citas:null,
            s:0,
            showmsg:false,
            msgmsg:"",
            classToAdd:{},
            styleToAdd:{},
            deleteAgree:false
        }
    },
    computed:{
        momentCreatedAt:function (){
            moment.locale('es');
            return moment(this.espV.created_at).format('DD MMMM YYYY');
        },
        total:function(){
            for(let a in this.citas[0]){
                this.s+=parseInt(this.citas[0][a]);
            }
             return this.s;
        }
    },
    created(){
        axios.get('/api/api/especialdadone',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{id:this.espV.id}}).then((resolve)=>{
            this.showInfo=true;
            this.citas=JSON.parse(JSON.stringify(resolve.data));
            this.chartist();
        }).catch((reject)=>{

        });
    },
    methods:{
        chartist(){
           new Chartist.Pie('.ct-chart',
            {
                series:[parseInt(this.citas[0].active),parseInt(this.citas[0].deactive),parseInt(this.citas[0].pendient)]
            },{
                labelInterpolationFnc:function(val){
                    return val;
                }
            }
            );
        },
        error(){
            if(this.espV.name!=""  && this.espV.name != null){
                this.updateEsp();
            }else{
                this.showMsg("Error faltan algunos campos",{"background-color":"red","color":"white"});
            }
        },
        updateEsp(){
            axios.get("/api/api/updateesp",{headers:{Authorization:`Bearer `+localStorage.getItem('accessToken')},params:{name:this.espV.name,id:this.espV.id}}).then((resolve)=>{
                this.showMsg("Actualizado Correctamente",{"background-color":"dodgerblue","color":"white"});
            }).catch((reject)=>{
                    this.showMsg("Error ya existe esa especialidad",{"background-color":"red","color":"white"});
            });
        },
        showMsg(msg,style){
            this.showmsg=true;
            this.msgmsg=msg;
            this.classToAdd={
                "fadeInLeft":true
            };
            this.styleToAdd=style;
            setTimeout(()=>{
                this.classToAdd={
                    "fadeOutRight":true
                }
            },3000);
            setTimeout(()=>{
                this.showmsg=false;
            },5000);
        },
        deleteThis(){
            if(this.deleteAgree){
                axios.get('/api/api/deleteesp',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{id:this.espV.id}}).then((resolve)=>{
                this.$emit("delete");
            }).catch();
            }else{

            }
        }
    }
}
</script>
