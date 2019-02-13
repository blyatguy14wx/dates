<template>
   <div>
<div v-if="showCard">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="text-left">
              <button class="btn btn-primary" v-if="showOtherInfo==2" @click="showOtherInfo=1">
                <div class="pe-7s-angle-left"></div>Ir atras
              </button>
            </div>
          </div>
        </div>
        <div v-if="showOtherInfo==1" class="row">
          <div class="col-md-12 text-center">
            <div class="card">
              <div class="header">
                <h4 class="title">especialidades
                  <div
                    style="padding:10px; border-radius:10px; color:white;"
                    :style="styleToAdd"
                    class="animated"
                    v-if="showmsg"
                    :class="classToAdd"
                  >{{msg}}</div>
                </h4>
                <div class="title text-center">
                    <form action="" @submit.prevent="clicklook">
                      <input type="text" :class="err.name" name="" v-model="esp"  id="" placeholder="Nombre Especialidad a Buscar" class="form-control">
                    </form>
                  <!--BOTONES DE BUSQUEDA-->
                  <a
                    class="btn btn-primary"
                    href="#"
                    title="buscar una cita"
                    aria-controls="buscar"
                    @click="clicklook"
                  >
                    <div class="pe-7s-search"></div>Buscar
                  </a>
                  <a
                    class="btn btn-success"
                    href="#agregar"
                    data-toggle="collapse"
                    aria-expanded="false"
                    aria-controls="agregar"
                    title="agregar una cita"
                    @click="addEsp"
                  >
                    <div class="pe-7s-plus"></div>Agregar
                  </a>
                  <br>
                  <br>
                </div>
              </div>
              <div class="content table-responsive table-full-width">
                <table class="table table-hover">
                  <thead>
                    <th class="text-center">ID</th>
                    <th class="text-center">Especialidad</th>
                  </thead>
                  <tbody>
                      <espcomponent
                       v-for="(espEcial) in especialidades"
                      :esp="espEcial"
                      :key="espEcial.id"
                      @showO="showEsp(espEcial)"
                      >
                      </espcomponent>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="pagination text-center">
              <li>
                <a @click="look(0)">primera 1</a>
              </li>
              <navlink
                @pag="look(...arguments)"
                v-for="index in nav"
                v-if="index+plusTo<=navLast"
                :last="navLast"
                :plus="plusTo"
                :links="index"
                :key="index"
              ></navlink>
              <li>
                <a @click="look((navLast-1)*10)">ultima {{navLast}}</a>
              </li>
            </div>
          </div>
        </div>
            <div class="row">
              <espeOne v-if="showOtherInfo==2" @delete="deleteThis" :espV="espV"></espeOne>
            </div>
        <div class="row">
          <div class="col-md-12">
          </div>
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
export default {
    data(){
        return{
          showCard:false,
            nav:10,
            plusTo:0,
            navLast:100,
            showOtherInfo:1,
            styleToAdd:{},
            classToAdd:{},
            msg:"",
            showmsg:false,
            especialidades:[],
            lookParams:{
                pag:0,
                name:null,
                id:null
            },
            err:{
              name:false
            },
            espV:null,
            esp:""
        }
    },
    methods:{
        look(e){
            (!isNaN(e)) ? this.lookParams.pag = e : this.lookParams.pag=0;

                if(this.lookParams.pag/10 >= 9){
                    this.plusTo = (this.lookParams.pag/10)-8;
                }else{
                    this.plusTo =0;
                }
                // we make the request 
                axios.get('/api/api/especialidades',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
                    this.showCard=true;
this.especialidades = JSON.parse(JSON.stringify(resolve.data));
this.nav =10  
this.navLast=Math.ceil(JSON.parse(JSON.stringify(this.especialidades[this.especialidades.length-1]))[0].count/10);
this.especialidades.pop();

                }).catch((reject)=>{
                  console.info(reject.data);
                });
        },
        error(){

        },
        showEsp(id){
          this.espV=id;
          this.showOtherInfo=2;
        },
        clicklook(){
          this.err.name={
              "red":false,
            };
            this.lookParams.name=this.esp;
            this.look();
          
        },
        addEsp(){
          if(this.esp != ""){
            this.err.name={
              "red":false,
              "animated":false,
              "shake":false,
            };
            axios.get("/api/api/addesp",{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{"name":this.esp} }).then((resolve)=>{
              this.showMsg("Agregado correctamente",{"background-color":"dodgerblue","color":"white"});
            }).catch((reject)=>{
              this.showMsg("Ya existe una especialidad con ese nombre",{"background-color":"red","color":"white"});
            });
           this.look();
          }else{
             this.err.name={
              "red":true,
              "animated":true,
              "shake":true,
            };
            
            this.showMsg("El nombre no puede estar vacio",{"background-color":"red","color":"white"});
          }
        },
        showMsg(msg,style){
            this.showmsg=true;
            this.msg=msg;
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
          this.showMsg("Especialidad Correctamente Borrada con toda su informacion",{"background-color":"dodgerblue","color":"white"});
          this.showOtherInfo=1;
          this.look();
        }
    },
    created(){
        
        this.look();
    }
}
</script>

<style>
.red{
  border: 2px solid red;
}
</style>
