<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['employee_id'], 'user_Emp_FK')->references(['id'])->on('employees')->onDelete('CASCADE');
            $table->foreign(['role_id'], 'user_role_FK')->references(['id'])->on('roles')->onDelete('CASCADE');
            $table->foreign(['trainee_id'], 'user_trainee')->references(['id'])->on('trainees')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('user_Emp_FK');
            $table->dropForeign('user_role_FK');
            $table->dropForeign('user_trainee');
        });
    }
}
