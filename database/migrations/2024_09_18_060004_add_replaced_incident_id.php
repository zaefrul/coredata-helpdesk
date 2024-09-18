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
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('replaced_incident_id')->nullable();
            $table->foreign('replaced_incident_id')->references('id')->on('incidents');
            $table->integer('old_item')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['replaced_incident_id']);
            $table->dropColumn('replaced_incident_id');
            $table->dropColumn('old_item');
        });
    }
};
