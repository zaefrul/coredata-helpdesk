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
        Schema::table('settings', function (Blueprint $table) {
            $table->index('field');
            $table->index('label');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('incident_id');
            $table->index('comment_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('prefix');
            $table->index('email');
            $table->index('phone_number');
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->index('incident_number');
            $table->unique('incident_number');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->index('serial_number');
            $table->index('part_number');
            $table->index('mfg_part_number');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropIndex('settings_field_index');
            $table->dropIndex('settings_label_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('activity_logs_user_id_index');
            $table->dropIndex('activity_logs_incident_id_index');
            $table->dropIndex('activity_logs_comment_id_index');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_prefix_index');
            $table->dropIndex('customers_email_index');
            $table->dropIndex('customers_phone_number_index');
        });

        Schema::table('incidents', function (Blueprint $table) {
            $table->dropIndex('incidents_incident_number_index');
            $table->dropUnique('incidents_incident_number_unique');
        });

        Schema::table('inventories', function (Blueprint $table) {
            $table->dropIndex('inventories_serial_number_index');
            $table->dropIndex('inventories_part_number_index');
            $table->dropIndex('inventories_mfg_part_number_index');
            $table->dropIndex('inventories_type_index');
        });
    }
};
