<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('add_type')->comment('1=permanent,temp=2');
            $table->string('address', 200);
            $table->unsignedMediumInteger('state_id')->nullable()->index('Add_state_FK');
            $table->unsignedInteger('country_id')->index('Add_Country_FK');
            $table->unsignedBigInteger('employee_id')->nullable()->index('Add_Emp_FK');
            $table->unsignedBigInteger('trainee_id')->nullable()->index('addresse_trainee');
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
        Schema::dropIfExists('addresses');
    }
}
