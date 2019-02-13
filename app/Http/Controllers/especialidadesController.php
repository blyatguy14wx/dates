<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Especialidades;
use Illuminate\Support\Facades\DB;

class especialidadesController extends Controller
{
    public function citasEspe(Response $request){
        return response()->json(Especialidades::select('id','name as label')->get(),Response::HTTP_OK);
    }

    public function serachEspe(Response $request){
        return response()->json(DB::select('select * from users where id = any (select "idDoctor" from doctor_especialidades where "idEspecialidad"='.$request->id.')'),Response::HTTP_OK);
    }

    public function doctorEspecialidades(Request $request){
        $request->validate(["id"=>"required"]);
        if($request->id && is_numeric($request->id)){
            return response()->json(DB::select('select id, name as label from especialidades where id= any (select "idEspecialidad" from doctor_especialidades where "idDoctor"='.$request->id.')'));
        }
    }

    public function especialidades(Request $request){
        $search='WHERE';
        if($request->name){
            $search.=" \"especialidades\".\"name\" LIKE '%".$request->name."%' AND ";
        }
        if($request->id){
            $search.=" \"especialidades\".\"id\" = '".$request->id."' AND ";
        }
        $query="";
        //verificar si hay algun parametro seleccionado
        if(substr($search,strlen($search)-4,4)=="AND "){
            $query = " ".substr($search,.0,strlen($search)-4);
        };
        //return 'select * from users '.$query.' ORDER BY id  LIMIT 10 OFFSET '.$request->pag.' ';
        $result = DB::select('select * from especialidades '.$query.' ORDER BY id  LIMIT 10 OFFSET '.$request->pag.' ');

        $offset = DB::select('SELECT count( "especialidades"."id" ) from especialidades '.$query);
         $result[count($result)]=$offset;

        return response()->json($result,200);
    }

    public function especialdadOne(Request $request){
        $request->validate([
            "id"=>"required|string|min:1"
        ]);
            $query = 'select (select count(id) from citas where citas.status=0 and "idEspecialidad"='.$request->id.') as deactive,(select count(id) from citas where citas.status=1 and "idEspecialidad"='.$request->id.') as active, (select count(id) from citas where citas.status=2 and "idEspecialidad"='.$request->id.') as pendient';
            $tot=DB::select($query);
            $tot[1]=DB::select('select (select count(id) as doctors from users where id = any (select "idDoctor" from doctor_especialidades where "idEspecialidad"='.$request->id.')),(select count(id) as pacientes from users where id = any (select "idPaciente" from citas where "idEspecialidad"='.$request->id.'))');
            return response()->json($tot,200);
    }

    public function updateEsp(Request $request){
        $request->validate([
            "id"=>"required|min:1|string",
            "name"=>"required|min:1|string"
        ]);
        $total = DB::select("select count(id) as id from especialidades where id!=".$request->id." and \"name\"='".$request->name."'");
        if($total[0]->id+0 > 0){
          return response()->json(["err"=>"there is already another name like that"],404);
        }else{
            $data = DB::select("update especialidades set name='".$request->name."' where id=".$request->id);
            $data = $data==1? "update done": "err something wnet wrong trying to update this item" ;
            return response()->json(["msg"=>$data],200);
        }

        
    }

    public function deleteEsp(Request $request){
        $request->validate([
            "id"=>"required|min:1|string"
        ]);
        $data = DB::select("DELETE FROM especialidades WHERE id=".$request->id);
        $data = $data==1? "delete done": "err something wnet wrong trying to delete this item" ;
        return response()->json(["msg"=>$data],200);
    }

    public function addEsp(Request $request){
        $request->validate([
            "name"=>"required|min:1|string"
        ]);
            $total = DB::select("select count(id) as id from especialidades where \"name\"='".$request->name."'");
         if($total[0]->id+0 > 0){
           return response()->json(["err"=>"there is already another name like that"],404);
         }else{
             $esp = new Especialidades;
             $esp->name = $request->name;
             $esp->descripcion = "";
             $esp->urlImg="";
             $esp->save();
             return response()->json(["msg"=>"add done"],201);
         }
    }
}
