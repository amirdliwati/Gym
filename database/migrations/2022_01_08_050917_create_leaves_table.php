<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('ispaid')->comment('yes=1,no=0');
            $table->unsignedBigInteger('type_id')->index('leave_type_FK');
            $table->unsignedBigInteger('employee_id')->index('leave_Emp_FK');
            $table->unsignedBigInteger('approved_by')->nullable()->index('leave_approved_FK');
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
        Schema::dropIfExists('leaves');
    }
}
