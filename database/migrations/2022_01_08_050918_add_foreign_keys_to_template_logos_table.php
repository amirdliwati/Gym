<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTemplateLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('template_logos', function (Blueprint $table) {
            $table->foreign(['pdf_template_id'], 'logos_pdf_template')->references(['id'])->on('pdf_templates')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('template_logos', function (Blueprint $table) {
            $table->dropForeign('logos_pdf_template');
        });
    }
}
