<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index('items_names');
            $table->string('brand', 100)->nullable();
            $table->string('model', 100);
            $table->unsignedTinyInteger('quality')->comment('from 1-> 5');
            $table->unsignedBigInteger('status_id')->index('items_status_FK');
            $table->string('serial', 50)->nullable();
            $table->string('barcode', 50)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('sub_inventory_id')->index('items_sub_inventory');
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
        Schema::dropIfExists('items');
    }
}
