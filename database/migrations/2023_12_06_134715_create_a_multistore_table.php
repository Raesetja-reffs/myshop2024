<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAMultistoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aMultistore', function (Blueprint $table) {
            $table->string('ItemCode', 15);
            $table->float('LastPurchAmt')->nullable();
            $table->float('CostThis13')->nullable();
            $table->float('QtyOnHand')->nullable();
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
        Schema::dropIfExists('aMultistore');
    }
}
