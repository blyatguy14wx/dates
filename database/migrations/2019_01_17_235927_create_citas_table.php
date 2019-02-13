<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('fechaCita');
            $table->unsignedInteger('idPaciente');
            $table->unsignedInteger('idDoctor')->nullable();
            $table->foreign('idPaciente')->on('users')->references('id')->onDelete("cascade");
            $table->foreign('idDoctor')->on('users')->references('id')->onDelete("cascade");
            $table->text('comentario');
            $table->boolean('validate');
            $table->integer('status');
            $table->unsignedInteger('idEspecialidad');
            $table->foreign('idEspecialidad')->on('especialidades')->references('id')->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
