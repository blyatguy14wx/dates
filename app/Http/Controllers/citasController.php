<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\citas;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Events\addCita;
use App\Events\citaAdd;
use Illuminate\Support\Facades\Event;

class citasController extends Controller
{
    public function citas(){
        $resultOne = DB::select('select users."imgUrl" as img, (select count(citas.id) from citas) as citasTotales, users.name as paciente, citas.created_at, "fechaCita",status, citas.id from citas
        inner join users
        on users.id = "idPaciente" order by citas.id limit 10 offset 0');
        $offsetOne = DB::select('SELECT count( citas."id" ) from citas
        inner join users
        on users.id = "idPaciente"');
        $resultOne[count($resultOne)]=$offsetOne;
        return response()->json($resultOne,Response::HTTP_OK);
    }

    public function citasSearch(Request $request){
  $search = "where ";
        if(isset($request->paciente)){
            if(\is_numeric($request->paciente)){
                $search .= "users.id = '".$request->paciente."' and ";
            }else{
                $search .= "users.name LIKE '%".$request->paciente."%' and ";
            }
        }
        if($request->doctor){
                $search .= "citas.\"idDoctor\" = ".$request->doctor." and ";
        }
        if($request->cita){
            $search .= "citas.id = ".$request->cita." and ";
        }

        if($request->especialidad){
            $search .= "\"citas\".\"idEspecialidad\" = ".$request->especialidad." and ";
        }
        
        if($request->fcd || $request->fch){
            
            if($request->fcd && $request->fch){
                $search .= " citas.created_at::date between date '".$request->fcd."' and date '".$request->fch."' and ";
            }

            if($request->fcd && !$request->fch){
                $search .= " citas.created_at::date = date '".$request->fcd."' and ";
            }

            if(!$request->fcd && $request->fch){
                $search .= " citas.created_at::date = date '".$request->fch."' and ";
            }

        }

        if($request->fccd || $request->fcch){
            
            if($request->fccd && $request->fcch){
                $search .= "\"fechaCita\"::date between date '".$request->fccd."' and date '".$request->fcch."' and ";
            }

            if($request->fccd && !$request->fcch){
                $search .= "\"fechaCita\"::date = date '".$request->fccd."' and ";
            }

            if(!$request->fccd && $request->fcch){
                $search .= "\"fechaCita\"::date = date '".$request->fcch."' and ";
            }

        }

        if($request->status || $request->status!=null){
            $search .= " citas.status ='".$request->status."' and ";
        }

        if($request->statuslook){
            $search .= " citas.status !='".($request->statuslook-1)."' and ";
        }

        if($request->dui){
            $search .= " users.dui ='".$request->dui."' and ";
        }
        
        $searchAnd = substr($search,strlen($search)-4,4);
        if($searchAnd == 'and '){
            $search = substr($search,0,strlen($search)-4);
        }else{
            $search = "";
        }
        $limit = $request->limit ? "limit 10": "" ;
        $request->pag = $request->pag ? "OFFSET ".$request->pag : " ";
   
        $result = DB::select('select users."imgUrl" as img,"citas"."status",status,users.name as paciente, citas.created_at, "fechaCita", citas.id from citas
        inner join users
        on users.id = "idPaciente" '.$search." ORDER BY \"citas\".\"id\""." ".$limit."  ".$request->pag);
       /*/////////////////////////*
        return 'select users."imgUrl" as img,"citas"."status",status,users.name as paciente, citas.created_at, "fechaCita", citas.id from citas
        inner join users
        on users.id = "idPaciente" '.$search." ORDER BY \"citas\".\"id\""." ".$limit."  ".$request->pag;
        /////////////////////////*/
        $offset = DB::select('SELECT count( citas."id" ) from citas
        inner join users
        on users.id = "idPaciente" '.$search);
         $result[count($result)]=$offset;
        return response()->json($result,Response::HTTP_OK);

    }

    public function citaLook(Request $request){
        $request->validate([
            "cita"=>"required|min:0"
        ]);
        $result = DB::select('select (select id as idDoctor from users where "users"."id"=(select "idDoctor" from citas where id='.$request->cita.'))
        ,(select "users"."name" as doctor from users where "users"."id"=(select "idDoctor" from citas where id='.$request->cita.')),
                (select "especialidades"."name" as especialidad from especialidades where id=(select "idEspecialidad" from citas where id='.$request->cita.') ),
                ( select "especialidades"."id" as idEspecialidad from especialidades where id=(select "idEspecialidad" from citas where id='.$request->cita.') )
                ,(select count(id) from citas where "idPaciente"=users.id), "citas"."status","users"."created_at" as creado,status,users.name as paciente, citas.created_at, "fechaCita", citas.id, comentario, "users"."imgUrl" as imgUrl, "users"."age" as age, "users"."email" as email, "users"."dui" as dui from citas
                        inner join users
                        on users.id = "idPaciente" where citas.id='.$request->cita);
                        $result[0]->isAdmin = $request->user()->isAdmin;
        return response()->json($result,Response::HTTP_OK);
        }

        public function updateCita(Request $request){
            
     $request->validate([
                "estado"=>"required|min:0|max:2",
                "doctor"=>"required",
                "fechaCita"=>"required|min:10|max:10",
                "hora" =>"required|string|min:5|max:8",
                "doctor"=>"required|min:0",
                "especialidad"=>"required",
                "comentario"=>"required|string|min:1",
                "cita"=>"required|min:0",
            ]);
            if(date('Y-m-d H:i:s') < date($request->fechaCita." ".$request->hora)){
                if($request->user()->isAdmin){
                    return  response()->json(DB::select('UPDATE citas set "fechaCita"=\''.$request->fechaCita.' '.$request->hora.'\' , "idEspecialidad"='.$request->especialidad.' , "idDoctor"='.$request->doctor.',"comentario"=\''.$request->comentario.'\', "status"='.$request->estado.' where id = '.$request->cita));
                }else{
                    return response()->json(["msg"=>"not allowed"],404);
                }

           return  response()->json(DB::select('UPDATE citas set "fechaCita"=\''.$request->fechaCita.' '.$request->hora.'\' , "idEspecialidad"='.$request->especialidad.' , "idDoctor"='.$request->doctor.',"comentario"=\''.$request->comentario.'\', "status"='.$request->estado.' where id = '.$request->cita));
        }else{
            return response()->json(["err"=>date('Y-m-d H:i:s'),"given data"=>date($request->fechaCita." ".$request->hora)],404);
        }

        }

        public function closeCita(Request $request){
            $request->validate([
                "comentario"=>"required|string|min:0",
                "cita"=>"required|min:0"
            ]);

            return response()->json(DB::select('update citas set "status"=0, "comentario"=\''.$request->comentario.'\' where id='.$request->cita),Response::HTTP_OK);
        }

        public function deleteCita(Request $request){
            $request->validate([
                "cita"=>"required|min:0"
            ]);
            return response()->json(DB::select('DELETE FROM "citas" where id='.$request->cita),Response::HTTP_OK);
        }

        //add cita
        public function addCita(Request $request){
            $request->validate(["fechaCita"=>"required|date",
                                "especialidad"=>"required|min:0",
                                "doctor"=>"required|min:0",
                                "usuario"=>"required|min:0",
                                "hora"=>"required"
            ]);
            if(date('Y-m-d H:i:s')>date($request->fechaCita.' '.$request->hora)){
                return response()->json(["fecha"=>"la fecha de la cita no puede ser menor a la fecha actual"],405);
            }else{
                
                $citaNew = new citas;
                $citaNew->idEspecialidad =$request->especialidad;
                $citaNew->idDoctor=$request->doctor;
                $citaNew->idPaciente=$request->usuario;
                $citaNew->fechaCita = $request->fechaCita.' '.$request->hora;
                $citaNew->comentario='';
                $citaNew->validate=true;
                $citaNew->status=1;
                $citaNew->save();

                Event::fire(new citaAdd($citaNew));
            }
        }
}
 