<template>
  <div>
    <div class="content" v-if="showCard">
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
                <h4 class="title">USUARIOS
                  <div
                    style="padding:10px; border-radius:10px; color:white;"
                    :style="styleToAdd"
                    class="animated"
                    v-if="showMsg"
                    :class="classToAdd"
                  >{{msg}}</div>
                </h4>
                <div class="title text-center">
                  <!--BOTONES DE BUSQUEDA-->
                  <a
                    class="btn btn-primary"
                    data-toggle="collapse"
                    href="#buscar"
                    title="buscar una cita"
                    aria-expanded="false"
                    aria-controls="buscar"
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
                  >
                    <div class="pe-7s-plus"></div>Agregar
                  </a>
                  <br>
                  <br>
                  <div id="buscar" class="collapse" style="background-color:#DCDCDC; color:black;">
                    <form class="form" @submit.prevent="look">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                              <div class="form-group">
                                <label class="color:black !important">nombre Usuario</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  v-model="lookParams.name"
                                  id
                                  placeholder="nombre Usuario"
                                >
                              </div>
                              <div class="form-group">
                                <label>email</label>
                                <input
                                  type="text"
                                  class="form-control"
                                  v-model="lookParams.email"
                                  id
                                  placeholder="email"
                                >
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                              <div class="form-group">
                                <label>id Usuario</label>
                                <input
                                  type="number"
                                  class="form-control"
                                  v-model="lookParams.id"
                                  id
                                  placeholder="id Usuario"
                                >
                              </div>
                              <div class="form-group">
                                <label>ducumento de identidad</label>
                                <input
                                  type="number"
                                  class="form-control"
                                  v-model="lookParams.dui"
                                  id
                                  placeholder="documento identidad"
                                >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                              <div class="form-group">
                                <label for>Edad</label>
                                <div>
                                  
                                  <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <input
                                    type="number"
                                    name
                                    id
                                    class="form-control"
                                    v-model="lookParams.aged"
                                    style="display:inline-block !important"
                                  >
                                      </div>
                                      <div class="col-md-6">
                                        <input
                                    style="display:inline-block !important"
                                    v-model="lookParams.ageh"
                                    type="number"
                                    name
                                    id
                                    class="form-control"
                                  >
                                      </div>
                                    </div>
                                  </div>
                                  
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label for>Rol</label>
                                <div>
                                  <select name="" v-model="lookParams.rol" id="" class="form-control">
                                      <option value="">Todos</option>
                                      <option value="TRUE">Administrador</option>
                                      <option value="FALSE">Normal</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                              <div class="form-group">
                                <label for>TIPO</label>
                                  <select name v-model="lookParams.doctor" class="form-control">
                                    <option value>Todos</option>
                                    <option value="FALSE">paciente</option>
                                    <option value="TRUE">doctor</option>
                                  </select>
                              </div>
                               <div class="form-group"  v-if="this.lookParams.doctor=='TRUE'">
                                <label for>especialidad Buscar</label>
                                <v-select :options="especialidades" v-model="especialidadModel"></v-select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for>Estado Usuario</label>
                            <select name="" id="" class="form-control" v-model="lookParams.allow">
                              <option value="0">Todos</option>
                              <option value=true>Activo</option>
                              <option value=false>Inactivos</option>
                            </select>
                          </div>

                            <div class="col-md-6" v-if="this.lookParams.doctor=='TRUE'">
                              <div class="table table-stripped table-responsive">
                                       <table class="table table-hover animated">
                                       <thead>
                                           <tr>
                                               <th  class="text-center">Id</th>
                                               <th  class="text-center">Especialidad</th>
                                               <th class="text-center">Accion</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                           <tr v-for="(especialidad,index) in espelidadesList" :key="index">
                                           <td class="text-center">{{especialidad.id}}</td>
                                           <td class="text-center">{{especialidad.label}}</td>
                                           <td @click="deleteEspecialidad(index)" class="text-center" ><div class="pe-7s-close" style="color:red;width:100px;heigth:100px"></div></td>
                                           </tr>
                                       </tbody>
                                       </table>
                                   </div>
                            </div>

                          <div class="col-md-12 col-sm-12 col-lg-12 text-center">
                            <button class="btn btn-success">BUSCAR</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="collapse" id="agregar">
                    <div>

                      <form class="form" @submit.prevent="error">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="container-fluid">

                          <div class="row">
                            <div class="col-sm-12 col-md-6">
                              <div class="form-group">
                          <label for="">Nombre Usuario</label>
                          <input type="text" name="" id="" class="form-control" placeholder="nombre de usuario" v-model="addParams.name" :class="{'redCubic':errorName}">
                        </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                               <div class="form-group">
                          <label for="">Edad Usuario</label>
                          <input type="text" name="" id="" class="form-control" placeholder="nombre de usuario" v-model="addParams.age" :class="{'redCubic':errorA}">
                        </div>
                            </div>
                          </div>


                      <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <v-select :options="especialidades" v-model="esp" :class="{'btn-danger':errorEsp}">
                            
                        </v-select>
                            </div>
                          </div>

                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="container-fluid">
                                <div class="row">
                                  <!--SECOND ADD COLUMN-->
