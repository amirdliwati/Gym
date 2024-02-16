<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('days_count')->nullable();
            $table->unsignedInteger('hours_count')->nullable();
            $table->unsignedInteger('remain_days')->nullable();
            $table->unsignedInteger('remain_hours')->nullable();
            $table->unsignedBigInteger('employee_id')->index('leaverole_Emp_FK');
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
        Schema::dropIfExists('leave_roles');
    }
}
