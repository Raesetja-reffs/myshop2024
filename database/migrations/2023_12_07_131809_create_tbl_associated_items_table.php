<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAssociatedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAssociatedItems', function (Blueprint $table) {
            $table->integer('intAssociatedItemID');
            $table->integer('intProductId');
            $table->integer('intAssociatedProductId');
            $table->timestamps();

            $table->primary('intAssociatedItemID');
        });

        DB::statement('ALTER TABLE tblAssociatedItems ADD decQuantity MONEY NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblAssociatedItems');
    }
}
