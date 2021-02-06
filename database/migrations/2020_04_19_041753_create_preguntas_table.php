<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('prueba_id');
            $table->foreign('prueba_id')->references('id')->on('pruebas');

            $table->text('pregunta');
            $table->text('opciones');
            $table->text('imagen')->nullable();
            $table->float('score', 8, 2)->default(1.00);

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
        Schema::dropIfExists('preguntas');
    }
}
