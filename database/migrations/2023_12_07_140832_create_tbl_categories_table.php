<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCategories', function (Blueprint $table) {
            $table->id('CategoryId')->notForReplication();
            $table->string('Category', 50)->nullable();
            $table->integer('MainCatId')->nullable();
            $table->float('Discount')->nullable();
            $table->float('cATDiscount')->nullable();
            $table->integer('HistoryFactorType')->nullable();
            $table->integer('HistoryFactor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblCategories');
    }
}
