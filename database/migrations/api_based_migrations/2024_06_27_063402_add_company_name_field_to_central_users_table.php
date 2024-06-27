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
            $table->string('company_name')->nullable()->after('company_id');
            $table->string('erp_apiusername')->nullable()->change();
            $table->string('erp_apipassword')->nullable()->change();
            $table->string('erp_apiauthtoken')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('central_users', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->string('erp_apiusername')->nullable(false)->change();
            $table->string('erp_apipassword')->nullable(false)->change();
            $table->string('erp_apiauthtoken')->nullable(false)->change();
        });
    }
};
