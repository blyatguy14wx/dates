<?php

use Illuminate\Http\Request;



Route::group(["prefix"=>"auth"],function(){
    Route::post("login","authController@login");
});

Route::group(["prefix"=>"dumpurl"],function(){
    Route::post('daolpu/gmi/edocsutatstihw/oskqisnfposaikan','userController@uploadPhoto');
});

Route::group(["prefix"=>"api","middleware"=>"auth:api"],function(){
    Route::get("updateuserp",'userController@updateUserP');
    Route::get('user','authController@user');
    Route::get('citas','citasController@citas');
    Route::get('citalook','citasController@citaLook');
    Route::get('updatecita','citasController@updateCita');
    Route::get('closecita','citasController@closeCita');
    Route::get('deletecita','citasController@deletecita');
    Route::get('logout','authController@logout');
    Route::get('deluser','userController@delUser');
    Route::get('especialidades','especialidadesController@especialidades');
    Route::get('citasearch','citasController@citasSearch');
    Route::get('citasespe','especialidadesController@citasEspe');
    Route::get('doctorcita','doctorController@doctorcita');
    Route::get('searchuser','userController@searchUser');
    Route::get('vselectuser','userController@vSelectUser');
    Route::get('addcita','citasController@addCita');
    Route::get("adduser",'userController@addUser');
    Route::get('doctorespecialidades','especialidadesController@doctorEspecialidades');
    Route::get('updateuser','userController@updateuser');
    Route::get('especialdadone','especialidadesController@especialdadOne');
    Route::get('updateesp','especialidadesController@updateEsp');
    Route::get('addesp','especialidadesController@addEsp');
    Route::get('deleteesp','especialidadesController@deleteEsp');
    Route::get('profile','authController@profile');
    Route::get('index','dashboardController@index');
    
});

Route::group(['prefix' => 'api'], function () {

});
