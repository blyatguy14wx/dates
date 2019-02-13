<template>
    <div>
       <div class="container-fluid" v-if="showCard">
           
           <div class="row">
               <div class="col-md-8">
                    <div class="card animated fadeInDown" :class="{blue:this.success,red:this.errCard,shake:this.errCard}" style="paddding:10px">
                        <div class="header">
                            <div class="card-title">
                             <h2>Usuario {{this.user.id}} <div v-if="showmsg" class="animated"  :style="styleToAdd" :class="classToAdd" style="border-radius:10px; padding:10px; display:inline-block">{{msgmsg}}</div></h2>
                            </div>
                        </div>
                <div class="card-body">
                    <form action="" class="form" @submit.prevent="errors" style="padding:10px">
                       <div class="cotainer-fluid">
                           <div class="row">
                               <div class="col-md-4">
                                    <div class="form-group">
                            <label for="">Nombre</label>
                            <input type="text" v-model="name" :class="{red:err.name,shake:err.name}" class="form-control animated">
                        </div>
                               </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                            <label for="">Edad</label>
                            <input type="number" v-model="age" :class="{red:err.age,shake:err.age}" class="form-control animated">
                        </div>
                               </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" v-model="email" :class="{red:err.email,shake:err.email}" class="form-control animated">
                        </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col-md-4">
                                   <div class="form-group">
                                       <label for="">Contacto</label>
                                       <input type="text" name="" id="" :class="{red:err.contacto,shake:err.contacto}" v-model="contacto" class="form-control animated">
                                   </div>
                               </div>
                               <div class="col-md-4">
                                    <div class="form-group" v-if="fromOther">
                                        <label for="">Rol</label>
                                        <div class="btn btn-success" v-if="isAdmin==true">Administrador</div>
                                        <div class="btn btn-primary" v-else>Normal</div>
                                   </div>
                                   <div v-else>
                                   <div class="form-group">
                                       <label for="">Rol</label>
                                       <select name="" id="" class="form-control" :class="{green:isAdmin,blue:!isAdmin}" v-model="isAdmin">
                                           <option value="false" :selected="!isAdmin">Normal</option>
                                           <option value="true" :selected="isAdmin">Administrador</option>
                                       </select>
                                   </div>
                                   </div>
                               </div>
                               <div class="col-md-4">
                                   <div class="form-group" v-if="fromOther">
                                        <label for="">Estado </label>
                                        <div class="btn btn-success">Activado</div>
                                   </div>
                                   <div v-else>
                                       <label for="">Estado </label>
                                       <select name="" id="" class="form-control" :class="{green:isAllow,danger:!isAllow}"  v-model="isAllow">
                                           <option value="false" :selected="!isAllow">Desactivado</option>
                                           <option value="true" :selected="isAllow">Activado</option>
                                       </select>
                                   </div>
                               </div>
                           </div>

            <div class="row"  v-if="fromOther">
                <div class="col-md-12">
                        <div class="container-fluid">
                            <label for=""  v-if="btnPass==0">Contraseña Actual</label>
                            <label for=""  v-if="btnPass==1">Contraseña Nueva</label>
                            <label for=""  v-if="btnPass==2">Reingrese Contraseña</label>
                            <div class="row">
                                <div class="col-md-8 animated" v-if="btnPass==0" :class="{'fadeInRight':btnPass!=0}">
                                     <div class="btn btn-primar" v-if="changePass" @click="changePass=false">Cambiar Contraseña</div>
                                    <input autofocus type="password" @submit.prevent="btnPassFun" v-if="!changePass" name="" id="" :class="{red:oldPass,shake:oldPass}" v-model="password[0]" class="form-control animated">
                                    </div>
                                <div class="col-md-8 animated" v-if="btnPass==1" :class="{'fadeInRight':btnPass!=1}"> 
                                   
                                    <input autofocus type="password" @submit.prevent="btnPassFun" name="" id="" :class="{red:passOne,shake:passOne}" v-model="password[1]" class="form-control animated">
                                    <p class="alert alert-danger animated shake" v-if="showAlertNotMatch">Las contraseñas no coinciden</p>
                                    </div>
                                <div class="col-md-8 animated"  v-if="btnPass==2" :class="{'fadeInRight':btnPass!=2}"> 
                                   
                                    <input autofocus type="password" @submit.prevent="btnPassFun" name="" id="" :class="{red:passTwo,shake:passTwo}" v-model="password[2]" class="form-control animated">
                                    </div>
                                    <div class="col-md-2">
                                    <div class="btn btn-warning" v-if="!updatePassBtn && !changePass"  @click="btnPassFun">
                                        Cambiar
                                    </div>
                                    <div class="btn btn-primary" v-if="updatePassBtn" @click="updatePass">
                                        Actualizar
                                    </div>
                                   </div>
                                   <div class="col-md-2">
                                    <div class="btn btn-danger"  v-if="!changePass" @click="resetPass">
                                        Cancelar
                                    </div>
                                   </div>
                            </div>
                        </div>
                </div>
            </div>

                           <div class="row">
                               <div class="col-md-6">
                                  <div class="form-group" v-if="!fromOther">	
                                      <label for="">Tipo </label>
                                       <select name="" id="" class="form-control" :class="{green:isDoctor,blue:!isDoctor}" v-model="isDoctor">
                                       <option value="false" :selected="!isDoctor">Paciente</option>
                                       <option value="true" :selected="isDoctor">Doctor</option>
                                       
                                   </select>
                                  </div>
                                  <div v-else>
                                        <!--  -->
                                         <div v-if="isAdmin==true">
                                            <label for="">Tipo </label>
                                       <select name="" id="" class="form-control" :class="{green:isDoctor,blue:!isDoctor}" v-model="isDoctor">
                                       <option value="false" :selected="!isDoctor">Paciente</option>
                                       <option value="true" :selected="isDoctor">Doctor</option>
                                       
                                   </select>
                                         </div>

                                        <div v-else>
                                             <label for="">Tipo </label>
                                         <div class="btn btn-success" v-if="this.user.isDoctor==true">Doctor</div>
                                        <div class="btn btn-primary" v-else>Paciente</div>
                                        </div>

                                  </div>
                               </div>
                               <div v-if="!fromOther">
                               <div class="col-md-6" v-if="isDoctor == 'true'">
                                  <div class="form-group">	
                                      <label for="">Especialidad</label>
                                       <v-select :options="especialidades" v-model="especialidadModel"> </v-select>
                                  </div>
                               </div>
                               </div>
                               <div v-else>
                                   <div v-if="isAdmin==true">
                               <div class="col-md-6" v-if="isDoctor == 'true'">
                                  <div class="form-group">	
                                      <label for="">Especialidad</label>
                                       <v-select :options="especialidades" v-model="especialidadModel"> </v-select>
                                  </div>
                               </div>
                                   </div>
                                   <div v-else>
                                       <div v-if="isDoctor==true"><label for="">Lista de especialidades</label></div>
                                   </div>
                               </div>
                           </div>
                           <div class="row" v-if="this.isDoctor =='true'">
                               <div class="col-md-12">
                                   <div class="table table-stripped table-responsive">
                                       <table class="table table-hover animated" :class="{red:this.err.espelidadesList,shake:this.err.espelidadesList}">
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
                                           <td @click="deleteEspecialidad(index)" class="text-center" v-if="!fromOther"><div class="pe-7s-close" style="color:red;width:100px;heigth:100px"></div></td>
                                            <td @click="deleteEspecialidad(index)" class="text-center"  v-if="fromOther && isAdmin==true"><div class="pe-7s-close" style="color:red;width:100px;heigth:100px"></div></td>
                                           </tr>
                                       </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </form>
                </div><!--cards Body end-->
                <div class="card-footer text-right">
                    <input type="checkbox" name="" id="" v-model="accepted" v-if="!fromOther"> <span v-if="!fromOther" >Estoy seguro de eliminar este usuario</span>
                        <button class="btn btn-danger" @click="deletedUser" v-if="!fromOther">Eliminar</button>
                        <button class="btn btn-primary " @click.prevent="errors" >Actualizar</button>
                </div><!--cards end-->
                    </div> 
                   
               </div>
                <!--IMG -->
