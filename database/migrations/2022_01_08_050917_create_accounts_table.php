<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_number', 10)->nullable();
            $table->string('name', 100);
            $table->unsignedBigInteger('parent')->nullable()->index('accounts_parent');
            $table->unsignedBigInteger('closing')->nullable()->index('accounts_closing');
            $table->unsignedTinyInteger('type')->nullable()->comment('0-> normal 1-> closing');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
