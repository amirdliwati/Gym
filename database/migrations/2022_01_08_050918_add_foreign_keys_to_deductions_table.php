<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'deductions_employee')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['payroll_id'], 'payroll_deduc_FK')->references(['id'])->on('payrolls')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['salary_id'], 'salary_deduc_FK')->references(['id'])->on('salaries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deductions', function (Blueprint $table) {
            $table->dropForeign('deductions_employee');
            $table->dropForeign('payroll_deduc_FK');
            $table->dropForeign('salary_deduc_FK');
        });
    }
}
