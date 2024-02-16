<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('prefix')->comment('Mr=0,Ms=1,Mrs=2');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->date('birthdate');
            $table->string('blood', 5)->nullable();
            $table->boolean('gender')->comment('female=0, male=1');
            $table->unsignedTinyInteger('marital_status')->comment('sin=0,mar=1,div=2,wid=3');
            $table->unsignedInteger('country_id')->nullable()->index('Emp_Nat_FK');
            $table->string('national_no', 30)->nullable();
            $table->string('passport', 20)->nullable();
            $table->string('email', 200);
            $table->string('system_email', 200)->nullable();
            $table->text('image')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedTinyInteger('status')->default('1')->comment('1->New 2->Registered 3->Canceled 4->Waiting');
            $table->unsignedBigInteger('department_id')->nullable()->index('trainee_department');
            $table->unsignedBigInteger('position_id')->index('trainee_position');
            $table->unsignedBigInteger('membership_id')->index('trainee_membership');
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
        Schema::dropIfExists('trainees');
    }
}
