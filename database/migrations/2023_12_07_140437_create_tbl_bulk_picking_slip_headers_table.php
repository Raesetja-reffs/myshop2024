<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBulkPickingSlipHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBulkPickingSlip_Header', function (Blueprint $table) {
            $table->id('BulkPickingSlipId');
            $table->datetime('Timestamp')->nullable();
            $table->datetime('DeliveryDate')->nullable();
            $table->integer('RouteId')->nullable();
            $table->integer('OrderType')->nullable();
            $table->integer('PrintedStatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBulkPickingSlip_Header');
    }
}
