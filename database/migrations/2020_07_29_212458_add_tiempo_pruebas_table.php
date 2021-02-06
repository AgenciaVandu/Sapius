<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTiempoPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pruebas', function (Blueprint $table) {
            $table->time('tiempo')
                ->after('descripcion')
                ->default('01:00:00')
                ->comment('Indica el tiempo asigando para presentar la prueba');
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
            $table->dropColumn('tiempo');
        });
    }
}
