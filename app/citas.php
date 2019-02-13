<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class citas extends Model
{
    public function citasDoctor(){
        
        return $this->belongsTo('App\User','idDoctor');

    }

    public function citasPaciente(){
        return $this->belongsTo('App\User','idPaciente');
    }
}
