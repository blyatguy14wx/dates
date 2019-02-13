<template>
    <div>
       
         <div class="content"  v-if="showCard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card animated fadeInLeft" :class="{'errorClass':errorClass,'successClass':successUpdate,'animated':true,'shake':errorClass}">
                            <div class="header">
                                <h4 class="title">CITA {{this.lookParams.cita}}
                                <div v-if="errorClass" class="animated fadeInLeft" style="display:inline-block; background-color:red; color:white; padding:10px; border-radius:10px;">Parece que faltan algunos campos, verifique por favor</div>
                                <div v-if="successUpdate" class="animated fadeInLeft" style="display:inline-block; background-color:dodgerblue; color:white; padding:10px; border-radius:10px;">ACTUALIZADO</div>
                                </h4> 
                            </div>
                            <div class="content">
                                <form>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>FECHA CITA</label>
                                                    <input v-if="showOrNot" :class="{errorClass:fechaHasClass}" type="date" class="form-control" v-model="updateParams.fechaCita">
                                                    <div v-else>
                                                        {{updateParams.fechaCita}}
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Hora Cita</label>
                                                <input :class="{errorClass:horaHasClass}" v-if="showOrNot" type="time" v-model="updateParams.hora" class="form-control">
                                                <div v-else>{{updateParams.hora}}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Estado</label>
                                                    <div v-if="showDate">
                                                    <select v-show="normal!=0" class="form-control"  v-model="updateParams.estado">
                                                    <option :selected="this.btnClass" value="1">Activa</option>
                           <option :selected="true"  value="0">Inactiva</option>
                           <option :selected="this.btnClass"  value="2">Pendiente</option>
                                                </select><button class="btn btn-primary pe-7s-close-circle" @click.prevent="showDate=false; updateParams.estado=normal">Cancelar</button>
                                                </div>
                                                <button @click.prevent="showDate=true" class="btn" :class="btnClass"  v-else>
                                                    {{momentStatus}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                             <div class="form-group">
                                                <label>ESPECIALIDAD O MOTIVO DE CONSULTA</label>
                       
                        <div v-if="!showOrNot">
                            {{searchEsp.label}}
                        </div>
                        <v-select :options="especialidades" :class="{'btn-danger':hasErroeEsp}" v-model="searchEsp" v-else>
                            
                        </v-select>
                       

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                           <div class="form-group">
                                                <label>Doctor</label>
                                                <div v-if="!showOrNot" >
                                                    {{doctor.label}}
                                                </div>
                                                <v-select v-else v-model="doctor" :class="{'btn-danger':doctorHasError}" :options="doctores"></v-select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Comentario</label>
                                                <textarea rows="5" v-if="showOrNotComent" v-model="updateParams.comentario" class="form-control" placeholder="Here can be your description" value="Mike" :class="{errorClass:comentarioHasError}"></textarea>
                                                <div v-else>{{updateParams.comentario}}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" v-if="showOrNot" @click.prevent="updateCitaEvent" class="btn btn-success btn-fill pull-right">Actualizar Cita</button>
                                     <button type="submit"  @click.prevent="closeCita" class="btn btn-primary btn-fill pull-right" v-if="showOrNotComent">Cerrar Cita</button>
                                     <button v-if="showOrNotComent" @click.prevent="deleteCita" type="submit" class="btn btn-danger btn-fill pull-center">Borrar Cita</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-user animated fadeInDown">
                            <div class="image">
                                <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
                            </div>
                            <div class="content">
                                <div class="author">
                                     <a href="#">
                                    <img class="avatar border-gray" :src="citas.imgurl" alt="..."/>

                                      <h4 class="title">{{citas.paciente}}<br />
                                         <small>Aqui desde: {{momentPaciente}}</small>
                                      </h4>
                                    </a>
                                </div>
                                <p class="description text-center">Consultas Recibidas: {{citas.count}} <br>
                                Edad: {{citas.age}} <br>
                                Correo Electronico: {{citas.email}} <br>
                                documento de identidad : {{citas.dui}}
                                 </p>
                            </div>
                            <hr>
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
                        <div style="display:none">
                            
    {{this.lookParams.cita=$route.params.id ? $route.params.id : this.citaIn }} 
    {{this.updateParams.cita=$route.params.id ? $route.params.id : this.citaIn }} 
     {{$route.params.id = null}}
                        </div>
                    </div>
                </div>
            </div>
</div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    props:["citaIn"],
    data(){
        return{
            showCard:false,
            successUpdate:false,
                errorClass:false,
                comentarioHasError:false,
                fechaHasClass:false,
                horaHasClass:false,
            doctorHasError:false,
            hasErroeEsp:false,
            especialidades:[],
            showOtherInfo:1,
            citas:[],
            normal:null,
            "searchEsp":{},
            showDate:false,
            showHour:false,
            doctores:[],
            doctor:{id:0,label:"generic"},
            lookParams:{
                "cita":this.citaIn,
            },
            updateParams:{
                fechaCita:null,
                hora:null,
                doctor:null,
                comentario:null,
                especialidad:{id:null,label:null},
                cita:this.citaIn
            },
            btnClass:{}
            
        }
    },
    methods:{
        deleteCita(){
            axios.get('/api/api/deletecita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.updateParams}).then((resolve)=>{
                console.log(resolve.data);
                this.$emit('deletedCita');
            }).catch((reject)=>{
                console.log(reject);
                
            });
        },
        lookUpCita(){
axios.get('/api/api/citalook',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
            
this.citas = JSON.parse(JSON.stringify(resolve.data[0]));


            this.btnClass={
                "btn-warning": this.citas.status !=0 && this.citas.status!=1 ? true:false,
                "btn-danger": this.citas.status !=2 && this.citas.status!=1 ? true:false,
                "btn-success": this.citas.status !=0 && this.citas.status!=2 ? true:false,
            };
            this.updateParams={
                fechaCita:moment(this.citas.fechaCita).format('YYYY-MM-DD'),
                hora:moment(this.citas.fechaCita).format('HH:mm:ss'),
                doctor:{label:this.citas.doctor,id:this.citas.iddoctor},
                comentario:this.citas.comentario,
                estado:this.citas.status,
                especialidad:{label:this.citas.especialidad,id:this.citas.idespecialidad},
                cita:this.citaIn ? this.citaIn : this.lookParams.cita,
                adminWeb:this.citas.isAdmin
            }
            this.doctor = {label:this.citas.doctor,id:this.citas.iddoctor};
            this.searchEsp={label:this.citas.especialidad,id:this.citas.idespecialidad};
            this.normal=this.citas.status;
                }).catch((reject)=>{
                });
        },
       closeCita(){
           this.updateParams.cita =this.citaIn ? this.citaIn : this.lookParams.cita;
           axios.get('/api/api/closecita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.updateParams}).then((resolve)=>{
               this.successUpdate=true;
               this.errorClass=false;
               this.comentarioHasError=false;
               this.lookUpCita();
           }).catch((reject)=>{
               this.successUpdate=false;
               this.errorClass=true;
               this.errorFunc();

           });
           
       },
        errorFunc(){
            if (!this.updateParams.fechaCita) {
                   this.fechaHasClass=true;
               }else{
                   if(this.updateParams.fechaCita){

                   }
               }
               if (!this.updateParams.hora) {
                   this.horaHasClass=true;
               }
                if (!this.searchEsp) {
                    this.hasErroeEsp = true;
                }
                if (!this.doctor) {
                    this.doctorHasError = true;
                }
                if (!this.updateParams.comentario) {
                    this.comentarioHasError=true;
                }
                this.errorClass=true;
                this.successUpdate=false;
        },
        updateCitaEvent(e){
            e.preventDefault();
            this.updateParams.cita =this.citaIn ? this.citaIn : this.lookParams.cita;
           if(!this.doctor || !this.searchEsp || !this.updateParams.comentario || !this.updateParams.fechaCita || !this.updateParams.hora || new Date(this.updateParams.fechaCita+' '+this.updateParams.hora).getTime()< new Date().getTime()){
               this.errorFunc();
               if(new Date(this.updateParams.fechaCita+' '+this.updateParams.hora).getTime()<new Date().getTime()){
              this.fechaHasClass=true;
              this.horaHasClass=true;
            }
            }else{
                this.fechaHasClass=false;
                this.horaHasClass=false;
                this.comentarioHasError=false;
                this.hasErroeEsp =false;
                this.doctorHasError=false;
                this.updateParams.doctor = this.doctor.id;
                this.updateParams.especialidad = this.searchEsp.id;
             axios.get('/api/api/updatecita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')}, params:this.updateParams}).then((resolve)=>{
                 console.log(resolve.data);
                 
                 this.showDate=false;
                 this.successUpdate=true;
                    this.errorClass=false;
axios.get('/api/api/citalook',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
this.citas = JSON.parse(JSON.stringify(resolve.data[0]));
            this.btnClass={
                "btn-warning": this.citas.status !=0 && this.citas.status!=1 ? true:false,
                "btn-danger": this.citas.status !=2 && this.citas.status!=1 ? true:false,
                "btn-success": this.citas.status !=0 && this.citas.status!=2 ? true:false,
            };
            this.updateParams={
                fechaCita:moment(this.citas.fechaCita).format('YYYY-MM-DD'),
                hora:moment(this.citas.fechaCita).format('HH:mm:ss'),
                doctor:{label:this.citas.doctor,id:this.citas.iddoctor},
                comentario:this.citas.comentario,
                estado:this.citas.status,
                cita:this.citaIn ? this.citaIn : this.lookParams.cita,
                adminWeb:this.citas.isAdmin
            }
            this.doctor = {label:this.citas.doctor,id:this.citas.iddoctor};
            this.searchEsp={label:this.citas.especialidad,id:this.citas.idespecialidad};
            console.log("");
            this.normal=this.citas.status;
                }).catch((reject)=>{console.log(reject);
                });

             }).catch((reject)=>{
                 this.errorClass = true;
                 console.log(reject);
                 
             });
            }
            
        }
    },
    watch:{
        searchEsp:function(){
             axios.get('/api/api/doctorcita',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.searchEsp}).then((resolve)=>{
                    this.doctores = JSON.parse(JSON.stringify(resolve.data));
                }).catch((reject)=>{console.log(reject);
                });
        },
        doctor:function (){
            (!this.doctor) ? this.doctorHasError=true:this.doctorHasError=false;
        }
    },
    computed:{
         showOrNotComent(){
            if (!this.updateParams.adminWeb && this.updateParams.estado!=0) {
                return true;
            } else {
                if(this.updateParams.adminWeb && this.updateParams.estado==0 || this.updateParams.adminWeb && this.updateParams.estado!=0){
                    return true;
                }else if (!this.updateParams.adminWeb || this.updateParams.estado!=0){
                    return false;
                }
            }
        },
        showOrNot(){
            if (!this.updateParams.adminWeb) {
                return false;
            } else {
                if(this.updateParams.adminWeb && this.updateParams.estado!=0){
                    return true;
                }else if (this.updateParams.estado!=0){
                    return true;
                }
            }
        },
        momentPaciente(){
            return moment(this.citas.creado).format("DD MMMM YYYY");
        },
        momentFechaCita(){
            return moment(this.citas.fechaCita).format('DD MMMM YYYY');
        },
        momentHoraCita(){
            return moment(this.citas.fechaCita).format("HH:mm:ss A");
        },
        momentStatus(){
                switch(this.citas.status){
                case 1:
                return "ACTIVA"
                break;
                case 2:
                return "PENDIENTE"
                break;
                case 0:
                return "INACTIVA"
                break;
            }
        }
    },
    mounted(){
        axios.get('/api/api/citalook',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:this.lookParams}).then((resolve)=>{
            
this.citas = JSON.parse(JSON.stringify(resolve.data[0]));


            this.btnClass={
                "btn-warning": this.citas.status !=0 && this.citas.status!=1 ? true:false,
                "btn-danger": this.citas.status !=2 && this.citas.status!=1 ? true:false,
                "btn-success": this.citas.status !=0 && this.citas.status!=2 ? true:false,
            };
            this.updateParams={
                fechaCita:moment(this.citas.fechaCita).format('YYYY-MM-DD'),
                hora:moment(this.citas.fechaCita).format('HH:mm:ss'),
                doctor:{label:this.citas.doctor,id:this.citas.iddoctor},
                comentario:this.citas.comentario,
                estado:this.citas.status,
                especialidad:{label:this.citas.especialidad,id:this.citas.idespecialidad},
                cita:this.lookParams.cita,
                adminWeb:this.citas.isAdmin
            }
            this.doctor = {label:this.citas.doctor,id:this.citas.iddoctor};
            this.searchEsp={label:this.citas.especialidad,id:this.citas.idespecialidad};
            this.normal=this.citas.status;
            this.showCard=true;
                }).catch((reject)=>{console.log(reject);
                });

                 axios.get('/api/api/citasespe',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')}}).then((resolve)=>{
                    this.especialidades = JSON.parse(JSON.stringify(resolve.data));
                    
                }).catch((reject)=>{console.log(reject);
                });
    },
    
}
</script>

<style>
.errorClass{
    border:2px solid red;
}
.successClass{
    border:2px solid dodgerblue;
}
</style>
