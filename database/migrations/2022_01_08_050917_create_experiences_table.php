<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employer', 50);
            $table->string('sector', 25)->nullable();
            $table->string('job_title', 50);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('job_loc')->index('Exp_cont_FK');
            $table->unsignedBigInteger('employee_id')->index('Emp_Exp_FK');
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
        Schema::dropIfExists('experiences');
    }
}
