<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContenidosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contenidos_programados', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('curso_programado_id');
            $table->foreign('curso_programado_id')->references('id')->on('cursos_programados');
            $table->unsignedBigInteger('media_id');
            $table->foreign('media_id')->references('id')->on('media');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');

            $table->enum('activo', ['si','no'])->deafult('si');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contenidos_programados');
    }
}
