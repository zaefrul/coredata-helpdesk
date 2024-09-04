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
        Schema::table('incidents', function (Blueprint $table) {
            //clear project_id now point to contract
            $table->dropForeign('incidents_project_id_foreign');
            $table->dropColumn('project_id');
            $table->foreignId('contract_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropForeign('incidents_contract_id_foreign');
            $table->dropColumn('contract_id');
            $table->foreignId('project_id')->constrained();
        });
    }
};
