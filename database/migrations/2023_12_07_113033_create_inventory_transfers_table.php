<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('InventoryTransfers', function (Blueprint $table) {
            $table->string('strDocNo');
            $table->integer('intFlag');
            $table->string('strErrorMessage')->nullable();
            $table->string('strCompanyName');
            $table->integer('intOrderId');
            $table->integer('intOutIn');

            $table->primary(['strDocNo', 'strCompanyName']);

            $table->timestamps();
        });

        DB::statement('ALTER TABLE InventoryTransfers ADD strXML xml NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('InventoryTransfers');
    }
}
