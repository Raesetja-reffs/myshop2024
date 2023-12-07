<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAppsRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblAppsRoles', function (Blueprint $table) {
            $table->id('intRoleId');
            $table->string('strRoleName', 250)->nullable();
            $table->string('strRoleDetailDescription', 800)->nullable();
            $table->string('strAppName', 50)->nullable();
            $table->dateTime('dteCreated')->default(now());
            $table->boolean('isRoleEnabled')->default(1);
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
        Schema::dropIfExists('tblAppsRoles');
    }
}
