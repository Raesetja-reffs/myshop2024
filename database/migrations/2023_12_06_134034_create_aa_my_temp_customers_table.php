<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAaMyTempCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aaMyTempCustomers', function (Blueprint $table) {
            $table->string('CustomerCode', 6);
            $table->string('CustomerDesc', 40)->nullable();
            $table->string('PostAddress01', 30)->nullable();
            $table->string('PostAddress02', 30)->nullable();
            $table->string('PostAddress03', 30)->nullable();
            $table->string('PostAddress04', 30)->nullable();
            $table->string('PostAddress05', 30)->nullable();
            $table->integer('TaxCode')->nullable();
            $table->string('ExemptRef', 16)->nullable();
            $table->integer('SettlementTerms')->nullable();
            $table->integer('PaymentTerms')->nullable();
            $table->string('Blocked', 5)->nullable();
            $table->string('IncExc', 5)->nullable();
            $table->bigInteger('CreditLimit')->nullable();
            $table->string('UserDefined01', 16)->nullable();
            $table->string('UserDefined02', 16)->nullable();
            $table->string('UserDefined03', 16)->nullable();
            $table->string('UserDefined04', 16)->nullable();
            $table->string('UserDefined05', 16)->nullable();
            $table->integer('PriceRegime')->nullable();
            $table->money('Balance')->nullable();
            $table->string('Category', 50)->nullable();
            $table->money('Discount')->nullable();
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
        Schema::dropIfExists('aaMyTempCustomers');
    }
}
