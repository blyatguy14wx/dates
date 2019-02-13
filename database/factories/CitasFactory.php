<?php

use Faker\Generator as Faker;

$factory->define(App\citas::class, function (Faker $faker) {
    return [
        "fechaCita"=>Date('Y-m-d'),
        "idPaciente"=>random_int(1,20),
        "idDoctor"=>random_int(1,20),
        "comentario"=>$faker->text(),
        "validate"=>$faker->randomElement([TRUE,FALSE]),
        "status"=>$faker->randomElement([1,2,0]),
        "idEspecialidad"=>random_int(1,6)
    ];
});
