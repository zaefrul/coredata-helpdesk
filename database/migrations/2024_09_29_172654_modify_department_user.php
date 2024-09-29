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
        Schema::table('departments', function (Blueprint $table) {
            // remove pc_name, pc_phone, pc_email columns, add relationship with users
            $table->dropColumn('pc_name');
            $table->dropColumn('pc_phone');
            $table->dropColumn('pc_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            // add pc_name, pc_phone, pc_email columns, remove relationship with users
            $table->string('pc_name')->nullable();
            $table->string('pc_phone')->nullable();
            $table->string('pc_email')->nullable();
        });
    }
};
