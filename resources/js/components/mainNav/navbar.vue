<template>
    <div v-if="showUp">
        <div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="/dashboard" class="simple-text">
                    DocV
                </a>
            </div>

            <ul class="nav">
                <li :class="{'active':classDash}" @click="loadclassDash">
                    <router-link to="/home/dashboard">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </router-link>
                </li>
                <li v-if="showUsers" :class="{'active':classUser}" @click="loadclassUser">
                    <router-link :to="{name:'users'}">
                        <i class="pe-7s-user"></i>
                        <p>Usuarios</p>
                    </router-link>
                </li>
                <li  :class="{'active':loadClassVar}"  @click="loadClass">
                    <router-link :to="{name:'citas'}" >
                        <i class="pe-7s-note2"></i>
                        <p>Citas</p>
                    </router-link>
                </li>
                <li :class="{'active':classRep}" @click="loadclassRep" v-if="showUsers">
                   <router-link :to="{name:'especialidades'}">
                        <i class="pe-7s-news-paper"></i>
                        <p>Especialidades</p>
                   </router-link>
                </li>
                <li :class="{'active':classPro}" @click="loadclassPro">
                    <router-link :to="{name:'profile'}">
                        <i class="pe-7s-science"></i>
                        <p>Perfil Usuario</p>
                    </router-link>
                </li>
				<li class="active-pro" @click="logout">
                        <a href="#">
                            <i class="pe-7s-rocket"></i>
                        <p>SALIR</p>
                        </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">{{title}}</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-dashboard"></i>
								<p class="hidden-lg hidden-md">Dashboard</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-lg hidden-md"></b>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Account</p>
                            </a>
                        </li>
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>
										Dropdown
										<b class="caret"></b>
									</p>

                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                              </ul>
                        </li>
                        <li>
                            <a href="#">
                                <p>Log out</p>
                            </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <router-view></router-view>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Blog
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>
    </div>
</template>

<script>
import Pusher from 'pusher-js';
import $ from 'jquery';
export default {
    props:["titleV"],
    data(){
        return{
            title:"Sistema de Citas",
            showUp:false,
            loadClassVar:false,
            classDash:false,
            classUser:false,
            classRep:false,
            classPro:false,
            showUsers:false
        }
    },
    methods:{
        loadClass(e){
            this.loadClassVar=true;
            this.classDash = false;
            this.classUser=false;
            this.classRep=false;
            this.classPro=false;
        },
        loadclassRep(){
            this.loadClassVar=false;
            this.classDash = false;
            this.classUser=false;
            this.classRep=true;
            this.classPro=false;
        },
        loadclassDash(){
            this.loadClassVar=false;
            this.classDash = true;
            this.classUser=false;
            this.classUser=false;
            this.classRep=false;
            this.classPro=false;
        },
        loadclassUser(){
            this.loadClassVar=false;
            this.classDash = false;
            this.classUser=true;
            this.classRep=false;
            this.classPro=false;
        },
        loadclassPro(){
            this.loadClassVar=false;
            this.classDash = false;
            this.classUser=false;
            this.classRep=false;
            this.classPro=true;
        },
        logout(){
            axios.get('/api/api/logout',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')}}).then((resolve)=>{ location.href='/'; console.log(JSON.parse(JSON.stringify(resolve.data)));
            }).catch((reject)=>{console.log(reject);
            });
        }
    },
    beforeCreate(){
        axios.get('/api/api/user',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:{email:localStorage.getItem("email")}}).then((resolve)=>{ 
            this.showUsers = JSON.parse(JSON.stringify(resolve.data)).allow==true?true:false;
            this.showUp=true;
         console.log('welcome');
        }).catch((reject)=>{ location.href='/'; console.log('not allowed little friend of mine');
        });

var pusher = new Pusher('23fcc4963122da8c2f65', {
      cluster: 'us2',
      forceTLS: true
    });
    
    var channel = pusher.subscribe('citaAddEvent');

    channel.bind('newCita', function(data) {
      alert(JSON.stringify(data));
      $.notify({
            icon: "nc-icon nc-app",
            message: "a new fucker is online"

        }, {
            type: type[color],
            timer: 8000,
            placement: {
                from: from,
                align: align
            }
        });
    });
    }
}
</script>
