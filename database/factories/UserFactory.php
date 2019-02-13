<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'isAdmin'=>$faker->randomElement([TRUE,FALSE]),
        "isDoctor"=>$faker->randomElement([TRUE,FALSE]),
        "isAllow"=>$faker->randomElement([TRUE,FALSE]),
        "imgUrl"=>"/img/avatar.png",
        "age"=>random_int(1,99),
        "dui"=>random_int(100000,9999999),
        "contacto"=>$faker->email
    ];
});
