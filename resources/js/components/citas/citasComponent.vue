<template>
    <div>
         <div class="content" v-if="showCard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-left" >
                            <button class="btn btn-primary" v-if="showOtherInfo==2" @click="showOtherInfo=1"> <div class="pe-7s-angle-left"></div> Ir atras</button>
                        </div>
                    </div>
                </div>
                <div v-if="showOtherInfo==1"  class="row">
                    <div class="col-md-12 text-center">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">CITAS <div style="display:none">{{this.showOtherInfo=$route.params.show ? $route.params.show : 1 }} {{$route.params.show=null }}</div>  <div style="padding:10px; border-radius:10px; color:white;" :style="styleToAdd" class="animated" v-if="showMsg" :class="classToAdd">{{msg}}</div></h4>
                                <div class="title text-center">
                                    <!--BOTONES DE BUSQUEDA-->
<a class="btn btn-primary"  data-toggle="collapse" href="#buscar" title="buscar una cita" aria-expanded="false" aria-controls="buscar" ><div class="pe-7s-search"></div> Buscar</a>
<a class="btn btn-success" href="#agregar" data-toggle="collapse" aria-expanded="false" aria-controls="agregar" title="agregar una cita"><div class="pe-7s-plus"></div>Agregar</a>
<br>
<br>
<div id="buscar" class="collapse" style="background-color:#DCDCDC; color:black;">
   <form class="form" @submit.prevent="look">
       <div class="container-fluid">
           <div class="row">
               <div class="col-md-6 col-sm-6 col-lg-6">
<div class="col-md-6 col-sm-6 col-lg-6">
  <div class="form-group">
    <label class="color:black !important">id o nombre Paciente</label>
    <input type="text" class="form-control" v-model="lookParams.paciente" id="" placeholder="id paciente">
  </div>
  <div class="form-group">
    <label >id Doctor</label>
    <input type="number" class="form-control" v-model="lookParams.doctor" id="" placeholder="id doctor">
  </div>
</div>
<div class="col-md-6 col-sm-6 col-lg-6">
  <div class="form-group">
    <label >id Cita</label>
    <input type="number" class="form-control" v-model="lookParams.cita" id="" placeholder="id cita">
  </div>
  <div class="form-group">
    <label >ducumento de identidad</label>
    <input type="number" class="form-control" v-model="lookParams.dui" id="" placeholder="documento identidad">
  </div>
</div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6">
                   <div class="col-md-6 col-sm-6 col-lg-6">
               <div class="form-group">
                   <label for="">fecha Creacion</label>
                   <div>
                       <input type="date" name="" id="" class="form-control" v-model="lookParams.fcd" style="display:inline !important">
                       <input style="display:inline !important" v-model="lookParams.fch" type="date" name="" id="" class="form-control">
                   </div>
               </div>
                   </div>
                   <div class="col-md-6 col-sm-6 col-lg-6">
               <div class="form-group">
                   <label for="">fecha Cita</label>
                   <div>
                       <input type="date" name="" id="" class="form-control" v-model="lookParams.fccd" style="display:inline !important">
                       <input style="display:inline !important" v-model="lookParams.fcch" type="date" name="" id="" class="form-control">
                   </div>
               </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6">
               <div class="form-group">
                   <label for="">Estado Cita</label>
                   <div>
                       <select name="" v-model="lookParams.status" id="" class="form-control">
                           <option value="">Todas</option>
                           <option value="1">Activa</option>
                           <option value="0">Inactiva</option>
                           <option value="2">Pendiente</option>
                       </select>
                   </div>
               </div>
               </div>
               <div class="col-md-6 col-sm-6 col-lg-6">
                   <div class="form-group">
                       <label for="">especialidad</label>
                   <v-select :options="especialidades" v-model="modelEspecialidad" >
                            
                        </v-select>
                   </div>
               </div>
               </div>
               <div class="col-md-12 col-sm-12 col-lg-12 text-center">
                   <button class="btn btn-success" >BUSCAR</button>
               </div>
           </div>
       </div>
</form>
</div>
    <div class="collapse" id="agregar">
    <form :class="{errorClass:errorClass,successClass:!errorClass}" style="border: 2px solid green !important; border-radius:10px; padding:10px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6">
    <div class="form-group">
               <label for="">especialidad</label>
           <v-select :options="especialidades" v-model="modelEspecialidadAdd" :class="{'btn-danger':errClassEspecialidad}">
                    
                </v-select>
           </div>
</div>
<div class="col-md-6 col-sm-6">
    <label for="">Usuario</label>
    <v-select :options="users" v-model="modeluserAdd" :class="{'btn-danger':errClassuser}">

    </v-select>
</div>
</div>
<div class="row">

<div class="col-md-6 col-sm-6">
    <div class="form-group">
               <label for="">Doctor</label>
           <v-select :options="doctores" v-model="modelDoctorAdd" :class="{'btn-danger':errClassDoctor}" >
                    
                </v-select>
           </div>
