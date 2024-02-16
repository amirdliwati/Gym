<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->foreign(['pdf_template_id'], 'payrolls_template')->references(['id'])->on('pdf_templates')->onDelete('CASCADE');
            $table->foreign(['employee_id'], 'payroll_employee')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['issued_employee_id'], 'payroll_employee_issued')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['salary_id'], 'payroll_salary_FK')->references(['id'])->on('salaries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropForeign('payrolls_template');
            $table->dropForeign('payroll_employee');
            $table->dropForeign('payroll_employee_issued');
            $table->dropForeign('payroll_salary_FK');
        });
    }
}
