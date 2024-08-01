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
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->dropIndex(['intCompanyRoleId', 'intCompanyId', 'bitActive']);
        });
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->renameColumn('intCompanyId', 'strCompanyId');
        });
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->string('strCompanyId')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->renameColumn('strCompanyId', 'intCompanyId');
        });
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->integer('intCompanyId')->nullable(false)->default(0)->change();
        });
        Schema::table('tblCompanyPermissions', function (Blueprint $table) {
            $table->index(['intCompanyRoleId', 'intCompanyId', 'bitActive']);
        });
    }
};
