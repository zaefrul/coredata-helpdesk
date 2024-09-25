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
        Schema::create('request_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained();
            $table->enum('status', ['pending', 'extracting', 'completed', 'emailed', 'failed'])->default('pending');
            $table->string('report_type');
            $table->foreignId('request_by')->constrained('users');
            $table->string('report_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_reports');
    }
};
