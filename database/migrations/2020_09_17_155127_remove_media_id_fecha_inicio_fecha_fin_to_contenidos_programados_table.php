<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveMediaIdFechaInicioFechaFinToContenidosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contenidos_programados', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_fin');
            $table->dropForeign(['media_id']);
            $table->dropColumn('media_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contenidos_programados', function (Blueprint $table) {
            //
        });
    }
}
