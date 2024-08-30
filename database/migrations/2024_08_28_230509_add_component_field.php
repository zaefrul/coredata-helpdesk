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
        Schema::table('components', function (Blueprint $table) {
            $table->string('part_number');
            $table->string('component_name');
            $table->renameColumn('model', 'component_model');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('components', function (Blueprint $table) {
            $table->dropColumn('part_number');
            $table->dropColumn('component_name');
            $table->renameColumn('component_model', 'model');
            $table->dropSoftDeletes();
        });
    }
};
