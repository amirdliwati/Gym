<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('doc_type', 50);
            $table->date('start_vaild');
            $table->date('end_valid');
            $table->text('legal_attach')->nullable();
            $table->unsignedBigInteger('employee_id')->index('Emp_doc_FK');
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
        Schema::dropIfExists('legal_docs');
    }
}
