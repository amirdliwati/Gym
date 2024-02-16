<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign(['account_id'], 'employee_account')->references(['id'])->on('accounts')->onDelete('CASCADE');
            $table->foreign(['currencies_id'], 'employee_currency')->references(['id'])->on('currencies')->onDelete('CASCADE');
            $table->foreign(['country_id'], 'Emp_Country_FK')->references(['id'])->on('countries')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['line'], 'Emp_line_FK')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['position_id'], 'Emp_Post_FK')->references(['id'])->on('positions')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['status_id'], 'Emp_stus_FK')->references(['id'])->on('jobs_status')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['job_type_id'], 'Emp_type_FK')->references(['id'])->on('job_types')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employee_account');
            $table->dropForeign('employee_currency');
            $table->dropForeign('Emp_Country_FK');
            $table->dropForeign('Emp_line_FK');
            $table->dropForeign('Emp_Post_FK');
            $table->dropForeign('Emp_stus_FK');
            $table->dropForeign('Emp_type_FK');
        });
    }
}
