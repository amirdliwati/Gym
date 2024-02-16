<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeesTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees_trainees', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'employee_trainee')->references(['id'])->on('employees')->onDelete('CASCADE');
            $table->foreign(['trainee_id'], 'trainee_employee')->references(['id'])->on('trainees')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees_trainees', function (Blueprint $table) {
            $table->dropForeign('employee_trainee');
            $table->dropForeign('trainee_employee');
        });
    }
}
