<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending', 'proses', 'selesai', 'ditolak') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE reports MODIFY COLUMN status ENUM('pending', 'proses', 'selesai') DEFAULT 'pending'");
    }
};
