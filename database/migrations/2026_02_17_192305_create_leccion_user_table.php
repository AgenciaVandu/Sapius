<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeccionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leccion_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leccion_id');
            $table->unsignedBigInteger('curso_programado_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('leccion_id')->references('id')->on('lecciones')->onDelete('cascade');
            $table->foreign('curso_programado_id')->references('id')->on('cursos_programados')->onDelete('cascade');

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'leccion_id', 'curso_programado_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leccion_user');
    }
}
