<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'contacto','facebook_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pacienteCitas(){
        return $this->hasMany('App\citas','idPaciente');
    }

    public function doctorCitas(){
        return $this->hasMany('App\citas','idDoctor');
    }

    public function doctorEspecialidad(){
        return $this->hasMany("App\doctorEspecialidad","idDoctor");
    }

    public function addNew($newUser){
        $check=static::where("facebook_id",$newUser["facebook_id"])->first();
        if(is_null($check)){
           return static::create($newUser);    
        }

        return $check;

    }
}
