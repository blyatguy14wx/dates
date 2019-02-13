<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class userController extends Controller
{
    //Buscar un usuario en la consulta general
    public function searchUser(Request $request){
        $search='WHERE';
        $innerJoin="";
        if($request->name){
            $search.=' "users"."name" like \'%'.$request->name.'%\' AND ';
        }
        if($request->id){
            $search.=' "users"."id"='.$request->id.' AND ';
        }
        if(!$request->fromOther){
            $search.=' "users"."id"!=1 AND ';
        }
        if($request->creadodesde || $request->creadohasta){
            if($request->creadodesde && !$request->creadohasta){
                $search.=' "users"."created_at"::date=date \''.$request->creadodesde.'\' AND ';
            }
            if(!$request->creadodesde && $request->creadohasta){
                $search.=' "users"."created_at"::date= date \''.$request->creadohasta.'\' AND ';
            }
            if($request->creadodesde && $request->creadohasta){
               if(date($request->creadodesde)< date($request->creadohasta)){
                $search.=' "users"."created_at"::date= date \''.$request->creadodesde.'\' AND "users"."created_at"::date= date \''.$request->creadohasta.'\' AND ';
               }else{
                $search.=' "users"."created_at"::date= date \''.$request->creadohasta.'\' AND "users"."created_at"::date= date \''.$request->creadodesde.'\' AND ';
               }
            }
        }

        if($request->dui){
            $search.=' "users"."dui" LIKE \'%'.$request->dui.'%\' AND ';
        }
        if($request->dui){
            $search.=' "users"."dui" LIKE \'%'.$request->dui.'%\' AND ';
        }
        if($request->allow){
            $search.=' "users"."isAllow"='.$request->allow.' AND ';
        }
        if($request->doctor){
            $search.=' "users"."isDoctor" = '.$request->doctor.' AND ';
        }
        if($request->rol){
            $search.=' "users"."isAdmin"='.$request->rol.' AND ';
        }
        if($request->email){
            $search.=' "users"."email" LIKE \'%'.$request->email.'%\' AND ';
        }
        if($request->aged || $request->ageh){
            if($request->aged && !$request->ageh){
                $search.=' "users"."age"='.$request->aged.' AND ';
            }
            if($request->aged && $request->ageh){
                
                if($request->aged < $request->ageh){
                    $search.=' "users"."age" BETWEEN '.$request->aged.' AND '.$request->ageh.' AND ';
                }
                if($request->aged > $request->ageh){
                    $search.=' "users"."age" BETWEEN '.$request->ageh.' AND '.$request->aged.' AND ';
                }
            }
        }
        if($request->esp){
            $innerJoin = " inner join doctor_especialidades on doctor_especialidades.\"idDoctor\" = users.id inner join especialidades on especialidades.id = doctor_especialidades.\"idEspecialidad\" ";
            $search.=" especialidades.\"id\" = ".$request->esp." AND ";
        }
        $query="";
        //verificar si hay algun parametro seleccionado
        if(substr($search,strlen($search)-4,4)=="AND "){
            $query = " ".substr($search,.0,strlen($search)-4);
        };
        //return 'select * from users '.$query.' ORDER BY id  LIMIT 10 OFFSET '.$request->pag.' ';
       // dd('select * from users '.$innerJoin.$query.' ORDER BY users."id"  LIMIT 10 OFFSET '.$request->pag.' ');
        $result = DB::select('select  "users"."imgUrl","users"."name","users"."id","users"."contacto","users"."created_at","users"."age","users"."email","users"."isAdmin","users"."isDoctor","users"."isAllow","users"."dui", "users"."created_at"  from users '.$innerJoin.$query.' ORDER BY users."id"  LIMIT 10 OFFSET '.$request->pag.' ');


        $offset = DB::select('SELECT count( "users"."id" ) from users '.$innerJoin.$query);
         $result[count($result)]=$offset;

        return response()->json($result,200);
    }

    public function addUser(Request $request){
            if($request->name && $request->age && $request->email && $request->esp && $request->admin && filter_var($request->email,FILTER_VALIDATE_EMAIL)){
                $newUser = new User;
                $newUser->name = $request->name;
                $newUser->age = $request->age;
                $newUser->email=$request->email;
                $newUser->isAdmin = $request->admin;
                $newUser->isAllow = true;
                $newUser->isDoctor = true;
                $newUser->imgUrl="/img/avatar.png";
                $newUser->password = bcrypt("secret");
                $newUser->contacto=0000;

            if($request->img){
                $code = "url".random_int(10000,9999999)."faker";
                $newUser->imgUrl = $code;
            }
               try {
                $newUser->save();
                DB::select('INSERT INTO "public"."doctor_especialidades" ( "idDoctor", "idEspecialidad") 
                VALUES ( '.$newUser->id.',  '.$request->esp.' )');
                return response()->json(["status"=>"done","newUser"=>$newUser->id,"urlDecode"=>$code],201);
               } catch (\Throwable $th) {
               return response()->json(["email"=>TRUE],404);
               }
            }else{
              return  response()->json(["err"=>"something is missing"],405);
            }
    }

    //para consulta de un v-select
    public function vSelectUser(Request $request){

        if(!$request->isdoctor){
            $request->isdoctor=false;
        }
        return response()->json(DB::select('select "id", "users"."id" || \'-) \' || "users"."name" as label from users where "isDoctor"='.$request->isdoctor.' order by id'),200);

    }

    public function updateuser(Request $request){
        $request->validate([
            "email"=>"email|string|required",
            "age"=>"required",
            "contacto"=>"required",
            "isAdmin"=>"string|required",
            "isAllow"=>"string|required",
            "isDoctor"=>"string|required",
            "name"=>"required|string",
            "contacto"=>"required",
            "id"=>"string|required"
        ]);
        if( count(User::where("email",$request->email)->where("id","!=",$request->id)->get()) > 0){
            return response()->json(["email"=>"this email has alredy taken"],404);
        }
      $user = new User;
        $userUp = $user::find($request->id);
        $userUp->name = $request->name;
        $userUp->email = $request->email;
        $userUp->age = $request->age;
        $userUp->contacto = $request->contacto;
        if($request->id != '1'){
            $userUp->isAdmin = $request->isAdmin;
        $userUp->isAllow = $request->isAllow;
        }
        $userUp->isDoctor = $request->isDoctor;
        $userUp->save();

        DB::delete("delete from doctor_especialidades where \"idDoctor\"=".$request->id);
        $sql="";
        if($request->isDoctor=="true"){
            
          forEach($request->especialidades as $key => $id){
             $sql="insert into doctor_especialidades (\"idDoctor\",\"idEspecialidad\",\"updated_at\") values(".$request->id.",".$id.",'".Date("Y/m/d H:m:i")."');";
             DB::select($sql);
          }
        }
        return response()->json(["message"=>"update done"],202);
    }

    public function delUser(Request $request){

        $request->validate([
            "id"=>"string|required|min:1"
        ]);

        $user = new User;
        if($request->id != '1'){
       $user=$user::find($request->id);
       $user->delete();
           return response()->json(["msg"=>"deleted done"],200);
        }else{
            return response()->json(["err"=>"this user is not allowed to be deleted from the db"],405);
        }
    }

    public function uploadPhoto(Request $request){

                $findUser = new User;
            $userResult=$findUser::find($request->params['newUser']);
            if($userResult->imgUrl == $request->params['urlDecode']){
                $file=$request->params["img"];

                /* EXPIRIMENTAL */
                $userResult->imgUrl = $file;
                $userResult->save();
                return response()->json(["msg"=>"done"],201);
                /*END EXPIREMENTAL*/

             /*   $splited = explode(',', substr( $file , 5 ) , 2);
    $mime=$splited[0];
    $data=$splited[1];

    $mime_split_without_base64=explode(';', $mime,2);
    $mime_split=explode('/', $mime_split_without_base64[0],2);
    if(count($mime_split)==2)
    {
        $extension=$mime_split[1];
        if($extension=='jpeg')$extension='jpg';
        if($extension=='png')$extension='png';
    }
                $filename = Carbon::now()->timestamp.".".$extension;
                $storageTo = public_path("img/users/".$filename);
                Image::make(base64_decode($data))->resize(300,300)->save($storageTo);
                $userResult->imgUrl = "/img/users/".$filename;
                $userResult->save();
                return response()->json(["status"=>"done"],201);
*/ }else{
                return response()->json(["err"=>"its seems like it doesnt work"],404);
            };
    }

    public function updateUserP(Request $request){

       $request->validate([
            "oldPass"=>"required|string|min:1",
            "passOne"=>"required|string|min:1",
            "passTwo"=>"required|string|min:1",
            "id"=>"required|string"
        ]);

        if($request->id == Auth::user()->id && $request->passOne === $request->passTwo){
           
            $updatePassword = new User;
            $updateUserPass =$updatePassword::findOrFail(Auth::user()->id);
            
           if(Hash::check($request->oldPass,$updateUserPass->password)){
            $updateUserPass->password = bcrypt($request->passTwo);
            $updateUserPass->save();
            return response()->json(["msg"=>"done"],Response::HTTP_OK);
           }else{
            return response()->json(["msg"=>"something went wrong password didnt matched"],Response::HTTP_NOT_ACCEPTABLE);
           }
        }else{
            return response()->json(["msg"=>"something went wrong"],Response::HTTP_NOT_ACCEPTABLE);
        }
        

    }

}