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
        Schema::table('assets', function (Blueprint $table) {
            // drop project_id
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

            // create contract_id
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('set null');

            // purchased_date
            $table->date('purchased_date')->nullable();

            // warranty end
            $table->date('warranty_end')->nullable();

            // serial number
            $table->string('serial_number')->nullable();

            // brand
            $table->string('brand')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // drop contract_id
            $table->dropForeign(['contract_id']);
            $table->dropColumn('contract_id');

            // create project_id
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');

            // drop purchased_date
            $table->dropColumn('purchased_date');

            // drop warranty end
            $table->dropColumn('warranty_end');

            // drop serial number
            $table->dropColumn('serial_number');

            // drop brand
            $table->dropColumn('brand');
        });
    }
};
