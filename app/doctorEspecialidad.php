<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class doctorEspecialidad extends Model
{
    protected $table = "doctor_especialidades";
    public function doctorEspecialidades(){
        return $this->belongsToMany("App\User","idDoctor");
    }

    public function EspeciliadidadDoctores(){
        return $this->belongsToMany("App\User","idEspecialidad");
    }
}
