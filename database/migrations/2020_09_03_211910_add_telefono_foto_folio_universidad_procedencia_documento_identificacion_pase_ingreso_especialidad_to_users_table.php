<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelefonoFotoFolioUniversidadProcedenciaDocumentoIdentificacionPaseIngresoEspecialidadToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable()->after('fecha_sustentacion');
            $table->string('foto')->nullable()->after('telefono');
            $table->string('folio')->nullable()->after('foto');
            $table->string('universidad_procedencia')->nullable()->after('folio');
            $table->string('documento_identificacion')->nullable()->after('universidad_procedencia');
            $table->string('pase_ingreso')->nullable()->after('documento_identificacion');
            $table->string('especialidad')->nullable()->after('pase_ingreso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto');
            $table->dropColumn('foto');
            $table->dropColumn('foto');
            $table->dropColumn('foto');
            $table->dropColumn('foto');
            $table->dropColumn('foto');
            $table->dropColumn('foto');
        });
    }
}
