<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBriefcaseRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBriefcaseReminders', function (Blueprint $table) {
            $table->id('intReminderId');
            $table->string('strNotes', 500)->nullable();
            $table->date('strRemiderDaydate')->nullable();
            $table->string('strCustomerCode', 50)->nullable();
            $table->integer('intUserId')->nullable();
            $table->datetime('dteCreated')->nullable()->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBriefcaseReminders');
    }
}
