<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('second_name', 100);
            $table->text('address');
            $table->string('email', 200);
            $table->string('mobile', 20);
            $table->string('phone', 20)->nullable();
            $table->string('website', 50)->nullable();
            $table->text('logo');
            $table->text('stamp')->nullable();
            $table->text('stamp2')->nullable();
            $table->string('type', 50)->nullable();
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
        Schema::dropIfExists('company_informations');
    }
}
