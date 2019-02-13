<?php

use Illuminate\Database\Seeder;
use PHPUnit\Runner\Filter\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(App\User::class,20)->create();
    }
}

