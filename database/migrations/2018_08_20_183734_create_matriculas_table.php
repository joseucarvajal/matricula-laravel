<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('idDepartamento')->nullable();
            $table->integer('idCiudad')->nullable();
            $table->string('nombre')->nullable();
            $table->string('documento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('estrato');
            $table->float('valor')->nullable();
            $table->foreign('idDepartamento')->references('id')->on('departamentos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('idCiudad')->references('id')->on('ciudads')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matriculas');
    }
}
