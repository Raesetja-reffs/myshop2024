<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATempDelAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aTempDelAddresses', function (Blueprint $table) {
            $table->string('CustomerCode', 6);
            $table->string('CustDelivCode', 10)->nullable();
            $table->string('SalesmanCode', 5)->nullable();
            $table->string('Contact', 16)->nullable();
            $table->string('Telephone', 16)->nullable();
            $table->string('Cell', 16)->nullable();
            $table->string('Fax', 16)->nullable();
            $table->string('DelAddress01', 30)->nullable();
            $table->string('DelAddress02', 30)->nullable();
            $table->string('DelAddress03', 30)->nullable();
            $table->string('DelAddress04', 30)->nullable();
            $table->string('DelAddress05', 30)->nullable();
            $table->string('Email', 200)->nullable();
            $table->string('ContactDocs', 16)->nullable();
            $table->string('EmailDocs', 200)->nullable();
            $table->string('ContactStatement', 16)->nullable();
            $table->string('EmailStatement', 200)->nullable();
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
        Schema::dropIfExists('aTempDelAddresses');
    }
}
