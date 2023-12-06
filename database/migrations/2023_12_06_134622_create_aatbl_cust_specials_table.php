<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAatblCustSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aatblCustSpecials', function (Blueprint $table) {
            $table->string('CustomerCode', 20)->nullable();
            $table->string('ItemCode', 20)->nullable();
            $table->string('ExpDate', 20)->nullable();
            $table->money('Qty01')->nullable();
            $table->money('Price01')->nullable();
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
        Schema::dropIfExists('aatblCustSpecials');
    }
}
