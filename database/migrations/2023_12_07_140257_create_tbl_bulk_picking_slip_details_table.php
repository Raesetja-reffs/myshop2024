<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBulkPickingSlipDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBulkPickingSlip_Details', function (Blueprint $table) {
            $table->id('BulkPickingSlipDetailId');
            $table->integer('BulkPickingSlipHeaderId')->nullable();
            $table->integer('ProductId')->nullable();
            $table->float('PriorQty')->nullable();
            $table->float('CurrentQty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBulkPickingSlip_Details');
    }
}
