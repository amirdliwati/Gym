<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number', 50)->nullable();
            $table->string('customer', 150);
            $table->date('date');
            $table->unsignedBigInteger('employee_id')->nullable()->index('receipt_book_employee');
            $table->unsignedTinyInteger('status')->comment('1-> archive  2-> not archive 3-> cancel');
            $table->unsignedTinyInteger('type')->comment('1-> receipt  2-> payment receipt');
            $table->unsignedInteger('currency_id')->index('receipt_book_currency');
            $table->double('amount');
            $table->string('notes', 500)->nullable();
            $table->string('amount_write', 500)->nullable();
            $table->string('lng', 10)->nullable();
            $table->unsignedBigInteger('pdf_template_id')->index('receipt_book_template');
            $table->unsignedBigInteger('employee_archive_id')->nullable()->index('receipt_book_employee_archive');
            $table->unsignedBigInteger('employee_cancel_id')->nullable()->index('receipt_book_employee_cancel');
            $table->string('notes_cancel', 500)->nullable();
            $table->unsignedBigInteger('account_id')->index('receipt_book_account');
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
        Schema::dropIfExists('receipts_books');
    }
}
