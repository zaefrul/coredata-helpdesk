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
        Schema::table('contracts', function (Blueprint $table) {
            // fk to custimer_id
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            // remove fk to project_id
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
        });
    }
};
