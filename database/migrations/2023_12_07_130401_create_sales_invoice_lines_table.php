<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SalesInvoiceLines', function (Blueprint $table) {
            $table->string('DocNumber');
            $table->string('PartNumber');
            $table->string('UnitOfMeasure')->nullable();
            $table->integer('DIMS_OrderDetailId')->nullable();
            $table->string('PDesc', 250)->nullable();
            $table->string('Location')->nullable();
            $table->string('UserDef1')->nullable();
            $table->string('UserDef2')->nullable();
            $table->string('UserDef3')->nullable();
            $table->string('Comment', 250)->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE SalesInvoiceLines ADD Qty MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceLines ADD UnitPrice MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceLines ADD LineTax MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceLines ADD LineTotal MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceLines ADD LineDiscount MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceLines ADD QtyInStock MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SalesInvoiceLines');
    }
}
