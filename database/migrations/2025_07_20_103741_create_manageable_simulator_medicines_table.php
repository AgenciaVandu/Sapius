<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageableSimulatorMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manageable_simulator_medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('image')->nullable();
            $table->string('type');
            $table->string('category');
            $table->integer('position');
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
        Schema::dropIfExists('manageable_simulator_medicines');
    }
}