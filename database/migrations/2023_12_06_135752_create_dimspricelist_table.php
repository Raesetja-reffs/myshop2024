<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimspricelistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DIMSPRICELIST', function (Blueprint $table) {
            $table->string('Code', 50)->nullable();
            $table->string('PastelDescription', 50)->nullable();
            $table->string('Item', 50)->nullable();
            $table->string('From', 50)->nullable();
            $table->string('To', 50)->nullable();
            $table->string('Price', 50)->nullable();
            $table->string('GroupId', 50)->nullable();
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
        Schema::dropIfExists('DIMSPRICELIST');
    }
}
