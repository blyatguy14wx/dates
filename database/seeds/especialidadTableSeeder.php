<?php

use Illuminate\Database\Seeder;
use App\Especialidades;

class especialidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(Especialidades::class,6)->create();
    }
}
