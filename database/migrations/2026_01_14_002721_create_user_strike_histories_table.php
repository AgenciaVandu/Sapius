<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStrikeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_strike_histories')) {
            Schema::create('user_strike_histories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('user_id'); // Using unsignedInteger to match users.id
                $table->string('action');
                $table->text('details')->nullable();
                $table->timestamps();

                // Check if users table uses bigIncrements or increments (usually unsignedInteger)
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_strike_histories');
    }
}
