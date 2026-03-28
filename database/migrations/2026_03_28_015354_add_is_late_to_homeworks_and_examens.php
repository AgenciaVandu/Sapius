<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsLateToHomeworksAndExamens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('homework', 'is_late')) {
            Schema::table('homework', function (Blueprint $table) {
                $table->boolean('is_late')->default(false)->after('leccion_id');
            });
        }

        if (!Schema::hasColumn('examenes', 'is_late')) {
            Schema::table('examenes', function (Blueprint $table) {
                $table->boolean('is_late')->default(false)->after('finalizado');
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
        if (Schema::hasColumn('homework', 'is_late')) {
            Schema::table('homework', function (Blueprint $table) {
                $table->dropColumn('is_late');
            });
        }

        if (Schema::hasColumn('examenes', 'is_late')) {
            Schema::table('examenes', function (Blueprint $table) {
                $table->dropColumn('is_late');
            });
        }
    }
}
