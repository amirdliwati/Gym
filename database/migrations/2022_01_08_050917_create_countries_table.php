<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->string('iso2', 2)->nullable()->unique('alpha_2_code');
            $table->string('iso3', 3)->nullable()->unique('alpha_3_code');
            $table->string('name', 52)->nullable();
            $table->string('nationality', 39)->nullable()->index('nationality');
            $table->unsignedTinyInteger('status')->default('0');
            $table->string('currency', 4)->nullable();
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
        Schema::dropIfExists('countries');
    }
}
