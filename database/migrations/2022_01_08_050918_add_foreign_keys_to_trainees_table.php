<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTraineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainees', function (Blueprint $table) {
            $table->foreign(['department_id'], 'trainee_department')->references(['id'])->on('departments')->onDelete('CASCADE');
            $table->foreign(['membership_id'], 'trainee_membership')->references(['id'])->on('memberships')->onDelete('CASCADE');
            $table->foreign(['position_id'], 'trainee_position')->references(['id'])->on('positions')->onDelete('CASCADE');
            $table->foreign(['country_id'], 'Train_Country_FK')->references(['id'])->on('countries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainees', function (Blueprint $table) {
            $table->dropForeign('trainee_department');
            $table->dropForeign('trainee_membership');
            $table->dropForeign('trainee_position');
            $table->dropForeign('Train_Country_FK');
        });
    }
}
