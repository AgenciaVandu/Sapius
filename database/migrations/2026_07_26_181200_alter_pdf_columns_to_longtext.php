<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterPdfColumnsToLongtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE material_pdfs MODIFY fields_config LONGTEXT NULL');
        DB::statement('ALTER TABLE alumno_pdf_respuestas MODIFY respuestas LONGTEXT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE material_pdfs MODIFY fields_config TEXT NULL');
        DB::statement('ALTER TABLE alumno_pdf_respuestas MODIFY respuestas TEXT NULL');
    }
}
