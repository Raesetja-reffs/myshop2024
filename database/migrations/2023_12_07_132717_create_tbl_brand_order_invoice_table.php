<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBrandOrderInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBrandOrderInvoice', function (Blueprint $table) {
            $table->integer('BrandId');
            $table->integer('OrderId');
            $table->string('OrderNo', 50)->nullable();
            $table->string('DocNo', 50)->nullable();
            $table->boolean('Changed')->default(0);
            $table->string('CrateDocNo', 50)->nullable();
            $table->float('CratesIn')->nullable();
            $table->float('CratesOut')->nullable();
            $table->float('CratesActual')->nullable();
            $table->dateTime('TimeIn')->nullable();
            $table->dateTime('TimeOut')->nullable();
            $table->boolean('CreditIssued')->default(0);
            $table->string('CreditNote', 50)->nullable();

            $table->primary(['BrandId', 'OrderId']);
        });

        DB::statement('ALTER TABLE tblBrandOrderInvoice ADD mnySubTotal MONEY NULL');
        DB::statement('ALTER TABLE tblBrandOrderInvoice ADD mnyTax MONEY NULL');
        DB::statement('ALTER TABLE tblBrandOrderInvoice ADD mnyTotal MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBrandOrderInvoice');
    }
}
