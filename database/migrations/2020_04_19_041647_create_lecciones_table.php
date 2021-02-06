<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('id')->on('cursos');

            $table->text('titulo');
            $table->string('slug', 255)->nullable();
            $table->text('imagen')->nullable();
            $table->text('contenido')->nullable();
            $table->text('resumen')->nullable();
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
        Schema::dropIfExists('leccions');
    }
}
