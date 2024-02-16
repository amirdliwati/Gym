<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSubInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_inventories', function (Blueprint $table) {
            $table->foreign(['branch_id'], 'sub_inventory_branch')->references(['id'])->on('branchs')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['inventory_type_id'], 'sub_inventory_type')->references(['id'])->on('inventory_types')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_inventories', function (Blueprint $table) {
            $table->dropForeign('sub_inventory_branch');
            $table->dropForeign('sub_inventory_type');
        });
    }
}
