<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCallistFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblCallistFilters', function (Blueprint $table) {
            $table->id('ID');
            $table->string('strUserName', 50)->nullable();
            $table->integer('intUserId')->nullable();
            $table->string('strRouteName', 50)->nullable();
            $table->integer('intRouteId')->nullable();
            $table->bigInteger('intSessionUserId')->nullable();
            $table->date('dteSessionDate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblCallistFilters');
    }
}
