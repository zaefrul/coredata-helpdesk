<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Correct syntax for modifying the ENUM column
        DB::statement("ALTER TABLE incidents MODIFY COLUMN status ENUM('open', 'in_progress', 'resolved', 'closed', 'verified')");
    }

    public function down()
    {
        // Optionally, revert to the original ENUM values
        DB::statement("ALTER TABLE incidents MODIFY COLUMN status ENUM('open', 'in_progress', 'resolved', 'closed')");
    }
};
