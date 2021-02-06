<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetroVisualizadoToExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examenes', function (Blueprint $table) {
            $table->enum('retro_visualizado',['si','no'])
                ->after('finalizado')
                ->default('no')
                ->comment('Indica si la retroalimentacion ya fue vista');
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
            $table->dropColumn('retro_visualizado');
        });
    }
}
