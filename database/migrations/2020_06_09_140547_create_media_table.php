<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('tipo', ['imagen','archivo','liga','video']);
            $table->text('ruta');

            $table->unsignedBigInteger('leccion_id');
            $table->foreign('leccion_id')->references('id')->on('lecciones');

            $table->enum('programable', ['si','no'])->deafult('si');
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
        Schema::dropIfExists('media');
    }
}
