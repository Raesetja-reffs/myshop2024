<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBrands', function (Blueprint $table) {
            $table->integer('BrandId');
            $table->string('Brand', 50)->nullable();
            $table->integer('GroupId')->nullable();
            $table->boolean('NewRec')->default(0);
            $table->integer('OwnerId')->nullable();

            $table->primary('BrandId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBrands');
    }
}
