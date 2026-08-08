<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllowDownloadToMaterialPdfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_pdfs', function (Blueprint $table) {
            $table->boolean('allow_download')->default(true)->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_pdfs', function (Blueprint $table) {
            $table->dropColumn('allow_download');
        });
    }
}
