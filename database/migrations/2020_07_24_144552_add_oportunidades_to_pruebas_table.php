<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOportunidadesToPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pruebas', function (Blueprint $table) {
            $table->unsignedInteger('oportunidades')
                ->after('descripcion')
                ->default(1)
                ->comment('Indica el numero de oportunidades para presentar la prueba');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pruebas', function (Blueprint $table) {
            $table->dropColumn('oportunidades');
        });
    }
}