<div class="col-md-4">
                        <div class="card card-user animated fadeInRight">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                     <div>
                                    <img class="avatar border-gray" :src="this.user.imgUrl" alt="..."/>

                                      <h4 class="title"><br />
                                         <small>Aqui desde: {{momentCreatedAt}}</small>
                                      </h4>
                                    </div>
                                </div>
                                <p class="description text-center">Consultas Recibidas:  <br>
                                 </p>
                            </div>
                            <hr>
                        </div>
                    </div>
                    <!--END IMG -->
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

export default{
    props:['userIn','fromOther'],
    data(){
        return{
            showLoading:false,
            showAlertNotMatch:false,
            changePass:true,
            btnPass:0,
            password:["","",""],
            updatePassBtn:false,
            showCard:false,
            regexemail: new RegExp("[a-z0-9A-Z]@[a-z][a-z]",""),
            showmsg:true,
            classToAdd:{},
            styleToAdd:{},
            msgmsg:"",
            user:{
                age: 57,
                contacto: "no cargado",
                created_at: "no cargado",
                dui: "no cargado",
                email: "no cargado",
                email_verified_at: "no cargado",
                id: 1,
                imgUrl: "/img/avatar.png",
                isAdmin: false,
                isAllow: false,
                isDoctor: false,
                name: "no cargado",
                updated_at: "no cargado",
            },
            pass:null,
            isDoctor:false,
            isAdmin:false,
            isAllow:false,
            name:false,
            age:false,
            email:false,
            contacto:false,
            especialidades :[{id:null,label:null}],
            especialidadModel:[{id:null,label:null}],
            espelidadesList:[],
            especialidadAddToList:null,
            err:{ //for show errors
            isDoctor:false,
            isAdmin:false,
            isAllow:false,
            name:false,
            age:false,
            email:false,
            contacto:false,
            espelidadesList:false,
            espelidadesList:false,
            allow:false,
            },
            especialidadesId:[],
            updateItems:{},
            rejectErr:[],
            success:false,
            errCard:false,
            accepted:false

        }
    },
    methods:{
        resetPass(){
            this.password=["","",""];
            this.btnPass=0;
            this.changePass=true;
        },
        btnPassFun(){
           console.info(this.btnPass,this.password[this.btnPass]);
            if(this.btnPass<2 && this.password[this.btnPass]!=""  && this.password[this.btnPass]!=undefined){
 this.btnPass=this.btnPass+1;
            }
            if(this.btnPass==2){
                this.updatePassBtn=true;
            }

        },
        updatePass(){
            if(this.password[this.btnPass]!=""  && this.password[this.btnPass]!=undefined){
                    if(this.password[1] === this.password[2]){ // verf si las contraseñas son iguales
                        this.showCard=false; //mostramos cargando
                        this.btnPass=0;
                        this.updatePassBtn=false;
                       axios.get("/api/api/updateuserp",{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{
                            "oldPass":this.password[0],
                            "passOne":this.password[1],
                            "passTwo":this.password[2],
                            "id":this.user.id
                        }}).then(()=>{
                        this.errCard=false;
                        this.success=true;
                        this.showMsg("Contraseña actualizado",{"background-color":"dodgerblue","color":"white"});
                           this.updatePassBtn=false; // boton de actualizar no se vizualiza
            this.changePass=true; // mostrar el formulario de actualizar contraseña
            this.showAlertNotMatch=false; // la alerta de no match no se muestra
             this.showCard=true; // ocutamos cargando
                       }).catch(()=>{
                           this.errCard=true;
                            this.success=false;
                            this.showCard=true;
                           this.showMsg("La contraseña no es la misma",{"background-color":"red","color":"white"});
                       });
            
                    }else{
                        this.updatePassBtn=false;
                        this.btnPass=1;
                        this.showAlertNotMatch=true;
                    }
            }
        }
        ,
        getUser(){
            axios.get('/api/api/searchuser',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{"id":this.userIn,"pag":0,"fromOther":this.fromOther}}).then((result) => {
                this.user=JSON.parse(JSON.stringify(result.data))[0];
                this.setModels();
            }).catch((err) => {
                
            });
        },
        getEspecialidades(){
            axios.get('api/api/citasespe',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`}}).then((resolve)=>{
                this.especialidades=JSON.parse(JSON.stringify(resolve.data));
                
            });
        },
        setModels(){
            this.isDoctor = this.user.isDoctor ? 'true':'false';
            this.isAdmin = this.user.isAdmin;
            this.isAllow = this.user.isAllow;
            this.name = this.user.name;
            this.age = this.user.age;
            this.email = this.user.email;
            this.contacto = this.user.contacto;
            if(this.user.isDoctor){
                this.getEspecialidadesDoctor();
            }else{
                this.showCard=true;
            }
        },
        getEspecialidadesDoctor(){
            axios.get('/api/api/doctorespecialidades',{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{"id":this.user.id}}).then((resolve)=>{
                this.showCard=true;
                this.espelidadesList =JSON.parse(JSON.stringify(resolve.data));
            });
        },
        deleteEspecialidad(index){
            this.espelidadesList.splice(index,1);
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
        updateUser(){ /* users update method */ 
        this.updateItems={
                "name":this.name,
                "age":this.age,
                "email":this.email,
                "contacto":this.contacto,
                "isAdmin":this.isAdmin,
                "isAllow":this.isAllow,
                "isDoctor":this.isDoctor,
                "especialidades":null,
                "id":this.user.id
            };
        if(this.isDoctor=='true'){
this.especialidadesId=[]; //we reset this array cuz if the upadte button had been trigger before
/* i mean that if the update button was trigged before the this.especialidadesId array must have some info that is not match */
            this.espelidadesList.forEach(esp => {
                this.especialidadesId.push(esp.id);
            });
            this.updateItems.especialidades = this.especialidadesId;
        }else{
        this.updateItems.especialidades=null;
        }
            this.showCard=false;
            axios.get("/api/api/updateuser",{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:this.updateItems}).then((resolve)=>{
                console.info(JSON.parse(JSON.stringify(resolve.data)));
                this.showMsg("Usuario actualizado",{"background-color":"dodgerblue","color":"white"});
                this.success=true;
                this.errCard=false;
            this.getUser();
            this.showCard=true;
            }).catch((reject)=>{
                this.rejectErr= JSON.parse(JSON.stringify(reject));

                for (let out in this.rejectErr.response.data.errors) {
                    this.err[out]=true;
                    if(out=='email'){
                        this.showMsg("El email es invalido",{"background-color":"red","color":"white"});
                    }
                }
                   if(this.rejectErr.response.data.email){
                        this.showMsg("Ya esta registrado bajo otro usuario",{"background-color":"red","color":"white"});
                        this.err.email=true;
                   }
                   
            });
        },
        errors(){
            for(let value in this.err){
                if( value=="espelidadesList" && this.isDoctor=='true'){
                    this.allow = this.err[value];
                    if(this.allow){
                    this.success=false;
                         this.errCard=true;
                        break;
                    }
                }else{
                    this.allow = this.err[value];
                    if(this.allow){
                    this.success=false;
                         this.errCard=true;
                        break;
                    }
                }
            }
            if(!this.allow){
                this.updateUser();
            }else{
              this.showMsg("Faltan algunos campos, verifica por favor",{"background-color":"red","color":"white"});
            }
        },
        deletedUser(){
            if(this.accepted){
                axios.get("/api/api/deluser",{headers:{Authorization:`Bearer ${localStorage.getItem('accessToken')}`},params:{id:this.userIn}}).then(()=>{
            this.$emit("deletedUser");
                }).catch((reject)=>{
                    this.showMsg("Error Algo Salio Mal Borrando Este Usuario",{"background-color":"red","color":"white"});
                });
            }
        }   
    },
    watch:{
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
        },
        name:function(){
            (this.name == "") ? this.err.name=true:this.err.name=false;
        },
        age:function(){
            (this.age == "") ? this.err.age=true:this.err.age=false;
        },
        email:function(){
            (this.email == "" || this.email.match(this.regexemail)==null) ? this.err.email=true:this.err.email=false;
        },
        contacto:function(){
            (this.contacto == "") ? this.err.contacto=true:this.err.contacto=false;
        },
        espelidadesList:function(){
            if(this.espelidadesList.length ==0 && this.isDoctor=='true'){
            this.err.espelidadesList=true;
            this.showMsg("Un doctor necesita especialidades",{"background-color":"red","color":"white"});
            }else{
                this.err.espelidadesList=false;
            }
            
        },
        isDoctor:function(){
            if(this.isDoctor=='true' && this.espelidadesList.length == 0){
                    this.err.espelidadesList=true;
            }else{
                this.err.espelidadesList=false;
            }
        }
    },
    created(){
        this.getUser();
        this.getEspecialidades();
    },
    computed:{
        momentCreatedAt:function(){
                return moment(this.user.created_at).format('dddd DD MMMM YYYY');
        },
        oldPass:function(){
            return this.password[0]==""
        }
        ,
        passOne:function(){
            return this.password[1]==""
        }
        ,
        passTwo:function(){
            return this.password[2]==""
        }
    }

}

</script>

<style>

.green{
    border: 2px solid green;
}

.danger{
    border: 2px solid yellow;
}
.red{
    border: 2px solid brown;
}

.blue{
    border: 2px solid dodgerblue;
}

</style>
