<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('pregunta_id');
            $table->foreign('pregunta_id')->references('id')->on('preguntas');

            $table->text('respuesta');
            $table->text('imagen')->nullable();
            $table->boolean('correcto');
            $table->unsignedInteger('posicion')->default(1);
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
        Schema::dropIfExists('respuestas');
    }
}
