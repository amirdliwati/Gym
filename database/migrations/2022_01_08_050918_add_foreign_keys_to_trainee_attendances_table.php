<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTraineeAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainee_attendances', function (Blueprint $table) {
            $table->foreign(['trainee_id'], 'trainee_attendances')->references(['id'])->on('trainees')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainee_attendances', function (Blueprint $table) {
            $table->dropForeign('trainee_attendances');
        });
    }
}
