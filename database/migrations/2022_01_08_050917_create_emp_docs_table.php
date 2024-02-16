<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_docs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('docu_type', 50);
            $table->string('description', 200);
            $table->text('docu_attach')->nullable();
            $table->unsignedBigInteger('employee_id')->index('Emp_docss_FK');
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
        Schema::dropIfExists('emp_docs');
    }
}
