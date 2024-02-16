<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('amount');
            $table->text('notes');
            $table->unsignedBigInteger('employee_id')->index('tasks_employee');
            $table->unsignedBigInteger('salary_id')->index('tasks_salary');
            $table->unsignedBigInteger('payroll_id')->nullable()->index('tasks_payroll');
            $table->text('attach')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
