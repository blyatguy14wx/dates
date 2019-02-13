<?php

use Faker\Generator as Faker;

$factory->define(App\Especialidades::class, function (Faker $faker) {
    return [
        "descripcion"=>$faker->text(),
        "name"=>$faker->randomElement(["odontologo","oculista","dentista","otorrinaringologo","psicologo","veterinario"]),
        "urlImg"=>$faker->imageUrl($width="200px",$height="200px")

    ];
});
