<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OrderLines', function (Blueprint $table) {
            $table->string('ID');
            $table->string('strPartNumber');
            $table->string('Quantity');
            $table->decimal('OrigQty', 18, 2);
            $table->decimal('Price', 18, 2)->nullable();
            $table->decimal('Vat', 18, 2)->nullable();
            $table->boolean('Authorised')->nullable();
            $table->integer('DIMSOrderDetailID')->nullable();
            $table->string('strComment')->nullable();
            $table->decimal('LineDisc', 18, 2)->nullable();
            $table->string('externalOrderId')->nullable();
            $table->timestamps();

            $table->primary(['ID', 'strPartNumber']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OrderLines');
    }
}
