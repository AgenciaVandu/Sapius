<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFechasToCursosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos_programados', function (Blueprint $table) {
            $table->dateTime('fecha_inicio_venta')->nullable();
            $table->dateTime('fecha_fin_venta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cursos_programados', function (Blueprint $table) {
            //
        });
    }
}
