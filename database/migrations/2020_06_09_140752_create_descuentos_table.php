<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('clave', 45);
            $table->float('descuento', 8, 2)->default(0.00);
            $table->unsignedInteger('limite')->default(1);
            $table->unsignedBigInteger('curso_programado_id');
            $table->foreign('curso_programado_id')->references('id')->on('cursos_programados');

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
        Schema::dropIfExists('descuentos');
    }
}
