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
        Schema::create('tblcompanyroles', function (Blueprint $table) {
            $table->id('intAutoId');
            $table->string('strPermissionAbv', 10);
            $table->string('strPermissionName', 100);
            $table->string('strGroupName', 100);
            $table->timestamps();
            $table->index(['strPermissionAbv', 'strPermissionName', 'strGroupName']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblcompanyroles');
    }
};
