<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversCashOffRPJTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DriversCashOffRPJ', function (Blueprint $table) {
            $table->id('intJournalID');
            $table->bigInteger('intDocumentType')->nullable();
            $table->string('strDocNumber', 50)->nullable();
            $table->datetime('dteDocDate')->nullable();
            $table->string('strHeaderComment', 50)->nullable();
            $table->string('strJournalN', 255)->nullable();
            $table->string('strHeaderAccount', 255)->nullable();
            $table->boolean('bitJournalExport')->default(false);
            $table->string('strJournalExportReason', 255)->nullable();
            $table->integer('intUserId')->nullable();
            $table->integer('intTaxType')->default(0);
            $table->timestamps();
        });

        // Add default constraint values
        DB::statement('ALTER TABLE DriversCashOffRPJ ADD decTotalP MONEY NULL');
        DB::statement('ALTER TABLE DriversCashOffRPJ ADD decTotalR MONEY NULL');
        DB::statement('ALTER TABLE DriversCashOffRPJ ADD decTaxAmount MONEY DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DriversCashOffRPJ');
    }
}
