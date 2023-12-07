<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoiceHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SalesInvoiceHeader', function (Blueprint $table) {
            $table->integer('BatchID')->nullable();
            $table->string('DocNumber')->primary();
            $table->string('DocDate')->nullable();
            $table->string('CustomerNumber')->nullable();
            $table->string('SoldTo1')->nullable();
            $table->string('SoldTo2')->nullable();
            $table->string('SoldTo3')->nullable();
            $table->string('SoldTo4')->nullable();
            $table->string('SoldTo5')->nullable();
            $table->string('ShipTo1')->nullable();
            $table->string('ShipTo2')->nullable();
            $table->string('ShipTo3')->nullable();
            $table->string('ShipTo4')->nullable();
            $table->string('ShipTo5')->nullable();
            $table->integer('intFlag')->nullable()->default(0);
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
            $table->string('SalesmanCode')->nullable();
            $table->text('MESSAGESINV')->nullable();
            $table->date('OrderDate')->nullable();
            $table->date('DeliveryDate')->nullable();

            $table->timestamps();
        });

        DB::statement('ALTER TABLE SalesInvoiceHeader ADD Subtotal MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceHeader ADD Tax MONEY NULL');
        DB::statement('ALTER TABLE SalesInvoiceHeader ADD Total MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SalesInvoiceHeader');
    }
}
