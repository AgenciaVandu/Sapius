<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContenidoToLeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lecciones', function (Blueprint $table) {
            DB::statement("ALTER TABLE lecciones MODIFY contenido LONGTEXT");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lecciones', function (Blueprint $table) {
            //
        });
    }
}
