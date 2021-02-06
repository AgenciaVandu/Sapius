<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdentificadorToCursosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos_programados', function (Blueprint $table) {
            $table->string('identificador')
                ->after('id')
                ->nullable()
                ->default(null)
                ->comment('Es el identificador del curso programado');
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
            $table->dropColumn('identificador');
        });
    }
}