</div>
<div class="col-md-6 col-sm-6">
    <div class="container-fluid">
        <div class="row col-md-6">
<div class="form-group text-center">
               <label for="">Fecha</label><br>
               <input class='form-control' v-model="addParams.fechaCita" :class="{errorClass:errClassfechaCita}" type="date" name="" id="">
           </div>
        </div>
        <div class="row col-md-6">
 <div class="form-group text-center">
               <label for="">Hora</label><br>
               <input class='form-control' v-model="addParams.hora" :class="{errorClass:errClasshora}" type="time" name="" id="">
           </div>
        </div>
    </div>
    
          
</div>
            </div>
        </div>

    <div class="text-center">
        <div class="btn btn-success" @click.prevent="error">AGREGAR</div>
    </div>
    </form>
    </div>
 </div>
                                    
                            </div>
                            <div class="content table-responsive table-full-width">
<table class="table table-hover" >
    <thead>
        <th class="text-center">ID</th>
        <th class="text-center">Foto</th>
        <th class="text-center">paciente</th>
        <th class="text-center">FECHA DE CITA</th>
        <th class="text-center">FECHA DE CREACION</th>
        <th>Estado</th>
    </thead>
    <tbody>
<citaComponent  v-for="(citaIncoming) in citas" :citaV="citaIncoming" :key="citaIncoming.id" @showUp="passTheId(citaIncoming.id)"></citaComponent>
    </tbody>
</table>

        </div>
        
        </div>
      <div class="pagination text-center">
          <li><a @click="look(0)">primera 1</a></li>
           <navlink @pag="look(...arguments)" v-for="index in nav" v-if="index+plusTo<=navLast" :last="navLast" :plus="plusTo" :links="index" :key="index"></navlink>
             <li><a @click="look((navLast-1)*10)">ultima {{navLast}}</a></li>
      </div>
        </div>

        </div>

<div class="row">
<div class="col-md-12" >
    <citaone :citaIn="cit" @deletedCita="deleteCita" v-if="showOtherInfo==2"></citaone>
</div>
</div>

        </div>
        </div>

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
</template>

