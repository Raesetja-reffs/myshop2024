<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBreifcaseSurveyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblBreifcaseSurveyQuestions', function (Blueprint $table) {
            $table->id('intAuto');
            $table->string('strMessage', 500)->nullable();
            $table->date('dteActiveFrom')->nullable();
            $table->date('dteActiveTo')->nullable();
            $table->datetime('dtmCreate')->nullable()->default(now());
            $table->integer('intLocation')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblBreifcaseSurveyQuestions');
    }
}
