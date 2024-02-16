<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('total')->nullable();
            $table->unsignedBigInteger('employee_id')->index('payroll_employee');
            $table->unsignedBigInteger('issued_employee_id')->index('payroll_employee_issued');
            $table->unsignedBigInteger('salary_id')->index('payroll_salary_FK');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('pdf_template_id')->nullable()->index('paroll_template');
            $table->text('signature')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
