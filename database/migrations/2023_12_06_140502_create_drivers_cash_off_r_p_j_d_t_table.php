<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversCashOffRPJDTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DriversCashOffRPJDT', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intJournalID')->unsigned();
            $table->bigInteger('intDocumentType')->nullable();
            $table->string('strDocNumber', 50)->nullable();
            $table->string('strLineAccount', 255)->nullable();
            $table->string('strAccountDescription', 255)->nullable();
            $table->string('strType', 255)->nullable();
            $table->money('decAmount')->nullable();
            $table->integer('intUserId')->nullable();

            $table->foreign('intJournalID')->references('intJournalID')->on('DriversCashOffRPJ')->onDelete('cascade');

            $table->primary('intID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DriversCashOffRPJDT');
    }
}
