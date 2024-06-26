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
        Schema::table('central_users', function (Blueprint $table) {
            $table->renameColumn('is_admin', 'user_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('central_users', function (Blueprint $table) {
            $table->renameColumn('user_role', 'is_admin');
        });
    }
};
