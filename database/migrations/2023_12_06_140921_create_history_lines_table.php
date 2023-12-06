<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HistoryLines', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('UserId')->nullable();
            $table->smallInteger('DocumentType')->nullable();
            $table->string('DocumentNumber', 8)->nullable();
            $table->string('ItemCode', 15)->nullable();
            $table->string('CustomerCode', 7)->nullable();
            $table->string('SalesmanCode', 5)->nullable();
            $table->smallInteger('SearchType')->nullable();
            $table->smallInteger('PPeriod')->nullable();
            $table->datetime('DDate')->nullable();
            $table->string('UnitUsed', 4)->nullable();
            $table->smallInteger('TaxType')->nullable();
            $table->smallInteger('DiscountType')->nullable();
            $table->smallInteger('DiscountPercentage')->nullable();
            $table->string('Description', 40)->nullable();
            $table->float('CostPrice')->nullable();
            $table->float('Qty')->nullable();
            $table->float('UnitPrice')->nullable();
            $table->float('InclusivePrice')->nullable();
            $table->float('FCurrUnitPrice')->nullable();
            $table->float('FCurrInclPrice')->nullable();
            $table->float('TaxAmt')->nullable();
            $table->float('FCurrTaxAmount')->nullable();
            $table->float('DiscountAmount')->nullable();
            $table->float('FCDiscountAmount')->nullable();
            $table->string('CostCode', 5)->nullable();
            $table->string('DateTime', 8)->nullable();
            $table->string('WhichUserDef', 1)->nullable();
            $table->smallInteger('Physical')->nullable();
            $table->smallInteger('Fixed')->nullable();
            $table->smallInteger('ShowQty')->nullable();
            $table->integer('LinkNum')->nullable();
            $table->integer('LinkedNum')->nullable();
            $table->float('GRNQty')->nullable();
            $table->integer('LinkID')->nullable();
            $table->string('MultiStore', 3)->nullable();
            $table->smallInteger('IsTMBLine')->nullable();
            $table->smallInteger('LinkDocumentType')->nullable();
            $table->string('LinkDocumentNumber', 8)->nullable();
            $table->string('Exported', 1)->nullable();
            $table->string('ExportRef', 4)->nullable();
            $table->integer('ExportNum')->nullable();
            $table->float('QtyLeft')->nullable();
            $table->string('CaseLotCode', 15)->nullable();
            $table->float('CaseLotQty')->nullable();
            $table->float('CaseLotRatio')->nullable();
            $table->integer('CostSyncDone')->nullable();
            $table->boolean('CurrentYear')->default(true);

            $table->timestamps();
        });

        // Add default constraint values
        DB::statement("ALTER TABLE HistoryLines ADD CONSTRAINT DF_HistoryLines_CurrentYear DEFAULT 1 FOR CurrentYear");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HistoryLines');
    }
}
