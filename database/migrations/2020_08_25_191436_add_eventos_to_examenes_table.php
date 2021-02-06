<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventosToExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('examenes', function (Blueprint $table) {
            $table->longText('eventos')
                ->after('retro_visualizado')
                ->nullable()
                ->default(null)
                ->comment('Indica las teclas presionadas por el usuario');
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
            $table->dropColumn('eventos');
        });
    }
}