<div class="col-md-12">
  <div class="form-group">
    <label for="">email</label>
    <input type="text" name="" id="" required v-model="addParams.email" class="form-control" :class="{'redCubic':errorEmail}">
  </div>
</div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
  <div class="form-group">
    <label for="">Foto</label>
    <img id="fotoSrc"  width="60px" height="60px" class="img-circle">
    <input type="file" name="" id="foto" @change="readURL">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label for="">Rol</label>
    <select name="" id="" class="form-control" v-model="addParams.admin" :class="{'redCubic':errorAdmin}">
      <option value="TRUE">Administrador</option>
      <option value="FALSE">Normal</option>
    </select>
  </div>
</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <button class="btn btn-success" @click.prevent="error">Agregar Doctor</button>
                            </div>
                          </div>
                        </div>
                      </form>

                    </div>

                  </div>
                </div>
              </div>
              <div class="content table-responsive table-full-width">
                <table class="table table-hover">
                  <thead>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">email</th>
                    <th class="text-center">Contacto</th>
                    <th class="text-center">Rol</th>
                     <th class="text-center">Tipo</th>
                      <th class="text-center">Edad</th>
                       <th class="text-center">Documento Ident</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                    <userComponent
                      v-for="(userIcoming) in users"
                      :userV="userIcoming"
                      :key="userIcoming.id"
                      @showUp="passTheId(userIcoming.id)"
                    ></userComponent>
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
          <div class="col-md-12">
            <userOne :userIn="us" @deletedUser="deletedUserOne" v-if="showOtherInfo==2"></userOne>
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
import $ from 'jquery';
export default {
  data() {
    return {
      especialidadAddToList:null, //this are avriables for the esp search
      especialidadModel:[{id:null,label:null}],
      espelidadesList:[],//END***
      showCard:false,
      csRf:"",
        showOtherInfo:1,
        showMsg:false,
        users:[],
        lookParams:{
            pag:0,
            dui:null,
            rol:null,
            status:null,
            email:null,
            aged:null,
            ageh:null,
            id:null,
            name:null,
            doctor:null,
            esp:null,
            allow:null
        },
        classToAdd:{},
        addParams:{
          name:null,
          dui:null,
          admin:null,
          isdoctor:true,
          isallow:true,
          email:null,
          age:null,
          country:null,
          esp:[{id:null,label:null}],
          img:false
        },
        styleToAdd:{
          'background-color':'crimson'
        },
        errorA:false,
        errorName:false,
        errorEmail:false,
        errorEsp:false,
        errorAdmin:false,
        errorRol:false,
        nav:10,
        navLast:0,
        plusTo:0,
        especialidades:[{id:null,label:null}],
        us:null,
        esp:null,
        emailMatch:new RegExp('[a-z]@[a-z][a-z]',""),
        err:0,
        general:false,
        success:false,
        msg:"",
        errorsthis:{},
        srcFoto:false,
        espLook:[{id:null,label:null}]
    };
  },
  methods:{
    deleteEspecialidad(index){
            this.espelidadesList.splice(index,1);
        },
      look(e){
            (!isNaN(e)) ? this.lookParams.pag = e : this.lookParams.pag=0;

                if(this.lookParams.pag/10 >= 9){
                    this.plusTo = (this.lookParams.pag/10)-8;
                }else{
                    this.plusTo =0;
                }
                // hacemos el request 
                if(this.espLook!=null){
                  this.lookParams.esp=this.espLook.id
                }else{
                  this.espLook=null;
                  this.lookParams.esp=null;
                }
                axios.get('/api/api/searchuser',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
                  this.showCard=true;
this.users = JSON.parse(JSON.stringify(resolve.data));
this.nav =10  
this.navLast=Math.ceil(JSON.parse(JSON.stringify(this.users[this.users.length-1]))[0].count/10);
this.users.pop();


                }).catch((reject)=>{
                  console.info(reject.data);
                });
        },
        deletedUserOne(){
          this.showOtherInfo=1;
          this.look();
          this.msg="Eliminado Correctamente";
    this.showMsg=true;
    this.classToAdd={
      'fadeInRight':true,
    }

    setTimeout(()=>{
      this.classToAdd={
      'fadeOutLeft':true,
    }
    },3000);
    setTimeout(()=>{
      this.showMsg=false;
    },6000);
    this.styleToAdd={
      'background-color':'red'
    };
        },

        passTheId(id){
            this.us = id;
            this.showOtherInfo=2;
        },
readURL() {
  let foto = document.getElementById("foto");

  if(foto.files && foto.files[0]){
    let fileReader = new FileReader();
    let imgSrc = document.getElementById("fotoSrc");
    fileReader.onload = function(e){
      imgSrc.src = e.target.result;
    };
   fileReader.readAsDataURL(foto.files[0]);
  }
},
error(){

  
  this.err=0;
  if(!this.addParams.name){
    this.errorName = true;
    this.err= this.err+1;
    
  }else{
    this.errorName = false;
  }
   if(!this.addParams.age){
    this.errorA = true;
    this.err= this.err+1;
  }else{
    this.errorA = false;
  }

if(!this.esp){
    this.errorEsp = true;
    this.err= this.err+1;
  }else{
    this.errorEsp = false;
  }
  if(!this.addParams.email || this.addParams.email.match(this.emailMatch)==null){
    this.errorEmail = true;
    this.err= this.err+1;
  }else{
    this.errorEmail = false;
  }
  if(!this.addParams.admin){
    this.errorAdmin = true;
    this.err= this.err+1;
  }else{
    this.errorAdmin = false;
  }
  if(this.err == 0){
    this.addUser();
    this.general=false;
   
  }else{
     this.errorMsg("faltan algunos campos");
  }
}
,
loadEsp(){
  axios('/api/api/citasespe',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`}}).then((resolve)=>{
    this.especialidades = JSON.parse(JSON.stringify(resolve.data));
  });
},
addUser(){
  let fotoSrc = document.getElementById("fotoSrc");
  this.srcFoto = fotoSrc.src; 
  this.addParams.img=true;
  console.log(this.addParams.img);
  axios.get("/api/api/adduser",{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`,'Accept':'application/json',"X-CSRF-TOKEN":this.csRf},params:this.addParams}).then((resolve)=>{
    this.msg="AGREGADO CORRECTAMENTE";
    this.showMsg=true;
    if(JSON.parse(JSON.stringify(resolve.data)).urlDecode){
      axios.post('/api/dumpurl/daolpu/gmi/edocsutatstihw/oskqisnfposaikan',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{"newUser":JSON.parse(JSON.stringify(resolve.data)).newUser,"urlDecode":JSON.parse(JSON.stringify(resolve.data)).urlDecode,"img":this.srcFoto}}).then((resolve)=>{});
    }
    this.classToAdd={
      'fadeInRight':true,
    }

    setTimeout(()=>{
      this.classToAdd={
      'fadeOutLeft':true,
    }
    },3000);
    setTimeout(()=>{
      this.showMsg=false;
    },6000);
    this.styleToAdd={
      'background-color':'dodgerblue'
    };
    this.look();
  }).catch((reject)=>{
   
    this.errorsthis = JSON.parse(JSON.stringify(reject.response.data)).email;

    this.msg="ERROR ALGUNOS CAMPOS NO CONCUERDAN";

    if(this.errorsthis){
this.msg="el correo electronico ya se encuentra registrado";
this.errorEmail=true;
    }else{
      this.msg="ERROR ALGUNOS CAMPOS NO CONCUERDAN";
      this.errorEmail=false;
    }
    this.errorMsg(this.msg);
  });
},
errorMsg(messeger){
  this.classToAdd={
          'redCubic':true,
          'fadeInLeft':true
        }
        setTimeout(()=>{
 this.classToAdd={
          'redCubic':true,
          'fadeOutRight':true
        }
        },3000);
this.styleToAdd={
  'background-color':'red'
}
        setTimeout(()=>{
          
        this.showMsg=false;
        },6000);
    this.msg=messeger;
    this.showMsg=true;
    this.general=true;
},
  },
  
  created(){
      this.look();
      this.loadEsp();
      
        let csrf = document.getElementById("csrf-token");
        this.csRf = csrf.content;
  },
  watch:{
    esp:function() {
      if(this.esp==null){
        this.addParams.esp=null;
        this.errorEsp=true;
      }else{
        this.addParams.esp=this.esp.id;
        this.errorEsp=false;
      }
    },
    
  especialidadModel:function(){
            if(this.especialidadModel!=null){
                this.especialidadAddToList=this.especialidadModel;
                this.espelidadesList.filter((es)=>{
                    if(es.id==this.especialidadModel.id){
                     this.especialidadAddToList=null;
                    }
                });
                if(this.especialidadAddToList!=null){
                    this.espelidadesList.push(this.especialidadAddToList);
                }
            }
        }
  },
        
};
</script>

<style>

.redCubic{
border: 2px solid crimson;
}

</style>
