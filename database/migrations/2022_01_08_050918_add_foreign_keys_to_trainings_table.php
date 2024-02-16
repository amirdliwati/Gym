<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'Emp_training_FK')->references(['id'])->on('employees')->onDelete('CASCADE');
            $table->foreign(['course_loc'], 'train_Country')->references(['id'])->on('countries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropForeign('Emp_training_FK');
            $table->dropForeign('train_Country');
        });
    }
}
