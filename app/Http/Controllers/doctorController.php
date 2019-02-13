<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class doctorController extends Controller
{
    public function doctorcita(Request $request){
        return response()->json(DB::select('select id, name as label from users where id = ANY (select "idDoctor" from doctor_especialidades where "idEspecialidad"='.$request->id.' )'),Response::HTTP_OK);

    }
}
