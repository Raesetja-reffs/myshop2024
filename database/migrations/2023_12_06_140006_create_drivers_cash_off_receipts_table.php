<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversCashOffReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DriversCashOffReceipts', function (Blueprint $table) {
            $table->id('intID');
            $table->bigInteger('intDocumentType')->nullable();
            $table->string('strDocNumber', 50)->nullable();
            $table->string('strCustomerCode', 50)->nullable();
            $table->string('strPartialReceiptNo', 255)->nullable();
            $table->string('strInv', 50)->nullable();
            $table->string('strAccountToPost', 255)->nullable();
            $table->integer('strCashControlAccount')->nullable();
            $table->date('dteDocDate')->nullable();
            $table->money('decCash')->nullable();
            $table->money('decChq')->nullable();
            $table->boolean('bitExported')->default(false);
            $table->string('strExportReference', 255)->nullable();
            $table->money('decInvoiceAmount')->nullable();
            $table->integer('intOwnerId')->nullable();
            $table->integer('intUserId')->nullable();

            $table->primary('intID');
            $table->index(['strDocNumber', 'strCustomerCode']);

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
        Schema::dropIfExists('DriversCashOffReceipts');
    }
}
