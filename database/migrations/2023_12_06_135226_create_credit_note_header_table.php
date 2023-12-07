<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditNoteHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CreditNoteHeader', function (Blueprint $table) {
            $table->string('DocNumber', 50);
            $table->string('DocDate', 50);
            $table->string('CustomerNumber', 50);
            $table->string('SoldTo', 500);
            $table->string('ShipTo', 500);
            $table->string('Subtotal', 50);
            $table->string('Tax', 50);
            $table->string('Total', 50);
            $table->string('OriginalDocNumber', 50);
            $table->integer('intFlag')->default(0);
            $table->string('ErrorMessage', 250)->nullable();
            $table->string('DIMS_ReturnId', 50)->nullable();
            $table->string('PaymentTerms', 50)->nullable();
            $table->string('CreditNoteReason', 50)->nullable();
            $table->boolean('BatchReportPrinted')->nullable();
            $table->string('InvoiceRef', 50)->nullable();
            $table->string('HeaderDiscount', 50)->default(0);
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
        Schema::dropIfExists('CreditNoteHeader');
    }
}