<script>
import _ from 'lodash';
export default {
    data(){
        return{
            showCard:false,
            styleToAdd:{},
            doctores:[{id:null,label:null}],
            modelEspecialidadAdd:{id:null,label:null},
            modelDoctorAdd:{id:null,label:null},
            users:[{id:null,label:null}],
            modeluserAdd:{id:null,label:null},
            especialidades:[{id:null,label:null}],
            modelEspecialidad:{id:null,label:null},
            showMsg:false,
            msg:'',
            classToAdd:{},
            showOtherInfo:1,//$route.params.show ?$route.params.show :1,
            citas:[],
            showSP:true,
            lookParams:{
                limit:true,
                especialidad:null,
                paciente:null,
            doctor:null,
            fcd:null,
            fch:null,
            fccd:null,
            fcch:null,
            cita:null,
            status:null,
            dui:null,
            pag:0
            },
            nav:0,
            plusTo:0,
            navLast:0,
            cit:null,
            errorClass:false,
            successfullAdd:false,
            addParams:{
                usuario:null,
                fechaCita:null,
                especialidad:null,
                doctor:null,
                hora:null
            },
            errClassEspecialidad:false,
            errClassDoctor:false,
            errClassuser:false,
            errClassfechaCita:false,
            errClasshora:false

        }
    },
    methods:{
        loadInfo(){

        axios.get('/api/api/citas',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')}}).then((resolve)=>{ 
            this.showCard=true;
            this.citas = JSON.parse(JSON.stringify(resolve.data));
        this.nav = 10;
        this.navLast=Math.ceil(JSON.parse(JSON.stringify(this.citas[10]))[0].count/10);
        this.citas.pop();
        
        }).catch((rej)=>{console.log(rej);
        });
        },
        loadEsp(){
            axios.get('/api/api/citasespe',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')}}).then((resolve)=>{
                    this.especialidades = JSON.parse(JSON.stringify(resolve.data));
                    
                }).catch((reject)=>{
                    console.log(reject);
                });

        },
        deleteCita(){
            this.classToAdd={
                "fadeInLeft":true,
                }
                this.styleToAdd={
                    "background-color":"red"
                };
            this.msg="CITA BORRADA";
            this.showMsg=true;
            this.look();
            this.showOtherInfo=1;
            setTimeout(() => {
                this.classToAdd={
                "fadeOutRight":true,}
            
            setTimeout(() => {
                this.showMsg=false;
                this.msg="";
            }, 3000);
            },3000);
        },
        passTheId(id){
            this.cit = id;
            this.showOtherInfo=2;
        },
        look(e){
            (!isNaN(e)) ? this.lookParams.pag = e : this.lookParams.pag=0;

                if(this.lookParams.pag/10 >= 9){
                    this.plusTo = (this.lookParams.pag/10)-8;
                }else{
                    this.plusTo =0;
                }
                if(this.modelEspecialidad){
    this.lookParams.especialidad = this.modelEspecialidad.id;
                }else{
                    this.lookParams.especialidad=null;
                }
                axios.get('/api/api/citasearch',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
this.citas = JSON.parse(JSON.stringify(resolve.data));
this.nav =10  
this.navLast=Math.ceil(JSON.parse(JSON.stringify(this.citas[this.citas.length-1]))[0].count/10);
this.citas.pop();


                }).catch((reject)=>{console.log(reject);
                });
        },
        //RETRIVING THE USERS FOR ADD A NEW DATE IN THE SYSTEM 
        loadUserV(){
            axios.get('/api/api/vselectuser',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:{"isdoctor":false}}).then((resolve)=>{
                this.users=JSON.parse(JSON.stringify(resolve.data));
                
            }).catch((reject)=>{
                console.log(reject);
                
            });
            
        },
        error(){
           if(this.modelEspecialidadAdd.id==null || this.modelDoctorAdd.id==null || this.modeluserAdd==null || !this.addParams.fechaCita || !this.addParams.hora || new Date(this.addParams.fechaCita+' '+this.addParams.hora).getTime() < new Date().getTime() ){

               this.errorClass=true;
               
               if(this.modelEspecialidadAdd.id==null ){
                   this.errClassEspecialidad = true;
               }else{
                   this.errClassEspecialidad = false;
               }
               if(this.modelDoctorAdd.id==null){
                   this.errClassDoctor = true;
               }else{
                   this.errClassDoctor = false;
               }
               if(this.modeluserAdd.id==null){
                   this.errClassuser = true;
               }else{
                   this.errClassuser = false;
               }
               if(!this.addParams.fechaCita){
                   this.errClassfechaCita = true;
               }else{
                   this.errClassfechaCita = false;
               }
               if(!this.addParams.hora){
                   this.errClasshora = true;
               }else{
                   this.errClasshora = false;
               }
               if(new Date(this.addParams.fechaCita+' '+this.addParams.hora).getTime() < new Date().getTime()){
                   this.errClasshora = true;
                   this.errClassfechaCita = true;
               }else{
                   this.errClasshora = false;
                   this.errClassfechaCita = false;
               }
           }else{
               this.errorClass=false;
               this.errClassEspecialidad=false;
               this.errClassuser=false;
               this.errClassfechaCita=false;
               this.errClasshora=false;
               this.errClassDoctor=false;
               this.addCita();
           }
        },
        addCita(){
                axios.get('/api/api/addcita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.addParams}).then((resolve)=>{
                    this.look();
                   this.classToAdd={
                "fadeInLeft":true,
                }
            this.msg="CITA AGREGADA";
            this.showMsg=true;
            this.look();
            this.showOtherInfo=1;
            this.styleToAdd={
                "background-color":"green"
            };
            setTimeout(() => {
                this.classToAdd={
                "fadeOutRight":true,
                }

            setTimeout(() => {
                this.showMsg=false;
                this.msg="";
            }, 3000);
            },3000);
                }).catch((reject)=>{
                    
                });
        },
    },
    watch:{
        modelDoctorAdd:function(){
            if (this.modelEspecialidadAdd==null || this.modelDoctorAdd==null) {
                this.modelDoctorAdd={id:null,label:null};
                this.errClassDoctor=true;
            }else{
                this.addParams.doctor=this.modelDoctorAdd.id;
                this.errClassDoctor=false;
            }
        },
        modelEspecialidadAdd:function (){
         
            
            if(this.modelEspecialidadAdd==null){
                this.doctores=[{id:null,label:null}];
                this.modelDoctorAdd={id:null,label:null};
                this.modelEspecialidadAdd={id:null,label:null};
                this.errClassEspecialidad=true;
            }else{
                this.errClassEspecialidad=false;
                this.addParams.especialidad=this.modelEspecialidadAdd.id;

            axios.get('/api/api/doctorcita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.modelEspecialidadAdd}).then((resolve)=>{
                    this.doctores = JSON.parse(JSON.stringify(resolve.data));
                }).catch((reject)=>{console.log(reject);
                });
        }
        },
        modeluserAdd:function (){
            if (this.modeluserAdd==null) {
                this.modeluserAdd={id:null,label:null};
                this.errClassuser=true;
            } else {
                this.addParams.usuario = this.modeluserAdd.id;
                this.errClassuser=false;
            }
        },

    },
    created(){
        this.loadUserV();
        this.loadInfo();
        this.loadEsp();
    }
}
</script>

<style>
.errorClass{
    border:2px solid red !important;
}
.successClass{
    border:2px solid dodgerblue;
}
</style>