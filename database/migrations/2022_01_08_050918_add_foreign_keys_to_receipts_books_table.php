<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToReceiptsBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts_books', function (Blueprint $table) {
            $table->foreign(['account_id'], 'receipt_book_account')->references(['id'])->on('accounts')->onDelete('CASCADE');
            $table->foreign(['currency_id'], 'receipt_book_currency')->references(['id'])->on('currencies')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['employee_id'], 'receipt_book_employee')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['employee_archive_id'], 'receipt_book_employee_archive')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['employee_cancel_id'], 'receipt_book_employee_cancel')->references(['id'])->on('employees')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['pdf_template_id'], 'receipt_book_template')->references(['id'])->on('pdf_templates')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts_books', function (Blueprint $table) {
            $table->dropForeign('receipt_book_account');
            $table->dropForeign('receipt_book_currency');
            $table->dropForeign('receipt_book_employee');
            $table->dropForeign('receipt_book_employee_archive');
            $table->dropForeign('receipt_book_employee_cancel');
            $table->dropForeign('receipt_book_template');
        });
    }
}
