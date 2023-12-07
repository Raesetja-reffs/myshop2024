<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceHeaderSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SalesInvoiceHeaderSource', function (Blueprint $table) {
            $table->integer('BatchID')->nullable();
            $table->string('DocNumber')->primary();
            $table->string('DocDate')->nullable();
            $table->string('CustomerNumber')->nullable();
            $table->string('SoldTo')->nullable();
            $table->string('ShipTo')->nullable();
            $table->integer('intFlag')->nullable();
            $table->string('ErrorMessage', 250)->nullable();
            $table->boolean('PushLive')->nullable();
            $table->string('DIMS_OrderId')->nullable();
            $table->string('ExportType')->nullable();
            $table->string('PaymentTerms')->nullable();
            $table->string('DIMS_OrderNo')->nullable();
            $table->boolean('BatchReportPrinted')->nullable();
            $table->string('HeaderDiscount')->nullable();
            $table->string('CompanyName')->nullable();
            $table->string('StatementStoreCode')->nullable();
            $table->string('UserDef1')->nullable();
            $table->bigInteger('JournalNumber')->nullable();
            $table->string('UserDef2')->nullable();
            $table->string('UserDef3')->nullable();
            $table->string('UserDef4')->nullable();
            $table->string('UserDef5')->nullable();
            $table->string('UserDef6')->nullable();
            $table->string('UserDef7')->nullable();
            $table->string('UserDef8')->nullable();
            $table->string('UserDef9')->nullable();
            $table->string('UserDef10')->nullable();
            $table->string('UserDef11')->nullable();
            $table->string('UserDef12')->nullable();
            $table->string('UserDef13')->nullable();
            $table->string('UserDef14')->nullable();
            $table->string('ComputerName')->nullable();
            $table->string('Printer', 150)->nullable();
            $table->string('SupplierDocumentNumber')->nullable();
            $table->integer('intSupplierFlag')->nullable();
            $table->string('SupplierErrorMessage', 255)->nullable();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE SalesInvoiceHeaderSource ADD Subtotal MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceHeaderSource ADD Tax MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceHeaderSource ADD Total MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SalesInvoiceHeaderSource');
    }
}

