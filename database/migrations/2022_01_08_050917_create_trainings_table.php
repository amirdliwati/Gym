<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('issue_cer');
            $table->string('course', 50);
            $table->string('institute', 50)->nullable();
            $table->unsignedInteger('course_loc')->index('train_Country');
            $table->string('result', 20)->nullable();
            $table->text('train_cer')->nullable();
            $table->unsignedBigInteger('employee_id')->index('Emp_training_FK');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
