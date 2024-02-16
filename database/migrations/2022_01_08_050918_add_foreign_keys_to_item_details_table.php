<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_details', function (Blueprint $table) {
            $table->foreign(['item_id'], 'item_details')->references(['id'])->on('items')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['origin_country'], 'item_origin_country')->references(['id'])->on('countries')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_details', function (Blueprint $table) {
            $table->dropForeign('item_details');
            $table->dropForeign('item_origin_country');
        });
    }
}
