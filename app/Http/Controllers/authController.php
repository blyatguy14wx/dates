<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\DB;

class authController extends Controller
{
    //HERE IS WHERE ALL THE AUTH WILL BE STORE AND DESTROYED
    
    /*THIS ONE IS FOR LOGIN WILL BE CALLED IN THE api.php on the 
    
    Route::group(['prefix' => 'auth'], function () {
        
    });*/

    // we use the loginRequest to validate the data that it comes in the $request
    #this is store en in the App/Http/Request/ folder 

    public function login(Request $request){
$request->validate(["email"=>"required","password"=>"required"]);

        $credentials=$request->only('email','password');

        if(!Auth::attempt($credentials)){
            return response()->json(["message"=>"error parece que el usuario no esta creado"],Response::HTTP_BAD_REQUEST);

        }
        if(!$request->user()->isAllow){
            return response()->json(["err"=>"you are not allow to get in"],Response::HTTP_METHOD_NOT_ALLOWED);
        }
        $tokenResult=$request->user()->CreateToken('Access Personal Token');
        $token=$tokenResult->token;

        if($request->remember){
            $token->expires_at = Carbon::now()->addDays(1);
        }
       $token->save();
        return response()->json([
            "access_token"=>$tokenResult->accessToken,
            "token_type"=>'bearer',
            "expires_at"=> Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            "id"=>$request->user()->id
            ]
        );

    }

    public function user(Request $req){
        $user =User::where("email",$req->email)->get();
        if($user[0]->isAdmin=="true"){
            $allow=true;
        }else{
            $allow=false;
        }
        return response()->json(["message"=>TRUE,"allow"=>$allow],200);
    }

    public function profile(Request $req){
        return response()->json($req->user(),200);
    }

    public function logout(Request $request){
        
        try {
            
           $request->user()->token()->revoke();
           $request->user()->logout();
           return "/";
        } catch (\Throwable $th) {
            return "/";
        }

      
    }

    public function loginF(){
        return view("loginTemplate");
    }

}
