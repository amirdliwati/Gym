<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->double('amount');
            $table->text('notes')->nullable();
            $table->double('monthly')->nullable();
            $table->unsignedBigInteger('employee_id')->index('loan_Emp_FK');
            $table->unsignedBigInteger('salary_id')->nullable()->index('salary_loans');
            $table->double('paid')->nullable()->default(0);
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
        Schema::dropIfExists('loans');
    }
}
