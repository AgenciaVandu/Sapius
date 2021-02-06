<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalPreguntasTotalCorrectasFinalizadoToExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examenes', function (Blueprint $table) {
            $table->enum('finalizado',['si','no'])
                ->after('score_total')
                ->default('no')
                ->comment('Indica si la prueba fue finalizada');

                $table->float('total_correctas',8,2)
                ->after('score_total')
                ->nullable()
                ->default(0.00)
                ->comment('Almacena el total de respuestas correctas');

                $table->float('total_preguntas',8,2)
                ->after('score_total')
                ->nullable()
                ->default(0.00)
                ->comment('Almacena el total de preguntas de la prueba');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examenes', function (Blueprint $table) {
            $table->dropColumn('finalizado');
            $table->dropColumn('total_correctas');
            $table->dropColumn('total_preguntas');
        });
    }
}
