<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblCompanyPermissions', function (Blueprint $table) {
            $table->id('intAutoId');
            $table->integer('intCompanyRoleId');
            $table->integer('intCompanyId')->default(0);
            $table->tinyInteger('bitActive')->default(0);
            $table->timestamps();
            $table->index(['intCompanyRoleId', 'intCompanyId', 'bitActive']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblCompanyPermissions');
    }
};
