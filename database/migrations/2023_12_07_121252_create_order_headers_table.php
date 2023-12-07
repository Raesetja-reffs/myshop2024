<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OrderHeaders', function (Blueprint $table) {
            $table->string('ID')->nullable();
            $table->date('OrderDate')->nullable();
            $table->date('DeliveryDate')->nullable();
            $table->string('OrderNumber')->nullable();
            $table->string('CustomerCode')->nullable();
            $table->text('Notes');
            $table->string('UserName')->nullable();
            $table->boolean('ExportedToDims')->default(0);
            $table->integer('DimsOrderID')->nullable();
            $table->integer('OrigOrderID')->nullable();
            $table->integer('DeliveryAddressID')->nullable();
            $table->boolean('bitBackOrder')->default(0);
            $table->boolean('bitCompleted')->default(0);
            $table->integer('intTransactionType')->default(1);
            $table->string('contact')->nullable();
            $table->boolean('TreatAsQuotation')->nullable();
            $table->string('Route')->nullable();

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
        Schema::dropIfExists('OrderHeaders');
    }
}
