<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'tasks_employee')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['payroll_id'], 'tasks_payroll')->references(['id'])->on('payrolls')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['salary_id'], 'tasks_salary')->references(['id'])->on('salaries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign('tasks_employee');
            $table->dropForeign('tasks_payroll');
            $table->dropForeign('tasks_salary');
        });
    }
}
