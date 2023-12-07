<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAaPervOverallSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aaPervOverallSpecials', function (Blueprint $table) {
            $table->string('ItemCode', 20)->nullable();
            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE aaPervOverallSpecials ADD PriceIncl MONEY NULL');
        DB::statement('ALTER TABLE aaPervOverallSpecials ADD PriceExcl MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aaPervOverallSpecials');
    }
}
