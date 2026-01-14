<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupAndOrderToProgrammingCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programming_calendars', function (Blueprint $table) {
            $table->string('group_name')->nullable()->after('end_date');
            $table->integer('position')->default(0)->after('group_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programming_calendars', function (Blueprint $table) {
            $table->dropColumn(['group_name', 'position']);
        });
    }
}
