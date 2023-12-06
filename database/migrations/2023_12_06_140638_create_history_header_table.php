<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HistoryHeader', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('DocumentType')->nullable();
            $table->string('DocumentNumber', 8)->nullable();
            $table->string('CustomerCode', 6)->nullable();
            $table->datetime('DocumentDate')->nullable();
            $table->string('OrderNumber', 25)->nullable();
            $table->string('SalesmanCode', 5)->nullable();
            $table->smallInteger('UserID')->nullable();
            $table->smallInteger('ExclIncl')->nullable();
            $table->string('Message01', 30)->nullable();
            $table->string('Message02', 30)->nullable();
            $table->string('Message03', 30)->nullable();
            $table->string('DelAddress01', 30)->nullable();
            $table->string('DelAddress02', 30)->nullable();
            $table->string('DelAddress03', 30)->nullable();
            $table->string('DelAddress04', 30)->nullable();
            $table->string('DelAddress05', 30)->nullable();
            $table->smallInteger('Terms')->nullable();
            $table->smallInteger('ExtraCosts')->nullable();
            $table->string('CostCode', 5)->nullable();
            $table->smallInteger('PPeriod')->nullable();
            $table->datetime('ClosingDate')->nullable();
            $table->string('Telephone', 16)->nullable();
            $table->string('Fax', 16)->nullable();
            $table->string('Contact', 16)->nullable();
            $table->smallInteger('CurrencyCode')->nullable();
            $table->float('ExchangeRate')->nullable();
            $table->float('DiscountPercent')->nullable();
            $table->float('Total')->nullable();
            $table->float('FCurrTotal')->nullable();
            $table->float('TotalTax')->nullable();
            $table->float('FCurrTotalTax')->nullable();
            $table->float('TotalCost')->nullable();
            $table->string('InvDeleted', 1)->nullable();
            $table->string('InvPrintStatus', 1)->nullable();
            $table->smallInteger('Onhold')->nullable();
            $table->string('GRNMisc', 1)->nullable();
            $table->smallInteger('Paid')->nullable();
            $table->string('Freight01', 10)->nullable();
            $table->string('Ship', 16)->nullable();
            $table->smallInteger('IsTMBDoc')->nullable();
            $table->string('Spare', 20)->nullable();
            $table->string('Exported', 1)->nullable();
            $table->string('ExportRef', 4)->nullable();
            $table->integer('ExportNum')->nullable();
            $table->string('Emailed', 1)->nullable();
            $table->boolean('CurrentYear')->default(true);

            $table->timestamps();
        });

        // Add default constraint values
        DB::statement("ALTER TABLE HistoryHeader ADD CONSTRAINT DF_HistoryHeader_DocumentType DEFAULT 1 FOR DocumentType");
        DB::statement("ALTER TABLE HistoryHeader ADD CONSTRAINT DF_HistoryHeader_CurrentYear DEFAULT 1 FOR CurrentYear");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HistoryHeader');
    }
}
