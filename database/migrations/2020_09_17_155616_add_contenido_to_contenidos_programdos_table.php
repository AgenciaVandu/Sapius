<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContenidoToContenidosProgramdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contenidos_programados', function (Blueprint $table) {
            $table->json('contenido')->nullable()->after('curso_programado_id');
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
