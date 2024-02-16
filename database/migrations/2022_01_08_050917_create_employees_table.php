<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('prefix')->comment('Mr=1,Ms=2,Mrs=3,Dr=4,Eng=5	');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('mother', 50)->nullable();
            $table->date('birthdate');
            $table->string('blood', 5)->nullable();
            $table->boolean('gender')->comment('female=0, male=1');
            $table->unsignedTinyInteger('marital_status')->comment('sin=0,mar=1,div=2,wid=3');
            $table->unsignedInteger('country_id')->nullable()->index('Emp_Nat_FK');
            $table->string('national_no', 30)->nullable();
            $table->string('passport', 20)->nullable();
            $table->string('email', 200);
            $table->string('system_email', 200)->nullable();
            $table->unsignedBigInteger('line')->nullable()->index('Emp_line_FK');
            $table->date('hire_date');
            $table->date('resignation_date')->nullable();
            $table->unsignedInteger('job_type_id')->nullable()->index('Emp_type_FK');
            $table->unsignedInteger('status_id')->nullable()->index('Emp_stus_FK');
            $table->unsignedBigInteger('position_id')->nullable()->index('Emp_Post_FK');
            $table->unsignedInteger('currencies_id')->nullable()->index('employee_currency');
            $table->text('emp_image')->nullable();
            $table->text('notes')->nullable();
            $table->text('sign')->nullable();
            $table->unsignedBigInteger('account_id')->nullable()->index('employee_account');
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
        Schema::dropIfExists('employees');
    }
}
