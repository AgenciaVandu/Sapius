<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrecioClaveDescuentoToCursosProgramadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cursos_programados', function (Blueprint $table) {
            $table->float('precio',8,2)->default(0.00)->after('fecha_fin');
            $table->string('clave_descuento',45)->nullable()->after('fecha_fin');
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
            $table->dropColumn('precio');
            $table->dropColumn('clave_descuento');
        });
    }
}
