<?php

use Faker\Generator as Faker;

$factory->define(App\doctorEspecialidad::class, function (Faker $faker) {
    return [
        "idDoctor"=>rand(1,6),
        "idEspecialidad"=>random_int(1,6)
    ];
});
