<template>
    <div>
       <body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('/img/login/bg-01.jpg');">
			<div class="wrap-login100 p-l-110 p-r-110 p-t-62 p-b-33 animated" :class="addClass">
				<form v-if="!loading" class="login100-form validate-form flex-sb flex-w"  @submit="loginFunction">
					<span class="login100-form-title p-b-53">
						Citas 
					</span>

					<a href="/facebook" class="btn-face m-b-40">
						<i class="fa fa-facebook-official"></i>
						Facebook
					</a>

					<a href="#" class="btn-google m-b-20 text-center">
						<img src="/img/login/icons/icon-google.png" alt="GOOGLE">
						Google
					</a>
					
					<div class="p-t-31 p-b-9">
						<span class="txt1">
							Email
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Username is required">
						<input class="input100" type="text" name="username" v-model="email" placeholder="Email">
						<span class="focus-input100"></span>
					</div>
					
					<div class="p-t-13 p-b-9">
						<span class="txt1">
							Contraseña
						</span>

						<a href="#" class="txt2 bo1 m-l-5">
							¿Olvidaste tu Contraseña?
						</a>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input  type="password" name="pass" v-model="password" :class="{'input100':true}" placeholder="Contraseña">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button class="login100-form-btn">
							Iniciar Sesion
						</button>
					</div>
				</form>
				<div class="login100-form validate-form flex-sb flex-w" v-else>
						<img src="/img/temsys/loading.gif" width="100pc" height="400pc" class="login100-form-title p-b-53 text-center" alt="">
				</div>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	

</body>
    </div>
</template>

<script>
export default {
    data(){
       return{
            errors:[],
            email:'',
            password:'',
            tokens:'',
			showLogin:false,
			addClass:{},
			loading:false
       }
    },
    methods:{
        loginFunction(e){
			this.addClass={
							"shake":false,
							"errClass":false
						};
			this.loading=true;
            e.preventDefault();
            axios.post('/api/auth/login',{"email":this.email,"password":this.password}).then((resolve)=>{
                console.log(JSON.parse(JSON.stringify(resolve.data)));
            this.tokens = resolve.data.access_token;
            localStorage.setItem('accessToken',resolve.data.access_token);
            localStorage.setItem("email",this.email);
            localStorage.setItem("idProfile",resolve.data.id);
			location.href="/home/dashboard";
			
            }).catch((reject)=>{
				let err = JSON.parse(JSON.stringify(reject));
				this.addClass={
							"shake":true,
							"errClass":true
						};
				switch(err.response.status){
					case 405:
						
					break;
				}
				this.loading=false;
            });
        }
    },
    beforeCreate(){
        axios.get('/api/api/user',{headers:{Authorization:'Bearer '+localStorage.getItem('accessToken')},params:{email:localStorage.getItem("email")}}).then((resolve)=>{ 
            this.showUsers = JSON.parse(JSON.stringify(resolve.data)).allow==true?true:false;
            this.showUp=true;
         window.location.href="/home/dashboard";
        }).catch((reject)=>{
            this.showLogin=true;
        });
    }
}
</script>

<style>
.errClass{
	border:2px solid red;
}
</style>
