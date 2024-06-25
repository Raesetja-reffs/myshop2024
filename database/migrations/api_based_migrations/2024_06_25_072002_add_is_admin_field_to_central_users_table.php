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
            $table->integer('is_admin')->default(0)->after('id');
            $table->text('internal_pass')->nullable()->after('password');
            $table->string('erp_user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('central_users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
            $table->dropColumn('internal_pass');
            $table->string('erp_user_id')->change();
        });
    }
};
