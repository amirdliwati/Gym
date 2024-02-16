<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIncrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('increments', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'increments_employee')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['payroll_id'], 'payroll_increse_FK')->references(['id'])->on('payrolls')->onUpdate('NO ACTION')->onDelete('SET NULL');
            $table->foreign(['salary_id'], 'salary_increse_FK')->references(['id'])->on('salaries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('increments', function (Blueprint $table) {
            $table->dropForeign('increments_employee');
            $table->dropForeign('payroll_increse_FK');
            $table->dropForeign('salary_increse_FK');
        });
    }
}
