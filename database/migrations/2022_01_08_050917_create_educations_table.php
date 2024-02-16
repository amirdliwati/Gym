<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level', 20);
            $table->string('school', 100);
            $table->string('degree', 100);
            $table->string('field', 100);
            $table->string('grade', 50);
            $table->date('start');
            $table->date('end');
            $table->unsignedInteger('location')->index('Edu_location_FK');
            $table->unsignedBigInteger('employee_id')->index('Emp_Edu_FK');
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
        Schema::dropIfExists('educations');
    }
}
