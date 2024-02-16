<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->foreign(['status_id'], 'items_status_FK')->references(['id'])->on('status_items')->onDelete('CASCADE');
            $table->foreign(['sub_inventory_id'], 'items_sub_inventory')->references(['id'])->on('sub_inventories')->onDelete('CASCADE');
            $table->foreign(['category_id'], 'item_category')->references(['id'])->on('categories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_status_FK');
            $table->dropForeign('items_sub_inventory');
            $table->dropForeign('item_category');
        });
    }
}
