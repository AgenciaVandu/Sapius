<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialPdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_pdfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leccion_id');
            $table->foreign('leccion_id')->references('id')->on('lecciones')->onDelete('cascade');
            $table->string('titulo');
            $table->string('file_path');
            $table->longText('fields_config')->nullable(); // Store field coordinates & labels as JSON string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_pdfs');
    }
}
