<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factory;

class DoctorEspTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(App\doctorEspecialidad::class,20)->create();
    }
}
