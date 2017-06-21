<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecurringElementsToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->boolean('is_recurring')->default(false);
            $table->integer('recurrence_period')->unsigned()->default(0)->nullable();
            $table->string('recurrence_type')->default('weeks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('is_recurring');
            $table->dropColumn('recurrence_period');
            $table->dropColumn('recurrence_type');
        });
    }
}
